<x-user.common title="商品一覧">
    <div class="max-w-7xl mx-auto px-4">

        <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 space-y-4 md:space-y-0">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900">デジタルアセットを探す</h1>
                <p class="text-gray-500 mt-2">最高品質の素材で、あなたのクリエイティブを加速させます。</p>
            </div>
        </div>

        <!-- Category Filter & Sort -->
        <x-user.product-filter
            :categories="$categories"
            :sort-options="$sortOptions"
            :sort="$sort"
        />

        @if ($products->count() > 0)
            <!-- Product Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8" id="product-grid">
                @foreach ($products as $product)
                    <x-user.product-card
                        :product-id="$product->id"
                        :image="$product->image_url ?? 'https://via.placeholder.com/600'"
                        :category="$product->category?->name ?? ''"
                        :category-slug="$product->category?->slug ?? ''"
                        :title="$product->name"
                        :description="$product->description"
                        :author="$product->seller?->user?->name ?? $product->seller?->shop_name"
                        :author-slug="$product->seller?->slug"
                        :author-icon="$product->seller?->user?->icon_url"
                        :price="$product->price"
                        :slug="$product->slug"
                        :liked="$product->liked_by_me ?? false"
                    />
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $products->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-20">
                <div class="bg-gray-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-400">
                    <i data-lucide="search-x" class="w-10 h-10"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">該当する商品が見つかりません</h3>
                <p class="text-gray-500">別のカテゴリーをお試しください。</p>
            </div>
        @endif
    </div>
</x-user.common>
