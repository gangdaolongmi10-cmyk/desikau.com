<?php

namespace App\Actions\User;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;

/**
 * レビュー投稿アクション
 */
final class StoreReviewAction
{
    /**
     * レビューを投稿
     *
     * @return array{success: bool, message: string}
     */
    public function execute(User $user, Product $product, array $validated): array
    {
        $exists = Review::where('product_id', $product->id)
            ->where('user_id', $user->id)
            ->exists();

        if ($exists) {
            return [
                'success' => false,
                'message' => 'この商品には既にレビューを投稿済みです。',
            ];
        }

        Review::create([
            'product_id' => $product->id,
            'user_id' => $user->id,
            'rating' => $validated['rating'],
            'title' => $validated['title'],
            'body' => $validated['body'],
        ]);

        return [
            'success' => true,
            'message' => 'レビューを投稿しました。',
        ];
    }
}
