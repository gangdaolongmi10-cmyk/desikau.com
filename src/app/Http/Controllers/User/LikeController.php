<?php

namespace App\Http\Controllers\User;

use App\Enums\SortOrder;
use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * お気に入りコントローラー
 */
final class LikeController extends Controller
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly CategoryRepository $categoryRepository
    ) {}

    /**
     * お気に入り一覧を表示
     */
    public function index(Request $request): View
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $categorySlug = $request->query('category');
        $sort = SortOrder::fromString($request->query('sort'));

        // お気に入り商品のクエリを構築
        $query = $user->likedProducts()
            ->with(['category', 'seller']);

        // カテゴリーで絞り込み
        if ($categorySlug) {
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        // ソート
        if ($sort === SortOrder::OLDEST) {
            $query->orderByPivot('created_at', 'asc');
        } else {
            $query->orderByPivot('created_at', 'desc');
        }

        $products = $query->paginate(12)->withQueryString();

        // いいね状態を付与（全てtrue）
        foreach ($products as $product) {
            $product->liked_by_me = true;
        }

        $categories = $this->categoryRepository->getList();
        $sortOptions = SortOrder::cases();

        return view('user.like.index', compact('products', 'categories', 'sortOptions', 'sort'));
    }
}
