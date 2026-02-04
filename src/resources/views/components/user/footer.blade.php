@guest
<section class="w-full bg-gradient-to-r from-indigo-50 to-purple-50 border-t border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="bg-white border border-gray-100 rounded-3xl p-6 md:p-8 flex flex-col md:flex-row items-center gap-8 shadow-sm hover:shadow-md transition-shadow">

            <!-- Info Side -->
            <div class="flex-grow space-y-3 text-center md:text-left">
                <h3 class="text-xl font-bold text-gray-900">アカウントにログイン</h3>
                <div class="flex flex-wrap justify-center md:justify-start gap-x-6 gap-y-2">
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <i data-lucide="check-circle-2" class="w-4 h-4 text-indigo-500"></i>
                        購入履歴の確認
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <i data-lucide="check-circle-2" class="w-4 h-4 text-indigo-500"></i>
                        お気に入りの保存
                    </div>
                </div>
            </div>

            <!-- Action Side -->
            <div class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto shrink-0">
                <a href="{{ route('user.login.index') }}" class="bg-indigo-600 text-white px-8 py-2.5 rounded-full font-medium hover:bg-indigo-700 transition-all shadow-sm text-sm w-full sm:w-auto text-center">
                    ログイン
                </a>
                <a href="{{ route('user.register.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-700 px-4 py-2 transition-colors">
                    新規登録はこちら
                </a>
            </div>

        </div>
    </div>
</section>
@endguest
<footer class="bg-white border-t border-gray-200 pt-16 pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-8 mb-12">
            {{-- ストア --}}
            <div>
                <h5 class="font-bold mb-4">ストア</h5>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li><a href="{{ route('user.home.index') }}" class="hover:text-indigo-600 transition-colors">ホーム</a></li>
                    <li><a href="{{ route('user.product.index') }}" class="hover:text-indigo-600 transition-colors">商品一覧</a></li>
                    <li><a href="{{ route('user.product.index', ['sort' => 'newest']) }}" class="hover:text-indigo-600 transition-colors">新着コンテンツ</a></li>
                    <li><a href="{{ route('user.cart.index') }}" class="hover:text-indigo-600 transition-colors">カート</a></li>
                </ul>
            </div>

            {{-- アカウント --}}
            <div>
                <h5 class="font-bold mb-4">アカウント</h5>
                <ul class="space-y-2 text-sm text-gray-600">
                    @auth
                        <li><a href="{{ route('user.profile.index') }}" class="hover:text-indigo-600 transition-colors">マイページ</a></li>
                        <li><a href="{{ route('user.like.index') }}" class="hover:text-indigo-600 transition-colors">お気に入り</a></li>
                        <li><a href="{{ route('user.purchase-history.index') }}" class="hover:text-indigo-600 transition-colors">購入履歴</a></li>
                    @else
                        <li><a href="{{ route('user.login.index') }}" class="hover:text-indigo-600 transition-colors">ログイン</a></li>
                        <li><a href="{{ route('user.register.index') }}" class="hover:text-indigo-600 transition-colors">新規登録</a></li>
                    @endauth
                </ul>
            </div>

            {{-- 出品者向け --}}
            <div>
                <h5 class="font-bold mb-4">出品者向け</h5>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li><a href="{{ route('user.seller.register.index') }}" class="hover:text-indigo-600 transition-colors">出品者登録</a></li>
                </ul>
            </div>

            {{-- サポート --}}
            <div>
                <h5 class="font-bold mb-4">サポート</h5>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li><a href="{{ route('user.inquiry.index') }}" class="hover:text-indigo-600 transition-colors">お問い合わせ</a></li>
                </ul>
            </div>

            {{-- サイト情報 --}}
            <div>
                <h5 class="font-bold mb-4">サイト情報</h5>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li><a href="{{ route('user.static.index', $StaticPage::PrivacyPolicy->value) }}" class="hover:text-indigo-600 transition-colors">プライバシーポリシー</a></li>
                    <li><a href="{{ route('user.static.index', $StaticPage::TermsOfService->value) }}" class="hover:text-indigo-600 transition-colors">利用規約</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-100 pt-8 flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0 text-xs text-gray-400">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }} Inc. All rights reserved.</p>
            <div class="flex space-x-6">
                <a href="{{ route('user.static.index', $StaticPage::LegalNotice->value) }}" class="hover:text-indigo-600 transition-colors">特定商取引法に基づく表記</a>
            </div>
        </div>
    </div>
</footer>