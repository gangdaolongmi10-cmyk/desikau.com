<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Seller;
use Illuminate\Database\Seeder;

/**
 * 商品シーダー
 */
class ProductSeeder extends Seeder
{
    /**
     * シーダーを実行
     */
    public function run(): void
    {
        $sellers = Seller::all();
        $categories = Category::all();

        // 出品者が存在しない場合は作成
        if ($sellers->isEmpty()) {
            $sellers = Seller::factory()->count(5)->create();
        }

        // 各出品者に2〜5個の商品を作成
        foreach ($sellers as $seller) {
            $productCount = fake()->numberBetween(2, 5);

            Product::factory()
                ->count($productCount)
                ->create([
                    'seller_id' => $seller->id,
                    'category_id' => $categories->isNotEmpty()
                        ? $categories->random()->id
                        : null,
                ]);
        }
    }
}
