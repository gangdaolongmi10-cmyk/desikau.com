<?php

/**
 * APIのルート定義
 * プレフィックス: /api
 * ルート名プレフィックス: api.（bootstrap/app.phpで設定済み）
 */

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| APIエンドポイント
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return response()->json([
        'status' => 'ok',
        'message' => 'Welcome to Desikau API',
    ]);
})->name('index');

// TODO: APIルートを追加
