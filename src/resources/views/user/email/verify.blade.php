<x-user.common title="メールアドレスの認証">
    <main class="flex-grow flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-md rounded-3xl shadow-xl overflow-hidden border border-gray-100">
            <div class="p-8 md:p-10">
                <!-- Logo -->
                <div class="flex justify-center mb-8">
                    <x-user.logo size="large" />
                </div>

                <!-- アイコン -->
                <div class="flex justify-center mb-6">
                    <div class="w-20 h-20 bg-indigo-100 rounded-full flex items-center justify-center">
                        <i data-lucide="mail-check" class="w-10 h-10 text-indigo-600"></i>
                    </div>
                </div>

                <div class="text-center mb-8">
                    <h1 class="text-2xl font-bold mb-2">メールアドレスを確認してください</h1>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        ご登録いただいたメールアドレスに認証リンクを送信しました。<br>
                        メール内のリンクをクリックして、アカウントを有効化してください。
                    </p>
                </div>

                {{-- 成功メッセージ --}}
                @if (session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-2xl text-sm mb-6">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                {{-- エラーメッセージ --}}
                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-2xl text-sm mb-6">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <div class="space-y-4">
                    <!-- 再送信フォーム -->
                    <form action="{{ route('verification.send') }}" method="POST">
                        @csrf
                        <x-user.form.button type="submit">
                            <i data-lucide="refresh-cw" class="w-4 h-4 mr-2 inline-block"></i>
                            認証メールを再送信
                        </x-user.form.button>
                    </form>

                    <!-- ログアウトリンク -->
                    <form action="{{ route('user.login.logout') }}" method="POST" class="text-center">
                        @csrf
                        <button type="submit" class="text-sm text-gray-500 hover:text-indigo-600 hover:underline transition-colors">
                            別のアカウントでログイン
                        </button>
                    </form>
                </div>

                <div class="mt-8 p-4 bg-gray-50 rounded-2xl">
                    <p class="text-xs text-gray-500 text-center leading-relaxed">
                        <i data-lucide="info" class="w-4 h-4 inline-block mr-1 align-middle"></i>
                        メールが届かない場合は、迷惑メールフォルダをご確認ください。<br>
                        数分経っても届かない場合は、再送信をお試しください。
                    </p>
                </div>
            </div>
        </div>
    </main>

    <script>
        lucide.createIcons();
    </script>
</x-user.common>
