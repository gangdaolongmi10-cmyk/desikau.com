<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

/**
 * カテゴリーのシーダー
 */
final class CategorySeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * マスターデータとなるカテゴリー一覧
     */
    private const CATEGORIES = [
        [
            'name' => '3Dモデル',
            'slug' => '3d-models',
            'sort_no' => 1,
            'is_active' => true,
        ],
        [
            'name' => 'プラグイン',
            'slug' => 'plugins',
            'sort_no' => 2,
            'is_active' => true,
        ],
        [
            'name' => 'UIキット',
            'slug' => 'ui-kits',
            'sort_no' => 3,
            'is_active' => true,
        ],
        [
            'name' => '電子書籍',
            'slug' => 'ebooks',
            'sort_no' => 4,
            'is_active' => true,
        ],
        [
            'name' => '楽曲・SE',
            'slug' => 'audio',
            'sort_no' => 5,
            'is_active' => true,
        ],
        [
            'name' => '動画テンプレート',
            'slug' => 'video-templates',
            'sort_no' => 6,
            'is_active' => true,
        ],
    ];

    /**
     * カテゴリーのシーディングを実行
     */
    public function run(): void
    {
        foreach (self::CATEGORIES as $categoryData) {
            Category::updateOrCreate(
                ['slug' => $categoryData['slug']],
                $categoryData
            );
        }
    }
}
