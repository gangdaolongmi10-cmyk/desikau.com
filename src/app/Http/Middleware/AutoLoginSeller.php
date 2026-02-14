<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * ユーザーが出品者アカウントを持っている場合、自動的にsellerガードでログインする
 */
class AutoLoginSeller
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // sellerガードで未ログインの場合
        if (!Auth::guard('seller')->check()) {
            // userガードでログイン中かつ出品者アカウントを持っている場合
            if (Auth::guard('web')->check()) {
                /** @var \App\Models\User $user */
                $user = Auth::guard('web')->user();
                /** @var \App\Models\Seller|null $seller */
                $seller = $user->seller;

                if ($seller) {
                    // sellerガードで自動ログイン
                    Auth::guard('seller')->login($seller);
                }
            }
        }

        return $next($request);
    }
}
