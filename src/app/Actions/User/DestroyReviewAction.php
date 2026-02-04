<?php

namespace App\Actions\User;

use App\Models\Review;
use App\Models\User;

/**
 * レビュー削除アクション
 */
final class DestroyReviewAction
{
    /**
     * レビューを削除
     *
     * @return array{success: bool, message: string}
     */
    public function execute(User $user, Review $review): array
    {
        if ($review->user_id !== $user->id) {
            return [
                'success' => false,
                'message' => '削除権限がありません。',
            ];
        }

        $review->delete();

        return [
            'success' => true,
            'message' => 'レビューを削除しました。',
        ];
    }
}
