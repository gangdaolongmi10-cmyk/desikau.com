{{-- 出品者ヘッダー --}}
@props([
    'title' => 'ダッシュボード',
    'subtitle' => null,
])

<header class="bg-white/80 backdrop-blur-md sticky top-0 z-40 border-b border-gray-200 px-4 lg:px-8 py-4 flex items-center justify-between">
    {{-- モバイル用タイトル --}}
    <h1 class="text-lg font-bold lg:hidden">{{ $title }}</h1>

    {{-- デスクトップ用タイトル --}}
    <div class="hidden lg:block">
        <h2 class="text-xl font-bold">{{ $title }}</h2>
        @if ($subtitle)
            <p class="text-xs text-gray-500">{{ $subtitle }}</p>
        @elseif (Auth::check())
            <p class="text-xs text-gray-500">お帰りなさい、{{ Auth::user()->name }} さん</p>
        @endif
    </div>

    {{-- 右側アクション --}}
    <div class="flex items-center space-x-4">
        {{-- ストアを見るボタン --}}
        <a href="{{ route('user.home.index') }}" class="hidden md:flex items-center space-x-2 px-4 py-2 bg-gray-100 text-gray-600 rounded-xl font-medium hover:bg-gray-200 transition-all">
            <i data-lucide="external-link" class="w-4 h-4"></i>
            <span class="text-sm">ストアを見る</span>
        </a>

        {{-- ユーザーアイコン --}}
        @auth
            <div class="h-10 w-10 rounded-full bg-gray-200 border-2 border-white shadow-sm overflow-hidden">
                @if (Auth::user()->icon_url)
                    <img src="{{ Auth::user()->icon_url }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-indigo-100 flex items-center justify-center">
                        <i data-lucide="user" class="w-5 h-5 text-indigo-600"></i>
                    </div>
                @endif
            </div>
        @endauth
    </div>
</header>
