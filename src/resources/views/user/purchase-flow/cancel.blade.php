<x-user.common title="お支払いキャンセル">
    <div class="max-w-2xl mx-auto text-center py-12">
        <!-- Cancel Icon -->
        <div class="w-24 h-24 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-8">
            <i data-lucide="x-circle" class="w-12 h-12 text-amber-600"></i>
        </div>

        <h1 class="text-3xl font-bold text-gray-900 mb-4">お支払いがキャンセルされました</h1>
        <p class="text-gray-600 mb-8">お支払い手続きがキャンセルされました。<br>カートの商品はそのまま保存されています。</p>

        <!-- Info Notice -->
        <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100 mb-8">
            <div class="flex items-start gap-3 text-left">
                <i data-lucide="info" class="w-6 h-6 text-gray-500 flex-shrink-0 mt-0.5"></i>
                <div>
                    <h3 class="font-bold text-gray-900 mb-1">ご注意</h3>
                    <p class="text-sm text-gray-600">お支払いが完了していないため、商品はまだ購入されていません。再度お支払い手続きを行う場合は、カートからお進みください。</p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('user.cart.index') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-700 transition-colors">
                <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                カートに戻る
            </a>
            <a href="{{ route('user.product.index') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-gray-100 text-gray-700 font-bold rounded-2xl hover:bg-gray-200 transition-colors">
                <i data-lucide="search" class="w-5 h-5"></i>
                商品を探す
            </a>
        </div>
    </div>
</x-user.common>
