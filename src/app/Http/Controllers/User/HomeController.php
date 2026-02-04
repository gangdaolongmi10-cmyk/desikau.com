<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

/**
 * ホームコントローラー
 */
final class HomeController extends Controller
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly CategoryRepository $categoryRepository
    ) {}

    /**
     * ホーム画面を表示
     */
    public function index(): View
    {
        $products = $this->productRepository->getRecommendedProducts();
        $products = $this->productRepository->attachLikedByMe($products);
        $categories = $this->categoryRepository->getList();

        // お気に入り商品を取得（ログイン時のみ、最大4件）
        $likedProducts = collect();
        if (Auth::check()) {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            $likedProducts = $user->likedProducts()
                ->with(['category', 'seller'])
                ->orderByPivot('created_at', 'desc')
                ->limit(4)
                ->get();

            // いいね状態を付与（全てtrue）
            foreach ($likedProducts as $product) {
                $product->liked_by_me = true;
            }
        }

        return view('user.home.index', compact('products', 'categories', 'likedProducts'));
    }
}
