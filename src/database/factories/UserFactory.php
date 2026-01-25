<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * ユーザーのファクトリー
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
final class UserFactory extends Factory
{
    /**
     * モデルクラス
     */
    protected $model = User::class;

    /**
     * キャッシュされたパスワードハッシュ
     */
    protected static ?string $password = null;

    /**
     * デフォルトの状態を定義
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake('ja_JP')->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password1'),
            'icon_url' => null,
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * メール未認証状態
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * アイコンURLを設定
     */
    public function withIcon(): static
    {
        return $this->state(fn (array $attributes) => [
            'icon_url' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=' . Str::random(10),
        ]);
    }

    /**
     * 指定したパスワードを設定
     */
    public function withPassword(string $password): static
    {
        return $this->state(fn (array $attributes) => [
            'password' => Hash::make($password),
        ]);
    }
}
