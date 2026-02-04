<?php

namespace App\Http\Controllers\User;

use App\Enums\SortOrder;
use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
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
        private readonly CategoryRepository $categoryRepository
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

        // レビュー一覧を取得（新しい順）
        $reviews = $product->reviews()
            ->with('user')
            ->orderByDesc('created_at')
            ->get();

        // レビュー統計を計算
        $reviewStats = $this->calculateReviewStats($reviews);

        // ログインユーザーが既にレビュー済みか確認
        $userReview = null;
        if (Auth::check()) {
            $userReview = $reviews->where('user_id', Auth::id())->first();
        }

        return view('user.product.detail', compact('product', 'relatedProducts', 'reviews', 'reviewStats', 'userReview'));
    }

    /**
     * レビュー統計を計算
     *
     * @param \Illuminate\Database\Eloquent\Collection $reviews
     * @return array{average: float, count: int, distribution: array<int, array{count: int, percentage: int}>}
     */
    private function calculateReviewStats($reviews): array
    {
        $count = $reviews->count();

        if ($count === 0) {
            return [
                'average' => 0,
                'count' => 0,
                'distribution' => [
                    5 => ['count' => 0, 'percentage' => 0],
                    4 => ['count' => 0, 'percentage' => 0],
                    3 => ['count' => 0, 'percentage' => 0],
                    2 => ['count' => 0, 'percentage' => 0],
                    1 => ['count' => 0, 'percentage' => 0],
                ],
            ];
        }

        $average = round($reviews->avg('rating'), 1);

        $distribution = [];
        for ($i = 5; $i >= 1; $i--) {
            $ratingCount = $reviews->where('rating', $i)->count();
            $distribution[$i] = [
                'count' => $ratingCount,
                'percentage' => round(($ratingCount / $count) * 100),
            ];
        }

        return [
            'average' => $average,
            'count' => $count,
            'distribution' => $distribution,
        ];
    }
}
