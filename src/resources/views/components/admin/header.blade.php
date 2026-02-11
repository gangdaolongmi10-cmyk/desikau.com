{{-- 管理画面ヘッダー --}}
@props([
    'title' => 'ダッシュボード',
])

<header class="bg-white/80 backdrop-blur-md sticky top-0 z-40 border-b border-gray-200 px-4 lg:px-8 py-4 flex items-center justify-between">
    <h1 class="text-lg lg:text-xl font-bold">{{ $title }}</h1>

    <div class="flex items-center space-x-4">
        <a href="{{ route('user.home.index') }}" class="hidden md:flex items-center space-x-2 px-4 py-2 bg-gray-100 text-gray-600 rounded-xl font-medium hover:bg-gray-200 transition-all">
            <i data-lucide="external-link" class="w-4 h-4"></i>
            <span class="text-sm">ストアを見る</span>
        </a>
    </div>
</header>
