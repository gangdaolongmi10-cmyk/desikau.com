<x-seller.common title="出品アイテム管理">
    {{-- ヘッダー --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold">出品アイテム管理</h1>
            <p class="text-sm text-gray-500 mt-1">商品の追加・編集・削除ができます</p>
        </div>
        <a href="{{ route('seller.product.create') }}" class="flex items-center space-x-2 px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition-all">
            <i data-lucide="plus" class="w-5 h-5"></i>
            <span>新規出品</span>
        </a>
    </div>

    {{-- フラッシュメッセージ --}}
    @if (session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    {{-- 商品一覧テーブル --}}
    <div class="bg-white rounded-[24px] border border-gray-100 shadow-sm overflow-hidden">
        @if ($products->isEmpty())
            <div class="p-12 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="package" class="w-8 h-8 text-gray-400"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-600 mb-2">まだ商品がありません</h3>
                <p class="text-sm text-gray-500 mb-6">最初の商品を出品してみましょう</p>
                <a href="{{ route('seller.product.create') }}" class="inline-flex items-center space-x-2 px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition-all">
                    <i data-lucide="plus" class="w-5 h-5"></i>
                    <span>新規出品</span>
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 text-[10px] uppercase font-bold text-gray-400 tracking-widest">
                        <tr>
                            <th class="px-6 py-4">商品</th>
                            <th class="px-6 py-4">カテゴリー</th>
                            <th class="px-6 py-4">価格</th>
                            <th class="px-6 py-4">ステータス</th>
                            <th class="px-6 py-4">登録日</th>
                            <th class="px-6 py-4">操作</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach ($products as $product)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-12 h-12 rounded-lg bg-gray-100 overflow-hidden flex-shrink-0">
                                            @if ($product->image_url)
                                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center">
                                                    <i data-lucide="image" class="w-5 h-5 text-gray-400"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-sm font-bold truncate">{{ $product->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $product->file_format ?? '-' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-gray-600">{{ $product->category?->name ?? '-' }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm font-bold">¥{{ number_format($product->price) }}</span>
                                    @if ($product->original_price && $product->original_price > $product->price)
                                        <span class="text-xs text-gray-400 line-through ml-1">¥{{ number_format($product->original_price) }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if ($product->isPublished())
                                        <span class="text-[10px] bg-green-100 text-green-600 px-2 py-1 rounded-full font-bold">公開中</span>
                                    @else
                                        <span class="text-[10px] bg-gray-100 text-gray-600 px-2 py-1 rounded-full font-bold">非公開</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-gray-500">{{ $product->created_at->format('Y.m.d') }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('seller.product.edit', $product) }}" class="p-2 text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all" title="編集">
                                            <i data-lucide="pencil" class="w-4 h-4"></i>
                                        </a>
                                        <form action="{{ route('seller.product.destroy', $product) }}" method="POST" onsubmit="return confirm('本当にこの商品を削除しますか？');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all" title="削除">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- ページネーション --}}
            @if ($products->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $products->links() }}
                </div>
            @endif
        @endif
    </div>
</x-seller.common>
