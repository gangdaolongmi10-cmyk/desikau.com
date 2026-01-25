<?php

/**
 * APIのルート定義
 * サブドメイン: api.desikau.local
 */

use Illuminate\Support\Facades\Route;

Route::name('api.')->group(function () {
    Route::get('/', function () {
        return response()->json([
            'status' => 'ok',
            'message' => 'Welcome to Desikau API',
        ]);
    })->name('index');

    // TODO: APIルートを追加
});
