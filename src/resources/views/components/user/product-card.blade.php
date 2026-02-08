{{-- 商品カードコンポーネント --}}
@props([
    'productId' => null,
    'image' => '',
    'category' => '',
    'categorySlug' => '',
    'title' => '',
    'description' => '',
    'author' => null,
    'authorSlug' => null,
    'authorIcon' => null,
    'rating' => null,
    'price' => 0,
    'slug' => '',
    'liked' => false,
])

<div {{ $attributes->merge(['class' => 'product-item group bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden']) }} @if($categorySlug) data-category="{{ $categorySlug }}" @endif>
    <div class="relative">
        <a href="{{ route('user.product.detail', $slug) }}" class="block">
            <div class="aspect-square overflow-hidden bg-gray-100">
                <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
            </div>
        </a>
        {{-- お気に入りボタン --}}
        <button
            type="button"
            onclick="toggleLike({{ $productId }}, this); event.stopPropagation();"
            class="absolute top-3 right-3 p-2 bg-white/80 backdrop-blur-sm rounded-full shadow-sm hover:bg-white transition-all group/like"
            data-liked="{{ $liked ? 'true' : 'false' }}"
            aria-label="お気に入り"
        >
            <i data-lucide="heart" class="w-5 h-5 transition-colors {{ $liked ? 'text-red-500 fill-red-500' : 'text-gray-400 group-hover/like:text-red-400' }}"></i>
        </button>
    </div>
    <div class="p-5">
        <div class="flex items-center justify-between mb-2">
            @if($categorySlug)
                <a href="{{ route('user.product.index', ['category' => $categorySlug]) }}" class="text-[10px] font-bold text-indigo-600 uppercase tracking-widest hover:text-indigo-800 transition-colors">{{ $category }}</a>
            @else
                <span class="text-[10px] font-bold text-indigo-600 uppercase tracking-widest">{{ $category }}</span>
            @endif
            @if($rating)
                <div class="flex items-center text-orange-400">
                    <i data-lucide="star" class="w-3 h-3 fill-current"></i>
                    <span class="text-xs font-bold ml-1 text-gray-500">{{ $rating }}</span>
                </div>
            @endif
        </div>
        <h3 class="font-bold text-gray-900 mb-1 group-hover:text-indigo-600 transition-colors">
            <a href="{{ route('user.product.detail', $slug) }}">{{ $title }}</a>
        </h3>
        @if($description)
            <p class="text-gray-500 text-xs mb-3 line-clamp-1">{{ $description }}</p>
        @endif
        @if($author)
            <a href="{{ $authorSlug ? route('user.seller.detail', $authorSlug) : '#' }}" class="flex items-center gap-2 mb-4 hover:opacity-80 transition-opacity">
                <div class="w-6 h-6 rounded-full overflow-hidden flex-shrink-0">
                    @if($authorIcon)
                        <img src="{{ $authorIcon }}" alt="{{ $author }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-indigo-100 flex items-center justify-center">
                            <i data-lucide="user" class="w-3 h-3 text-indigo-600"></i>
                        </div>
                    @endif
                </div>
                <span class="text-xs text-gray-600 font-medium hover:text-indigo-600 transition-colors truncate">{{ $author }}</span>
            </a>
        @endif
        <div class="flex items-center justify-between border-t border-gray-50 pt-4">
            <span class="text-lg font-bold text-gray-900">¥{{ number_format($price) }}</span>
            <button onclick="addToCart({{ $productId }}); event.preventDefault();" class="p-2 bg-gray-900 text-white rounded-xl hover:bg-indigo-600 transition-colors">
                <i data-lucide="plus" class="w-5 h-5"></i>
            </button>
        </div>
    </div>
</div>
