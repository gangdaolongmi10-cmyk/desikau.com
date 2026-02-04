<x-seller.common title="商品編集">
    {{-- ヘッダー --}}
    <div class="flex items-center space-x-4">
        <a href="{{ route('seller.product.index') }}" class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-all">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold">商品編集</h1>
            <p class="text-sm text-gray-500 mt-1">{{ $product->name }}</p>
        </div>
    </div>

    {{-- フォーム --}}
    <form action="{{ route('seller.product.update', $product) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-[24px] border border-gray-100 shadow-sm p-6 lg:p-8">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- 商品名 --}}
            <div class="lg:col-span-2">
                <label for="name" class="block text-sm font-bold text-gray-700 mb-2">商品名 <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all @error('name') border-red-500 @enderror"
                    placeholder="例: デジタルイラスト素材集">
                @error('name')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- カテゴリー --}}
            <div>
                <label for="category_id" class="block text-sm font-bold text-gray-700 mb-2">カテゴリー <span class="text-red-500">*</span></label>
                <select name="category_id" id="category_id" required
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all @error('category_id') border-red-500 @enderror">
                    <option value="">選択してください</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- ステータス --}}
            <div>
                <label for="status" class="block text-sm font-bold text-gray-700 mb-2">公開ステータス <span class="text-red-500">*</span></label>
                <select name="status" id="status" required
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all @error('status') border-red-500 @enderror">
                    <option value="0" {{ old('status', $product->status->value) == 0 ? 'selected' : '' }}>非公開</option>
                    <option value="1" {{ old('status', $product->status->value) == 1 ? 'selected' : '' }}>公開中</option>
                </select>
                @error('status')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- 価格 --}}
            <div>
                <label for="price" class="block text-sm font-bold text-gray-700 mb-2">価格（円） <span class="text-red-500">*</span></label>
                <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" required min="0"
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all @error('price') border-red-500 @enderror"
                    placeholder="例: 1980">
                @error('price')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- 元価格 --}}
            <div>
                <label for="original_price" class="block text-sm font-bold text-gray-700 mb-2">元価格（円）</label>
                <input type="number" name="original_price" id="original_price" value="{{ old('original_price', $product->original_price) }}" min="0"
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all @error('original_price') border-red-500 @enderror"
                    placeholder="例: 2980（セール前の価格）">
                @error('original_price')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- 商品説明 --}}
            <div class="lg:col-span-2">
                <label for="description" class="block text-sm font-bold text-gray-700 mb-2">商品説明</label>
                <textarea name="description" id="description" rows="6"
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all resize-none @error('description') border-red-500 @enderror"
                    placeholder="商品の特徴や内容を詳しく記入してください">{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- 画像URL --}}
            <div class="lg:col-span-2">
                <label for="image_url" class="block text-sm font-bold text-gray-700 mb-2">商品画像URL</label>
                <input type="url" name="image_url" id="image_url" value="{{ old('image_url', $product->image_url) }}"
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all @error('image_url') border-red-500 @enderror"
                    placeholder="https://example.com/image.jpg">
                @error('image_url')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
                @if ($product->image_url)
                    <div class="mt-3">
                        <p class="text-xs text-gray-500 mb-2">現在の画像:</p>
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-32 h-32 object-cover rounded-lg">
                    </div>
                @endif
            </div>

            {{-- デジタルコンテンツファイル --}}
            <div class="lg:col-span-2">
                <label for="file" class="block text-sm font-bold text-gray-700 mb-2">デジタルコンテンツファイル</label>
                @if ($product->file_path)
                    <div class="mb-3 flex items-center space-x-2 text-sm text-gray-700 bg-gray-50 px-4 py-2 rounded-lg">
                        <i data-lucide="file" class="w-4 h-4 text-gray-400"></i>
                        <span>現在のファイル: {{ basename($product->file_path) }}</span>
                    </div>
                @endif
                <input type="file" name="file" id="file"
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all @error('file') border-red-500 @enderror">
                <p class="mt-1 text-xs text-gray-500">
                    @if ($product->file_path)
                        新しいファイルを選択すると既存のファイルが置き換わります。最大500MBまで。
                    @else
                        最大500MBまでアップロード可能です。
                    @endif
                </p>
                @error('file')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- ファイル形式 --}}
            <div>
                <label for="file_format" class="block text-sm font-bold text-gray-700 mb-2">ファイル形式</label>
                <input type="text" name="file_format" id="file_format" value="{{ old('file_format', $product->file_format) }}"
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all @error('file_format') border-red-500 @enderror"
                    placeholder="例: PSD, AI, PNG">
                @error('file_format')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- ファイルサイズ --}}
            <div>
                <label for="file_size" class="block text-sm font-bold text-gray-700 mb-2">ファイルサイズ</label>
                <input type="text" name="file_size" id="file_size" value="{{ old('file_size', $product->file_size) }}"
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all @error('file_size') border-red-500 @enderror"
                    placeholder="例: 256MB">
                @error('file_size')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- ボタン --}}
        <div class="flex items-center justify-end space-x-4 mt-8 pt-6 border-t border-gray-100">
            <a href="{{ route('seller.product.index') }}" class="px-6 py-3 text-gray-500 font-bold hover:text-gray-700 transition-all">
                キャンセル
            </a>
            <button type="submit" class="flex items-center space-x-2 px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition-all">
                <i data-lucide="check" class="w-5 h-5"></i>
                <span>更新する</span>
            </button>
        </div>
    </form>
</x-seller.common>
