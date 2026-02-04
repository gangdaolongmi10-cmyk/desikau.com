<?php

namespace Database\Factories;

use App\Models\Seller;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * 出品者ファクトリー
 *
 * @extends Factory<Seller>
 */
class SellerFactory extends Factory
{
    protected $model = Seller::class;

    /**
     * ショップ名のリスト
     */
    private const SHOP_NAMES = [
        'クリエイティブスタジオ',
        'デジタルアトリエ',
        'ピクセルワークス',
        'アートファクトリー',
        '3Dクラフト工房',
        'テクスチャラボ',
        'UIデザイン研究所',
        'フォント工房',
        'グラフィックガレージ',
        'デザインハウス',
        'イラストスタジオ',
        'モデリング工房',
        'アセットストア',
        'クリエイターズギルド',
        'デジタルアーツ',
    ];

    /**
     * ショップ説明のリスト
     */
    private const DESCRIPTIONS = [
        '高品質な3Dモデルとテクスチャを提供しています。ゲーム開発や映像制作にお使いください。',
        'プロフェッショナル向けのUIキットを専門に制作しています。',
        'オリジナルフォントとタイポグラフィ素材を販売中。商用利用可能です。',
        'ゲーム開発者のための素材を多数取り揃えています。',
        'クオリティにこだわったデジタルアセットを提供します。',
        'イラストレーター向けの素材やブラシを制作・販売しています。',
        '建築ビジュアライゼーション用の高精細3Dモデルを提供。',
        'Webデザイナーのためのモダンなコンポーネントを販売中。',
    ];

    /**
     * モデルのデフォルト状態を定義
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = ['3d', 'ui', 'texture', 'font', 'other'];
        $shopName = fake()->randomElement(self::SHOP_NAMES) . fake()->unique()->randomNumber(3);

        return [
            'user_id' => null,
            'email' => fake('ja_JP')->unique()->safeEmail(),
            'password' => Hash::make('password1'),
            'shop_name' => $shopName,
            'slug' => Str::slug($shopName) . '-' . fake()->unique()->randomNumber(5),
            'main_category' => fake()->randomElement($categories),
            'description' => fake()->optional(0.8)->randomElement(self::DESCRIPTIONS),
            'twitter_username' => fake()->optional(0.6)->userName(),
            'youtube_url' => fake()->optional(0.4)->url(),
            'twitch_username' => fake()->optional(0.3)->userName(),
        ];
    }

    /**
     * ユーザーに紐づいた出品者
     */
    public function withUser(User $user = null): static
    {
        return $this->state(function (array $attributes) use ($user) {
            $user = $user ?? User::factory()->create();
            return [
                'user_id' => $user->id,
                'email' => $user->email,
            ];
        });
    }
}
