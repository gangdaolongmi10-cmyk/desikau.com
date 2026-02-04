<x-user.common title="お知らせ">
    <div class="max-w-4xl mx-auto px-4">
        <div class="mb-10">
            <h1 class="text-3xl font-extrabold text-gray-900">お知らせ</h1>
            <p class="text-gray-500 mt-2">サービスに関する重要なお知らせやアップデート情報をお届けします。</p>
        </div>

        @if ($announcements->isEmpty())
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-12 text-center">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i data-lucide="bell-off" class="w-10 h-10 text-gray-400"></i>
                </div>
                <h2 class="text-xl font-bold text-gray-900 mb-2">お知らせはありません</h2>
                <p class="text-gray-500">現在公開中のお知らせはありません。</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach ($announcements as $announcement)
                    <a href="{{ route('user.announcement.show', $announcement) }}"
                       class="block bg-white rounded-2xl border border-gray-100 shadow-sm p-6 hover:shadow-md hover:border-gray-200 transition-all group">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-3 mb-2">
                                    @if ($announcement->category)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold text-white"
                                              style="background-color: {{ $announcement->category->color }}">
                                            {{ $announcement->category->name }}
                                        </span>
                                    @endif
                                    <span class="text-sm text-gray-500">
                                        {{ $announcement->published_at->format('Y.m.d') }}
                                    </span>
                                </div>
                                <h2 class="text-lg font-bold text-gray-900 group-hover:text-indigo-600 transition-colors truncate">
                                    {{ $announcement->title }}
                                </h2>
                            </div>
                            <div class="flex-shrink-0 text-gray-400 group-hover:text-indigo-600 transition-colors">
                                <i data-lucide="chevron-right" class="w-5 h-5"></i>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            @if ($announcements->hasPages())
                <div class="mt-8">
                    {{ $announcements->links() }}
                </div>
            @endif
        @endif
    </div>
</x-user.common>
