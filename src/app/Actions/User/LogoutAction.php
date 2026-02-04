<?php

namespace App\Actions\User;

use Illuminate\Support\Facades\Auth;

/**
 * ログアウト処理アクション
 */
final class LogoutAction
{
    /**
     * ログアウトを実行
     */
    public function execute(): void
    {
        Auth::guard('seller')->logout();
        Auth::logout();

        session()->invalidate();
        session()->regenerateToken();
    }
}
