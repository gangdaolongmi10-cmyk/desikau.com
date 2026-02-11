<?php

namespace App\Actions\Seller;

use App\Models\Review;
use App\Models\Seller;
use App\Repositories\OrderRepository;

/**
 * 出品者ダッシュボードデータ取得アクション
 */
final class GetSellerDashboardAction
{
    public function __construct(
        private readonly OrderRepository $orderRepository
    ) {}

    /**
     * ダッシュボード表示に必要なデータを取得
     *
     * @return array{monthlySales: int, orderCount: int, salesChange: float, orderChange: float, averageRating: float|null, reviewCount: int, recentSales: \Illuminate\Database\Eloquent\Collection}
     */
    public function execute(Seller $seller): array
    {
        $monthlyStats = $this->orderRepository->getMonthlyStatsBySeller($seller->id);

        $reviewQuery = Review::whereHas('product', function ($query) use ($seller) {
            $query->where('seller_id', $seller->id);
        });

        $averageRating = (clone $reviewQuery)->avg('rating');
        $reviewCount = (clone $reviewQuery)->count();

        $recentSales = $this->orderRepository->getRecentSalesBySeller($seller->id);

        return [
            'monthlySales' => $monthlyStats['sales'],
            'orderCount' => $monthlyStats['order_count'],
            'salesChange' => $monthlyStats['sales_change'],
            'orderChange' => $monthlyStats['order_change'],
            'averageRating' => $averageRating ? round($averageRating, 1) : null,
            'reviewCount' => $reviewCount,
            'recentSales' => $recentSales,
        ];
    }
}
