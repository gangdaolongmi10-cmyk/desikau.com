<?php

namespace App\Http\Controllers\Seller;

use App\Actions\Seller\DestroyProductAction;
use App\Actions\Seller\StoreProductAction;
use App\Actions\Seller\UpdateProductAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Seller\ProductStoreRequest;
use App\Http\Requests\Seller\ProductUpdateRequest;
use App\Models\Product;
use App\Models\Seller;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

/**
 * 出品者向け商品管理コントローラー
 */
class ProductController extends Controller
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly CategoryRepository $categoryRepository
    ) {}

    /**
     * 現在のSellerユーザーを取得
     */
    private function seller(): Seller
    {
        return Auth::guard('seller')->user();
    }

    /**
     * Sellerユーザーで認可チェック
     */
    private function authorizeForSeller(string $ability, mixed $arguments = []): void
    {
        Gate::forUser($this->seller())->authorize($ability, $arguments);
    }

    /**
     * 商品一覧を表示
     */
    public function index(): View
    {
        $this->authorizeForSeller('viewAny', Product::class);

        $products = $this->productRepository->getBySellerPaginated($this->seller()->id);

        return view('seller.product.index', compact('products'));
    }

    /**
     * 商品作成フォームを表示
     */
    public function create(): View
    {
        $this->authorizeForSeller('create', Product::class);

        $categories = $this->categoryRepository->getAll();

        return view('seller.product.create', compact('categories'));
    }

    /**
     * 商品を保存
     */
    public function store(ProductStoreRequest $request, StoreProductAction $action): RedirectResponse
    {
        $this->authorizeForSeller('create', Product::class);

        $action->execute(
            $this->seller(),
            $request->validated(),
            $request->file('file')
        );

        return redirect()
            ->route('seller.product.index')
            ->with('success', '商品を登録しました。');
    }

    /**
     * 商品編集フォームを表示
     */
    public function edit(Product $product): View
    {
        $this->authorizeForSeller('update', $product);

        $categories = $this->categoryRepository->getAll();

        return view('seller.product.edit', compact('product', 'categories'));
    }

    /**
     * 商品を更新
     */
    public function update(ProductUpdateRequest $request, Product $product, UpdateProductAction $action): RedirectResponse
    {
        $this->authorizeForSeller('update', $product);

        $action->execute(
            $product,
            $request->validated(),
            $request->file('file')
        );

        return redirect()
            ->route('seller.product.index')
            ->with('success', '商品を更新しました。');
    }

    /**
     * 商品を削除
     */
    public function destroy(Product $product, DestroyProductAction $action): RedirectResponse
    {
        $this->authorizeForSeller('delete', $product);

        $action->execute($product);

        return redirect()
            ->route('seller.product.index')
            ->with('success', '商品を削除しました。');
    }
}
