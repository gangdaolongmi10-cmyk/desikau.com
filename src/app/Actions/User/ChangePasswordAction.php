<?php

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * パスワード変更アクション
 */
final class ChangePasswordAction
{
    /**
     * パスワードを変更
     */
    public function execute(User $user, string $newPassword): void
    {
        $user->update([
            'password' => Hash::make($newPassword),
        ]);
    }
}
