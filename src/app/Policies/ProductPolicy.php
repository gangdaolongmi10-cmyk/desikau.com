<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\Seller;
use App\Models\User;

/**
 * 商品の認可ポリシー
 */
class ProductPolicy
{
    /**
     * 商品一覧の閲覧権限
     */
    public function viewAny(User|Seller $user): bool
    {
        // 出品者のみ自分の商品一覧を閲覧可能
        return $user instanceof Seller;
    }

    /**
     * 商品の閲覧権限
     */
    public function view(User|Seller $user, Product $product): bool
    {
        // 出品者は自分の商品のみ閲覧可能
        if ($user instanceof Seller) {
            return $user->id === $product->seller_id;
        }

        // ユーザーは公開中の商品のみ閲覧可能
        return $product->isPublished();
    }

    /**
     * 商品の作成権限
     */
    public function create(User|Seller $user): bool
    {
        // 出品者のみ作成可能
        return $user instanceof Seller;
    }

    /**
     * 商品の更新権限
     */
    public function update(User|Seller $user, Product $product): bool
    {
        // 出品者は自分の商品のみ更新可能
        if ($user instanceof Seller) {
            return $user->id === $product->seller_id;
        }

        return false;
    }

    /**
     * 商品の削除権限
     */
    public function delete(User|Seller $user, Product $product): bool
    {
        // 出品者は自分の商品のみ削除可能
        if ($user instanceof Seller) {
            return $user->id === $product->seller_id;
        }

        return false;
    }
}
