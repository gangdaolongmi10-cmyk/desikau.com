<?php

/**
 * ユーザー向けサイトのルート定義
 * サブドメイン: desikau.local
 */

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\InquiryController;
use App\Http\Controllers\User\LoginController;
use App\Http\Controllers\User\ProductController;
use App\Http\Controllers\User\RegisterController;
use App\Http\Controllers\User\StaticController;

Route::name('user.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home.index');

    // ゲスト専用（ログイン中はアクセス不可）
    Route::middleware('guest')->group(function () {
        Route::get('/login', [LoginController::class, 'index'])->name('login.index');
        Route::post('/login', [LoginController::class, 'login'])->name('login.login');
        Route::get('/register', [RegisterController::class, 'index'])->name('register.index');
    });

    // ログアウト
    Route::post('/logout', [LoginController::class, 'logout'])->name('login.logout');

    Route::prefix('inquiry')->name('inquiry.')->group(function () {
        Route::get('/', [InquiryController::class, 'index'])->name('index');
    });
    Route::prefix('product')->name('product.')->group(function () {
        Route::get('/{slug}', [ProductController::class, 'detail'])->name('detail');
    });
    Route::get('/static/{slug}', [StaticController::class, 'index'])->name('static.index');
});
