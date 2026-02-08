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
<footer class="bg-gray-900 text-gray-300 pt-16 pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- ロゴ・プラットフォーム説明 --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 mb-12">
            <div class="lg:col-span-1">
                <div class="flex items-center space-x-2 mb-4">
                    <div class="bg-indigo-500 p-1.5 rounded-lg">
                        <i data-lucide="layers" class="text-white w-6 h-6"></i>
                    </div>
                    <span class="text-xl font-bold tracking-tight text-white">{{ config('app.name') }}</span>
                </div>
                <p class="text-sm text-gray-400 leading-relaxed mb-4">
                    {{ config('app.name') }}は、クリエイターがデジタルコンテンツを販売できるマーケットプレイスです。<br>
                    プラットフォーム運営者として、安全な取引環境を提供しています。
                </p>
                <p class="text-xs text-gray-500">
                    運営: {{ config('app.name') }} Inc.
                </p>
            </div>

            {{-- リンクセクション --}}
            <div class="lg:col-span-2 grid grid-cols-2 md:grid-cols-4 gap-8">
                {{-- ストア --}}
                <div>
                    <h5 class="font-bold text-white mb-4 text-sm">ストア</h5>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('user.home.index') }}" class="hover:text-indigo-400 transition-colors">ホーム</a></li>
                        <li><a href="{{ route('user.product.index') }}" class="hover:text-indigo-400 transition-colors">商品一覧</a></li>
                        <li><a href="{{ route('user.product.index', ['sort' => 'newest']) }}" class="hover:text-indigo-400 transition-colors">新着コンテンツ</a></li>
                        <li><a href="{{ route('user.cart.index') }}" class="hover:text-indigo-400 transition-colors">カート</a></li>
                    </ul>
                </div>

                {{-- アカウント --}}
                <div>
                    <h5 class="font-bold text-white mb-4 text-sm">アカウント</h5>
                    <ul class="space-y-2.5 text-sm">
                        @auth
                            <li><a href="{{ route('user.profile.index') }}" class="hover:text-indigo-400 transition-colors">マイページ</a></li>
                            <li><a href="{{ route('user.like.index') }}" class="hover:text-indigo-400 transition-colors">お気に入り</a></li>
                            <li><a href="{{ route('user.purchase-history.index') }}" class="hover:text-indigo-400 transition-colors">購入履歴</a></li>
                        @else
                            <li><a href="{{ route('user.login.index') }}" class="hover:text-indigo-400 transition-colors">ログイン</a></li>
                            <li><a href="{{ route('user.register.index') }}" class="hover:text-indigo-400 transition-colors">新規登録</a></li>
                        @endauth
                    </ul>
                </div>

                {{-- 出品者向け --}}
                <div>
                    <h5 class="font-bold text-white mb-4 text-sm">出品者向け</h5>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('user.seller.register.index') }}" class="hover:text-indigo-400 transition-colors">出品者登録</a></li>
                    </ul>
                </div>

                {{-- サポート・法的情報 --}}
                <div>
                    <h5 class="font-bold text-white mb-4 text-sm">サポート</h5>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('user.inquiry.index') }}" class="hover:text-indigo-400 transition-colors">お問い合わせ</a></li>
                        <li><a href="{{ route('user.static.index', $StaticPage::TermsOfService->value) }}" class="hover:text-indigo-400 transition-colors">利用規約</a></li>
                        <li><a href="{{ route('user.static.index', $StaticPage::PrivacyPolicy->value) }}" class="hover:text-indigo-400 transition-colors">プライバシーポリシー</a></li>
                        <li><a href="{{ route('user.static.index', $StaticPage::LegalNotice->value) }}" class="hover:text-indigo-400 transition-colors">特定商取引法に基づく表記</a></li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- 運営者情報 --}}
        <div class="border-t border-gray-800 pt-8 mb-8">
            <div class="bg-gray-800/50 rounded-xl p-6">
                <h6 class="text-sm font-bold text-white mb-3 flex items-center gap-2">
                    <i data-lucide="building-2" class="w-4 h-4 text-indigo-400"></i>
                    プラットフォーム運営者情報
                </h6>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-xs text-gray-400">
                    <div>
                        <span class="text-gray-500">運営者名</span>
                        <p class="mt-0.5">{{ config('app.name') }} Inc.</p>
                    </div>
                    <div>
                        <span class="text-gray-500">お問い合わせ</span>
                        <p class="mt-0.5">
                            <a href="{{ route('user.inquiry.index') }}" class="hover:text-indigo-400 transition-colors">お問い合わせフォーム</a>
                        </p>
                    </div>
                    <div>
                        <span class="text-gray-500">サービス形態</span>
                        <p class="mt-0.5">デジタルコンテンツマーケットプレイス</p>
                    </div>
                    <div>
                        <span class="text-gray-500">決済方法</span>
                        <p class="mt-0.5">クレジットカード（Visa / Mastercard / AMEX / JCB）</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- コピーライト --}}
        <div class="border-t border-gray-800 pt-6 flex flex-col md:flex-row justify-between items-center space-y-3 md:space-y-0 text-xs text-gray-500">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }} Inc. All rights reserved.</p>
            <p>当サイトはプラットフォーム型のマーケットプレイスです。各商品の販売責任は出品者に帰属します。</p>
        </div>
    </div>
</footer>