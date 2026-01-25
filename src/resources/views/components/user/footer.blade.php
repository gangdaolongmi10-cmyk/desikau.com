<footer class="bg-white border-t border-gray-200 pt-16 pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-8 mb-12">
            <div class="col-span-2">
                <div class="mb-6">
                    <x-user.logo size="small" />
                </div>
                <p class="text-gray-500 text-sm mb-6 max-w-xs">
                    最高品質のデジタルアセットを提供し、クリエイターの夢を形にする手助けをします。
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-indigo-600 transition-colors"><i data-lucide="twitter" class="w-5 h-5"></i></a>
                    <a href="#" class="text-gray-400 hover:text-indigo-600 transition-colors"><i data-lucide="instagram" class="w-5 h-5"></i></a>
                    <a href="#" class="text-gray-400 hover:text-indigo-600 transition-colors"><i data-lucide="github" class="w-5 h-5"></i></a>
                </div>
            </div>
            <div>
                <h5 class="font-bold mb-4">ストア</h5>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li><a href="#" class="hover:text-indigo-600 transition-colors">新着コンテンツ</a></li>
                    <li><a href="#" class="hover:text-indigo-600 transition-colors">ベストセラー</a></li>
                    <li><a href="#" class="hover:text-indigo-600 transition-colors">無料アセット</a></li>
                    <li><a href="#" class="hover:text-indigo-600 transition-colors">セール中</a></li>
                </ul>
            </div>
            <div>
                <h5 class="font-bold mb-4">サポート</h5>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li><a href="{{ route('user.inquiry.index') }}" class="hover:text-indigo-600 transition-colors">お問い合わせ</a></li>
                </ul>
            </div>
            <div>
                <h5 class="font-bold mb-4">サイト情報</h5>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li><a href="{{ route('user.static.index', $StaticPage::PrivacyPolicy->value) }}" class="hover:text-indigo-600 transition-colors">プライバシー</a></li>
                    <li><a href="{{ route('user.static.index', $StaticPage::TermsOfService->value) }}" class="hover:text-indigo-600 transition-colors">利用規約</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-100 pt-8 flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0 text-xs text-gray-400">
            <p>&copy; 2024 {{ config('app.name') }} Inc. All rights reserved.</p>
            <div class="flex space-x-6">
                <span>特定商取引法に基づく表記</span>
                <span>サイトマップ</span>
            </div>
        </div>
    </div>
</footer>