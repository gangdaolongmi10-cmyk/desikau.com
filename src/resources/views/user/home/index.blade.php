<x-user.common title="Welcome">
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <section class="mb-12">
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center gap-3">
                    <i data-lucide="sparkles" class="w-6 h-6 text-indigo-600"></i>
                    <h3 class="text-2xl font-bold text-gray-900">新着コンテンツ</h3>
                </div>
                <a href="{{ route('user.product.index') }}" class="flex items-center space-x-2 text-sm text-indigo-600 font-semibold hover:underline">
                    <span>すべて表示</span>
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @forelse ($products as $product)
                    <x-user.product-card
                        :product-id="$product->id"
                        :image="$product->image_url ?? 'https://via.placeholder.com/500'"
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
                @empty
                    <p class="col-span-4 text-center text-gray-500 py-12">商品がありません</p>
                @endforelse
            </div>
        </section>
        @auth
            @if ($likedProducts->count() > 0)
                <section class="mb-12">
                    <div class="flex items-center justify-between mb-8">
                        <div class="flex items-center gap-3">
                            <i data-lucide="heart" class="w-6 h-6 text-red-500"></i>
                            <h3 class="text-2xl font-bold text-gray-900">お気に入り</h3>
                        </div>
                        <a href="{{ route('user.like.index') }}" class="flex items-center space-x-2 text-sm text-indigo-600 font-semibold hover:underline">
                            <span>すべて表示</span>
                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </a>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                        @foreach ($likedProducts as $product)
                            <x-user.product-card
                                :product-id="$product->id"
                                :image="$product->image_url ?? 'https://via.placeholder.com/500'"
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
                </section>
            @endif
        @endauth
    </main>
</x-user.common>