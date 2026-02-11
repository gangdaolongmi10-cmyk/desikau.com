@use('App\Enums\Role')

<x-user.common title="Welcome">
    <main class="flex-grow flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-md rounded-3xl shadow-xl overflow-hidden border border-gray-100">
            <div class="p-8 md:p-10">
                <!-- Logo -->
                <div class="flex justify-center mb-10">
                    <x-user.logo size="large" />
                </div>

                <!-- ログインタイプ切り替えタブ -->
                <div class="flex mb-8 bg-gray-100 rounded-2xl p-1" id="login-tabs">
                    <button type="button" data-login-type="{{ Role::USER->value }}" class="flex-1 py-3 px-4 rounded-xl text-sm font-semibold transition-all bg-white text-indigo-600 shadow-sm">
                        <i data-lucide="user" class="w-4 h-4 inline-block mr-1"></i>
                        {{ Role::USER->label() }}
                    </button>
                    <button type="button" data-login-type="{{ Role::SELLER->value }}" class="flex-1 py-3 px-4 rounded-xl text-sm font-semibold transition-all text-gray-500 hover:text-gray-700">
                        <i data-lucide="store" class="w-4 h-4 inline-block mr-1"></i>
                        {{ Role::SELLER->label() }}
                    </button>
                </div>

                <div class="text-center mb-8">
                    <h1 class="text-2xl font-bold mb-2" id="login-title">おかえりなさい！</h1>
                    <p class="text-gray-500 text-sm" id="login-description">ログインして、あなたのデジタル資産にアクセスしましょう。</p>
                </div>

                <form action="{{ route('user.login.login') }}" method="POST" class="space-y-5">
                    @csrf
                    <input type="hidden" name="login_type" id="login-type-input" value="{{ old('login_type', Role::USER->value) }}">

                    {{-- フラッシュメッセージ --}}
                    @if (session('warning'))
                        <div class="bg-amber-50 border border-amber-200 text-amber-700 px-4 py-3 rounded-2xl text-sm flex items-center gap-2">
                            <i data-lucide="alert-triangle" class="w-4 h-4 flex-shrink-0"></i>
                            <p>{{ session('warning') }}</p>
                        </div>
                    @endif

                    {{-- エラーメッセージ --}}
                    @if ($errors->any())
                        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-2xl text-sm">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <x-user.form.input
                        type="email"
                        name="email"
                        label="メールアドレス"
                        placeholder="you@example.com"
                        :value="old('email')"
                    />
                    <div>
                        <div class="flex justify-between items-center mb-1.5 ml-1">
                            <label class="block text-sm font-semibold text-gray-700">パスワード</label>
                            <a href="#" class="text-xs text-indigo-600 font-medium hover:underline">忘れた場合</a>
                        </div>
                        <div class="relative" data-password-container>
                            <input type="password" id="password-input" name="password" placeholder="••••••••" data-password-input class="w-full px-4 py-3.5 rounded-2xl bg-gray-50 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none pr-12">
                            <button type="button" data-password-toggle class="absolute right-4 top-3.5 text-gray-400 hover:text-gray-600">
                                <i data-lucide="eye" data-password-icon-show class="w-5 h-5"></i>
                                <i data-lucide="eye-off" data-password-icon-hide class="w-5 h-5 hidden"></i>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center ml-1">
                        <input type="checkbox" id="remember" name="remember" value="1" {{ old('remember') ? 'checked' : '' }} class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                        <label for="remember" class="ml-2 text-sm text-gray-600">ログイン状態を保持する</label>
                    </div>

                    <x-user.form.button>ログイン</x-user.form.button>
                </form>

                <x-user.form.divider />

                <div class="grid grid-cols-2 gap-4">
                    <button class="flex items-center justify-center space-x-2 px-4 py-3 rounded-2xl border border-gray-200 hover:bg-gray-50 transition-all font-medium text-sm">
                        <img src="https://www.google.com/favicon.ico" class="w-4 h-4" alt="Google">
                        <span>Google</span>
                    </button>
                </div>
                <p class="mt-10 text-center text-sm text-gray-500" id="register-link">
                    アカウントをお持ちでないですか？
                    <a href="{{ route('user.register.index') }}" class="text-indigo-600 font-bold hover:underline">新規登録</a>
                </p>
                <p class="mt-10 text-center text-sm text-gray-500 hidden" id="seller-register-link">
                    出品者アカウントをお持ちでないですか？
                    <a href="{{ route('user.seller.register.index') }}" class="text-indigo-600 font-bold hover:underline">出品者登録</a>
                </p>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Role Enumの値をPHPから取得
            const ROLE_USER = '{{ Role::USER->value }}';
            const ROLE_SELLER = '{{ Role::SELLER->value }}';

            const tabs = document.querySelectorAll('#login-tabs button');
            const loginTypeInput = document.getElementById('login-type-input');
            const loginTitle = document.getElementById('login-title');
            const loginDescription = document.getElementById('login-description');
            const registerLink = document.getElementById('register-link');
            const sellerRegisterLink = document.getElementById('seller-register-link');

            const contents = {};
            contents[ROLE_USER] = {
                title: 'おかえりなさい！',
                description: 'ログインして、あなたのデジタル資産にアクセスしましょう。'
            };
            contents[ROLE_SELLER] = {
                title: '出品者ログイン',
                description: 'ショップを管理して、売上を確認しましょう。'
            };

            function setActiveTab(type) {
                tabs.forEach(tab => {
                    const tabType = tab.dataset.loginType;
                    if (tabType === type) {
                        tab.classList.add('bg-white', 'text-indigo-600', 'shadow-sm');
                        tab.classList.remove('text-gray-500', 'hover:text-gray-700');
                    } else {
                        tab.classList.remove('bg-white', 'text-indigo-600', 'shadow-sm');
                        tab.classList.add('text-gray-500', 'hover:text-gray-700');
                    }
                });

                loginTypeInput.value = type;
                loginTitle.textContent = contents[type].title;
                loginDescription.textContent = contents[type].description;

                // 登録リンクの切り替え
                if (type === ROLE_SELLER) {
                    registerLink.classList.add('hidden');
                    sellerRegisterLink.classList.remove('hidden');
                } else {
                    registerLink.classList.remove('hidden');
                    sellerRegisterLink.classList.add('hidden');
                }
            }

            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    setActiveTab(this.dataset.loginType);
                });
            });

            // 初期表示（old値がある場合はそのタブをアクティブに）
            const initialType = loginTypeInput.value || ROLE_USER;
            setActiveTab(initialType);
        });
    </script>
</x-user.common>
