<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

/**
 * データベースシーダー
 */
class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * データベースのシーディングを実行
     */
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            UserSeeder::class,
            SellerSeeder::class,
            SellerLegalInfoSeeder::class,
            ProductSeeder::class,
            PurchaseHistorySeeder::class,
            LikeSeeder::class,
            ReviewSeeder::class,
            AnnouncementSeeder::class,
        ]);
    }
}
