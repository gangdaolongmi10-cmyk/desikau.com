<?php

namespace Database\Factories;

use App\Enums\ProductStatus;
use App\Models\Category;
use App\Models\Product;
use App\Models\Seller;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * 商品ファクトリー
 *
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * 商品名のプレフィックスリスト
     */
    private const NAME_PREFIXES = [
        'プレミアム',
        'プロフェッショナル',
        'ハイクオリティ',
        'オリジナル',
        'カスタム',
        'モダン',
        'クラシック',
        'シンプル',
        'エレガント',
        'ミニマル',
    ];

    /**
     * 商品名のサフィックスリスト
     */
    private const NAME_SUFFIXES = [
        '3Dモデルセット',
        'テクスチャパック',
        'UIキット',
        'アイコンセット',
        'フォントファミリー',
        'ブラシコレクション',
        'グラデーションパック',
        'エフェクト素材',
        'テンプレート集',
        'マテリアルパック',
        'HDRIセット',
        'サウンドエフェクト',
        'モーショングラフィックス',
        'ベクター素材集',
        'イラスト素材',
    ];

    /**
     * 商品説明のリスト
     */
    private const DESCRIPTIONS = [
        '高品質な素材をお届けします。商用利用可能で、様々なプロジェクトにご活用いただけます。',
        'プロのクリエイター向けに制作した素材です。細部までこだわり抜いた品質をお約束します。',
        '初心者からプロまで幅広くお使いいただける素材セットです。チュートリアル付き。',
        'ゲーム開発や映像制作に最適な素材を厳選しました。即戦力として活用できます。',
        '最新のトレンドを取り入れたデザイン素材です。あなたのプロジェクトを格上げします。',
        '時間短縮に最適な素材パックです。クオリティを保ちながら効率的に制作できます。',
        '細部まで作り込んだ高解像度素材です。拡大しても美しさを保ちます。',
        'カスタマイズしやすい設計で、様々な用途に対応できます。',
    ];

    /**
     * 商品画像URLのリスト
     */
    private const IMAGE_URLS = [
        'https://m.media-amazon.com/images/I/61GGZRBy8KL.jpg',
    ];

    /**
     * モデルのデフォルト状態を定義
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->randomElement(self::NAME_PREFIXES) . fake()->randomElement(self::NAME_SUFFIXES);
        $price = fake()->numberBetween(5, 100) * 100; // 500円〜10,000円（100円単位）

        return [
            'seller_id' => null,
            'category_id' => null,
            'name' => $name,
            'slug' => Str::slug($name) . '-' . fake()->unique()->randomNumber(5),
            'description' => fake()->optional(0.9)->randomElement(self::DESCRIPTIONS),
            'price' => $price,
            'original_price' => fake()->optional(0.3)->numberBetween($price, $price * 2),
            'image_url' => fake()->randomElement(self::IMAGE_URLS),
            'file_format' => fake()->optional(0.7)->randomElement(['PNG', 'JPG', 'PSD', 'AI', 'FBX', 'OBJ', 'BLEND', 'MAX']),
            'file_size' => fake()->optional(0.7)->randomElement(['50MB', '100MB', '250MB', '500MB', '1.2GB', '2.5GB']),
            'status' => ProductStatus::PUBLISHED,
        ];
    }

    /**
     * 出品者に紐づいた商品
     */
    public function withSeller(Seller $seller = null): static
    {
        return $this->state(function (array $attributes) use ($seller) {
            return [
                'seller_id' => $seller?->id ?? Seller::factory(),
            ];
        });
    }

    /**
     * カテゴリーに紐づいた商品
     */
    public function withCategory(Category $category = null): static
    {
        return $this->state(function (array $attributes) use ($category) {
            return [
                'category_id' => $category?->id ?? Category::factory(),
            ];
        });
    }

    /**
     * 非公開の商品
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => ProductStatus::DRAFT,
        ]);
    }
}
