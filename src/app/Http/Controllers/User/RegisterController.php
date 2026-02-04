<?php

namespace App\Http\Controllers\User;

use App\Actions\User\RegisterUserAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\RegisterRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

/**
 * ユーザー登録コントローラー
 */
final class RegisterController extends Controller
{
    /**
     * 登録画面を表示
     */
    public function index(): View
    {
        return view('user.register.index');
    }

    /**
     * ユーザー登録処理
     */
    public function register(RegisterRequest $request, RegisterUserAction $action): RedirectResponse
    {
        $action->execute(
            $request->input('username'),
            $request->input('email'),
            $request->input('password'),
            $request->file('icon')
        );

        return redirect()->route('verification.notice');
    }
}
