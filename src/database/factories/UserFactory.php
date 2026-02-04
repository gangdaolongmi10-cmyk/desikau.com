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
     * アイコンURLのリスト
     */
    private const ICON_URLS = [
        'https://yt3.googleusercontent.com/87cGpoLYzGJJWveiEfqBOX99uLoceI5H2aYIPrjSo5BAcgM7w4rAT4pCFni0_ZiU9ShvyVmAoQ=s900-c-k-c0x00ffffff-no-rj',
    ];

    /**
     * デフォルトの状態を定義
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake('ja_JP')->name(),
            'email' => fake('ja_JP')->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password1'),
            'icon_url' => fake()->randomElement(self::ICON_URLS),
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
     * アイコンURLを設定（特定のURL）
     */
    public function withIcon(string $url = null): static
    {
        return $this->state(fn (array $attributes) => [
            'icon_url' => $url ?? fake()->randomElement(self::ICON_URLS),
        ]);
    }

    /**
     * アイコンなし
     */
    public function withoutIcon(): static
    {
        return $this->state(fn (array $attributes) => [
            'icon_url' => null,
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
