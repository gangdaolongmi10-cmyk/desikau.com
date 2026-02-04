<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\PurchaseHistory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * 購入履歴ファクトリー
 *
 * @extends Factory<PurchaseHistory>
 */
class PurchaseHistoryFactory extends Factory
{
    protected $model = PurchaseHistory::class;

    /**
     * モデルのデフォルト状態を定義
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'product_id' => Product::factory(),
            'price' => fake()->numberBetween(5, 100) * 100,
            'status' => 1,
            'purchased_at' => now(),
        ];
    }
}
