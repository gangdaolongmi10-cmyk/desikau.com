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
        $faker = fake('ja_JP');
        $categories = ['3d', 'ui', 'texture', 'font', 'other'];
        $shopName = fake()->randomElement(self::SHOP_NAMES) . fake()->unique()->randomNumber(3);
        $prefectures = [
            '北海道', '青森県', '岩手県', '宮城県', '秋田県', '山形県', '福島県',
            '茨城県', '栃木県', '群馬県', '埼玉県', '千葉県', '東京都', '神奈川県',
            '新潟県', '富山県', '石川県', '福井県', '山梨県', '長野県', '岐阜県',
            '静岡県', '愛知県', '三重県', '滋賀県', '京都府', '大阪府', '兵庫県',
            '奈良県', '和歌山県', '鳥取県', '島根県', '岡山県', '広島県', '山口県',
            '徳島県', '香川県', '愛媛県', '高知県', '福岡県', '佐賀県', '長崎県',
            '熊本県', '大分県', '宮崎県', '鹿児島県', '沖縄県',
        ];

        return [
            'user_id' => null,
            'email' => $faker->unique()->safeEmail(),
            'password' => Hash::make('password1'),
            'shop_name' => $shopName,
            'slug' => Str::slug($shopName) . '-' . fake()->unique()->randomNumber(5),
            'main_category' => fake()->randomElement($categories),
            'description' => fake()->optional(0.8)->randomElement(self::DESCRIPTIONS),
            'twitter_username' => fake()->optional(0.6)->userName(),
            'youtube_url' => fake()->optional(0.4)->url(),
            'twitch_username' => fake()->optional(0.3)->userName(),
            'postal_code' => $faker->optional(0.8)->postcode(),
            'prefecture' => $faker->optional(0.8)->randomElement($prefectures),
            'city' => $faker->optional(0.8)->city(),
            'address' => $faker->optional(0.8)->streetAddress(),
            'building' => $faker->optional(0.4)->secondaryAddress(),
            'phone_number' => $faker->optional(0.8)->phoneNumber(),
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
