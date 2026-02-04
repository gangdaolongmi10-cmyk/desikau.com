<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * レビューシーダー
 */
class ReviewSeeder extends Seeder
{
    /**
     * シーダー実行
     */
    public function run(): void
    {
        $products = Product::all();
        $users = User::all();

        if ($products->isEmpty() || $users->isEmpty()) {
            $this->command->warn('商品またはユーザーが存在しないため、レビューシーダーをスキップします。');
            return;
        }

        // 各商品に対してランダムなレビューを生成
        foreach ($products as $product) {
            // 商品ごとに0〜5件のレビューを生成
            $reviewCount = fake()->numberBetween(0, 5);
            $reviewers = $users->random(min($reviewCount, $users->count()));

            foreach ($reviewers as $user) {
                // 既にレビュー済みでないことを確認
                $exists = Review::where('product_id', $product->id)
                    ->where('user_id', $user->id)
                    ->exists();

                if (!$exists) {
                    // 80%の確率で高評価、20%の確率で低評価
                    if (fake()->boolean(80)) {
                        Review::factory()
                            ->highRating()
                            ->create([
                                'product_id' => $product->id,
                                'user_id' => $user->id,
                            ]);
                    } else {
                        Review::factory()
                            ->lowRating()
                            ->create([
                                'product_id' => $product->id,
                                'user_id' => $user->id,
                            ]);
                    }
                }
            }
        }
    }
}
