<?php

namespace App\Http\Controllers\User;

use App\Actions\User\LoginAction;
use App\Actions\User\LogoutAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

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
    public function login(LoginRequest $request, LoginAction $action): RedirectResponse
    {
        $result = $action->execute(
            $request->credentials(),
            $request->remember(),
            $request->loginType()
        );

        if (!$result['success']) {
            return back()
                ->withInput($request->only('email', 'remember', 'login_type'))
                ->withErrors(['email' => $result['message']]);
        }

        return redirect()->intended($result['redirect'])
            ->with('success', $result['message']);
    }

    /**
     * ログアウト処理
     */
    public function logout(LogoutAction $action): RedirectResponse
    {
        $action->execute();

        return redirect()->route('user.home.index')
            ->with('success', 'ログアウトしました。');
    }
}
