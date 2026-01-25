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
        ]);
    }
}
