<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use App\Repositories\ProductRepository;
use App\Repositories\SellerRepository;
use Illuminate\Contracts\View\View;

/**
 * 出品者コントローラー
 */
final class SellerController extends Controller
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly SellerRepository $sellerRepository
    ) {}

    /**
     * 出品者詳細ページを表示
     */
    public function detail(Seller $seller): View
    {
        $seller = $this->sellerRepository->loadWithLegalInfo($seller);
        $products = $this->productRepository->getPublishedBySeller($seller);
        $products = $this->productRepository->attachLikedByMe($products);

        return view('user.seller.detail', compact('seller', 'products'));
    }
}
