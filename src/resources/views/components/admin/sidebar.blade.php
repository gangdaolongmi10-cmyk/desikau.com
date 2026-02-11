{{-- 管理画面サイドバー --}}
<aside class="hidden lg:flex flex-col w-64 bg-gray-900 fixed h-full z-50">
    {{-- ロゴ --}}
    <div class="p-6">
        <a href="{{ route('admin.dashboard.index') }}" class="flex items-center space-x-2">
            <div class="bg-indigo-500 p-1.5 rounded-lg">
                <i data-lucide="shield" class="text-white w-5 h-5"></i>
            </div>
            <div>
                <span class="text-lg font-bold text-white tracking-tight">{{ config('app.name') }}</span>
                <p class="text-[10px] text-gray-400 -mt-0.5">管理画面</p>
            </div>
        </a>
    </div>

    {{-- ナビゲーション --}}
    <nav class="flex-1 px-3 space-y-1">
        <a href="{{ route('admin.dashboard.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl font-bold transition-all {{ request()->routeIs('admin.dashboard.*') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
            <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
            <span>ダッシュボード</span>
        </a>
        <a href="{{ route('admin.user.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl font-bold transition-all {{ request()->routeIs('admin.user.*') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
            <i data-lucide="users" class="w-5 h-5"></i>
            <span>ユーザー管理</span>
        </a>
        <a href="{{ route('admin.announcement.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl font-bold transition-all {{ request()->routeIs('admin.announcement.*') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
            <i data-lucide="megaphone" class="w-5 h-5"></i>
            <span>お知らせ管理</span>
        </a>
    </nav>

    {{-- フッター --}}
    <div class="p-4 border-t border-gray-800">
        <a href="{{ route('user.home.index') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-400 hover:text-white rounded-xl hover:bg-gray-800 transition-all">
            <i data-lucide="external-link" class="w-5 h-5"></i>
            <span class="text-sm font-medium">ストアを見る</span>
        </a>
    </div>
</aside>
