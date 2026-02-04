<?php

namespace App\Http\Controllers\User;

use App\Actions\User\ChangePasswordAction;
use App\Actions\User\DeleteAccountAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\ChangePasswordRequest;
use App\Http\Requests\User\DeleteAccountRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * プロフィールコントローラー
 */
final class ProfileController extends Controller
{
    /**
     * プロフィール画面を表示
     */
    public function index(Request $request): View
    {
        $user = Auth::guard('web')->user();
        $seller = Auth::guard('seller')->user();
        $tab = $request->query('tab', 'user');

        return view('user.profile.index', compact('user', 'seller', 'tab'));
    }

    /**
     * パスワードを変更
     */
    public function changePassword(ChangePasswordRequest $request, ChangePasswordAction $action): RedirectResponse
    {
        $action->execute(Auth::user(), $request->input('new_password'));

        return redirect()
            ->route('user.profile.index')
            ->with('success', 'パスワードを変更しました。');
    }

    /**
     * アカウントを削除（論理削除）
     */
    public function destroy(DeleteAccountRequest $request, DeleteAccountAction $action): RedirectResponse
    {
        $action->execute(Auth::user());

        return redirect()
            ->route('user.home.index')
            ->with('success', 'アカウントを削除しました。ご利用ありがとうございました。');
    }
}
