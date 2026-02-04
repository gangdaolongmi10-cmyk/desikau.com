<?php

namespace Database\Factories;

use App\Enums\AnnouncementStatus;
use App\Models\Announcement;
use App\Models\AnnouncementCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * お知らせファクトリ
 *
 * @extends Factory<Announcement>
 */
class AnnouncementFactory extends Factory
{
    protected $model = Announcement::class;

    /**
     * デフォルト状態
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $publishedAt = fake()->dateTimeBetween('-3 months', 'now');

        return [
            'title' => fake()->realText(50),
            'content' => fake()->realText(500),
            'status' => AnnouncementStatus::PUBLISHED,
            'category_id' => AnnouncementCategory::factory(),
            'published_at' => $publishedAt,
            'closed_at' => null,
        ];
    }

    /**
     * 公開中
     */
    public function published(): static
    {
        return $this->state(fn () => [
            'status' => AnnouncementStatus::PUBLISHED,
            'published_at' => fake()->dateTimeBetween('-1 month', 'now'),
            'closed_at' => null,
        ]);
    }

    /**
     * 終了済み
     */
    public function archived(): static
    {
        return $this->state(fn () => [
            'status' => AnnouncementStatus::ARCHIVED,
            'published_at' => fake()->dateTimeBetween('-3 months', '-1 month'),
            'closed_at' => fake()->dateTimeBetween('-1 month', 'now'),
        ]);
    }

    /**
     * 予約投稿
     */
    public function scheduled(): static
    {
        return $this->state(fn () => [
            'status' => AnnouncementStatus::PUBLISHED,
            'published_at' => fake()->dateTimeBetween('+1 day', '+1 month'),
            'closed_at' => null,
        ]);
    }

    /**
     * 期間限定
     */
    public function limited(): static
    {
        $publishedAt = fake()->dateTimeBetween('-1 month', 'now');

        return $this->state(fn () => [
            'status' => AnnouncementStatus::PUBLISHED,
            'published_at' => $publishedAt,
            'closed_at' => fake()->dateTimeBetween('+1 week', '+1 month'),
        ]);
    }
}
