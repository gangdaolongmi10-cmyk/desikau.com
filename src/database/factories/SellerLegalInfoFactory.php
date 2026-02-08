<?php

namespace Database\Factories;

use App\Models\Seller;
use App\Models\SellerLegalInfo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * 特定商取引法に基づく表記ファクトリー
 *
 * @extends Factory<SellerLegalInfo>
 */
class SellerLegalInfoFactory extends Factory
{
    protected $model = SellerLegalInfo::class;

    /**
     * 販売業者名リスト
     */
    private const COMPANY_NAMES = [
        '株式会社デジタルクリエイト',
        '合同会社クリエイティブワークス',
        'デジタルアート工房',
        '株式会社メディアラボ',
        'クリエイターズスタジオ',
    ];

    /**
     * 代表者名リスト
     */
    private const REPRESENTATIVE_NAMES = [
        '山田太郎',
        '佐藤花子',
        '鈴木一郎',
        '田中美咲',
        '高橋健太',
    ];

    /**
     * 所在地リスト
     */
    private const ADDRESSES = [
        '東京都渋谷区神宮前1-2-3 クリエイティブビル5F',
        '大阪府大阪市北区梅田2-4-6 デジタルタワー10F',
        '福岡県福岡市中央区天神3-5-7 テックプラザ3F',
        '愛知県名古屋市中区栄4-8-12 メディアセンター7F',
        '北海道札幌市中央区大通西5-1-3 クリエイトオフィス2F',
    ];

    /**
     * 郵便番号リスト
     */
    private const POSTAL_CODES = [
        '150-0001',
        '530-0001',
        '810-0001',
        '460-0008',
        '060-0042',
    ];

    /**
     * モデルのデフォルト状態を定義
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $index = fake()->numberBetween(0, count(self::COMPANY_NAMES) - 1);

        return [
            'seller_id' => null,
            'company_name' => self::COMPANY_NAMES[$index],
            'representative_name' => self::REPRESENTATIVE_NAMES[$index],
            'postal_code' => self::POSTAL_CODES[$index],
            'address' => self::ADDRESSES[$index],
            'phone_number' => '03-' . fake()->numberBetween(1000, 9999) . '-' . fake()->numberBetween(1000, 9999),
            'email' => fake()->unique()->safeEmail(),
            'price_description' => '各商品ページに表示された価格に基づきます。表示価格は税込みです。',
            'payment_method' => 'クレジットカード（VISA、Mastercard、JCB、American Express）',
            'delivery_period' => '決済完了後、即時ダウンロード可能です。',
            'return_policy' => 'デジタルコンテンツの性質上、購入後の返品・キャンセルはお受けできません。商品に不具合がある場合は、購入後7日以内にお問い合わせください。',
        ];
    }

    /**
     * 出品者に紐づいた表記
     */
    public function withSeller(Seller $seller): static
    {
        return $this->state(fn (array $attributes) => [
            'seller_id' => $seller->id,
        ]);
    }
}
