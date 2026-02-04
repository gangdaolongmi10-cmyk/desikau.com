<x-user.common title="出品者登録">
    <div class="max-w-3xl mx-auto">
        <!-- Title Section -->
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-indigo-50 rounded-2xl mb-4">
                <i data-lucide="store" class="text-indigo-600 w-8 h-8"></i>
            </div>
            <h1 class="text-3xl font-bold tracking-tight text-gray-900">出品者として登録</h1>
            <p class="text-gray-500 mt-2">クリエイタープロフィールを設定して販売を開始しましょう</p>
        </div>

        <!-- Registration Form Card -->
        <div class="bg-white rounded-[32px] p-8 md:p-12 border border-gray-100 shadow-sm">
            {{-- エラー表示 --}}
            @if ($errors->any())
                <div class="mb-8 p-4 bg-red-50 border border-red-200 rounded-2xl">
                    <ul class="text-sm text-red-600 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('user.seller.register.register') }}" method="POST" class="space-y-10">
                @csrf

                <!-- Section: Shop Basic Info -->
                <div class="space-y-6">
                    <div class="flex items-center space-x-2 border-b border-gray-50 pb-4">
                        <i data-lucide="user-plus" class="w-5 h-5 text-indigo-600"></i>
                        <h2 class="text-xl font-bold">基本情報</h2>
                    </div>

                    <!-- Email Address Field -->
                    <div class="space-y-2">
                        <label for="email" class="text-sm font-bold text-gray-700">メールアドレス <span class="text-red-500">*</span></label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                <i data-lucide="mail" class="w-5 h-5 text-gray-400 group-focus-within:text-indigo-600 transition-colors"></i>
                            </div>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="example@digitalvault.com" class="w-full bg-gray-50 border border-gray-200 rounded-2xl pl-14 pr-5 py-4 focus:bg-white focus:border-indigo-600 outline-none transition-all @error('email') border-red-500 @enderror">
                        </div>
                        <p class="text-[11px] text-gray-400 ml-1">重要なお知らせをこのアドレスにお送りします。</p>
                    </div>

                    <!-- Password Fields -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="password" class="text-sm font-bold text-gray-700">パスワード <span class="text-red-500">*</span></label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                    <i data-lucide="lock" class="w-5 h-5 text-gray-400 group-focus-within:text-indigo-600 transition-colors"></i>
                                </div>
                                <input type="password" id="password" name="password" required placeholder="8文字以上" class="w-full bg-gray-50 border border-gray-200 rounded-2xl pl-14 pr-5 py-4 focus:bg-white focus:border-indigo-600 outline-none transition-all @error('password') border-red-500 @enderror">
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label for="password_confirmation" class="text-sm font-bold text-gray-700">パスワード（確認） <span class="text-red-500">*</span></label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                    <i data-lucide="lock" class="w-5 h-5 text-gray-400 group-focus-within:text-indigo-600 transition-colors"></i>
                                </div>
                                <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="もう一度入力" class="w-full bg-gray-50 border border-gray-200 rounded-2xl pl-14 pr-5 py-4 focus:bg-white focus:border-indigo-600 outline-none transition-all">
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="shop_name" class="text-sm font-bold text-gray-700">ショップ名 / クリエイター名 <span class="text-red-500">*</span></label>
                            <input type="text" id="shop_name" name="shop_name" value="{{ old('shop_name') }}" required placeholder="例: Digital Studio" class="w-full bg-gray-50 border border-gray-200 rounded-2xl px-5 py-4 focus:bg-white focus:border-indigo-600 outline-none transition-all @error('shop_name') border-red-500 @enderror">
                        </div>
                        <div class="space-y-2">
                            <label for="main_category" class="text-sm font-bold text-gray-700">主な販売カテゴリー <span class="text-red-500">*</span></label>
                            <select id="main_category" name="main_category" required class="w-full bg-gray-50 border border-gray-200 rounded-2xl px-5 py-4 focus:bg-white focus:border-indigo-600 outline-none transition-all appearance-none @error('main_category') border-red-500 @enderror">
                                <option value="">選択してください</option>
                                <option value="3d" {{ old('main_category') === '3d' ? 'selected' : '' }}>3Dモデル</option>
                                <option value="ui" {{ old('main_category') === 'ui' ? 'selected' : '' }}>UIキット</option>
                                <option value="texture" {{ old('main_category') === 'texture' ? 'selected' : '' }}>テクスチャ</option>
                                <option value="font" {{ old('main_category') === 'font' ? 'selected' : '' }}>フォント</option>
                                <option value="other" {{ old('main_category') === 'other' ? 'selected' : '' }}>その他</option>
                            </select>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="description" class="text-sm font-bold text-gray-700">ショップの紹介文</label>
                        <textarea id="description" name="description" rows="4" placeholder="作品の特徴やコンセプトを入力してください" class="w-full bg-gray-50 border border-gray-200 rounded-2xl px-5 py-4 focus:bg-white focus:border-indigo-600 outline-none transition-all resize-none @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                    </div>
                </div>

                <!-- Section: SNS Links -->
                <div class="space-y-6">
                    <div class="flex items-center justify-between border-b border-gray-50 pb-4">
                        <div class="flex items-center space-x-2">
                            <i data-lucide="share-2" class="w-5 h-5 text-indigo-600"></i>
                            <h2 class="text-xl font-bold">SNS・外部アカウント</h2>
                        </div>
                        <span class="text-xs font-bold text-gray-400 bg-gray-50 px-3 py-1 rounded-full uppercase tracking-wider">任意</span>
                    </div>
                    <p class="text-sm text-gray-500">あなたの活動状況がわかるアカウントを登録してください。</p>

                    <div class="grid grid-cols-1 gap-4">
                        <!-- X (Twitter) -->
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                <i data-lucide="twitter" class="w-5 h-5 text-gray-400 group-focus-within:text-black transition-colors"></i>
                            </div>
                            <input type="text" name="twitter_username" value="{{ old('twitter_username') }}" placeholder="X (Twitter) ユーザー名 (@username)" class="w-full bg-gray-50 border border-gray-200 rounded-2xl pl-14 pr-5 py-4 focus:bg-white focus:border-black outline-none transition-all">
                        </div>

                        <!-- YouTube -->
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                <i data-lucide="youtube" class="w-5 h-5 text-gray-400 group-focus-within:text-red-600 transition-colors"></i>
                            </div>
                            <input type="url" name="youtube_url" value="{{ old('youtube_url') }}" placeholder="YouTube チャンネルURL" class="w-full bg-gray-50 border border-gray-200 rounded-2xl pl-14 pr-5 py-4 focus:bg-white focus:border-red-600 outline-none transition-all">
                        </div>

                        <!-- Twitch -->
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                <i data-lucide="twitch" class="w-5 h-5 text-gray-400 group-focus-within:text-purple-600 transition-colors"></i>
                            </div>
                            <input type="text" name="twitch_username" value="{{ old('twitch_username') }}" placeholder="Twitch ユーザー名" class="w-full bg-gray-50 border border-gray-200 rounded-2xl pl-14 pr-5 py-4 focus:bg-white focus:border-purple-600 outline-none transition-all">
                        </div>
                    </div>
                </div>

                <!-- Section: Verification Footer -->
                <div class="space-y-6 pt-6 border-t border-gray-50">
                    <label class="flex items-start space-x-4 cursor-pointer group">
                        <div class="relative flex items-center mt-1">
                            <input type="checkbox" name="agree_terms" value="1" {{ old('agree_terms') ? 'checked' : '' }} required class="peer h-6 w-6 cursor-pointer appearance-none rounded-lg border-2 border-gray-200 checked:bg-indigo-600 checked:border-indigo-600 transition-all @error('agree_terms') border-red-500 @enderror">
                            <i data-lucide="check" class="absolute w-4 h-4 text-white left-1 pointer-events-none hidden peer-checked:block"></i>
                        </div>
                        <span class="text-sm text-gray-600 leading-relaxed group-hover:text-gray-900 transition-colors">
                            <a href="#" class="text-indigo-600 font-bold hover:underline">出品者利用規約</a> および <a href="#" class="text-indigo-600 font-bold hover:underline">販売手数料（一律15%）の規定</a> に同意して、クリエイターとして活動を開始します。
                        </span>
                    </label>

                    <div class="pt-4">
                        <button type="submit" class="w-full py-5 bg-indigo-600 text-white font-bold rounded-2xl shadow-xl shadow-indigo-100 hover:bg-indigo-700 transition-all active:scale-[0.98] flex items-center justify-center space-x-3 text-lg">
                            <span>登録</span>
                            <i data-lucide="chevron-right" class="w-6 h-6"></i>
                        </button>
                        <p class="text-center text-[10px] text-gray-400 mt-6 font-bold tracking-widest uppercase">
                            Secure Registration Process Powered by DigitalVault
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-user.common>
