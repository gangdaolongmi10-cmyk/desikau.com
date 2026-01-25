<?php

/**
 * 管理画面のルート定義
 * サブドメイン: admin.desikau.local
 */

use Illuminate\Support\Facades\Route;

Route::name('admin.')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard.index');
    })->name('dashboard.index');

    // TODO: 管理画面のルートを追加
});
