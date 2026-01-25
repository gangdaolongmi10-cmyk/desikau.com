<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

/**
 * ログインコントローラー
 */
final class LoginController extends Controller
{
    /**
     * ログイン画面を表示
     */
    public function index(): View
    {
        return view('user.login.index');
    }

    /**
     * ログイン処理
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->credentials();
        $remember = $request->remember();

        if (Auth::attempt($credentials, $remember)) {
            // セッションを再生成（セッション固定攻撃対策）
            $request->session()->regenerate();

            // 前の画面にリダイレクト（なければホームへ）
            return redirect()->intended(route('user.home.index'))
                ->with('success', 'ログインしました。');
        }

        // 認証失敗
        return back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => 'メールアドレスまたはパスワードが正しくありません。',
            ]);
    }

    /**
     * ログアウト処理
     */
    public function logout(): RedirectResponse
    {
        Auth::logout();

        // セッションを無効化
        request()->session()->invalidate();

        // CSRFトークンを再生成
        request()->session()->regenerateToken();

        return redirect()->route('user.home.index')
            ->with('success', 'ログアウトしました。');
    }
}
