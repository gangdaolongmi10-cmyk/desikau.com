{{-- 出品者サイドバー --}}
<aside class="hidden lg:flex flex-col w-64 bg-white border-r border-gray-200 fixed h-full z-50">
    {{-- ロゴ --}}
    <div class="p-6">
        <a href="{{ route('seller.home.index') }}" class="flex items-center space-x-2">
            <div class="bg-indigo-600 p-1.5 rounded-lg">
                <i data-lucide="layers" class="text-white w-5 h-5"></i>
            </div>
            <span class="text-xl font-bold tracking-tight">{{ config('app.name') }}</span>
        </a>
    </div>

    {{-- ナビゲーション --}}
    <nav class="flex-1 px-4 space-y-1">
        <a href="{{ route('seller.home.index') }}" class="flex items-center space-x-3 {{ request()->routeIs('seller.home.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-500 hover:bg-gray-50' }} px-4 py-3 rounded-xl font-bold transition-all">
            <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
            <span>ダッシュボード</span>
        </a>
        <a href="{{ route('seller.product.index') }}" class="flex items-center space-x-3 {{ request()->routeIs('seller.product.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-500 hover:bg-gray-50' }} px-4 py-3 rounded-xl font-bold transition-all">
            <i data-lucide="package" class="w-5 h-5"></i>
            <span>出品アイテム管理</span>
        </a>
        <a href="{{ route('seller.legal-info.edit') }}" class="flex items-center space-x-3 {{ request()->routeIs('seller.legal-info.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-500 hover:bg-gray-50' }} px-4 py-3 rounded-xl font-bold transition-all">
            <i data-lucide="file-text" class="w-5 h-5"></i>
            <span>特定商取引法に基づく表記</span>
        </a>
        <a href="#" class="flex items-center space-x-3 text-gray-500 hover:bg-gray-50 px-4 py-3 rounded-xl font-medium transition-all">
            <i data-lucide="settings" class="w-5 h-5"></i>
            <span>設定</span>
        </a>

        {{-- 区切り線 --}}
        <div class="border-t border-gray-100 mt-4 pt-4">
            <a href="{{ route('user.home.index') }}" class="flex items-center space-x-3 text-gray-500 hover:bg-gray-50 px-4 py-3 rounded-xl font-medium transition-all">
                <i data-lucide="external-link" class="w-5 h-5"></i>
                <span>ストアを見る</span>
            </a>
            <a href="{{ route('user.profile.index') }}" class="flex items-center space-x-3 text-gray-500 hover:bg-gray-50 px-4 py-3 rounded-xl font-medium transition-all">
                <i data-lucide="user" class="w-5 h-5"></i>
                <span>ユーザー画面へ</span>
            </a>
        </div>
    </nav>

    {{-- ユーザー情報 --}}
    @auth
        <div class="p-4 border-t border-gray-100">
            <div class="flex items-center space-x-3 px-4 py-3">
                <div class="w-10 h-10 rounded-full overflow-hidden flex-shrink-0">
                    @if (Auth::user()->icon_url)
                        <img src="{{ Auth::user()->icon_url }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-indigo-100 flex items-center justify-center">
                            <i data-lucide="user" class="w-5 h-5 text-indigo-600"></i>
                        </div>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500 truncate">出品者</p>
                </div>
            </div>
        </div>
    @endauth
</aside>
