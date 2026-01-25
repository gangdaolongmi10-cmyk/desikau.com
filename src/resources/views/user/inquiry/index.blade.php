<x-user.common title="Welcome">
    <div class="max-w-2xl mx-auto">
        <x-user.page-title
            title="お問い合わせ"
            description="サービスに関するご質問やご要望がございましたら、以下のフォームよりお気軽にご連絡ください。"
        />

        <!-- Contact Form Card -->
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 md:p-10">
            <form id="contact-form" onsubmit="handleContactSubmit(event)" class="space-y-6">
                <x-user.form.input
                    type="text"
                    name="name"
                    label="お名前"
                    placeholder="山田 太郎"
                    :required="true"
                />

                <x-user.form.input
                    type="email"
                    name="email"
                    label="メールアドレス"
                    placeholder="you@example.com"
                    :required="true"
                />

                <x-user.form.textarea
                    name="message"
                    label="お問い合わせ内容"
                    placeholder="こちらにご記入ください..."
                    :required="true"
                />

                <!-- Privacy Policy Check -->
                <div class="flex items-start ml-1">
                    <input type="checkbox" id="agree" required class="mt-1 w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 cursor-pointer">
                    <label for="agree" class="ml-2 text-sm text-gray-600 leading-relaxed cursor-pointer">
                        <a href="{{ route('user.static.index', $StaticPage::PrivacyPolicy->value) }}" class="text-indigo-600 font-semibold hover:underline">プライバシーポリシー</a> に同意の上、送信してください。
                    </label>
                </div>

                <!-- Submit Button -->
                <x-user.form.button id="submit-btn" icon="send">メッセージを送信する</x-user.form.button>
            </form>

            <!-- Success Message (Hidden by default) -->
            <div id="success-msg" class="hidden text-center py-10">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 text-green-600 rounded-full mb-6">
                    <i data-lucide="check-circle" class="w-10 h-10"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">送信が完了しました</h2>
                <p class="text-gray-500 mb-8">お問い合わせありがとうございます。内容を確認次第、担当者よりメールにてご連絡いたします。</p>
                <a href="index.html" class="inline-flex items-center justify-center px-8 py-3 bg-gray-900 text-white font-bold rounded-2xl hover:bg-indigo-600 transition-all">
                    ストアに戻る
                </a>
            </div>
        </div>
    </div>
</x-user.common>