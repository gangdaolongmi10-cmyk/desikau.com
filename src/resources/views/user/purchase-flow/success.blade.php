<x-user.common title="ご注文完了">
    <div class="max-w-2xl mx-auto text-center py-12">
        <!-- Success Icon -->
        <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-8">
            <i data-lucide="check-circle" class="w-12 h-12 text-green-600"></i>
        </div>

        <h1 class="text-3xl font-bold text-gray-900 mb-4">ご注文ありがとうございます！</h1>
        <p class="text-gray-600 mb-2">ご注文が完了しました。</p>
        <p class="text-lg font-bold text-indigo-600 mb-8">注文番号: {{ $order->order_number }}</p>

        <!-- Order Summary -->
        <div class="bg-white rounded-[24px] p-8 border border-gray-100 shadow-sm text-left mb-8">
            <h2 class="text-xl font-bold mb-6 flex items-center gap-2">
                <i data-lucide="package" class="w-5 h-5 text-indigo-600"></i>
                ご注文内容
            </h2>

            <div class="space-y-4 mb-6">
                @foreach ($order->items as $item)
                    <div class="flex justify-between items-center py-3 border-b border-gray-50 last:border-0">
                        <div>
                            <p class="font-medium text-gray-900">{{ $item->product_name }}</p>
                            <p class="text-sm text-gray-500">数量: {{ $item->quantity }}</p>
                        </div>
                        <p class="font-bold text-gray-900">¥{{ number_format($item->price * $item->quantity) }}</p>
                    </div>
                @endforeach
            </div>

            <div class="space-y-2 pt-4 border-t border-gray-100">
                <div class="flex justify-between text-gray-600">
                    <span>小計</span>
                    <span>¥{{ number_format($order->subtotal) }}</span>
                </div>
                <div class="flex justify-between text-gray-600">
                    <span>消費税</span>
                    <span>¥{{ number_format($order->tax) }}</span>
                </div>
                <div class="flex justify-between text-lg font-bold text-gray-900 pt-2 border-t border-gray-100">
                    <span>合計</span>
                    <span class="text-indigo-600">¥{{ number_format($order->total) }}</span>
                </div>
            </div>
        </div>

        <!-- Digital Content Notice -->
        <div class="bg-indigo-50 rounded-2xl p-6 border border-indigo-100 mb-8">
            <div class="flex items-start gap-3 text-left">
                <i data-lucide="download" class="w-6 h-6 text-indigo-600 flex-shrink-0 mt-0.5"></i>
                <div>
                    <h3 class="font-bold text-indigo-900 mb-1">ダウンロードについて</h3>
                    <p class="text-sm text-indigo-700">購入した商品は「購入履歴」からダウンロードできます。</p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('user.purchase-history.index') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-700 transition-colors">
                <i data-lucide="download" class="w-5 h-5"></i>
                購入履歴へ
            </a>
            <a href="{{ route('user.home.index') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-gray-100 text-gray-700 font-bold rounded-2xl hover:bg-gray-200 transition-colors">
                <i data-lucide="home" class="w-5 h-5"></i>
                トップページへ
            </a>
        </div>
    </div>
</x-user.common>
