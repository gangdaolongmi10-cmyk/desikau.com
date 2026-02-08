<?php

namespace App\Actions\Seller;

use App\Models\Seller;
use App\Models\SellerLegalInfo;

/**
 * 特定商取引法に基づく表記の作成・更新アクション
 */
final class UpsertSellerLegalInfoAction
{
    /**
     * 特定商取引法に基づく表記を作成または更新
     */
    public function execute(Seller $seller, array $validated): SellerLegalInfo
    {
        return SellerLegalInfo::updateOrCreate(
            ['seller_id' => $seller->id],
            $validated
        );
    }
}
