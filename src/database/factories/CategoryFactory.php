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
     * デフォルトの状態を定義
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->randomElement([
            'テストカテゴリー1',
            'テストカテゴリー2',
            'テストカテゴリー3',
            'テストカテゴリー4',
            'テストカテゴリー5',
        ]);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
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
