<?php

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * アカウント削除アクション
 */
final class DeleteAccountAction
{
    /**
     * アカウントを削除（論理削除 + 匿名化）
     */
    public function execute(User $user): void
    {
        $userId = $user->id;

        // 個人情報を匿名化
        $user->update([
            'name' => '退会済みユーザー',
            'icon_url' => null,
            'remember_token' => null,
        ]);

        // 論理削除
        $user->delete();

        // ログアウト
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        // 監査ログ（個人情報は含めない）
        Log::info('アカウント削除', [
            'user_id' => $userId,
            'deleted_at' => now()->toIso8601String(),
        ]);
    }
}
