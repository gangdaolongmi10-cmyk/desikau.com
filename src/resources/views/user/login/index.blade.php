<x-user.common title="Welcome">
    <main class="flex-grow flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-md rounded-3xl shadow-xl overflow-hidden border border-gray-100">
            <div class="p-8 md:p-10">
                <!-- Logo -->
                <div class="flex justify-center mb-10">
                    <x-user.logo size="large" />
                </div>

                <div class="text-center mb-8">
                    <h1 class="text-2xl font-bold mb-2">おかえりなさい！</h1>
                    <p class="text-gray-500 text-sm">ログインして、あなたのデジタル資産にアクセスしましょう。</p>
                </div>

                <form action="{{ route('user.login.login') }}" method="POST" class="space-y-5">
                    @csrf

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
                        <div class="relative">
                            <input type="password" id="password-input" name="password" placeholder="••••••••" class="w-full px-4 py-3.5 rounded-2xl bg-gray-50 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none">
                            <button type="button" class="absolute right-4 top-3.5 text-gray-400 hover:text-gray-600">
                                <i data-lucide="eye" class="w-5 h-5"></i>
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
                    <button class="flex items-center justify-center space-x-2 px-4 py-3 rounded-2xl border border-gray-200 hover:bg-gray-50 transition-all font-medium text-sm">
                        <i data-lucide="github" class="w-4 h-4 text-gray-900"></i>
                        <span>GitHub</span>
                    </button>
                </div>

                <p class="mt-10 text-center text-sm text-gray-500">
                    アカウントをお持ちでないですか？ 
                    <a href="{{ route('user.register.index') }}" class="text-indigo-600 font-bold hover:underline">新規登録</a>
                </p>
            </div>
        </div>
    </main>
</x-user.common>