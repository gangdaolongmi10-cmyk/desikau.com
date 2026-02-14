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
        $faker = fake('ja_JP');
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
            'name' => $faker->name(),
            'email' => $faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password1'),
            'icon_url' => fake()->randomElement(self::ICON_URLS),
            'postal_code' => $faker->optional(0.7)->postcode(),
            'prefecture' => $faker->optional(0.7)->randomElement($prefectures),
            'city' => $faker->optional(0.7)->city(),
            'address' => $faker->optional(0.7)->streetAddress(),
            'building' => $faker->optional(0.3)->secondaryAddress(),
            'phone_number' => $faker->optional(0.7)->phoneNumber(),
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
