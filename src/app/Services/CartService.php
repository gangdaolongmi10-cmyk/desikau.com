<?php

namespace App\Services;

use App\Models\CartItem;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

/**
 * カートサービス
 */
class CartService
{
    /**
     * Cookieキー名
     */
    private const CART_TOKEN_KEY = 'cart_token';

    /**
     * Cookie有効期限（30日）
     */
    private const COOKIE_LIFETIME = 60 * 24 * 30;

    /**
     * カートに商品を追加
     */
    public function addItem(int $productId, int $quantity = 1, ?User $user = null): CartItem
    {
        if ($user) {
            return $this->addItemForUser($user, $productId, $quantity);
        }

        return $this->addItemForGuest($productId, $quantity);
    }

    /**
     * ログインユーザーのカートに追加
     */
    private function addItemForUser(User $user, int $productId, int $quantity): CartItem
    {
        $cartItem = CartItem::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $quantity);
            return $cartItem->fresh();
        }

        return CartItem::create([
            'user_id' => $user->id,
            'product_id' => $productId,
            'quantity' => $quantity,
        ]);
    }

    /**
     * ゲストのカートに追加
     */
    private function addItemForGuest(int $productId, int $quantity): CartItem
    {
        $cartToken = $this->getOrCreateCartToken();

        $cartItem = CartItem::where('cart_token', $cartToken)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $quantity);
            return $cartItem->fresh();
        }

        return CartItem::create([
            'cart_token' => $cartToken,
            'product_id' => $productId,
            'quantity' => $quantity,
        ]);
    }

    /**
     * カートアイテムを取得
     */
    public function getItems(?User $user = null): Collection
    {
        if ($user) {
            return CartItem::with('product.seller.user', 'product.category')
                ->where('user_id', $user->id)
                ->get();
        }

        $cartToken = $this->getCartToken();
        if (!$cartToken) {
            return collect();
        }

        return CartItem::with('product.seller.user', 'product.category')
            ->where('cart_token', $cartToken)
            ->get();
    }

    /**
     * カートの合計金額を計算
     */
    public function getTotal(?User $user = null): int
    {
        return $this->getItems($user)->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });
    }

    /**
     * カートのアイテム数を取得
     */
    public function getItemCount(?User $user = null): int
    {
        return $this->getItems($user)->sum('quantity');
    }

    /**
     * カートアイテムの数量を更新
     */
    public function updateQuantity(int $cartItemId, int $quantity, ?User $user = null): ?CartItem
    {
        $cartItem = $this->findCartItem($cartItemId, $user);

        if (!$cartItem) {
            return null;
        }

        if ($quantity <= 0) {
            $cartItem->delete();
            return null;
        }

        $cartItem->update(['quantity' => $quantity]);
        return $cartItem->fresh();
    }

    /**
     * カートアイテムを削除
     */
    public function removeItem(int $cartItemId, ?User $user = null): bool
    {
        $cartItem = $this->findCartItem($cartItemId, $user);

        if (!$cartItem) {
            return false;
        }

        return $cartItem->delete();
    }

    /**
     * カートを空にする
     */
    public function clear(?User $user = null): void
    {
        if ($user) {
            CartItem::where('user_id', $user->id)->delete();
            return;
        }

        $cartToken = $this->getCartToken();
        if ($cartToken) {
            CartItem::where('cart_token', $cartToken)->delete();
        }
    }

    /**
     * ログイン時にゲストカートをマージ
     */
    public function mergeGuestCart(User $user): void
    {
        $cartToken = $this->getCartToken();

        if (!$cartToken) {
            return;
        }

        $guestItems = CartItem::where('cart_token', $cartToken)->get();

        foreach ($guestItems as $guestItem) {
            $userItem = CartItem::where('user_id', $user->id)
                ->where('product_id', $guestItem->product_id)
                ->first();

            if ($userItem) {
                // 同一商品が存在する場合は数量を加算
                $userItem->increment('quantity', $guestItem->quantity);
                $guestItem->delete();
            } else {
                // 存在しない場合はuser_idをセットしてcart_tokenをクリア
                $guestItem->update([
                    'user_id' => $user->id,
                    'cart_token' => null,
                ]);
            }
        }

        // cart_token Cookieを削除
        $this->forgetCartToken();
    }

    /**
     * カートアイテムを検索
     */
    private function findCartItem(int $cartItemId, ?User $user = null): ?CartItem
    {
        $query = CartItem::where('id', $cartItemId);

        if ($user) {
            $query->where('user_id', $user->id);
        } else {
            $cartToken = $this->getCartToken();
            if (!$cartToken) {
                return null;
            }
            $query->where('cart_token', $cartToken);
        }

        return $query->first();
    }

    /**
     * cart_tokenを取得（存在しなければ生成）
     */
    public function getOrCreateCartToken(): string
    {
        $cartToken = $this->getCartToken();

        if (!$cartToken) {
            $cartToken = (string) Str::uuid();
            Cookie::queue(self::CART_TOKEN_KEY, $cartToken, self::COOKIE_LIFETIME);
        }

        return $cartToken;
    }

    /**
     * cart_tokenを取得
     */
    public function getCartToken(): ?string
    {
        return request()->cookie(self::CART_TOKEN_KEY);
    }

    /**
     * cart_token Cookieを削除
     */
    public function forgetCartToken(): void
    {
        Cookie::queue(Cookie::forget(self::CART_TOKEN_KEY));
    }
}
