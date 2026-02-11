<?php

namespace App\Http\Controllers\User;

use App\Enums\SortOrder;
use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ReviewRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * 商品コントローラー
 */
final class ProductController extends Controller
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly CategoryRepository $categoryRepository,
        private readonly ReviewRepository $reviewRepository
    ) {}

    /**
     * 商品一覧を表示
     */
    public function index(Request $request): View
    {
        $categorySlug = $request->query('category');
        $keyword = $request->query('q');
        $sort = SortOrder::fromString($request->query('sort'));
        $products = $this->productRepository->getPublishedProducts($categorySlug, $keyword, $sort);
        $products = $this->productRepository->attachLikedByMe($products);
        $categories = $this->categoryRepository->getList();
        $sortOptions = SortOrder::cases();

        return view('user.product.index', compact('products', 'categories', 'categorySlug', 'keyword', 'sort', 'sortOptions'));
    }

    /**
     * 商品詳細を表示
     */
    public function detail(string $slug): View
    {
        $product = $this->productRepository->findBySlug($slug);

        if (!$product) {
            abort(404);
        }

        $product = $this->productRepository->attachLikedByMeToSingle($product);
        $relatedProducts = $this->productRepository->getRelatedProducts($product);
        $relatedProducts = $this->productRepository->attachLikedByMe($relatedProducts);

        $reviews = $this->reviewRepository->getByProduct($product);
        $reviewStats = $this->reviewRepository->calculateStats($reviews);

        // ログインユーザーが既にレビュー済みか確認
        $userReview = null;
        if (Auth::check()) {
            $userReview = $reviews->where('user_id', Auth::id())->first();
        }

        return view('user.product.detail', compact('product', 'relatedProducts', 'reviews', 'reviewStats', 'userReview'));
    }
}
