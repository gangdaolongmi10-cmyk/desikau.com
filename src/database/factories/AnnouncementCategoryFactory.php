<?php

namespace Database\Factories;

use App\Models\AnnouncementCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * お知らせカテゴリファクトリ
 *
 * @extends Factory<AnnouncementCategory>
 */
class AnnouncementCategoryFactory extends Factory
{
    protected $model = AnnouncementCategory::class;

    /**
     * デフォルト状態
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement(['重要', 'メンテナンス', 'アップデート', 'キャンペーン', 'その他']),
            'slug' => fake()->unique()->slug(1),
            'color' => fake()->randomElement([
                AnnouncementCategory::COLOR_RED,
                AnnouncementCategory::COLOR_ORANGE,
                AnnouncementCategory::COLOR_BLUE,
                AnnouncementCategory::COLOR_GREEN,
                AnnouncementCategory::COLOR_GRAY,
            ]),
            'sort_order' => fake()->numberBetween(0, 10),
        ];
    }

    /**
     * 重要カテゴリ
     */
    public function important(): static
    {
        return $this->state(fn () => [
            'name' => '重要',
            'slug' => 'important',
            'color' => AnnouncementCategory::COLOR_RED,
            'sort_order' => 0,
        ]);
    }

    /**
     * メンテナンスカテゴリ
     */
    public function maintenance(): static
    {
        return $this->state(fn () => [
            'name' => 'メンテナンス',
            'slug' => 'maintenance',
            'color' => AnnouncementCategory::COLOR_ORANGE,
            'sort_order' => 1,
        ]);
    }

    /**
     * アップデートカテゴリ
     */
    public function update(): static
    {
        return $this->state(fn () => [
            'name' => 'アップデート',
            'slug' => 'update',
            'color' => AnnouncementCategory::COLOR_BLUE,
            'sort_order' => 2,
        ]);
    }

    /**
     * キャンペーンカテゴリ
     */
    public function campaign(): static
    {
        return $this->state(fn () => [
            'name' => 'キャンペーン',
            'slug' => 'campaign',
            'color' => AnnouncementCategory::COLOR_GREEN,
            'sort_order' => 3,
        ]);
    }
}
