<?php

namespace Database\Seeders;

use App\Models\Seller;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * 出品者シーダー
 */
class SellerSeeder extends Seeder
{
    /**
     * シーダーを実行
     */
    public function run(): void
    {
        // 既存ユーザーを取得
        $users = User::all();

        // 一部のユーザーを出品者として登録（アイコン・名前表示用）
        $sellerUsers = $users->take(3);
        foreach ($sellerUsers as $user) {
            Seller::factory()->withUser($user)->create();
        }

        // ユーザーと紐づかない出品者も作成
        Seller::factory()->count(2)->create();
    }
}
