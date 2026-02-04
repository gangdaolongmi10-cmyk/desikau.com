<?php

/**
 * 出品者向けサイトのルート定義
 * プレフィックス: /seller
 * ルート名プレフィックス: seller.（bootstrap/app.phpで設定済み）
 */

use App\Http\Controllers\Seller\HomeController;
use App\Http\Controllers\Seller\ProductController;
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
});
