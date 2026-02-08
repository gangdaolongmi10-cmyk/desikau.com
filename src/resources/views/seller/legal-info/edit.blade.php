<x-seller.common title="特定商取引法に基づく表記">
    {{-- ヘッダー --}}
    <div>
        <h1 class="text-2xl font-bold">特定商取引法に基づく表記</h1>
        <p class="text-sm text-gray-500 mt-1">法令に基づき、販売者情報を登録してください。</p>
    </div>

    {{-- 成功メッセージ --}}
    @if (session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center space-x-2">
            <i data-lucide="check-circle" class="w-5 h-5"></i>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
    @endif

    {{-- フォーム --}}
    <form action="{{ route('seller.legal-info.update') }}" method="POST" class="bg-white rounded-[24px] border border-gray-100 shadow-sm p-6 lg:p-8">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- 販売業者名 --}}
            <div>
                <label for="company_name" class="block text-sm font-bold text-gray-700 mb-2">販売業者名 <span class="text-red-500">*</span></label>
                <input type="text" name="company_name" id="company_name" value="{{ old('company_name', $legalInfo?->company_name) }}" required
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all @error('company_name') border-red-500 @enderror"
                    placeholder="例: 株式会社デジタルクリエイト">
                @error('company_name')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- 代表者名 --}}
            <div>
                <label for="representative_name" class="block text-sm font-bold text-gray-700 mb-2">代表者名 <span class="text-red-500">*</span></label>
                <input type="text" name="representative_name" id="representative_name" value="{{ old('representative_name', $legalInfo?->representative_name) }}" required
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all @error('representative_name') border-red-500 @enderror"
                    placeholder="例: 山田太郎">
                @error('representative_name')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- 郵便番号 --}}
            <div>
                <label for="postal_code" class="block text-sm font-bold text-gray-700 mb-2">郵便番号 <span class="text-red-500">*</span></label>
                <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code', $legalInfo?->postal_code) }}" required
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all @error('postal_code') border-red-500 @enderror"
                    placeholder="例: 150-0001">
                @error('postal_code')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- 電話番号 --}}
            <div>
                <label for="phone_number" class="block text-sm font-bold text-gray-700 mb-2">電話番号 <span class="text-red-500">*</span></label>
                <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number', $legalInfo?->phone_number) }}" required
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all @error('phone_number') border-red-500 @enderror"
                    placeholder="例: 03-1234-5678">
                @error('phone_number')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- 所在地 --}}
            <div class="lg:col-span-2">
                <label for="address" class="block text-sm font-bold text-gray-700 mb-2">所在地 <span class="text-red-500">*</span></label>
                <input type="text" name="address" id="address" value="{{ old('address', $legalInfo?->address) }}" required
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all @error('address') border-red-500 @enderror"
                    placeholder="例: 東京都渋谷区神宮前1-2-3 クリエイティブビル5F">
                @error('address')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- メールアドレス --}}
            <div class="lg:col-span-2">
                <label for="email" class="block text-sm font-bold text-gray-700 mb-2">メールアドレス <span class="text-red-500">*</span></label>
                <input type="email" name="email" id="email" value="{{ old('email', $legalInfo?->email) }}" required
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all @error('email') border-red-500 @enderror"
                    placeholder="例: info@example.com">
                @error('email')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- 販売価格について --}}
            <div class="lg:col-span-2">
                <label for="price_description" class="block text-sm font-bold text-gray-700 mb-2">販売価格について <span class="text-red-500">*</span></label>
                <textarea name="price_description" id="price_description" rows="3" required
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all resize-none @error('price_description') border-red-500 @enderror"
                    placeholder="例: 各商品ページに表示された価格に基づきます。表示価格は税込みです。">{{ old('price_description', $legalInfo?->price_description) }}</textarea>
                @error('price_description')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- 支払方法 --}}
            <div class="lg:col-span-2">
                <label for="payment_method" class="block text-sm font-bold text-gray-700 mb-2">支払方法 <span class="text-red-500">*</span></label>
                <textarea name="payment_method" id="payment_method" rows="3" required
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all resize-none @error('payment_method') border-red-500 @enderror"
                    placeholder="例: クレジットカード（VISA、Mastercard、JCB、American Express）">{{ old('payment_method', $legalInfo?->payment_method) }}</textarea>
                @error('payment_method')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- 引渡し時期 --}}
            <div class="lg:col-span-2">
                <label for="delivery_period" class="block text-sm font-bold text-gray-700 mb-2">引渡し時期 <span class="text-red-500">*</span></label>
                <textarea name="delivery_period" id="delivery_period" rows="3" required
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all resize-none @error('delivery_period') border-red-500 @enderror"
                    placeholder="例: 決済完了後、即時ダウンロード可能です。">{{ old('delivery_period', $legalInfo?->delivery_period) }}</textarea>
                @error('delivery_period')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- 返品・キャンセルについて --}}
            <div class="lg:col-span-2">
                <label for="return_policy" class="block text-sm font-bold text-gray-700 mb-2">返品・キャンセルについて <span class="text-red-500">*</span></label>
                <textarea name="return_policy" id="return_policy" rows="3" required
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all resize-none @error('return_policy') border-red-500 @enderror"
                    placeholder="例: デジタルコンテンツの性質上、購入後の返品・キャンセルはお受けできません。">{{ old('return_policy', $legalInfo?->return_policy) }}</textarea>
                @error('return_policy')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- ボタン --}}
        <div class="flex items-center justify-end space-x-4 mt-8 pt-6 border-t border-gray-100">
            <button type="submit" class="flex items-center space-x-2 px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition-all">
                <i data-lucide="check" class="w-5 h-5"></i>
                <span>保存する</span>
            </button>
        </div>
    </form>
</x-seller.common>
