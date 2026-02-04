<x-user.common title="ショッピングカート">
    <div class="max-w-6xl mx-auto">
        <h1 class="text-3xl font-bold mb-10 flex items-center space-x-3">
            <i data-lucide="shopping-cart" class="w-8 h-8 text-indigo-600"></i>
            <span>ショッピングカート</span>
        </h1>

        @if ($cartItems->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Cart Items List -->
                <div class="lg:col-span-2 space-y-4" id="cart-items">
                    @foreach ($cartItems as $item)
                        <div class="cart-item bg-white rounded-[24px] p-6 border border-gray-100 shadow-sm flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-6 relative group" data-id="{{ $item->id }}">
                            <a href="{{ route('user.product.detail', $item->product->slug) }}" class="w-full md:w-32 h-32 bg-gray-100 rounded-2xl overflow-hidden flex-shrink-0">
                                <img src="{{ $item->product->image_url ?? 'https://via.placeholder.com/300' }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                            </a>
                            <div class="flex-grow space-y-1 text-center md:text-left">
                                <h3 class="font-bold text-lg">
                                    <a href="{{ route('user.product.detail', $item->product->slug) }}" class="hover:text-indigo-600 transition-colors">
                                        {{ $item->product->name }}
                                    </a>
                                </h3>
                                @if ($item->product->file_format)
                                    <p class="text-sm text-gray-500 italic">フォーマット: {{ $item->product->file_format }}</p>
                                @endif
                                <div class="pt-2 flex items-center justify-center md:justify-start space-x-4">
                                    <div class="flex items-center border border-gray-200 rounded-lg overflow-hidden">
                                        <button onclick="updateQuantity({{ $item->id }}, {{ $item->quantity - 1 }})" class="p-2 hover:bg-gray-50 text-gray-400">
                                            <i data-lucide="minus" class="w-4 h-4"></i>
                                        </button>
                                        <span class="px-4 font-bold text-sm quantity-display">{{ $item->quantity }}</span>
                                        <button onclick="updateQuantity({{ $item->id }}, {{ $item->quantity + 1 }})" class="p-2 hover:bg-gray-50 text-gray-400">
                                            <i data-lucide="plus" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                    <button onclick="removeItem({{ $item->id }})" class="text-xs font-bold text-red-400 hover:text-red-600 flex items-center space-x-1">
                                        <i data-lucide="trash-2" class="w-3 h-3"></i>
                                        <span>削除</span>
                                    </button>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xl font-bold text-indigo-600">¥{{ number_format($item->product->price * $item->quantity) }}</p>
                                @if ($item->quantity > 1)
                                    <p class="text-xs text-gray-400">¥{{ number_format($item->product->price) }} × {{ $item->quantity }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach

                    <!-- Info -->
                    <div class="pt-6">
                        <div class="bg-indigo-50 rounded-2xl p-4 flex items-center space-x-3 text-indigo-700">
                            <i data-lucide="info" class="w-5 h-5"></i>
                            <p class="text-sm font-medium">デジタル商品は購入後、すぐにダウンロード可能です。</p>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-[32px] border border-gray-100 shadow-sm p-8 sticky top-24">
                        <h2 class="text-xl font-bold mb-6">注文の概要</h2>

                        <div class="space-y-4 mb-8">
                            <div class="flex justify-between text-gray-500 font-medium">
                                <span>小計</span>
                                <span class="text-gray-900" id="subtotal">¥{{ number_format($subtotal) }}</span>
                            </div>
                            <div class="flex justify-between text-gray-500 font-medium">
                                <span>消費税 ({{ $taxRate->label() }})</span>
                                <span class="text-gray-900" id="tax">¥{{ number_format($tax) }}</span>
                            </div>
                            <div class="pt-4 border-t border-gray-50 flex justify-between">
                                <span class="text-lg font-bold">合計金額</span>
                                <span class="text-2xl font-extrabold text-indigo-600" id="grand-total">¥{{ number_format($total) }}</span>
                            </div>

                        <!-- Checkout Button -->
                        <a href="{{ route('user.checkout.index') }}" class="w-full py-4 bg-indigo-600 text-white font-bold rounded-2xl shadow-xl shadow-indigo-100 hover:bg-indigo-700 transition-all active:scale-[0.98] flex items-center justify-center space-x-2">
                            <span>お支払い手続きへ</span>
                            <i data-lucide="arrow-right" class="w-5 h-5"></i>
                        </a>

                        <div class="mt-6 flex items-center justify-center space-x-4 grayscale opacity-40">
                            <i data-lucide="credit-card" class="w-6 h-6"></i>
                            <span class="text-[10px] font-bold text-gray-400 tracking-tighter">SECURE PAYMENT POWERED BY STRIPE</span>
                        </div>
                    </div>
                </div>

            </div>
        @else
            <!-- Empty Cart -->
            <div class="text-center py-20">
                <div class="bg-gray-100 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-400">
                    <i data-lucide="shopping-cart" class="w-12 h-12"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-3">カートは空です</h2>
                <p class="text-gray-500 mb-8">気になる商品をカートに追加してみましょう。</p>
                <a href="{{ route('user.product.index') }}" class="inline-flex items-center space-x-2 bg-indigo-600 text-white px-8 py-4 rounded-2xl font-bold hover:bg-indigo-700 transition-colors">
                    <span>商品を探す</span>
                    <i data-lucide="arrow-right" class="w-5 h-5"></i>
                </a>
            </div>
        @endif
    </div>

    <script>
        /**
         * 数量を更新
         */
        function updateQuantity(cartItemId, quantity) {
            fetch(`{{ url('/cart') }}/${cartItemId}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ quantity: quantity }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (data.removed) {
                        // アイテムが削除された場合はページをリロード
                        location.reload();
                    } else {
                        // ページをリロードして最新の状態を表示
                        location.reload();
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('エラーが発生しました');
            });
        }

        /**
         * アイテムを削除
         */
        function removeItem(cartItemId) {
            if (!confirm('この商品をカートから削除しますか？')) {
                return;
            }

            fetch(`{{ url('/cart') }}/${cartItemId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('エラーが発生しました');
            });
        }
    </script>
</x-user.common>
