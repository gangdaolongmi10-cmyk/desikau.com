<x-admin.common title="ユーザー管理">
    {{-- 統計カード --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <div class="flex items-center space-x-3">
                <div class="bg-indigo-100 p-2 rounded-xl">
                    <i data-lucide="users" class="w-5 h-5 text-indigo-600"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-medium">全ユーザー</p>
                    <p class="text-xl font-bold">{{ number_format($totalCount) }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <div class="flex items-center space-x-3">
                <div class="bg-green-100 p-2 rounded-xl">
                    <i data-lucide="user-check" class="w-5 h-5 text-green-600"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-medium">有効</p>
                    <p class="text-xl font-bold">{{ number_format($activeCount) }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <div class="flex items-center space-x-3">
                <div class="bg-red-100 p-2 rounded-xl">
                    <i data-lucide="user-x" class="w-5 h-5 text-red-600"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-medium">退会済み</p>
                    <p class="text-xl font-bold">{{ number_format($deletedCount) }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- フィルター・検索 --}}
    <div class="bg-white rounded-[24px] border border-gray-100 shadow-sm p-4">
        <form action="{{ route('admin.user.index') }}" method="GET" class="flex flex-col lg:flex-row items-stretch lg:items-center gap-3">
            {{-- キーワード検索 --}}
            <div class="relative flex-1">
                <span class="absolute inset-y-0 left-4 flex items-center text-gray-400">
                    <i data-lucide="search" class="w-4 h-4"></i>
                </span>
                <input type="text" name="keyword" value="{{ $keyword }}" placeholder="名前・メールアドレスで検索"
                    class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
            </div>
            {{-- ステータスフィルター --}}
            <div class="flex items-center gap-2">
                <span class="text-sm text-gray-500 font-medium">ステータス:</span>
                @php
                    $statuses = ['' => '全て', 'active' => '有効', 'deleted' => '退会済み'];
                @endphp
                @foreach ($statuses as $key => $label)
                    <a href="{{ route('admin.user.index', array_filter(['keyword' => $keyword, 'status' => $key ?: null])) }}"
                        class="px-3 py-1.5 rounded-full text-xs font-bold transition-all {{ ($status ?? '') === $key ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>
            <button type="submit" class="px-4 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-bold hover:bg-indigo-700 transition-all">
                検索
            </button>
        </form>
    </div>

    {{-- ユーザーテーブル --}}
    <div class="bg-white rounded-[32px] border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-50 flex items-center justify-between">
            <h3 class="font-bold text-lg">ユーザー一覧</h3>
            <span class="text-sm text-gray-400">{{ $users->total() }}件</span>
        </div>

        @if ($users->isEmpty())
            <div class="p-12 text-center text-gray-400">
                <i data-lucide="user-x" class="w-10 h-10 mx-auto mb-3"></i>
                <p class="text-sm">該当するユーザーが見つかりません</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 text-[10px] uppercase font-bold text-gray-400 tracking-widest">
                        <tr>
                            <th class="px-6 py-4">ID</th>
                            <th class="px-6 py-4">ユーザー</th>
                            <th class="px-6 py-4">メールアドレス</th>
                            <th class="px-6 py-4">出品者</th>
                            <th class="px-6 py-4">メール認証</th>
                            <th class="px-6 py-4">ステータス</th>
                            <th class="px-6 py-4">登録日</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach ($users as $user)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 text-xs text-gray-500 font-mono">{{ $user->id }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-9 h-9 rounded-full bg-gray-100 overflow-hidden flex-shrink-0">
                                            @if ($user->icon_url)
                                                <img src="{{ $user->icon_url }}" alt="{{ $user->name }}" class="object-cover w-full h-full">
                                            @else
                                                <div class="w-full h-full bg-indigo-100 flex items-center justify-center">
                                                    <i data-lucide="user" class="w-4 h-4 text-indigo-600"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <span class="text-sm font-bold">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $user->email }}</td>
                                <td class="px-6 py-4">
                                    @if ($user->seller)
                                        <span class="text-[10px] bg-indigo-100 text-indigo-600 px-2 py-1 rounded-full font-bold">{{ $user->seller->shop_name }}</span>
                                    @else
                                        <span class="text-xs text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if ($user->email_verified_at)
                                        <span class="text-[10px] bg-green-100 text-green-600 px-2 py-1 rounded-full font-bold">認証済み</span>
                                    @else
                                        <span class="text-[10px] bg-yellow-100 text-yellow-600 px-2 py-1 rounded-full font-bold">未認証</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if ($user->trashed())
                                        <span class="text-[10px] bg-red-100 text-red-600 px-2 py-1 rounded-full font-bold">退会済み</span>
                                    @else
                                        <span class="text-[10px] bg-green-100 text-green-600 px-2 py-1 rounded-full font-bold">有効</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ $user->created_at->format('Y.m.d') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if ($users->hasPages())
                <div class="p-6 border-t border-gray-50">
                    {{ $users->links() }}
                </div>
            @endif
        @endif
    </div>
</x-admin.common>
