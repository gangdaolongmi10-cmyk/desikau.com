<?php

namespace App\Http\Controllers\Seller;

use App\Actions\Seller\GetSellerDashboardAction;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * 出品者ダッシュボードコントローラー
 */
final class HomeController extends Controller
{
    public function index(GetSellerDashboardAction $action)
    {
        $seller = Auth::guard('seller')->user();
        $data = $action->execute($seller);

        return view('seller.home.index', $data);
    }
}
