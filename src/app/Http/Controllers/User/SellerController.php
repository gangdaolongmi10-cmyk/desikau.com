<?php

namespace App\Http\Controllers\User;

use App\Enums\ProductStatus;
use App\Http\Controllers\Controller;
use App\Models\Seller;
use App\Repositories\ProductRepository;
use Illuminate\Contracts\View\View;

/**
 * 出品者コントローラー
 */
final class SellerController extends Controller
{
    public function __construct(
        private readonly ProductRepository $productRepository
    ) {}

    /**
     * 出品者詳細ページを表示
     */
    public function detail(Seller $seller): View
    {
        // 出品者の公開商品を取得
        $products = $seller->products()
            ->where('status', ProductStatus::PUBLISHED)
            ->with('category')
            ->orderByDesc('created_at')
            ->get();

        // いいね状態を付与
        $products = $this->productRepository->attachLikedByMe($products);

        return view('user.seller.detail', compact('seller', 'products'));
    }
}
