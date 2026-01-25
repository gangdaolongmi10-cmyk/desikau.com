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
            $domain = config('app.domain', 'desikau.local');

            // ユーザー向けサイト (desikau.local)
            Route::domain($domain)
                ->middleware('web')
                ->group(base_path('routes/user.php'));

            // 管理画面 (admin.desikau.local)
            Route::domain('admin.' . $domain)
                ->middleware('web')
                ->group(base_path('routes/admin.php'));

            // API (api.desikau.local)
            Route::domain('api.' . $domain)
                ->middleware('api')
                ->group(base_path('routes/api.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
