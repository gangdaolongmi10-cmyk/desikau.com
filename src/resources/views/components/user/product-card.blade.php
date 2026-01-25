{{-- 商品カードコンポーネント --}}
@props([
    'image' => '',
    'category' => '',
    'title' => '',
    'author' => '',
    'price' => 0,
    'slug' => '',
])

<a href="{{ route('user.product.detail', $slug) }}" class="group bg-white rounded-2xl overflow-hidden border border-gray-100 hover:shadow-2xl hover:shadow-indigo-500/10 transition-all duration-300">
    <div class="relative h-48 overflow-hidden">
        <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
        <div class="absolute top-3 left-3 bg-white/90 backdrop-blur px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wider">{{ $category }}</div>
        <button class="absolute top-3 right-3 p-1.5 bg-white/20 backdrop-blur rounded-full text-white opacity-0 group-hover:opacity-100 transition-opacity">
            <i data-lucide="heart" class="w-4 h-4"></i>
        </button>
    </div>
    <div class="p-5">
        <h4 class="font-bold text-gray-900 mb-1 group-hover:text-indigo-600 transition-colors">{{ $title }}</h4>
        <p class="text-xs text-gray-500 mb-4">By {{ $author }}</p>
        <div class="flex items-center justify-between">
            <span class="text-lg font-bold text-gray-900">¥{{ number_format($price) }}</span>
            <button onclick="addToCart()" class="bg-gray-900 text-white p-2 rounded-lg hover:bg-indigo-600 transition-colors">
                <i data-lucide="shopping-bag" class="w-5 h-5"></i>
            </button>
        </div>
    </div>
</a>
