<x-user.common title="お気に入り">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 space-y-4 md:space-y-0">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <i data-lucide="heart" class="w-8 h-8 text-red-500"></i>
                    <h1 class="text-3xl font-extrabold text-gray-900">お気に入り</h1>
                </div>
                <p class="text-gray-500">気になる商品をまとめてチェック</p>
            </div>
            <p class="text-sm text-gray-500">{{ $products->total() }}件のお気に入り</p>
        </div>

        <!-- Category Filter & Sort -->
        <x-user.product-filter
            :categories="$categories"
            :sort-options="$sortOptions"
            :sort="$sort"
        />

        @if ($products->count() > 0)
            <!-- Product Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
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
                <div class="bg-red-50 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i data-lucide="heart" class="w-12 h-12 text-red-300"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">お気に入りがありません</h3>
                <p class="text-gray-500 mb-6">気になる商品のハートをクリックして<br>お気に入りに追加しましょう</p>
                <a href="{{ route('user.product.index') }}" class="inline-flex items-center gap-2 bg-indigo-600 text-white font-bold px-6 py-3 rounded-xl hover:bg-indigo-700 transition-all">
                    <i data-lucide="search" class="w-5 h-5"></i>
                    商品を探す
                </a>
            </div>
        @endif
    </div>
</x-user.common>
