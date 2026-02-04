<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\ProductLikeService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

/**
 * 商品いいねコントローラー
 */
class ProductLikeController extends Controller
{
    public function __construct(
        private readonly ProductLikeService $productLikeService
    ) {
    }

    /**
     * 商品にいいねを追加
     *
     * @param Product $product 対象商品
     * @return Response 204 No Content
     */
    public function store(Product $product): Response
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $this->productLikeService->addLike($product, $user);

        return response()->noContent();
    }

    /**
     * 商品からいいねを解除
     *
     * @param Product $product 対象商品
     * @return Response 204 No Content
     */
    public function destroy(Product $product): Response
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $this->productLikeService->removeLike($product, $user);

        return response()->noContent();
    }
}
