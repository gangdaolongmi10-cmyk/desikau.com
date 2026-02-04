<x-user.common title="プロフィール">
    <div class="max-w-5xl mx-auto px-4">
        {{-- タブ切り替え --}}
        @if ($user && $seller)
            <div class="flex items-center justify-between mb-8">
                <div class="flex space-x-2">
                    <a href="{{ route('user.profile.index', ['tab' => 'user']) }}"
                       class="px-6 py-3 rounded-xl font-bold transition-all {{ $tab === 'user' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">
                        <i data-lucide="user" class="w-4 h-4 inline-block mr-2"></i>
                        ユーザー
                    </a>
                    <a href="{{ route('user.profile.index', ['tab' => 'seller']) }}"
                       class="px-6 py-3 rounded-xl font-bold transition-all {{ $tab === 'seller' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">
                        <i data-lucide="store" class="w-4 h-4 inline-block mr-2"></i>
                        出品者
                    </a>
                </div>
                @if ($tab === 'seller')
                    <a href="{{ route('seller.home.index') }}"
                       class="px-6 py-3 rounded-xl font-bold transition-all bg-emerald-600 text-white hover:bg-emerald-700 shadow-lg shadow-emerald-200">
                        <i data-lucide="layout-dashboard" class="w-4 h-4 inline-block mr-2"></i>
                        出品者ダッシュボードへ
                    </a>
                @endif
            </div>
        @elseif ($seller)
            <div class="flex justify-end mb-8">
                <a href="{{ route('seller.home.index') }}"
                   class="px-6 py-3 rounded-xl font-bold transition-all bg-emerald-600 text-white hover:bg-emerald-700 shadow-lg shadow-emerald-200">
                    <i data-lucide="layout-dashboard" class="w-4 h-4 inline-block mr-2"></i>
                    出品者ダッシュボードへ
                </a>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Overview -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8 text-center">
                    <div class="relative inline-block mb-4">
                        <div class="w-32 h-32 rounded-full bg-indigo-100 flex items-center justify-center border-4 border-white shadow-lg mx-auto overflow-hidden">
                            @if ($tab === 'seller' && $seller)
                                <i data-lucide="store" class="w-12 h-12 text-indigo-600"></i>
                            @else
                                @if ($user?->icon_url)
                                    <img src="{{ $user->icon_url }}" alt="Avatar" class="w-full h-full object-cover">
                                @else
                                    <i data-lucide="user" class="w-12 h-12 text-indigo-600"></i>
                                @endif
                            @endif
                        </div>
                    </div>

                    @if ($tab === 'seller' && $seller)
                        <h2 class="text-xl font-bold text-gray-900">{{ $seller->shop_name }}</h2>
                        <p class="text-sm text-gray-500 mb-2">{{ $seller->email }}</p>
                        <span class="inline-block bg-indigo-50 text-indigo-600 text-xs font-bold px-3 py-1 rounded-full">{{ $seller->main_category }}</span>
                    @elseif ($user)
                        <h2 class="text-xl font-bold text-gray-900">{{ $user->name }}</h2>
                        <p class="text-sm text-gray-500">{{ $user->email }}</p>
                    @endif
                </div>

                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
                    <nav class="flex flex-col">
                        <a href="#" class="px-6 py-4 flex items-center space-x-3 bg-indigo-50 text-indigo-600 font-bold border-r-4 border-indigo-600">
                            <i data-lucide="settings" class="w-5 h-5"></i>
                            <span>プロフィール編集</span>
                        </a>
                        @if ($user)
                            <form action="{{ route('user.login.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full px-6 py-4 flex items-center space-x-3 text-red-500 hover:bg-red-50 transition-colors">
                                    <i data-lucide="log-out" class="w-5 h-5"></i>
                                    <span>ログアウト</span>
                                </button>
                            </form>
                        @endif
                    </nav>
                </div>
            </div>

            <!-- Right Column -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8">
                    @if ($tab === 'seller' && $seller)
                        {{-- 出品者プロフィール --}}
                        <div class="flex items-center justify-between mb-8 border-b border-gray-50 pb-6">
                            <h3 class="text-xl font-bold">ショップ情報</h3>
                            <button class="bg-indigo-600 text-white text-sm font-bold px-6 py-2.5 rounded-xl hover:bg-indigo-700 transition-all shadow-md shadow-indigo-100">
                                変更を保存
                            </button>
                        </div>

                        <form class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-sm font-bold text-gray-700">ショップ名</label>
                                    <input type="text" value="{{ $seller->shop_name }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 focus:bg-white focus:border-indigo-600 outline-none transition-all">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-bold text-gray-700">主なカテゴリー</label>
                                    <select class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 focus:bg-white focus:border-indigo-600 outline-none transition-all">
                                        <option value="3d" {{ $seller->main_category === '3d' ? 'selected' : '' }}>3Dモデル</option>
                                        <option value="ui" {{ $seller->main_category === 'ui' ? 'selected' : '' }}>UIキット</option>
                                        <option value="texture" {{ $seller->main_category === 'texture' ? 'selected' : '' }}>テクスチャ</option>
                                        <option value="font" {{ $seller->main_category === 'font' ? 'selected' : '' }}>フォント</option>
                                        <option value="other" {{ $seller->main_category === 'other' ? 'selected' : '' }}>その他</option>
                                    </select>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-bold text-gray-700">ショップ紹介</label>
                                <textarea rows="4" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 focus:bg-white focus:border-indigo-600 outline-none transition-all resize-none">{{ $seller->description }}</textarea>
                            </div>

                            <div class="border-t border-gray-100 pt-6">
                                <h4 class="text-sm font-bold text-gray-700 mb-4">SNS・外部リンク</h4>
                                <div class="space-y-4">
                                    <div class="relative">
                                        <i data-lucide="twitter" class="w-5 h-5 text-gray-400 absolute left-4 top-3.5"></i>
                                        <input type="text" value="{{ $seller->twitter_username }}" placeholder="X (Twitter)" class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-12 pr-4 py-3 focus:bg-white focus:border-indigo-600 outline-none transition-all">
                                    </div>
                                    <div class="relative">
                                        <i data-lucide="youtube" class="w-5 h-5 text-gray-400 absolute left-4 top-3.5"></i>
                                        <input type="url" value="{{ $seller->youtube_url }}" placeholder="YouTube URL" class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-12 pr-4 py-3 focus:bg-white focus:border-indigo-600 outline-none transition-all">
                                    </div>
                                    <div class="relative">
                                        <i data-lucide="twitch" class="w-5 h-5 text-gray-400 absolute left-4 top-3.5"></i>
                                        <input type="text" value="{{ $seller->twitch_username }}" placeholder="Twitch" class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-12 pr-4 py-3 focus:bg-white focus:border-indigo-600 outline-none transition-all">
                                    </div>
                                </div>
                            </div>
                        </form>
                    @elseif ($user)
                        {{-- 成功メッセージ --}}
                        @if (session('success'))
                            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl">
                                {{ session('success') }}
                            </div>
                        @endif

                        {{-- ユーザープロフィール --}}
                        <div class="flex items-center justify-between mb-8 border-b border-gray-50 pb-6">
                            <h3 class="text-xl font-bold">基本情報</h3>
                            <button class="bg-indigo-600 text-white text-sm font-bold px-6 py-2.5 rounded-xl hover:bg-indigo-700 transition-all shadow-md shadow-indigo-100">
                                変更を保存
                            </button>
                        </div>

                        <form class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-sm font-bold text-gray-700">表示名</label>
                                    <input type="text" value="{{ $user->name }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 focus:bg-white focus:border-indigo-600 outline-none transition-all">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-bold text-gray-700">メールアドレス</label>
                                    <input type="email" value="{{ $user->email }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 focus:bg-white focus:border-indigo-600 outline-none transition-all">
                                </div>
                            </div>
                        </form>

                        {{-- パスワード変更 --}}
                        <div class="mt-10 pt-8 border-t border-gray-100">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-xl font-bold">パスワード変更</h3>
                            </div>

                            <form action="{{ route('user.profile.changePassword') }}" method="POST" class="space-y-6">
                                @csrf

                                <div class="space-y-2">
                                    <label for="current_password" class="text-sm font-bold text-gray-700">現在のパスワード</label>
                                    <div x-data="{ show: false }" class="relative">
                                        <input :type="show ? 'text' : 'password'" id="current_password" name="current_password"
                                               class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 pr-12 focus:bg-white focus:border-indigo-600 outline-none transition-all @error('current_password') border-red-500 @enderror"
                                               placeholder="現在のパスワードを入力">
                                        <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-gray-600">
                                            <i x-show="!show" data-lucide="eye" class="w-5 h-5"></i>
                                            <i x-show="show" x-cloak data-lucide="eye-off" class="w-5 h-5"></i>
                                        </button>
                                    </div>
                                    @error('current_password')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-2">
                                        <label for="new_password" class="text-sm font-bold text-gray-700">新しいパスワード</label>
                                        <div x-data="{ show: false }" class="relative">
                                            <input :type="show ? 'text' : 'password'" id="new_password" name="new_password"
                                                   class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 pr-12 focus:bg-white focus:border-indigo-600 outline-none transition-all @error('new_password') border-red-500 @enderror"
                                                   placeholder="8〜25文字の英数字">
                                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-gray-600">
                                                <i x-show="!show" data-lucide="eye" class="w-5 h-5"></i>
                                                <i x-show="show" x-cloak data-lucide="eye-off" class="w-5 h-5"></i>
                                            </button>
                                        </div>
                                        @error('new_password')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="space-y-2">
                                        <label for="new_password_confirmation" class="text-sm font-bold text-gray-700">新しいパスワード（確認）</label>
                                        <div x-data="{ show: false }" class="relative">
                                            <input :type="show ? 'text' : 'password'" id="new_password_confirmation" name="new_password_confirmation"
                                                   class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 pr-12 focus:bg-white focus:border-indigo-600 outline-none transition-all"
                                                   placeholder="もう一度入力">
                                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-gray-600">
                                                <i x-show="!show" data-lucide="eye" class="w-5 h-5"></i>
                                                <i x-show="show" x-cloak data-lucide="eye-off" class="w-5 h-5"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex justify-end">
                                    <button type="submit"
                                            class="bg-indigo-600 text-white text-sm font-bold px-6 py-2.5 rounded-xl hover:bg-indigo-700 transition-all shadow-md shadow-indigo-100">
                                        パスワードを変更
                                    </button>
                                </div>
                            </form>
                        </div>

                        {{-- アカウント削除 --}}
                        <div x-data="{ showDeleteModal: false }" class="mt-10 pt-8 border-t border-gray-100">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-xl font-bold text-red-600">アカウント削除</h3>
                            </div>

                            <div class="bg-red-50 border border-red-200 rounded-xl p-6">
                                <div class="flex items-start space-x-4">
                                    <div class="flex-shrink-0">
                                        <i data-lucide="alert-triangle" class="w-6 h-6 text-red-500"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-sm font-bold text-red-800 mb-2">この操作は取り消せません</h4>
                                        <p class="text-sm text-red-700 mb-4">
                                            アカウントを削除すると、購入履歴、いいね、レビューなどのすべてのデータにアクセスできなくなります。
                                            削除後は同じメールアドレスで再登録が可能です。
                                        </p>
                                        <button type="button"
                                                @click="showDeleteModal = true"
                                                class="bg-red-600 text-white text-sm font-bold px-6 py-2.5 rounded-xl hover:bg-red-700 transition-all">
                                            アカウントを削除する
                                        </button>
                                    </div>
                                </div>
                            </div>

                            {{-- 削除確認モーダル --}}
                            <div x-show="showDeleteModal"
                                 x-cloak
                                 class="fixed inset-0 z-50 overflow-y-auto"
                                 aria-labelledby="modal-title"
                                 role="dialog"
                                 aria-modal="true">
                                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                                    {{-- 背景オーバーレイ --}}
                                    <div x-show="showDeleteModal"
                                         x-transition:enter="ease-out duration-300"
                                         x-transition:enter-start="opacity-0"
                                         x-transition:enter-end="opacity-100"
                                         x-transition:leave="ease-in duration-200"
                                         x-transition:leave-start="opacity-100"
                                         x-transition:leave-end="opacity-0"
                                         @click="showDeleteModal = false"
                                         class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

                                    {{-- モーダルコンテンツ --}}
                                    <div x-show="showDeleteModal"
                                         x-transition:enter="ease-out duration-300"
                                         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                         x-transition:leave="ease-in duration-200"
                                         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                         class="relative bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full">
                                        <form action="{{ route('user.profile.destroy') }}" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <div class="bg-white px-6 pt-6 pb-4">
                                                <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full mb-4">
                                                    <i data-lucide="trash-2" class="w-6 h-6 text-red-600"></i>
                                                </div>
                                                <h3 class="text-lg font-bold text-gray-900 text-center mb-2" id="modal-title">
                                                    アカウントを削除しますか？
                                                </h3>
                                                <p class="text-sm text-gray-500 text-center mb-6">
                                                    この操作は取り消せません。確認のためパスワードを入力してください。
                                                </p>

                                                <div x-data="{ show: false }" class="relative">
                                                    <label for="delete_password" class="block text-sm font-bold text-gray-700 mb-2">パスワード</label>
                                                    <div class="relative">
                                                        <input :type="show ? 'text' : 'password'"
                                                               id="delete_password"
                                                               name="password"
                                                               required
                                                               class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 pr-12 focus:bg-white focus:border-red-600 outline-none transition-all"
                                                               placeholder="パスワードを入力">
                                                        <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-gray-600">
                                                            <i x-show="!show" data-lucide="eye" class="w-5 h-5"></i>
                                                            <i x-show="show" x-cloak data-lucide="eye-off" class="w-5 h-5"></i>
                                                        </button>
                                                    </div>
                                                    @error('password')
                                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="bg-gray-50 px-6 py-4 flex flex-row-reverse gap-3">
                                                <button type="submit"
                                                        class="bg-red-600 text-white text-sm font-bold px-6 py-2.5 rounded-xl hover:bg-red-700 transition-all">
                                                    削除する
                                                </button>
                                                <button type="button"
                                                        @click="showDeleteModal = false"
                                                        class="bg-white text-gray-700 text-sm font-bold px-6 py-2.5 rounded-xl border border-gray-300 hover:bg-gray-50 transition-all">
                                                    キャンセル
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <i data-lucide="user-x" class="w-16 h-16 text-gray-300 mx-auto mb-4"></i>
                            <p class="text-gray-500">ログインしてください</p>
                            <a href="{{ route('user.login.index') }}" class="inline-block mt-4 bg-indigo-600 text-white font-bold px-6 py-3 rounded-xl hover:bg-indigo-700 transition-all">
                                ログイン
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-user.common>
