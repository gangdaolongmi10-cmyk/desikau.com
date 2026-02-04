<x-user.common title="{{ $announcement->title }}">
    <div class="max-w-4xl mx-auto px-4">
        {{-- パンくずリスト --}}
        <nav class="mb-6">
            <ol class="flex items-center space-x-2 text-sm">
                <li>
                    <a href="{{ route('user.home.index') }}" class="text-gray-500 hover:text-indigo-600 transition-colors">
                        ホーム
                    </a>
                </li>
                <li class="text-gray-400">/</li>
                <li>
                    <a href="{{ route('user.announcement.index') }}" class="text-gray-500 hover:text-indigo-600 transition-colors">
                        お知らせ
                    </a>
                </li>
                <li class="text-gray-400">/</li>
                <li class="text-gray-900 font-medium truncate max-w-xs">
                    {{ $announcement->title }}
                </li>
            </ol>
        </nav>

        <article class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
            {{-- ヘッダー --}}
            <div class="p-8 border-b border-gray-100">
                <div class="flex items-center gap-3 mb-4">
                    @if ($announcement->category)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold text-white"
                              style="background-color: {{ $announcement->category->color }}">
                            {{ $announcement->category->name }}
                        </span>
                    @endif
                    <span class="text-sm text-gray-500">
                        {{ $announcement->published_at->format('Y年n月j日') }}
                    </span>
                </div>
                <h1 class="text-2xl font-bold text-gray-900">
                    {{ $announcement->title }}
                </h1>
            </div>

            {{-- 本文 --}}
            <div class="p-8">
                <div class="prose prose-gray max-w-none">
                    {!! nl2br(e($announcement->content)) !!}
                </div>
            </div>
        </article>

        {{-- 戻るリンク --}}
        <div class="mt-8 text-center">
            <a href="{{ route('user.announcement.index') }}"
               class="inline-flex items-center space-x-2 text-indigo-600 hover:text-indigo-700 font-bold transition-colors">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                <span>お知らせ一覧に戻る</span>
            </a>
        </div>
    </div>
</x-user.common>
