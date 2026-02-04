<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        using: function () {
            // 出品者向けサイト (/seller) - user.phpより先に読み込む
            Route::middleware('web')
                ->prefix('seller')
                ->name('seller.')
                ->group(base_path('routes/seller.php'));

            // ユーザー向けサイト (/)
            Route::middleware('web')
                ->group(base_path('routes/user.php'));

            // 管理画面 (/admin)
            Route::middleware('web')
                ->prefix('admin')
                ->name('admin.')
                ->group(base_path('routes/admin.php'));

            // API (/api)
            Route::middleware('api')
                ->prefix('api')
                ->name('api.')
                ->group(base_path('routes/api.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'seller.auto-login' => \App\Http\Middleware\AutoLoginSeller::class,
        ]);

        // 未認証ユーザーのリダイレクト先を設定
        $middleware->redirectGuestsTo('/login');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
