<?php

namespace Database\Seeders;

use App\Models\Seller;
use App\Models\SellerLegalInfo;
use Illuminate\Database\Seeder;

/**
 * 特定商取引法に基づく表記シーダー
 */
class SellerLegalInfoSeeder extends Seeder
{
    /**
     * シーダーを実行
     */
    public function run(): void
    {
        $sellers = Seller::all();

        if ($sellers->isEmpty()) {
            return;
        }

        foreach ($sellers as $seller) {
            // 既に表記がある場合はスキップ
            if ($seller->legalInfo()->exists()) {
                continue;
            }

            SellerLegalInfo::factory()
                ->withSeller($seller)
                ->create();
        }
    }
}
