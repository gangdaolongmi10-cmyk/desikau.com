<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * ユーザーのシーダー
 */
final class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * テスト用ユーザーデータ
     */
    private const TEST_USERS = [
        [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => 'password1',
        ],
        [
            'name' => '管理者',
            'email' => 'admin@example.com',
            'password' => 'admin1234',
        ],
    ];

    /**
     * ユーザーのシーディングを実行
     */
    public function run(): void
    {
        // テスト用ユーザーを作成
        foreach (self::TEST_USERS as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'email' => $userData['email'],
                    'password' => Hash::make($userData['password']),
                    'email_verified_at' => now(),
                ]
            );
        }

        // ダミーユーザーを10件作成（重複を避けるため既存ユーザー以外）
        User::factory()
            ->count(10)
            ->withIcon()
            ->create();
    }
}
