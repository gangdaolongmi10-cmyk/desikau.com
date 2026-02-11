<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Repositories\OrderRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * 出品者売上管理コントローラー
 */
final class SalesController extends Controller
{
    public function __construct(
        private readonly OrderRepository $orderRepository
    ) {}

    /**
     * 売上一覧を表示
     */
    public function index(Request $request): View
    {
        $seller = Auth::guard('seller')->user();
        $period = $request->query('period', 'current_month');
        $startDateInput = $request->query('start_date');
        $endDateInput = $request->query('end_date');

        [$startDate, $endDate] = $this->resolvePeriod($period, $startDateInput, $endDateInput);

        // サマリーデータ
        $totalSales = $this->orderRepository->getTotalSalesBySeller($seller->id);
        $monthlyStats = $this->orderRepository->getMonthlyStatsBySeller($seller->id);

        // 売上一覧（ページネーション）
        $sales = $this->orderRepository->getSalesBySellerPaginated(
            $seller->id,
            $startDate,
            $endDate
        );
        $queryParams = ['period' => $period];
        if ($period === 'custom' && $startDateInput && $endDateInput) {
            $queryParams['start_date'] = $startDateInput;
            $queryParams['end_date'] = $endDateInput;
        }
        $sales->appends($queryParams);

        return view('seller.sales.index', [
            'totalSales' => $totalSales,
            'monthlySales' => $monthlyStats['sales'],
            'salesChange' => $monthlyStats['sales_change'],
            'orderCount' => $monthlyStats['order_count'],
            'orderChange' => $monthlyStats['order_change'],
            'sales' => $sales,
            'currentPeriod' => $period,
            'startDate' => $startDateInput,
            'endDate' => $endDateInput,
        ]);
    }

    /**
     * 期間パラメータから開始日・終了日を算出
     *
     * @param string $period 期間キー
     * @param string|null $startDate カスタム開始日（Y-m-d）
     * @param string|null $endDate カスタム終了日（Y-m-d）
     * @return array{0: Carbon|null, 1: Carbon|null}
     */
    private function resolvePeriod(string $period, ?string $startDate = null, ?string $endDate = null): array
    {
        return match ($period) {
            'current_month' => [
                Carbon::now()->startOfMonth(),
                Carbon::now()->endOfMonth(),
            ],
            'last_month' => [
                Carbon::now()->subMonth()->startOfMonth(),
                Carbon::now()->subMonth()->endOfMonth(),
            ],
            'last_3_months' => [
                Carbon::now()->subMonths(3)->startOfMonth(),
                Carbon::now()->endOfMonth(),
            ],
            'custom' => [
                $startDate ? Carbon::parse($startDate)->startOfDay() : Carbon::now()->startOfMonth(),
                $endDate ? Carbon::parse($endDate)->endOfDay() : Carbon::now()->endOfMonth(),
            ],
            'all' => [null, null],
            default => [
                Carbon::now()->startOfMonth(),
                Carbon::now()->endOfMonth(),
            ],
        };
    }
}
