<x-admin.common title="お知らせ編集">
    {{-- ヘッダー --}}
    <div class="flex items-center space-x-4">
        <a href="{{ route('admin.announcement.index') }}" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-xl transition-all">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold">お知らせ編集</h1>
            <p class="text-sm text-gray-500 mt-1">お知らせの内容を編集します。</p>
        </div>
    </div>

    {{-- 成功メッセージ --}}
    @if (session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center space-x-2">
            <i data-lucide="check-circle" class="w-5 h-5"></i>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
    @endif

    {{-- フォーム --}}
    <form action="{{ route('admin.announcement.update', $announcement) }}" method="POST" class="bg-white rounded-[24px] border border-gray-100 shadow-sm p-6 lg:p-8">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            {{-- タイトル --}}
            <div>
                <label for="title" class="block text-sm font-bold text-gray-700 mb-2">タイトル <span class="text-red-500">*</span></label>
                <input type="text" name="title" id="title" value="{{ old('title', $announcement->title) }}" required
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all @error('title') border-red-500 @enderror"
                    placeholder="お知らせのタイトル">
                @error('title')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- カテゴリ・ステータス --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <label for="category_id" class="block text-sm font-bold text-gray-700 mb-2">カテゴリ</label>
                    <select name="category_id" id="category_id"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all appearance-none @error('category_id') border-red-500 @enderror">
                        <option value="">カテゴリなし</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $announcement->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="status" class="block text-sm font-bold text-gray-700 mb-2">ステータス <span class="text-red-500">*</span></label>
                    <select name="status" id="status" required
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all appearance-none @error('status') border-red-500 @enderror">
                        @foreach (\App\Enums\AnnouncementStatus::cases() as $s)
                            <option value="{{ $s->value }}" {{ old('status', $announcement->status->value) === $s->value ? 'selected' : '' }}>{{ $s->label() }}</option>
                        @endforeach
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- 公開日時・終了日時 --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <label for="published_at" class="block text-sm font-bold text-gray-700 mb-2">公開日時 <span class="text-red-500">*</span></label>
                    <input type="datetime-local" name="published_at" id="published_at" value="{{ old('published_at', $announcement->published_at->format('Y-m-d\TH:i')) }}" required
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all @error('published_at') border-red-500 @enderror">
                    @error('published_at')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="closed_at" class="block text-sm font-bold text-gray-700 mb-2">公開終了日時</label>
                    <input type="datetime-local" name="closed_at" id="closed_at" value="{{ old('closed_at', $announcement->closed_at?->format('Y-m-d\TH:i')) }}"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all @error('closed_at') border-red-500 @enderror">
                    <p class="mt-1 text-xs text-gray-400">空欄の場合は無期限で公開されます。</p>
                    @error('closed_at')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- 本文 --}}
            <div>
                <label for="content" class="block text-sm font-bold text-gray-700 mb-2">本文 <span class="text-red-500">*</span></label>
                <textarea name="content" id="content" rows="10" required
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all resize-none @error('content') border-red-500 @enderror"
                    placeholder="お知らせの本文を入力してください。">{{ old('content', $announcement->content) }}</textarea>
                @error('content')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- ボタン --}}
        <div class="flex items-center justify-between mt-8 pt-6 border-t border-gray-100">
            <button type="button" onclick="if(confirm('このお知らせを削除しますか？')) document.getElementById('delete-form').submit()"
                class="flex items-center space-x-2 px-4 py-2.5 text-red-600 hover:bg-red-50 rounded-xl font-bold transition-all">
                <i data-lucide="trash-2" class="w-4 h-4"></i>
                <span>削除</span>
            </button>
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.announcement.index') }}" class="px-6 py-3 bg-gray-100 text-gray-600 rounded-xl font-bold hover:bg-gray-200 transition-all">
                    キャンセル
                </a>
                <button type="submit" class="flex items-center space-x-2 px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition-all">
                    <i data-lucide="check" class="w-5 h-5"></i>
                    <span>更新する</span>
                </button>
            </div>
        </div>
    </form>

    {{-- 削除フォーム（メインフォーム外に配置） --}}
    <form id="delete-form" action="{{ route('admin.announcement.destroy', $announcement) }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>
</x-admin.common>
