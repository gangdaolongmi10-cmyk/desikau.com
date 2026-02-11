<x-admin.common title="お知らせ管理">
    {{-- ヘッダー --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold">お知らせ管理</h1>
            <p class="text-sm text-gray-500 mt-1">サイトのお知らせを管理できます。</p>
        </div>
        <a href="{{ route('admin.announcement.create') }}" class="flex items-center space-x-2 px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition-all">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>新規作成</span>
        </a>
    </div>

    {{-- 成功メッセージ --}}
    @if (session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center space-x-2">
            <i data-lucide="check-circle" class="w-5 h-5"></i>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
    @endif

    {{-- フィルター --}}
    <div class="bg-white rounded-[24px] border border-gray-100 shadow-sm p-4">
        <div class="flex items-center gap-2">
            <span class="text-sm text-gray-500 font-medium mr-2">ステータス:</span>
            <a href="{{ route('admin.announcement.index') }}" class="px-4 py-2 rounded-full text-sm font-bold transition-all {{ !$status ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                全て
            </a>
            @foreach (\App\Enums\AnnouncementStatus::cases() as $s)
                <a href="{{ route('admin.announcement.index', ['status' => $s->value]) }}" class="px-4 py-2 rounded-full text-sm font-bold transition-all {{ $status === $s->value ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    {{ $s->label() }}
                </a>
            @endforeach
        </div>
    </div>

    {{-- お知らせテーブル --}}
    <div class="bg-white rounded-[32px] border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-50 flex items-center justify-between">
            <h3 class="font-bold text-lg">お知らせ一覧</h3>
            <span class="text-sm text-gray-400">{{ $announcements->total() }}件</span>
        </div>

        @if ($announcements->isEmpty())
            <div class="p-12 text-center text-gray-400">
                <i data-lucide="megaphone" class="w-10 h-10 mx-auto mb-3"></i>
                <p class="text-sm">お知らせがありません</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 text-[10px] uppercase font-bold text-gray-400 tracking-widest">
                        <tr>
                            <th class="px-6 py-4">タイトル</th>
                            <th class="px-6 py-4">カテゴリ</th>
                            <th class="px-6 py-4">ステータス</th>
                            <th class="px-6 py-4">公開日時</th>
                            <th class="px-6 py-4">公開終了</th>
                            <th class="px-6 py-4">操作</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach ($announcements as $announcement)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <span class="text-sm font-bold truncate max-w-[300px] block">{{ $announcement->title }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($announcement->category)
                                        <span class="text-[10px] px-2 py-1 rounded-full font-bold" style="background-color: {{ $announcement->category->color }}20; color: {{ $announcement->category->color }};">
                                            {{ $announcement->category->name }}
                                        </span>
                                    @else
                                        <span class="text-xs text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if ($announcement->status === \App\Enums\AnnouncementStatus::PUBLISHED && $announcement->isPublished())
                                        <span class="text-[10px] bg-green-100 text-green-600 px-2 py-1 rounded-full font-bold">公開中</span>
                                    @elseif ($announcement->status === \App\Enums\AnnouncementStatus::PUBLISHED)
                                        <span class="text-[10px] bg-yellow-100 text-yellow-600 px-2 py-1 rounded-full font-bold">予約</span>
                                    @else
                                        <span class="text-[10px] bg-gray-100 text-gray-500 px-2 py-1 rounded-full font-bold">終了</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ $announcement->published_at->format('Y.m.d H:i') }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ $announcement->closed_at?->format('Y.m.d H:i') ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.announcement.edit', $announcement) }}" class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all" title="編集">
                                            <i data-lucide="pencil" class="w-4 h-4"></i>
                                        </a>
                                        <form action="{{ route('admin.announcement.destroy', $announcement) }}" method="POST" onsubmit="return confirm('このお知らせを削除しますか？')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all" title="削除">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if ($announcements->hasPages())
                <div class="p-6 border-t border-gray-50">
                    {{ $announcements->links() }}
                </div>
            @endif
        @endif
    </div>
</x-admin.common>
