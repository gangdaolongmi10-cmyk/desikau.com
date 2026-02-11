<?php

namespace App\Repositories;

use App\Models\Seller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * 出品者リポジトリ
 */
class SellerRepository
{
    /**
     * 出品者を登録
     *
     * @param array<string, mixed> $data
     */
    public function create(array $data): Seller
    {
        // emailが一致するユーザーを検索して紐づける
        $user = User::where('email', $data['email'])->first();

        $seller = new Seller();
        $seller->fill([
            'user_id' => $user?->id,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'shop_name' => $data['shop_name'],
            'main_category' => $data['main_category'],
            'description' => $data['description'] ?? null,
            'twitter_username' => $data['twitter_username'] ?? null,
            'youtube_url' => $data['youtube_url'] ?? null,
            'twitch_username' => $data['twitch_username'] ?? null,
        ]);
        $seller->save();

        return $seller;
    }

    /**
     * メールアドレスで出品者を取得
     */
    public function findByEmail(string $email): ?Seller
    {
        return Seller::where('email', $email)->first();
    }

    /**
     * 出品者に特定商取引法情報をeager loadして返す
     */
    public function loadWithLegalInfo(Seller $seller): Seller
    {
        $seller->load('legalInfo');

        return $seller;
    }
}
