<x-seller.common title="設定">
    {{-- ヘッダー --}}
    <div>
        <h1 class="text-2xl font-bold">設定</h1>
        <p class="text-sm text-gray-500 mt-1">ショップ情報やアカウント設定を管理できます。</p>
    </div>

    {{-- 成功メッセージ --}}
    @if (session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center space-x-2">
            <i data-lucide="check-circle" class="w-5 h-5"></i>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
    @endif

    {{-- フォーム --}}
    <form action="{{ route('seller.settings.update') }}" method="POST" class="space-y-8">
        @csrf
        @method('PUT')

        {{-- セクション1: ショップ情報 --}}
        <div class="bg-white rounded-[24px] border border-gray-100 shadow-sm p-6 lg:p-8">
            <div class="flex items-center space-x-3 mb-6">
                <div class="bg-indigo-100 p-2 rounded-xl">
                    <i data-lucide="store" class="w-5 h-5 text-indigo-600"></i>
                </div>
                <h2 class="text-lg font-bold">ショップ情報</h2>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{-- ショップ名 --}}
                <div>
                    <label for="shop_name" class="block text-sm font-bold text-gray-700 mb-2">ショップ名 <span class="text-red-500">*</span></label>
                    <input type="text" name="shop_name" id="shop_name" value="{{ old('shop_name', $seller->shop_name) }}" required
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all @error('shop_name') border-red-500 @enderror"
                        placeholder="例: デジタルクリエイトショップ">
                    @error('shop_name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- 主な販売カテゴリー --}}
                <div>
                    <label for="main_category" class="block text-sm font-bold text-gray-700 mb-2">主な販売カテゴリー <span class="text-red-500">*</span></label>
                    <select name="main_category" id="main_category" required
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all appearance-none @error('main_category') border-red-500 @enderror">
                        <option value="">選択してください</option>
                        <option value="3d" {{ old('main_category', $seller->main_category) === '3d' ? 'selected' : '' }}>3Dモデル</option>
                        <option value="ui" {{ old('main_category', $seller->main_category) === 'ui' ? 'selected' : '' }}>UIキット</option>
                        <option value="texture" {{ old('main_category', $seller->main_category) === 'texture' ? 'selected' : '' }}>テクスチャ</option>
                        <option value="font" {{ old('main_category', $seller->main_category) === 'font' ? 'selected' : '' }}>フォント</option>
                        <option value="other" {{ old('main_category', $seller->main_category) === 'other' ? 'selected' : '' }}>その他</option>
                    </select>
                    @error('main_category')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- ショップの紹介文 --}}
                <div class="lg:col-span-2">
                    <label for="description" class="block text-sm font-bold text-gray-700 mb-2">ショップの紹介文</label>
                    <textarea name="description" id="description" rows="4"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all resize-none @error('description') border-red-500 @enderror"
                        placeholder="ショップの特徴や取り扱いコンテンツについて紹介してください。">{{ old('description', $seller->description) }}</textarea>
                    <p class="mt-1 text-xs text-gray-400">1000文字以内</p>
                    @error('description')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- セクション2: SNS・外部アカウント --}}
        <div class="bg-white rounded-[24px] border border-gray-100 shadow-sm p-6 lg:p-8">
            <div class="flex items-center space-x-3 mb-6">
                <div class="bg-indigo-100 p-2 rounded-xl">
                    <i data-lucide="share-2" class="w-5 h-5 text-indigo-600"></i>
                </div>
                <h2 class="text-lg font-bold">SNS・外部アカウント</h2>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{-- X (Twitter) ユーザー名 --}}
                <div>
                    <label for="twitter_username" class="block text-sm font-bold text-gray-700 mb-2">X (Twitter) ユーザー名</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-4 flex items-center text-gray-400">@</span>
                        <input type="text" name="twitter_username" id="twitter_username" value="{{ old('twitter_username', $seller->twitter_username) }}"
                            class="w-full pl-8 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all @error('twitter_username') border-red-500 @enderror"
                            placeholder="username">
                    </div>
                    @error('twitter_username')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Twitch ユーザー名 --}}
                <div>
                    <label for="twitch_username" class="block text-sm font-bold text-gray-700 mb-2">Twitch ユーザー名</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-4 flex items-center text-gray-400">@</span>
                        <input type="text" name="twitch_username" id="twitch_username" value="{{ old('twitch_username', $seller->twitch_username) }}"
                            class="w-full pl-8 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all @error('twitch_username') border-red-500 @enderror"
                            placeholder="username">
                    </div>
                    @error('twitch_username')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- YouTube チャンネルURL --}}
                <div class="lg:col-span-2">
                    <label for="youtube_url" class="block text-sm font-bold text-gray-700 mb-2">YouTube チャンネルURL</label>
                    <input type="url" name="youtube_url" id="youtube_url" value="{{ old('youtube_url', $seller->youtube_url) }}"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all @error('youtube_url') border-red-500 @enderror"
                        placeholder="https://www.youtube.com/@channel">
                    @error('youtube_url')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- セクション3: 住所・連絡先情報 --}}
        <div class="bg-white rounded-[24px] border border-gray-100 shadow-sm p-6 lg:p-8">
            <div class="flex items-center space-x-3 mb-6">
                <div class="bg-indigo-100 p-2 rounded-xl">
                    <i data-lucide="map-pin" class="w-5 h-5 text-indigo-600"></i>
                </div>
                <h2 class="text-lg font-bold">住所・連絡先情報</h2>
            </div>
            <p class="text-sm text-gray-500 mb-6">特定商取引法に基づく表記や発送業務に使用されます。</p>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{-- 郵便番号 --}}
                <div>
                    <label for="postal_code" class="block text-sm font-bold text-gray-700 mb-2">郵便番号</label>
                    <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code', $seller->postal_code) }}"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all @error('postal_code') border-red-500 @enderror"
                        placeholder="123-4567">
                    @error('postal_code')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- 電話番号 --}}
                <div>
                    <label for="phone_number" class="block text-sm font-bold text-gray-700 mb-2">電話番号</label>
                    <input type="tel" name="phone_number" id="phone_number" value="{{ old('phone_number', $seller->phone_number) }}"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all @error('phone_number') border-red-500 @enderror"
                        placeholder="03-1234-5678">
                    @error('phone_number')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- 都道府県 --}}
                <div>
                    <label for="prefecture" class="block text-sm font-bold text-gray-700 mb-2">都道府県</label>
                    <select name="prefecture" id="prefecture"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all appearance-none @error('prefecture') border-red-500 @enderror">
                        <option value="">選択してください</option>
                        @php
                            $prefectures = [
                                '北海道', '青森県', '岩手県', '宮城県', '秋田県', '山形県', '福島県',
                                '茨城県', '栃木県', '群馬県', '埼玉県', '千葉県', '東京都', '神奈川県',
                                '新潟県', '富山県', '石川県', '福井県', '山梨県', '長野県', '岐阜県',
                                '静岡県', '愛知県', '三重県', '滋賀県', '京都府', '大阪府', '兵庫県',
                                '奈良県', '和歌山県', '鳥取県', '島根県', '岡山県', '広島県', '山口県',
                                '徳島県', '香川県', '愛媛県', '高知県', '福岡県', '佐賀県', '長崎県',
                                '熊本県', '大分県', '宮崎県', '鹿児島県', '沖縄県',
                            ];
                        @endphp
                        @foreach($prefectures as $pref)
                            <option value="{{ $pref }}" {{ old('prefecture', $seller->prefecture) === $pref ? 'selected' : '' }}>{{ $pref }}</option>
                        @endforeach
                    </select>
                    @error('prefecture')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- 市区町村 --}}
                <div>
                    <label for="city" class="block text-sm font-bold text-gray-700 mb-2">市区町村</label>
                    <input type="text" name="city" id="city" value="{{ old('city', $seller->city) }}"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all @error('city') border-red-500 @enderror"
                        placeholder="渋谷区">
                    @error('city')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- 住所 --}}
                <div class="lg:col-span-2">
                    <label for="address" class="block text-sm font-bold text-gray-700 mb-2">住所</label>
                    <input type="text" name="address" id="address" value="{{ old('address', $seller->address) }}"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all @error('address') border-red-500 @enderror"
                        placeholder="道玄坂1-2-3">
                    @error('address')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- 建物名・部屋番号 --}}
                <div class="lg:col-span-2">
                    <label for="building" class="block text-sm font-bold text-gray-700 mb-2">建物名・部屋番号</label>
                    <input type="text" name="building" id="building" value="{{ old('building', $seller->building) }}"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all @error('building') border-red-500 @enderror"
                        placeholder="ABCビル4階">
                    @error('building')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- セクション4: パスワード変更 --}}
        <div class="bg-white rounded-[24px] border border-gray-100 shadow-sm p-6 lg:p-8">
            <div class="flex items-center space-x-3 mb-6">
                <div class="bg-indigo-100 p-2 rounded-xl">
                    <i data-lucide="lock" class="w-5 h-5 text-indigo-600"></i>
                </div>
                <h2 class="text-lg font-bold">パスワード変更</h2>
            </div>
            <p class="text-sm text-gray-500 mb-6">パスワードを変更しない場合は空欄のままにしてください。</p>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{-- 現在のパスワード --}}
                <div class="lg:col-span-2">
                    <label for="current_password" class="block text-sm font-bold text-gray-700 mb-2">現在のパスワード</label>
                    <input type="password" name="current_password" id="current_password"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all @error('current_password') border-red-500 @enderror"
                        placeholder="現在のパスワードを入力">
                    @error('current_password')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- 新しいパスワード --}}
                <div>
                    <label for="password" class="block text-sm font-bold text-gray-700 mb-2">新しいパスワード</label>
                    <input type="password" name="password" id="password"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all @error('password') border-red-500 @enderror"
                        placeholder="8文字以上">
                    @error('password')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- 新しいパスワード（確認） --}}
                <div>
                    <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-2">新しいパスワード（確認）</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                        placeholder="もう一度入力">
                </div>
            </div>
        </div>

        {{-- ボタン --}}
        <div class="flex items-center justify-end space-x-4">
            <button type="submit" class="flex items-center space-x-2 px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition-all">
                <i data-lucide="check" class="w-5 h-5"></i>
                <span>保存する</span>
            </button>
        </div>
    </form>
</x-seller.common>
