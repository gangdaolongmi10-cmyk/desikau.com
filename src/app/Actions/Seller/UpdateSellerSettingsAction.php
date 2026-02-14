<?php

namespace App\Actions\Seller;

use App\Models\Seller;
use Illuminate\Support\Facades\Hash;

/**
 * 出品者設定更新アクション
 */
final class UpdateSellerSettingsAction
{
    /**
     * 出品者設定を更新
     */
    public function execute(Seller $seller, array $validated): Seller
    {
        $seller->shop_name = $validated['shop_name'];
        $seller->main_category = $validated['main_category'];
        $seller->description = $validated['description'] ?? null;
        $seller->twitter_username = $validated['twitter_username'] ?? null;
        $seller->youtube_url = $validated['youtube_url'] ?? null;
        $seller->twitch_username = $validated['twitch_username'] ?? null;

        // 住所・電話番号情報
        $seller->postal_code = $validated['postal_code'] ?? null;
        $seller->prefecture = $validated['prefecture'] ?? null;
        $seller->city = $validated['city'] ?? null;
        $seller->address = $validated['address'] ?? null;
        $seller->building = $validated['building'] ?? null;
        $seller->phone_number = $validated['phone_number'] ?? null;

        // パスワードが入力されている場合のみ更新
        if (!empty($validated['password'])) {
            $seller->password = Hash::make($validated['password']);
        }

        $seller->save();

        return $seller;
    }
}
