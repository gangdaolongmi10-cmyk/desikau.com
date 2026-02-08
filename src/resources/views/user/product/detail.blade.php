<x-user.common :title="$product->name">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Breadcrumbs -->
        <nav class="flex items-center space-x-2 text-sm text-gray-400 mb-8">
            <a href="{{ route('user.product.index') }}" class="hover:text-indigo-600">ストア</a>
            <i data-lucide="chevron-right" class="w-4 h-4"></i>
            @if ($product->category)
                <a href="{{ route('user.product.index', ['category' => $product->category->slug]) }}" class="hover:text-indigo-600">{{ $product->category->name }}</a>
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
            @endif
            <span class="text-gray-900 font-medium">{{ $product->name }}</span>
        </nav>

        <div class="lg:grid lg:grid-cols-2 lg:gap-x-12">
            <!-- Product Gallery (Left) -->
            <div class="space-y-4">
                <div class="aspect-square w-full rounded-3xl overflow-hidden bg-white border border-gray-100 shadow-sm">
                    <img id="main-image" src="{{ $product->image_url ?? 'https://via.placeholder.com/1200' }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition-opacity duration-300">
                </div>
            </div>

            <!-- Product Details (Right) -->
            <div class="mt-10 lg:mt-0 px-2 flex flex-col">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        @if ($product->category)
                            <a href="{{ route('user.product.index', ['category' => $product->category->slug]) }}" class="bg-indigo-50 text-indigo-600 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider hover:bg-indigo-100 transition-colors">{{ $product->category->name }}</a>
                        @endif
                        <span class="bg-gray-100 text-gray-500 text-xs font-medium px-3 py-1 rounded-full">デジタル限定</span>
                    </div>

                    <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4 leading-tight">
                        {{ $product->name }}
                    </h1>

                    <div class="flex items-center space-x-4 mb-6">
                        <p class="text-3xl font-bold text-gray-900">¥{{ number_format($product->price) }}</p>
                        @if ($product->original_price && $product->original_price > $product->price)
                            <span class="text-sm text-gray-400 line-through">¥{{ number_format($product->original_price) }}</span>
                            @php
                                $discountRate = round((1 - $product->price / $product->original_price) * 100);
                            @endphp
                            <span class="bg-red-100 text-red-600 text-xs font-bold px-2 py-0.5 rounded">{{ $discountRate }}% OFF</span>
                        @endif
                    </div>

                    @if ($product->description)
                        <div class="prose prose-sm text-gray-600 mb-8">
                            {!! nl2br(e($product->description)) !!}
                        </div>
                    @endif
                </div>

                <!-- Action Buttons -->
                <div class="mt-auto space-y-4 pt-8 border-t border-gray-100">
                    <div class="flex space-x-4">
                        <button onclick="addToCart({{ $product->id }})" class="flex-1 bg-indigo-600 text-white py-4 rounded-2xl font-bold hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200 flex items-center justify-center space-x-2 active:scale-[0.98]">
                            <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                            <span>カートに追加する</span>
                        </button>
                        <button
                            id="detail-fav-btn"
                            onclick="toggleLike({{ $product->id }}, this)"
                            class="p-4 rounded-2xl border border-gray-200 hover:bg-gray-50 transition-all group"
                            data-liked="{{ ($product->liked_by_me ?? false) ? 'true' : 'false' }}"
                        >
                            <i data-lucide="heart" class="w-6 h-6 transition-colors {{ ($product->liked_by_me ?? false) ? 'text-red-500 fill-red-500' : 'text-gray-400 group-hover:text-red-500' }}"></i>
                        </button>
                        <x-user.share-button :title="$product->name" />
                    </div>

                    <div class="bg-indigo-50 rounded-2xl p-4 flex items-start space-x-3">
                        <i data-lucide="info" class="w-5 h-5 text-indigo-600 mt-0.5"></i>
                        <p class="text-[11px] text-indigo-800 leading-relaxed">
                            <strong>デジタルコンテンツについて:</strong> 本商品は決済完了後、即座にマイページからダウンロード可能です。物理的な発送はございません。
                        </p>
                    </div>
                </div>

                <!-- Specifications -->
                @if ($product->file_format || $product->file_size)
                    <div class="mt-8 grid grid-cols-2 gap-4">
                        @if ($product->file_format)
                            <div>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-1">ファイル形式</p>
                                <p class="text-sm font-semibold text-gray-700">{{ $product->file_format }}</p>
                            </div>
                        @endif
                        @if ($product->file_size)
                            <div>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-1">サイズ</p>
                                <p class="text-sm font-semibold text-gray-700">{{ $product->file_size }}</p>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Seller Info -->
                @if ($product->seller)
                    <div class="mt-8 pt-8 border-t border-gray-100">
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-3">出品者</p>
                        <a href="{{ route('user.seller.detail', $product->seller->slug) }}" class="flex items-center space-x-4 p-4 bg-gray-50 rounded-2xl hover:bg-gray-100 transition-colors group">
                            <div class="w-12 h-12 rounded-xl overflow-hidden flex-shrink-0">
                                @if ($product->seller->user?->icon_url)
                                    <img src="{{ $product->seller->user->icon_url }}" alt="{{ $product->seller->user->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-indigo-100 flex items-center justify-center">
                                        <i data-lucide="user" class="w-6 h-6 text-indigo-600"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-bold text-gray-900 group-hover:text-indigo-600 transition-colors truncate">{{ $product->seller->user?->name ?? $product->seller->shop_name }}</p>
                                <p class="text-xs text-gray-500">{{ $product->seller->main_category }}</p>
                            </div>
                            <i data-lucide="chevron-right" class="w-5 h-5 text-gray-400 group-hover:text-indigo-600 transition-colors"></i>
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Related Products -->
        @if ($relatedProducts->count() > 0)
            <section class="mt-20">
                <h3 class="text-xl font-bold mb-8">こちらの関連商品もおすすめ</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    @foreach ($relatedProducts as $relatedProduct)
                        <x-user.product-card
                            :product-id="$relatedProduct->id"
                            :image="$relatedProduct->image_url ?? 'https://via.placeholder.com/400'"
                            :category="$relatedProduct->category?->name ?? ''"
                            :category-slug="$relatedProduct->category?->slug ?? ''"
                            :title="$relatedProduct->name"
                            :description="$relatedProduct->description"
                            :author="$relatedProduct->seller?->user?->name ?? $relatedProduct->seller?->shop_name"
                            :author-slug="$relatedProduct->seller?->slug"
                            :author-icon="$relatedProduct->seller?->user?->icon_url"
                            :price="$relatedProduct->price"
                            :slug="$relatedProduct->slug"
                            :liked="$relatedProduct->liked_by_me ?? false"
                        />
                    @endforeach
                </div>
            </section>
        @endif
    </div>

    <div class="max-w-7xl mx-auto px-4 mt-20 space-y-12">
        {{-- フラッシュメッセージ --}}
        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-2xl flex items-center gap-3">
                <i data-lucide="check-circle" class="w-5 h-5"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-2xl flex items-center gap-3">
                <i data-lucide="alert-circle" class="w-5 h-5"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Review Summary Section -->
        <section class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm">
            <h2 class="text-2xl font-bold text-gray-900 mb-8">カスタマーレビュー</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 items-center">
                <!-- Average Score -->
                <div class="text-center">
                    @if ($reviewStats['count'] > 0)
                        <p class="text-6xl font-extrabold text-indigo-600">{{ $reviewStats['average'] }}</p>
                        <div class="flex justify-center my-3">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= round($reviewStats['average']))
                                    <i data-lucide="star" class="w-5 h-5 text-orange-400 fill-orange-400"></i>
                                @else
                                    <i data-lucide="star" class="w-5 h-5 text-gray-300"></i>
                                @endif
                            @endfor
                        </div>
                        <p class="text-sm text-gray-500 font-medium">{{ $reviewStats['count'] }}件のレビュー</p>
                    @else
                        <p class="text-6xl font-extrabold text-gray-300">-</p>
                        <div class="flex justify-center my-3 text-gray-300">
                            @for ($i = 1; $i <= 5; $i++)
                                <i data-lucide="star" class="w-5 h-5"></i>
                            @endfor
                        </div>
                        <p class="text-sm text-gray-500 font-medium">まだレビューはありません</p>
                    @endif
                </div>

                <!-- Score Distribution -->
                <div class="md:col-span-2 space-y-3">
                    @for ($i = 5; $i >= 1; $i--)
                        <div class="flex items-center space-x-4 text-sm font-medium {{ $reviewStats['distribution'][$i]['count'] > 0 ? 'text-gray-700' : 'text-gray-300' }}">
                            <span class="w-12">{{ $i }}つ星</span>
                            <div class="flex-grow h-2 bg-gray-100 rounded-full overflow-hidden">
                                <div class="bg-indigo-500 h-full transition-all duration-300" style="width: {{ $reviewStats['distribution'][$i]['percentage'] }}%"></div>
                            </div>
                            <span class="w-10 text-right">{{ $reviewStats['distribution'][$i]['percentage'] }}%</span>
                        </div>
                    @endfor
                </div>
            </div>
        </section>

        <!-- Post Review Section -->
        @auth
            @if (!$userReview)
                <section class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm">
                    <h3 class="text-lg font-bold mb-4">レビューを投稿する</h3>

                    <form action="{{ route('user.product.review.store', $product) }}" method="POST">
                        @csrf

                        {{-- 評価（星） --}}
                        <div class="mb-4">
                            <div class="flex space-x-1" id="rating-stars">
                                @for ($i = 1; $i <= 5; $i++)
                                    <button type="button" onclick="setRating({{ $i }})" class="rating-star hover:scale-110 transition-transform text-gray-300 hover:text-orange-400">
                                        <i data-lucide="star" class="w-6 h-6"></i>
                                    </button>
                                @endfor
                            </div>
                            <input type="hidden" name="rating" id="rating-input" value="{{ old('rating', 0) }}">
                            @error('rating')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- タイトル --}}
                        <div class="mb-4">
                            <input
                                type="text"
                                name="title"
                                value="{{ old('title') }}"
                                placeholder="レビューのタイトル"
                                class="w-full bg-gray-50 border border-gray-100 rounded-xl px-5 py-3 focus:bg-white focus:ring-2 focus:ring-indigo-100 focus:border-indigo-600 outline-none transition-all @error('title') border-red-300 @enderror"
                            >
                            @error('title')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- 本文 --}}
                        <div class="mb-4">
                            <textarea
                                name="body"
                                rows="3"
                                placeholder="この商品についてどう思いましたか？"
                                class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-5 py-4 focus:bg-white focus:ring-2 focus:ring-indigo-100 focus:border-indigo-600 outline-none transition-all resize-none @error('body') border-red-300 @enderror"
                            >{{ old('body') }}</textarea>
                            @error('body')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-indigo-600 text-white font-bold px-8 py-3 rounded-xl hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-100">
                                投稿する
                            </button>
                        </div>
                    </form>
                </section>
            @else
                <section class="bg-indigo-50 rounded-3xl p-6 border border-indigo-100">
                    <div class="flex items-center gap-3 text-indigo-700">
                        <i data-lucide="check-circle" class="w-5 h-5"></i>
                        <span class="font-medium">この商品にはレビューを投稿済みです</span>
                    </div>
                </section>
            @endif
        @else
            <section class="bg-gray-50 rounded-3xl p-8 border border-gray-100 text-center">
                <p class="text-gray-600 mb-4">レビューを投稿するにはログインが必要です</p>
                <a href="{{ route('user.login.index') }}" class="inline-flex items-center gap-2 bg-indigo-600 text-white font-bold px-6 py-3 rounded-xl hover:bg-indigo-700 transition-all">
                    <i data-lucide="log-in" class="w-5 h-5"></i>
                    ログインする
                </a>
            </section>
        @endauth

        <!-- Reviews List -->
        <div class="space-y-6">
            <div class="flex items-center justify-between px-2">
                <p class="font-bold text-gray-900">{{ $reviews->count() }}件のレビュー</p>
            </div>

            @if ($reviews->count() > 0)
                <div class="space-y-4">
                    @foreach ($reviews as $review)
                        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center gap-3">
                                    {{-- ユーザーアイコン --}}
                                    <div class="w-10 h-10 rounded-full overflow-hidden flex-shrink-0">
                                        @if ($review->user->icon_url)
                                            <img src="{{ $review->user->icon_url }}" alt="{{ $review->user->name }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-indigo-100 flex items-center justify-center">
                                                <i data-lucide="user" class="w-5 h-5 text-indigo-600"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-900">{{ $review->user->name }}</p>
                                        <p class="text-xs text-gray-400">{{ $review->created_at->format('Y年n月j日') }}</p>
                                    </div>
                                </div>

                                {{-- 評価（星） --}}
                                <div class="flex items-center gap-1">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $review->rating)
                                            <i data-lucide="star" class="w-4 h-4 text-orange-400 fill-orange-400"></i>
                                        @else
                                            <i data-lucide="star" class="w-4 h-4 text-gray-300"></i>
                                        @endif
                                    @endfor
                                </div>
                            </div>

                            <h4 class="font-bold text-gray-900 mb-2">{{ $review->title }}</h4>
                            <p class="text-gray-600 text-sm leading-relaxed">{{ $review->body }}</p>

                            {{-- 自分のレビューなら削除ボタン表示 --}}
                            @auth
                                @if ($review->user_id === Auth::id())
                                    <div class="mt-4 pt-4 border-t border-gray-100">
                                        <form action="{{ route('user.product.review.destroy', [$product, $review]) }}" method="POST" onsubmit="return confirm('このレビューを削除しますか？');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm text-red-500 hover:text-red-600 flex items-center gap-1">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                削除する
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12 text-gray-500">
                    <i data-lucide="message-circle" class="w-12 h-12 mx-auto mb-4 text-gray-300"></i>
                    <p>まだレビューはありません。最初のレビューを投稿しましょう！</p>
                </div>
            @endif
        </div>
    </div>

    <script>
        /**
         * 評価の星をセット
         */
        function setRating(rating) {
            document.getElementById('rating-input').value = rating;
            const stars = document.querySelectorAll('.rating-star');
            stars.forEach((star, index) => {
                const icon = star.querySelector('[data-lucide="star"]');
                if (index < rating) {
                    icon.classList.remove('text-gray-300');
                    icon.classList.add('text-orange-400', 'fill-orange-400');
                } else {
                    icon.classList.remove('text-orange-400', 'fill-orange-400');
                    icon.classList.add('text-gray-300');
                }
            });
            // Lucide アイコンを再描画
            lucide.createIcons();
        }

        // 初期値がある場合は星を設定
        document.addEventListener('DOMContentLoaded', function() {
            const initialRating = document.getElementById('rating-input')?.value;
            if (initialRating && initialRating > 0) {
                setRating(parseInt(initialRating));
            }
        });
    </script>
</x-user.common>
