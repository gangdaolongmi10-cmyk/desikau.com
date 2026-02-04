<?php

namespace Database\Factories;

use App\Enums\InquiryStatus;
use App\Models\Inquiry;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * お問い合わせファクトリー
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Inquiry>
 */
class InquiryFactory extends Factory
{
    /**
     * モデル名
     */
    protected $model = Inquiry::class;

    /**
     * デフォルトの状態を定義
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $isUser = fake()->boolean(70);

        return [
            'user_id' => $isUser ? User::factory() : null,
            'guest_token' => $isUser ? null : (string) Str::uuid(),
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'message' => fake()->realText(500),
            'status' => fake()->randomElement(InquiryStatus::cases()),
        ];
    }

    /**
     * ログインユーザーからのお問い合わせ
     */
    public function fromUser(User $user = null): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => $user?->id ?? User::factory(),
            'guest_token' => null,
        ]);
    }

    /**
     * ゲストからのお問い合わせ
     */
    public function fromGuest(): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => null,
            'guest_token' => (string) Str::uuid(),
        ]);
    }

    /**
     * 未読のお問い合わせ
     */
    public function unread(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => InquiryStatus::UNREAD,
        ]);
    }

    /**
     * 既読のお問い合わせ
     */
    public function read(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => InquiryStatus::READ,
        ]);
    }

    /**
     * 返信済みのお問い合わせ
     */
    public function replied(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => InquiryStatus::REPLIED,
        ]);
    }
}
