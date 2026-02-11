<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

/**
 * 管理画面ダッシュボードコントローラー
 */
final class DashboardController extends Controller
{
    /**
     * ダッシュボードを表示
     */
    public function index(): View
    {
        $today = Carbon::today();

        // 本日の売上
        $todaySales = (int) DB::table('orders')
            ->where('status', Order::STATUS_PAID)
            ->whereDate('paid_at', $today)
            ->sum('total');

        // 本日の注文数
        $todayOrders = DB::table('orders')
            ->where('status', Order::STATUS_PAID)
            ->whereDate('paid_at', $today)
            ->count();

        // 登録ユーザー数
        $totalUsers = User::count();

        // 公開中のお知らせ数
        $publishedAnnouncements = Announcement::published()->count();

        return view('admin.dashboard.index', compact(
            'todaySales',
            'todayOrders',
            'totalUsers',
            'publishedAnnouncements',
        ));
    }
}
