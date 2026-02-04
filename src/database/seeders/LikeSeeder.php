<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * いいねテストデータシーダー
 */
class LikeSeeder extends Seeder
{
    /**
     * シーディングを実行
     */
    public function run(): void
    {
        $users = User::all();
        $products = Product::all();

        if ($users->isEmpty() || $products->isEmpty()) {
            return;
        }

        $likes = [];
        $likesCount = [];

        // 各ユーザーがランダムな商品にいいね
        foreach ($users as $user) {
            // 各ユーザーは1〜5個の商品にいいね
            $likeCount = rand(1, min(5, $products->count()));
            $likedProducts = $products->random($likeCount);

            foreach ($likedProducts as $product) {
                $likes[] = [
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // 商品ごとのいいね数をカウント
                if (!isset($likesCount[$product->id])) {
                    $likesCount[$product->id] = 0;
                }
                $likesCount[$product->id]++;
            }
        }

        // いいねデータを一括挿入
        DB::table('likes')->insert($likes);

        // 商品のlikes_countを更新
        foreach ($likesCount as $productId => $count) {
            Product::where('id', $productId)->update(['likes_count' => $count]);
        }
    }
}
