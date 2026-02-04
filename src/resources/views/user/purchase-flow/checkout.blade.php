<x-user.common title="購入手続き">
    <div class="max-w-6xl mx-auto">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Left Column: Forms -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Digital Content Notice -->
                <div class="bg-indigo-50 rounded-2xl p-6 border border-indigo-100">
                    <div class="flex items-start gap-3">
                        <i data-lucide="download" class="w-6 h-6 text-indigo-600 flex-shrink-0 mt-0.5"></i>
                        <div>
                            <h3 class="font-bold text-indigo-900 mb-1">デジタルコンテンツのご購入</h3>
                            <p class="text-sm text-indigo-700">デジタル商品は決済完了後、すぐにダウンロード可能になります。配送先の入力は不要です。</p>
                        </div>
                    </div>
                </div>

                <!-- Payment Method Section -->
                <section class="bg-white rounded-[24px] p-8 border border-gray-100 shadow-sm">
                    <h2 class="text-xl font-bold mb-6 flex items-center gap-2">
                        <i data-lucide="credit-card" class="w-5 h-5 text-indigo-600"></i>
                        お支払い方法
                    </h2>

                    <div class="space-y-3">
                        <div class="relative">
                            <input type="radio" name="payment" id="credit_card" class="peer hidden" checked>
                            <label for="credit_card" class="flex items-center justify-between p-4 border-2 border-indigo-200 bg-indigo-50/50 rounded-2xl cursor-pointer hover:border-indigo-300 transition-all peer-checked:border-indigo-500">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600">
                                        <i data-lucide="credit-card" class="w-5 h-5"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold">クレジットカード</p>
                                        <p class="text-xs text-gray-500">VISA, Mastercard, JCB, AMEX</p>
                                    </div>
                                </div>
                                <div class="w-5 h-5 border-2 border-indigo-500 rounded-full flex items-center justify-center">
                                    <div class="w-2.5 h-2.5 bg-indigo-500 rounded-full"></div>
                                </div>
                            </label>
                        </div>

                        <!-- Stripe Checkout Info -->
                        <div class="mt-4 p-6 bg-gray-50 rounded-2xl border border-gray-100">
                            <div class="flex items-start gap-3">
                                <i data-lucide="shield-check" class="w-6 h-6 text-green-600 flex-shrink-0"></i>
                                <div>
                                    <p class="font-bold text-gray-900 mb-1">安全な決済</p>
                                    <p class="text-sm text-gray-600">「注文を確定する」ボタンをクリックすると、Stripeの安全な決済ページに移動します。カード情報は当サイトには保存されません。</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Order Items Section -->
                <section class="bg-white rounded-[24px] p-8 border border-gray-100 shadow-sm">
                    <h2 class="text-xl font-bold mb-6 flex items-center gap-2">
                        <i data-lucide="package" class="w-5 h-5 text-indigo-600"></i>
                        ご注文商品
                    </h2>

                    <div class="space-y-4">
                        @foreach ($cartItems as $item)
                            <div class="flex gap-4 p-4 bg-gray-50 rounded-xl">
                                <div class="w-20 h-20 bg-gray-200 rounded-lg overflow-hidden flex-shrink-0">
                                    @if ($item->product->image_url)
                                        <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <i data-lucide="image" class="w-8 h-8 text-gray-400"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-grow min-w-0">
                                    <p class="font-bold text-gray-900 truncate">{{ $item->product->name }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $item->product->seller?->shop_name }}</p>
                                    <div class="flex items-center justify-between mt-2">
                                        <span class="text-sm text-gray-500">数量: {{ $item->quantity }}</span>
                                        <span class="font-bold text-indigo-600">¥{{ number_format($item->product->price * $item->quantity) }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <a href="{{ route('user.cart.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium flex items-center gap-1">
                            <i data-lucide="arrow-left" class="w-4 h-4"></i>
                            カートに戻る
                        </a>
                    </div>
                </section>
            </div>

            <!-- Right Column: Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-[32px] border border-gray-100 shadow-sm p-8 sticky top-24">
                    <h2 class="text-xl font-bold mb-6">ご注文内容</h2>

                    <!-- Mini Cart Items -->
                    <div class="space-y-4 mb-8 max-h-64 overflow-y-auto">
                        @foreach ($cartItems as $item)
                            <div class="flex gap-4">
                                <div class="w-16 h-16 bg-gray-100 rounded-xl overflow-hidden flex-shrink-0">
                                    @if ($item->product->image_url)
                                        <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <i data-lucide="image" class="w-5 h-5 text-gray-400"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-grow min-w-0">
                                    <p class="text-sm font-bold line-clamp-1">{{ $item->product->name }}</p>
                                    <p class="text-xs text-gray-500">数量: {{ $item->quantity }}</p>
                                    <p class="text-sm font-bold text-indigo-600">¥{{ number_format($item->product->price * $item->quantity) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Price Breakdown -->
                    <div class="space-y-4 pt-4 border-t border-gray-50 mb-8">
                        <div class="flex justify-between text-gray-500 font-medium text-sm">
                            <span>小計</span>
                            <span class="text-gray-900 font-bold">¥{{ number_format($subtotal) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-500 font-medium text-sm">
                            <span>配送料</span>
                            <span class="text-green-600 font-bold">無料</span>
                        </div>
                        <div class="flex justify-between text-gray-500 font-medium text-sm">
                            <span>消費税 ({{ $taxRate->label() }})</span>
                            <span class="text-gray-900 font-bold">¥{{ number_format($tax) }}</span>
                        </div>
                        <div class="pt-4 border-t border-gray-50 flex justify-between items-end">
                            <span class="text-lg font-bold">合計金額</span>
                            <span class="text-2xl font-extrabold text-indigo-600">¥{{ number_format($total) }}</span>
                        </div>
                    </div>

                    <button id="purchase-btn" onclick="handlePurchase()" class="w-full py-4 bg-indigo-600 text-white font-bold rounded-2xl shadow-xl shadow-indigo-100 hover:bg-indigo-700 transition-all active:scale-[0.98] flex items-center justify-center space-x-2">
                        <span>注文を確定する</span>
                        <i data-lucide="check-circle" class="w-5 h-5"></i>
                    </button>

                    <!-- Error Message -->
                    <div id="error-message" class="hidden mt-4 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm"></div>

                    <p class="mt-6 text-[10px] text-gray-400 text-center leading-relaxed">
                        「注文を確定する」をクリックすることで、Desikauの<a href="{{ route('user.static.index', 'terms') }}" class="underline">利用規約</a>および<a href="{{ route('user.static.index', 'privacy') }}" class="underline">プライバシーポリシー</a>に同意したものとみなされます。
                    </p>

                    <!-- Stripe Badge -->
                    <div class="mt-6 flex items-center justify-center space-x-2 text-gray-400">
                        <i data-lucide="lock" class="w-4 h-4"></i>
                        <span class="text-[10px] font-bold tracking-tighter">POWERED BY STRIPE</span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        /**
         * 購入処理を実行
         */
        async function handlePurchase() {
            const btn = document.getElementById('purchase-btn');
            const errorDiv = document.getElementById('error-message');

            // ボタンをローディング状態に
            btn.innerHTML = '<i data-lucide="loader-2" class="w-5 h-5 animate-spin"></i><span class="ml-2">処理中...</span>';
            lucide.createIcons();
            btn.disabled = true;
            errorDiv.classList.add('hidden');

            try {
                // Stripe Checkoutセッションを作成
                const response = await fetch('{{ route('user.checkout.session') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                });

                const data = await response.json();

                if (data.success && data.checkout_url) {
                    // Stripe Checkoutページにリダイレクト
                    window.location.href = data.checkout_url;
                } else {
                    throw new Error(data.message || '決済処理に失敗しました');
                }
            } catch (error) {
                console.error('Payment error:', error);

                // エラーメッセージを表示
                errorDiv.textContent = error.message || '決済処理に失敗しました。しばらく経ってからお試しください。';
                errorDiv.classList.remove('hidden');

                // ボタンを元に戻す
                btn.innerHTML = '<span>注文を確定する</span><i data-lucide="check-circle" class="w-5 h-5"></i>';
                lucide.createIcons();
                btn.disabled = false;
            }
        }
    </script>
</x-user.common>
