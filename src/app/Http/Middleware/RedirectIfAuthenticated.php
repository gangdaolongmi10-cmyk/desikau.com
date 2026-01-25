<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * ログイン済みユーザーをリダイレクトするミドルウェア
 */
final class RedirectIfAuthenticated
{
    /**
     * リクエストを処理
     */
    public function handle(Request $request, Closure $next, ?string $guard = null): Response
    {
        if (Auth::guard($guard)->check()) {
            // 前のURLにリダイレクト（なければホームへ）
            $previousUrl = url()->previous();
            $currentUrl = $request->url();

            // 前のURLが現在のURLと同じ、またはログイン・登録ページの場合はホームへ
            if ($previousUrl === $currentUrl || $this->isAuthPage($previousUrl)) {
                return redirect()->route('user.home.index');
            }

            return redirect($previousUrl);
        }

        return $next($request);
    }

    /**
     * 認証関連ページかどうかを判定
     */
    private function isAuthPage(string $url): bool
    {
        $authPaths = ['/login', '/register'];

        foreach ($authPaths as $path) {
            if (str_contains($url, $path)) {
                return true;
            }
        }

        return false;
    }
}
