<?php

namespace App\Actions\User;

use App\Models\Seller;
use App\Repositories\SellerRepository;
use Illuminate\Support\Facades\Auth;

/**
 * 出品者登録アクション
 */
final class RegisterSellerAction
{
    public function __construct(
        private readonly SellerRepository $sellerRepository
    ) {}

    /**
     * 出品者を登録しログイン
     */
    public function execute(array $validated): Seller
    {
        $seller = $this->sellerRepository->create($validated);

        Auth::guard('seller')->login($seller);

        return $seller;
    }
}
