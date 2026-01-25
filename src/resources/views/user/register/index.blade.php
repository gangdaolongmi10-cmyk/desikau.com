<x-user.common title="Welcome">
    <main class="flex-grow flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-lg rounded-3xl shadow-xl overflow-hidden border border-gray-100">
            <div class="p-8 md:p-10">
                <!-- Logo -->
                <div class="flex justify-center mb-8">
                    <x-user.logo size="large" />
                </div>

                <div class="text-center mb-8">
                    <h1 class="text-2xl font-bold mb-2">アカウントを作成</h1>
                    <p class="text-gray-500 text-sm">クリエイターの世界へようこそ。</p>
                </div>

                <form action="#" class="space-y-6">
                    <!-- Icon Upload Section -->
                    <div class="flex flex-col items-center mb-6">
                        <div class="relative group">
                            <div id="image-preview" class="w-24 h-24 rounded-full bg-gray-100 border-2 border-dashed border-gray-300 flex items-center justify-center overflow-hidden">
                                <i data-lucide="user" class="text-gray-400 w-10 h-10"></i>
                            </div>
                            <label for="icon-upload" class="absolute bottom-0 right-0 bg-indigo-600 text-white p-2 rounded-full shadow-lg cursor-pointer hover:bg-indigo-700 transition-all">
                                <i data-lucide="camera" class="w-4 h-4"></i>
                                <input type="file" id="icon-upload" accept="image/*" class="hidden" onchange="previewImage(event)">
                            </label>
                        </div>
                        <p class="text-[11px] text-gray-400 mt-3 font-medium">プロフィール画像を選択</p>
                    </div>

                    <!-- User Name -->
                    <x-user.form.input
                        type="text"
                        name="username"
                        label="ユーザー名"
                        placeholder="クリエイター名"
                        icon="user-tag"
                        :required="true"
                    />

                    <!-- Email -->
                    <x-user.form.input
                        type="email"
                        name="email"
                        label="メールアドレス"
                        placeholder="you@example.com"
                        icon="mail"
                        :required="true"
                    />

                    <!-- Password -->
                    <x-user.form.input
                        type="password"
                        name="password"
                        label="パスワード"
                        placeholder="8文字以上の英数字"
                        icon="lock"
                        hint="※セキュリティのため、記号を含めることを推奨します。"
                        :required="true"
                    />

                    <div class="pt-2">
                        <x-user.form.button>アカウントを無料で作成</x-user.form.button>
                    </div>
                </form>

                <x-user.form.divider />

                <div class="text-center text-sm text-gray-500">
                    すでにアカウントをお持ちですか？ 
                    <a href="{{ route('user.login.index') }}" class="text-indigo-600 font-bold hover:underline">ログイン</a>
                </div>

                <p class="mt-8 text-[11px] text-center text-gray-400 leading-relaxed">
                    登録することで、当社の <a href="{{ route('user.static.index', $StaticPage::TermsOfService->value) }}" class="underline hover:text-indigo-600">利用規約</a> および <a href="{{ route('user.static.index', $StaticPage::PrivacyPolicy->value) }}" class="underline hover:text-indigo-600">プライバシーポリシー</a> に同意したものとみなされます。
                </p>
            </div>
        </div>
    </main>
    <script>
        lucide.createIcons();

        function previewImage(event) {
            const preview = document.getElementById('image-preview');
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = function() {
                preview.innerHTML = `<img src="${reader.result}" class="w-full h-full object-cover">`;
            }

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>
</x-user.common>