<?php

namespace App\Services;

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * 商品いいねサービス
 */
class ProductLikeService
{
    /**
     * 商品にいいねを追加
     *
     * @param Product $product 対象商品
     * @param User $user いいねするユーザー
     * @return bool 新規にいいねが追加された場合はtrue
     */
    public function addLike(Product $product, User $user): bool
    {
        return DB::transaction(function () use ($product, $user) {
            // syncWithoutDetachingは既存のリレーションを削除せず、新規のみ追加
            $changes = $product->likedUsers()->syncWithoutDetaching([$user->id]);

            // 新規にattachされた場合のみカウントを増やす
            if (!empty($changes['attached'])) {
                $product->increment('likes_count');
                return true;
            }

            return false;
        });
    }

    /**
     * 商品からいいねを解除
     *
     * @param Product $product 対象商品
     * @param User $user いいねを解除するユーザー
     * @return bool いいねが解除された場合はtrue
     */
    public function removeLike(Product $product, User $user): bool
    {
        return DB::transaction(function () use ($product, $user) {
            // detachは削除された件数を返す
            $detached = $product->likedUsers()->detach($user->id);

            // 実際にdetachされた場合のみカウントを減らす
            if ($detached > 0) {
                $product->decrement('likes_count');
                return true;
            }

            return false;
        });
    }

    /**
     * ユーザーが商品をいいねしているか確認
     *
     * @param Product $product 対象商品
     * @param User $user 確認するユーザー
     * @return bool いいねしている場合はtrue
     */
    public function hasLiked(Product $product, User $user): bool
    {
        return $product->likedUsers()->where('user_id', $user->id)->exists();
    }
}
