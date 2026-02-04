<?php

/**
 * 管理画面のルート定義
 * プレフィックス: /admin
 * ルート名プレフィックス: admin.（bootstrap/app.phpで設定済み）
 */

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| ダッシュボード
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('admin.dashboard.index');
})->name('dashboard.index');

// TODO: 管理画面のルートを追加
