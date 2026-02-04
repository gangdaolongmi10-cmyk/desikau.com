<x-user.common title="{{ $seller->user?->name ?? $seller->shop_name }}">
    <section class="bg-white rounded-[32px] border border-gray-100 shadow-sm p-8 mb-10 overflow-hidden relative">
        <div class="absolute top-0 left-0 w-full h-32 bg-gradient-to-r from-indigo-500 to-purple-500 opacity-10"></div>

        <div class="relative flex flex-col md:flex-row items-center md:items-end space-y-6 md:space-y-0 md:space-x-8">
            <!-- Profile Image -->
            <div class="relative">
                <div class="w-32 h-32 rounded-[28px] border-4 border-white shadow-xl overflow-hidden">
                    @if ($seller->user?->icon_url)
                        <img src="{{ $seller->user->icon_url }}" alt="{{ $seller->user->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-indigo-100 flex items-center justify-center">
                            <i data-lucide="user" class="w-16 h-16 text-indigo-600"></i>
                        </div>
                    @endif
                </div>
                <div class="absolute -bottom-2 -right-2 bg-green-500 w-6 h-6 rounded-full border-4 border-white"></div>
            </div>

            <!-- Profile Text -->
            <div class="flex-1 text-center md:text-left">
                <div class="flex flex-col md:flex-row md:items-center md:space-x-4 mb-2">
                    <h2 class="text-3xl font-bold">{{ $seller->user?->name ?? $seller->shop_name }}</h2>
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-indigo-50 text-indigo-600 text-xs font-bold mt-2 md:mt-0 w-max self-center md:self-auto">
                        {{ $seller->main_category }}
                    </span>
                </div>
                @if ($seller->user && $seller->shop_name)
                    <p class="text-sm text-gray-500 mb-2">{{ $seller->shop_name }}</p>
                @endif
                @if ($seller->description)
                    <p class="text-gray-500 font-medium mb-4 max-w-2xl">
                        {{ $seller->description }}
                    </p>
                @endif
                <div class="flex items-center justify-center md:justify-start space-x-8">
                    <div class="text-center md:text-left">
                        <span class="block text-xl font-bold">{{ $products->count() }}</span>
                        <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">出品数</span>
                    </div>
                    @if ($seller->twitter_username || $seller->youtube_url || $seller->twitch_username)
                        <div class="text-center md:text-left border-l border-gray-100 pl-8">
                            <div class="flex items-center space-x-3">
                                @if ($seller->twitter_username)
                                    <a href="https://twitter.com/{{ $seller->twitter_username }}" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-blue-400 transition-colors">
                                        <i data-lucide="twitter" class="w-5 h-5"></i>
                                    </a>
                                @endif
                                @if ($seller->youtube_url)
                                    <a href="{{ $seller->youtube_url }}" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-red-500 transition-colors">
                                        <i data-lucide="youtube" class="w-5 h-5"></i>
                                    </a>
                                @endif
                                @if ($seller->twitch_username)
                                    <a href="https://twitch.tv/{{ $seller->twitch_username }}" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-purple-500 transition-colors">
                                        <i data-lucide="twitch" class="w-5 h-5"></i>
                                    </a>
                                @endif
                            </div>
                            <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">SNS</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex space-x-3 w-full md:w-auto">
                <button onclick="shareProfile()" class="flex-1 md:flex-none px-10 py-3 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 transition-all flex items-center justify-center gap-2 shadow-lg shadow-indigo-100">
                    <i data-lucide="share-2" class="w-4 h-4 text-white"></i>
                    プロフィールを共有
                </button>
            </div>
        </div>
    </section>

    <!-- Category Filtering & Items -->
    <section>
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 space-y-4 md:space-y-0">
            <h3 class="text-xl font-bold">出品商品</h3>
        </div>

        <!-- Product Grid -->
        @if ($products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($products as $product)
                    <x-user.product-card
                        :product-id="$product->id"
                        :image="$product->image_url ?? 'https://via.placeholder.com/500'"
                        :category="$product->category?->name ?? ''"
                        :category-slug="$product->category?->slug ?? ''"
                        :title="$product->name"
                        :description="$product->description"
                        :author="$seller->user?->name ?? $seller->shop_name"
                        :author-slug="$seller->slug"
                        :author-icon="$seller->user?->icon_url"
                        :price="$product->price"
                        :slug="$product->slug"
                        :liked="$product->liked_by_me ?? false"
                    />
                @endforeach
            </div>
        @else
            <div class="text-center py-16 bg-white rounded-[32px] border border-gray-100">
                <i data-lucide="package" class="w-16 h-16 text-gray-300 mx-auto mb-4"></i>
                <p class="text-gray-500 font-medium">まだ商品がありません</p>
            </div>
        @endif
    </section>
    <!-- Notification Toast -->
    <div id="toast" class="fixed bottom-8 left-1/2 -translate-x-1/2 z-[100] hidden">
        <div class="bg-gray-900 text-white px-6 py-3 rounded-2xl shadow-2xl flex items-center space-x-3 animate-slide-up">
            <i data-lucide="check-circle" class="w-5 h-5 text-green-400"></i>
            <span class="text-sm font-medium" id="toast-message">リンクをコピーしました</span>
        </div>
    </div>

    <script>
        /**
         * プロフィールを共有
         */
        function shareProfile() {
            const shareData = {
                title: '{{ $seller->user?->name ?? $seller->shop_name }} - desikau',
                text: '{{ $seller->description ?? ($seller->user?->name ?? $seller->shop_name) . "のショップをチェック！" }}',
                url: window.location.href
            };

            if (navigator.share) {
                navigator.share(shareData).catch((err) => console.log('Error sharing', err));
            } else {
                // Fallback: Copy to clipboard
                navigator.clipboard.writeText(window.location.href).then(() => {
                    showToast('URLをクリップボードにコピーしました');
                });
            }
        }

        /**
         * トースト通知を表示
         */
        function showToast(message) {
            const toast = document.getElementById('toast');
            const toastMsg = document.getElementById('toast-message');
            toastMsg.textContent = message;
            toast.classList.remove('hidden');

            setTimeout(() => {
                toast.classList.add('hidden');
            }, 3000);
        }
    </script>
</x-user.common>