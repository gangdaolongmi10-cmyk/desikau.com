<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * カテゴリーのファクトリー
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
final class CategoryFactory extends Factory
{
    /**
     * モデルクラス
     */
    protected $model = Category::class;

    /**
     * ソート番号のカウンター
     */
    private static int $sortCounter = 1;

    /**
     * カテゴリー名のリスト
     */
    private const CATEGORY_NAMES = [
        '3Dモデル',
        'テクスチャ・マテリアル',
        'UIキット',
        'アイコン',
        'フォント',
        'イラスト素材',
        ' 写真素材',
        'サウンド・音楽',
        'テンプレート',
        'ブラシ・ツール',
        'モーショングラフィックス',
        'ゲームアセット',
        'プラグイン・拡張機能',
        'チュートリアル・教材',
        'その他',
    ];

    /**
     * デフォルトの状態を定義
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->randomElement(self::CATEGORY_NAMES);

        return [
            'name' => $name,
            'slug' => Str::slug($name) . '-' . fake()->unique()->randomNumber(3),
            'sort_no' => self::$sortCounter++,
            'is_active' => true,
        ];
    }

    /**
     * 無効状態のカテゴリー
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * カウンターをリセット
     */
    public static function resetSortCounter(): void
    {
        self::$sortCounter = 1;
    }
}
