<?php

/**
 * 出品者向けサイトのルート定義
 * プレフィックス: /seller
 * ルート名プレフィックス: seller.（bootstrap/app.phpで設定済み）
 */

use App\Http\Controllers\Seller\HomeController;
use App\Http\Controllers\Seller\ProductController;
use App\Http\Controllers\Seller\SalesController;
use App\Http\Controllers\Seller\SellerLegalInfoController;
use App\Http\Controllers\Seller\SettingsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| 出品者専用（認証必須）
|--------------------------------------------------------------------------
*/
Route::middleware(['seller.auto-login', 'auth:seller'])->group(function () {
    // ダッシュボード
    Route::get('/', [HomeController::class, 'index'])->name('home.index');

    // 商品管理（RESTfulリソースルート）
    Route::resource('product', ProductController::class)->except(['show']);

    // 売上管理
    Route::get('sales', [SalesController::class, 'index'])->name('sales.index');

    // 特定商取引法に基づく表記
    Route::get('legal-info', [SellerLegalInfoController::class, 'edit'])->name('legal-info.edit');
    Route::put('legal-info', [SellerLegalInfoController::class, 'update'])->name('legal-info.update');

    // 設定
    Route::get('settings', [SettingsController::class, 'edit'])->name('settings.edit');
    Route::put('settings', [SettingsController::class, 'update'])->name('settings.update');
});
