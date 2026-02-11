<?php

namespace App\Repositories;

use App\Enums\ProductStatus;
use App\Enums\SortOrder;
use App\Models\Order;
use App\Models\Product;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

/**
 * 商品リポジトリ
 */
class ProductRepository
{
    /** 1ページあたりの表示件数 */
    private const PER_PAGE = 12;

    /** ランキングキャッシュキー */
    private const RANKING_CACHE_KEY = 'product_ranking';

    /** ランキングキャッシュTTL（秒） */
    private const RANKING_CACHE_TTL = 300;

    /**
     * 公開中の商品一覧をページネーションで取得
     *
     * @param string|null $categorySlug カテゴリーのslugでフィルタ
     * @param string|null $keyword 検索キーワード（商品名・カテゴリ名でLIKE検索）
     * @param SortOrder $sort ソート順
     * @param int $perPage 1ページあたりの件数
     */
    public function getPublishedProducts(?string $categorySlug = null, ?string $keyword = null, SortOrder $sort = SortOrder::NEWEST, int $perPage = self::PER_PAGE): LengthAwarePaginator
    {
        $query = Product::query()
            ->with(['category', 'seller'])
            ->where('products.status', ProductStatus::PUBLISHED);

        // カテゴリでフィルタ
        if ($categorySlug) {
            $query->join('categories', 'products.category_id', '=', 'categories.id')
                ->where('categories.slug', $categorySlug)
                ->select('products.*');
        }

        // キーワード検索（商品名・カテゴリ名でLIKE検索）
        if ($keyword) {
            $query->where(function ($q) use ($keyword, $categorySlug) {
                $q->where('products.name', 'LIKE', "%{$keyword}%");

                // カテゴリフィルタがない場合のみカテゴリ名でも検索
                if (!$categorySlug) {
                    $q->orWhereHas('category', function ($categoryQuery) use ($keyword) {
                        $categoryQuery->where('name', 'LIKE', "%{$keyword}%");
                    });
                }
            });
        }

        return $query->orderBy('products.created_at', $sort->direction())
            ->paginate($perPage)
            ->withQueryString();
    }

    /**
     * slugで商品を取得
     */
    public function findBySlug(string $slug): ?Product
    {
        return Product::query()
            ->with(['category', 'seller'])
            ->where('slug', $slug)
            ->where('status', ProductStatus::PUBLISHED)
            ->first();
    }

    /**
     * おすすめ商品を取得（ホーム画面用）
     *
     * @param int $limit 取得件数
     * @return Collection<int, Product>
     */
    public function getRecommendedProducts(int $limit = 4): Collection
    {
        return Product::query()
            ->with(['category', 'seller'])
            ->where('status', ProductStatus::PUBLISHED)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * 関連商品を取得（同じカテゴリーの商品）
     *
     * @param Product $product 基準となる商品
     * @param int $limit 取得件数
     * @return Collection<int, Product>
     */
    public function getRelatedProducts(Product $product, int $limit = 4): Collection
    {
        return Product::query()
            ->with(['category', 'seller'])
            ->where('status', ProductStatus::PUBLISHED)
            ->where('id', '!=', $product->id)
            ->when($product->category_id, function ($query) use ($product) {
                $query->where('category_id', $product->category_id);
            })
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * 商品コレクションに認証ユーザーのいいね状態(liked_by_me)を付与
     *
     * @param Collection<int, Product>|LengthAwarePaginator $products 商品コレクション
     * @param User|null $user ユーザー（nullの場合は認証ユーザーを使用）
     * @return Collection<int, Product>|LengthAwarePaginator
     */
    public function attachLikedByMe(Collection|LengthAwarePaginator $products, ?User $user = null): Collection|LengthAwarePaginator
    {
        $user = $user ?? Auth::user();

        if (!$user) {
            // 未認証の場合は全てfalse
            foreach ($products as $product) {
                $product->liked_by_me = false;
            }
            return $products;
        }

        // ユーザーがいいねしている商品IDを取得
        $likedProductIds = $user->likedProducts()
            ->whereIn('products.id', $products->pluck('id'))
            ->pluck('products.id')
            ->toArray();

        // 各商品にliked_by_meを付与
        foreach ($products as $product) {
            $product->liked_by_me = in_array($product->id, $likedProductIds);
        }

        return $products;
    }

    /**
     * 単一商品に認証ユーザーのいいね状態(liked_by_me)を付与
     *
     * @param Product $product 商品
     * @param User|null $user ユーザー（nullの場合は認証ユーザーを使用）
     * @return Product
     */
    public function attachLikedByMeToSingle(Product $product, ?User $user = null): Product
    {
        $user = $user ?? Auth::user();

        if (!$user) {
            $product->liked_by_me = false;
            return $product;
        }

        $product->liked_by_me = $product->likedUsers()->where('user_id', $user->id)->exists();

        return $product;
    }

    /**
     * ユーザーのお気に入り商品をページネーションで取得
     *
     * @param User $user ユーザー
     * @param string|null $categorySlug カテゴリーのslugでフィルタ
     * @param SortOrder $sort ソート順
     * @param int $perPage 1ページあたりの件数
     */
    public function getLikedProductsByUser(User $user, ?string $categorySlug = null, SortOrder $sort = SortOrder::NEWEST, int $perPage = self::PER_PAGE): LengthAwarePaginator
    {
        $query = $user->likedProducts()
            ->with(['category', 'seller']);

        if ($categorySlug) {
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        if ($sort === SortOrder::OLDEST) {
            $query->orderByPivot('created_at', 'asc');
        } else {
            $query->orderByPivot('created_at', 'desc');
        }

        $products = $query->paginate($perPage)->withQueryString();

        // お気に入り一覧なのでいいね状態は全てtrue
        foreach ($products as $product) {
            $product->liked_by_me = true;
        }

        return $products;
    }

    /**
     * 出品者の公開中商品を取得
     *
     * @param Seller $seller 出品者
     * @return Collection<int, Product>
     */
    public function getPublishedBySeller(Seller $seller): Collection
    {
        return $seller->products()
            ->where('status', ProductStatus::PUBLISHED)
            ->with('category')
            ->orderByDesc('created_at')
            ->get();
    }

    /**
     * 出品者の商品をページネーションで取得（出品者管理画面用）
     *
     * @param int $sellerId 出品者ID
     * @param int $perPage 1ページあたりの件数
     */
    public function getBySellerPaginated(int $sellerId, int $perPage = 10): LengthAwarePaginator
    {
        return Product::where('seller_id', $sellerId)
            ->with('category')
            ->orderByDesc('created_at')
            ->paginate($perPage);
    }

    /**
     * 売上ランキング商品を取得（キャッシュ付き）
     *
     * order_items × orders(paid) のCOUNT集計でランキングを算出し、
     * 5分間キャッシュする。
     *
     * @param int $limit 取得件数
     * @return Collection<int, Product>
     */
    public function getRankedProducts(int $limit = 4): Collection
    {
        $rankedProductIds = Cache::remember(
            self::RANKING_CACHE_KEY,
            self::RANKING_CACHE_TTL,
            function () use ($limit) {
                return DB::table('order_items')
                    ->join('orders', 'order_items.order_id', '=', 'orders.id')
                    ->where('orders.status', Order::STATUS_PAID)
                    ->select('order_items.product_id', DB::raw('SUM(order_items.quantity) as total_sales'))
                    ->groupBy('order_items.product_id')
                    ->orderByDesc('total_sales')
                    ->limit($limit)
                    ->pluck('total_sales', 'order_items.product_id');
            }
        );

        if ($rankedProductIds->isEmpty()) {
            return new Collection();
        }

        // 商品を取得し、ランキング順を維持
        $products = Product::query()
            ->with(['category', 'seller'])
            ->where('status', ProductStatus::PUBLISHED)
            ->whereIn('id', $rankedProductIds->keys())
            ->get()
            ->sortBy(function (Product $product) use ($rankedProductIds) {
                return -($rankedProductIds[$product->id] ?? 0);
            })
            ->values();

        return $products;
    }
}
