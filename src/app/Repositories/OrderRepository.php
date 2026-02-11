<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

/**
 * 注文リポジトリ
 */
final class OrderRepository
{
    /**
     * ユーザーの支払い完了済み注文を取得
     *
     * @param int $userId ユーザーID
     * @param int $perPage 1ページあたりの件数
     * @return LengthAwarePaginator
     */
    public function getPaidOrdersByUserId(int $userId, int $perPage = 10): LengthAwarePaginator
    {
        return Order::with(['items.product'])
            ->where('user_id', $userId)
            ->where('status', Order::STATUS_PAID)
            ->orderByDesc('paid_at')
            ->paginate($perPage);
    }

    /**
     * 注文番号で注文を取得
     *
     * @param string $orderNumber 注文番号
     * @return Order|null
     */
    public function findByOrderNumber(string $orderNumber): ?Order
    {
        return Order::with(['items.product'])
            ->where('order_number', $orderNumber)
            ->first();
    }

    /**
     * ユーザーの全注文を取得
     *
     * @param int $userId ユーザーID
     * @param int $perPage 1ページあたりの件数
     * @return LengthAwarePaginator
     */
    public function getAllOrdersByUserId(int $userId, int $perPage = 10): LengthAwarePaginator
    {
        return Order::with(['items.product'])
            ->where('user_id', $userId)
            ->orderByDesc('created_at')
            ->paginate($perPage);
    }

    /**
     * 出品者の期間内売上と注文数を取得
     *
     * @param int $sellerId 出品者ID
     * @param Carbon $startDate 開始日
     * @param Carbon $endDate 終了日
     * @return object{total_sales: int, order_count: int}
     */
    public function getSalesStatsBySeller(int $sellerId, Carbon $startDate, Carbon $endDate): object
    {
        $result = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('products.seller_id', $sellerId)
            ->where('orders.status', Order::STATUS_PAID)
            ->whereBetween('orders.paid_at', [$startDate, $endDate])
            ->selectRaw('
                COALESCE(SUM(order_items.price * order_items.quantity), 0) as total_sales,
                COUNT(DISTINCT orders.id) as order_count
            ')
            ->first();

        return (object) [
            'total_sales' => (int) $result->total_sales,
            'order_count' => (int) $result->order_count,
        ];
    }

    /**
     * 出品者の今月の売上統計を取得
     *
     * @param int $sellerId 出品者ID
     * @return array{sales: int, order_count: int, sales_change: int|null, order_change: int|null}
     */
    public function getMonthlyStatsBySeller(int $sellerId): array
    {
        $currentStart = Carbon::now()->startOfMonth();
        $currentEnd = Carbon::now()->endOfMonth();
        $lastStart = Carbon::now()->subMonth()->startOfMonth();
        $lastEnd = Carbon::now()->subMonth()->endOfMonth();

        // 今月の統計
        $currentStats = $this->getSalesStatsBySeller($sellerId, $currentStart, $currentEnd);

        // 先月の統計（前月比計算用）
        $lastStats = $this->getSalesStatsBySeller($sellerId, $lastStart, $lastEnd);

        return [
            'sales' => $currentStats->total_sales,
            'order_count' => $currentStats->order_count,
            'sales_change' => $this->calculateChangePercent($currentStats->total_sales, $lastStats->total_sales),
            'order_change' => $this->calculateChangePercent($currentStats->order_count, $lastStats->order_count),
        ];
    }

    /**
     * 出品者の最近の売上（注文アイテム）を取得
     *
     * @param int $sellerId 出品者ID
     * @param int $limit 取得件数
     * @return Collection<int, OrderItem>
     */
    public function getRecentSalesBySeller(int $sellerId, int $limit = 10): Collection
    {
        return OrderItem::with(['order', 'product'])
            ->whereHas('product', function ($query) use ($sellerId) {
                $query->where('seller_id', $sellerId);
            })
            ->whereHas('order', function ($query) {
                $query->whereIn('status', [Order::STATUS_PAID, Order::STATUS_PENDING]);
            })
            ->orderByDesc('created_at')
            ->limit($limit)
            ->get();
    }

    /**
     * 出品者の売上をページネーションで取得
     *
     * @param int $sellerId 出品者ID
     * @param Carbon|null $startDate 開始日
     * @param Carbon|null $endDate 終了日
     * @param int $perPage 1ページあたりの件数
     * @return LengthAwarePaginator
     */
    public function getSalesBySellerPaginated(
        int $sellerId,
        ?Carbon $startDate,
        ?Carbon $endDate,
        int $perPage = 20
    ): LengthAwarePaginator {
        $query = OrderItem::with(['order', 'product'])
            ->whereHas('product', function ($q) use ($sellerId) {
                $q->where('seller_id', $sellerId);
            })
            ->whereHas('order', function ($q) use ($startDate, $endDate) {
                $q->where('status', Order::STATUS_PAID);
                if ($startDate && $endDate) {
                    $q->whereBetween('paid_at', [$startDate, $endDate]);
                }
            })
            ->orderByDesc('created_at');

        return $query->paginate($perPage);
    }

    /**
     * 出品者の全期間累計売上額を取得
     *
     * @param int $sellerId 出品者ID
     * @return int 累計売上額
     */
    public function getTotalSalesBySeller(int $sellerId): int
    {
        $result = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('products.seller_id', $sellerId)
            ->where('orders.status', Order::STATUS_PAID)
            ->selectRaw('COALESCE(SUM(order_items.price * order_items.quantity), 0) as total')
            ->first();

        return (int) $result->total;
    }

    /**
     * 前月比を計算
     *
     * @param int $current 今月の値
     * @param int $previous 先月の値
     * @return int|null パーセント（先月が0の場合はnull）
     */
    private function calculateChangePercent(int $current, int $previous): ?int
    {
        if ($previous === 0) {
            return $current > 0 ? 100 : null;
        }

        return (int) round((($current - $previous) / $previous) * 100);
    }
}
