<x-user.common title="購入履歴">
    <div class="max-w-4xl mx-auto px-4">

        <div class="mb-10">
            <h1 class="text-3xl font-extrabold text-gray-900">購入履歴</h1>
            <p class="text-gray-500 mt-2">過去に購入したすべてのアセットを確認・ダウンロードできます。</p>
        </div>

        @if ($orders->isEmpty())
            {{-- 購入履歴がない場合 --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-12 text-center">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i data-lucide="shopping-bag" class="w-10 h-10 text-gray-400"></i>
                </div>
                <h2 class="text-xl font-bold text-gray-900 mb-2">購入履歴がありません</h2>
                <p class="text-gray-500 mb-6">まだ商品を購入していません。素敵なアセットを探してみましょう。</p>
                <a href="{{ route('user.product.index') }}" class="inline-flex items-center space-x-2 bg-indigo-600 text-white px-6 py-3 rounded-xl text-sm font-bold hover:bg-indigo-700 transition-all shadow-md shadow-indigo-100">
                    <i data-lucide="search" class="w-4 h-4"></i>
                    <span>商品を探す</span>
                </a>
            </div>
        @else
            {{-- 注文一覧 --}}
            <div class="space-y-6">
                @foreach ($orders as $order)
                    {{-- 注文カード --}}
                    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
                        {{-- 注文ヘッダー --}}
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex flex-wrap justify-between items-center gap-4">
                            <div class="flex space-x-8 text-xs font-medium text-gray-500">
                                <div>
                                    <p class="uppercase tracking-wider mb-1">注文日</p>
                                    <p class="text-gray-900 text-sm">{{ $order->paid_at->format('Y年n月j日') }}</p>
                                </div>
                                <div>
                                    <p class="uppercase tracking-wider mb-1">合計金額</p>
                                    <p class="text-gray-900 text-sm">&yen;{{ number_format($order->total) }}</p>
                                </div>
                                <div class="hidden sm:block">
                                    <p class="uppercase tracking-wider mb-1">注文番号</p>
                                    <p class="text-gray-900 text-sm">{{ $order->order_number }}</p>
                                </div>
                            </div>
                            <a href="{{ route('user.purchase-history.receipt', $order) }}" class="flex items-center space-x-1 text-sm font-bold text-indigo-600 hover:text-indigo-700">
                                <i data-lucide="file-text" class="w-4 h-4"></i>
                                <span>領収書をダウンロード</span>
                            </a>
                        </div>

                        {{-- 注文アイテム一覧 --}}
                        <div class="divide-y divide-gray-100">
                            @foreach ($order->items as $item)
                                <div class="p-6">
                                    <div class="flex items-center space-x-6">
                                        {{-- 商品画像 --}}
                                        <div class="w-24 h-24 rounded-2xl overflow-hidden flex-shrink-0 bg-gray-100">
                                            @if ($item->product && $item->product->image_url)
                                                <img src="{{ $item->product->image_url }}" alt="{{ $item->product_name }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center">
                                                    <i data-lucide="image" class="w-8 h-8 text-gray-300"></i>
                                                </div>
                                            @endif
                                        </div>

                                        {{-- 商品情報 --}}
                                        <div class="flex-grow">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <h3 class="font-bold text-gray-900 mb-1">{{ $item->product_name }}</h3>
                                                    <p class="text-xs text-gray-500">
                                                        &yen;{{ number_format($item->price) }}
                                                        @if ($item->quantity > 1)
                                                            &times; {{ $item->quantity }}
                                                        @endif
                                                    </p>
                                                </div>
                                                <span class="bg-green-100 text-green-700 text-[10px] font-bold px-2 py-1 rounded-full uppercase">支払い完了</span>
                                            </div>

                                            {{-- アクションボタン --}}
                                            <div class="mt-4 flex flex-wrap gap-3">
                                                @if ($item->product && $item->product->hasFile())
                                                    <a href="{{ route('user.download', $item->product) }}" class="flex items-center space-x-2 bg-indigo-600 text-white px-4 py-2 rounded-xl text-sm font-bold hover:bg-indigo-700 transition-all shadow-md shadow-indigo-100">
                                                        <i data-lucide="download" class="w-4 h-4"></i>
                                                        <span>ダウンロード</span>
                                                    </a>
                                                @else
                                                    <span class="flex items-center space-x-2 bg-gray-300 text-gray-500 px-4 py-2 rounded-xl text-sm font-bold cursor-not-allowed">
                                                        <i data-lucide="download" class="w-4 h-4"></i>
                                                        <span>ダウンロード</span>
                                                    </span>
                                                @endif
                                                @if ($item->product)
                                                    <a href="{{ route('user.product.detail', $item->product->slug) }}" class="flex items-center space-x-2 bg-white border border-gray-200 text-gray-700 px-4 py-2 rounded-xl text-sm font-bold hover:bg-gray-50 transition-all">
                                                        <i data-lucide="external-link" class="w-4 h-4"></i>
                                                        <span>商品ページ</span>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- ページネーション --}}
            @if ($orders->hasPages())
                <div class="mt-8">
                    {{ $orders->links() }}
                </div>
            @endif
        @endif

    </div>
</x-user.common>
