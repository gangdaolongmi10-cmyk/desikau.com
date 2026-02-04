<header class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16 gap-4">
            {{-- ロゴ --}}
            <div class="flex items-center flex-shrink-0">
                <a href="{{ route('user.home.index') }}">
                    <x-user.logo />
                </a>
            </div>

            {{-- 検索バー（中央） --}}
            <div class="hidden md:flex flex-1 max-w-xl mx-4">
                <form action="{{ route('user.product.index') }}" method="GET" class="w-full">
                    <div class="relative flex items-center">
                        <i data-lucide="search" class="absolute left-3 w-4 h-4 text-gray-400 pointer-events-none"></i>
                        <input
                            type="text"
                            name="q"
                            value="{{ request('q') }}"
                            placeholder="商品名・カテゴリで検索"
                            class="w-full pl-10 pr-4 py-2 bg-gray-100 border border-transparent rounded-full text-sm focus:bg-white focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100 transition-all outline-none"
                        >
                    </div>
                </form>
            </div>

            {{-- 右側アイコン群 --}}
            <div class="flex items-center space-x-4">
                {{-- モバイル用検索ボタン --}}
                <button data-search-toggle class="md:hidden text-gray-600 hover:text-indigo-600 transition-colors">
                    <i data-lucide="search" class="w-6 h-6"></i>
                </button>

                {{-- カート --}}
                <a href="{{ route('user.cart.index') }}" class="relative text-gray-600 hover:text-indigo-600 transition-colors">
                    <i data-lucide="shopping-cart" class="w-6 h-6"></i>
                    <span id="cart-count" class="absolute -top-2 -right-2 bg-indigo-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full transition-all">0</span>
                </a>

                @auth
                    {{-- ログイン中（デスクトップ表示） --}}
                    <a href="{{ route('user.profile.index') }}" class="hidden sm:flex items-center space-x-2 text-gray-600 hover:text-indigo-600 transition-colors group">
                        <div class="w-8 h-8 rounded-full overflow-hidden flex-shrink-0 border-2 border-transparent group-hover:border-indigo-200 transition-colors">
                            @if (Auth::user()->icon_url)
                                <img src="{{ Auth::user()->icon_url }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-indigo-100 flex items-center justify-center">
                                    <i data-lucide="user" class="w-4 h-4 text-indigo-600"></i>
                                </div>
                            @endif
                        </div>
                        <span class="text-sm font-medium">{{ Auth::user()->name }}</span>
                    </a>
                @else
                    {{-- 未ログイン（デスクトップ表示） --}}
                    <a href="{{ route('user.login.index') }}" class="hidden sm:block bg-indigo-600 text-white px-5 py-2 rounded-full font-medium hover:bg-indigo-700 transition-all shadow-sm">
                        ログイン
                    </a>
                @endauth

                {{-- ハンバーガーメニューボタン --}}
                <button data-mobile-menu-toggle class="text-gray-600 hover:text-indigo-600 transition-colors p-2 -mr-2">
                    <i data-lucide="menu" data-mobile-menu-icon-open class="w-6 h-6"></i>
                    <i data-lucide="x" data-mobile-menu-icon-close class="w-6 h-6 hidden"></i>
                </button>
            </div>
        </div>

        {{-- モバイル用検索バー（トグル表示） --}}
        <div data-search-panel class="hidden md:hidden pb-3">
            <form action="{{ route('user.product.index') }}" method="GET">
                <div class="relative flex items-center">
                    <i data-lucide="search" class="absolute left-3 w-4 h-4 text-gray-400 pointer-events-none"></i>
                    <input
                        type="text"
                        name="q"
                        value="{{ request('q') }}"
                        placeholder="商品名・カテゴリで検索"
                        class="w-full pl-10 pr-4 py-2.5 bg-gray-100 border border-transparent rounded-full text-sm focus:bg-white focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100 transition-all outline-none"
                    >
                </div>
            </form>
        </div>
    </div>
</header>

<script>
    // モバイル検索バーのトグル
    document.addEventListener('DOMContentLoaded', function() {
        const searchToggle = document.querySelector('[data-search-toggle]');
        const searchPanel = document.querySelector('[data-search-panel]');

        if (searchToggle && searchPanel) {
            searchToggle.addEventListener('click', function() {
                searchPanel.classList.toggle('hidden');
                if (!searchPanel.classList.contains('hidden')) {
                    searchPanel.querySelector('input').focus();
                }
            });
        }
    });
</script>

{{-- 背景オーバーレイ --}}
<div data-mobile-menu-overlay class="fixed inset-0 bg-black/50 z-[60] hidden"></div>

{{-- スライドメニュー --}}
<div data-mobile-menu class="fixed top-0 right-0 h-full w-80 max-w-[85vw] bg-white shadow-2xl z-[70] transform translate-x-full transition-transform duration-300 ease-in-out overflow-hidden">
    <div class="flex flex-col h-full">
        {{-- メニューヘッダー --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <span class="text-lg font-bold text-gray-900">メニュー</span>
            <button data-mobile-menu-close class="text-gray-400 hover:text-gray-600 transition-colors p-1">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>

        {{-- ナビゲーション --}}
        <nav class="flex-1 overflow-y-auto px-4 py-4 space-y-1">
            <a href="{{ route('user.home.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl {{ request()->routeIs('user.home.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700 hover:bg-gray-50' }} transition-colors">
                <i data-lucide="home" class="w-5 h-5"></i>
                <span class="font-medium">ホーム</span>
            </a>
            <a href="{{ route('user.product.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl {{ request()->routeIs('user.product.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700 hover:bg-gray-50' }} transition-colors">
                <i data-lucide="package" class="w-5 h-5"></i>
                <span class="font-medium">商品一覧</span>
            </a>

            @auth
                @if (Auth::user()->seller)
                    <a href="{{ route('seller.home.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-gray-50 transition-colors">
                        <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                        <span class="font-medium">出品者ダッシュボード</span>
                    </a>
                @else
                    <a href="{{ route('user.seller.register.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl {{ request()->routeIs('user.seller.register.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700 hover:bg-gray-50' }} transition-colors">
                        <i data-lucide="store" class="w-5 h-5"></i>
                        <span class="font-medium">出品者登録</span>
                    </a>
                @endif
            @else
                <a href="{{ route('user.seller.register.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl {{ request()->routeIs('user.seller.register.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700 hover:bg-gray-50' }} transition-colors">
                    <i data-lucide="store" class="w-5 h-5"></i>
                    <span class="font-medium">出品者登録</span>
                </a>
            @endauth
            @auth
                <a href="{{ route('user.like.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl {{ request()->routeIs('user.like.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700 hover:bg-gray-50' }} transition-colors">
                    <i data-lucide="heart" class="w-5 h-5"></i>
                    <span class="font-medium">お気に入り</span>
                </a>
                <a href="{{ route('user.purchase-history.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl {{ request()->routeIs('user.purchase-history.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700 hover:bg-gray-50' }} transition-colors">
                    <i data-lucide="receipt" class="w-5 h-5"></i>
                    <span class="font-medium">購入履歴</span>
                </a>
            @endauth
            <a href="{{ route('user.announcement.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl {{ request()->routeIs('user.announcement.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700 hover:bg-gray-50' }} transition-colors">
                <i data-lucide="bell" class="w-5 h-5"></i>
                <span class="font-medium">お知らせ</span>
            </a>
            <a href="{{ route('user.faq.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl {{ request()->routeIs('user.faq.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700 hover:bg-gray-50' }} transition-colors">
                <i data-lucide="help-circle" class="w-5 h-5"></i>
                <span class="font-medium">よくある質問</span>
            </a>
            <a href="{{ route('user.inquiry.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl {{ request()->routeIs('user.inquiry.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700 hover:bg-gray-50' }} transition-colors">
                <i data-lucide="mail" class="w-5 h-5"></i>
                <span class="font-medium">お問い合わせ</span>
            </a>
        </nav>

        {{-- フッター（ログイン情報） --}}
        <div class="border-t border-gray-100 px-4 py-4 space-y-3">
            @auth
                <a href="{{ route('user.profile.index') }}" class="flex items-center space-x-3 px-4 py-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors {{ request()->routeIs('user.profile.*') ? 'ring-2 ring-indigo-500' : '' }}">
                    <div class="w-10 h-10 rounded-full overflow-hidden flex-shrink-0">
                        @if (Auth::user()->icon_url)
                            <img src="{{ Auth::user()->icon_url }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-indigo-100 flex items-center justify-center">
                                <i data-lucide="user" class="w-5 h-5 text-indigo-600"></i>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <p class="text-xs text-gray-500">ログイン中</p>
                        <p class="font-medium text-gray-900">{{ Auth::user()->name }}</p>
                    </div>
                    <i data-lucide="chevron-right" class="w-5 h-5 text-gray-400"></i>
                </a>
            @else
                <a href="{{ route('user.login.index') }}" class="w-full flex items-center justify-center space-x-2 bg-indigo-600 text-white px-4 py-3 rounded-xl font-medium hover:bg-indigo-700 transition-colors">
                    <i data-lucide="log-in" class="w-5 h-5"></i>
                    <span>ログイン</span>
                </a>
                <a href="{{ route('user.register.index') }}" class="w-full flex items-center justify-center space-x-2 border border-gray-200 text-gray-700 px-4 py-3 rounded-xl font-medium hover:bg-gray-50 transition-colors">
                    <i data-lucide="user-plus" class="w-5 h-5"></i>
                    <span>新規登録</span>
                </a>
            @endauth
        </div>
    </div>
</div>
