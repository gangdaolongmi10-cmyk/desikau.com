<?php

/**
 * 管理画面のルート定義
 * プレフィックス: /admin
 * ルート名プレフィックス: admin.（bootstrap/app.phpで設定済み）
 */

use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| ダッシュボード
|--------------------------------------------------------------------------
*/
Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

// ユーザー管理
Route::get('user', [UserController::class, 'index'])->name('user.index');

// お知らせ管理
Route::resource('announcement', AnnouncementController::class)->except(['show']);
