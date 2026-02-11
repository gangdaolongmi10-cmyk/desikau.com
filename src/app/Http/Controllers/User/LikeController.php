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

        $products = $this->productRepository->getLikedProductsByUser($user, $categorySlug, $sort);
        $categories = $this->categoryRepository->getList();
        $sortOptions = SortOrder::cases();

        return view('user.like.index', compact('products', 'categories', 'sortOptions', 'sort'));
    }
}
