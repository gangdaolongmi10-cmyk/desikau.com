<x-admin.common title="ダッシュボード">
    {{-- サマリーカード --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <div class="flex items-center space-x-3 mb-3">
                <div class="bg-indigo-100 p-2.5 rounded-xl">
                    <i data-lucide="banknote" class="w-5 h-5 text-indigo-600"></i>
                </div>
                <span class="text-sm text-gray-500 font-medium">本日の売上</span>
            </div>
            <p class="text-2xl font-bold">&yen;{{ number_format($todaySales) }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <div class="flex items-center space-x-3 mb-3">
                <div class="bg-green-100 p-2.5 rounded-xl">
                    <i data-lucide="shopping-cart" class="w-5 h-5 text-green-600"></i>
                </div>
                <span class="text-sm text-gray-500 font-medium">本日の注文数</span>
            </div>
            <p class="text-2xl font-bold">{{ number_format($todayOrders) }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <div class="flex items-center space-x-3 mb-3">
                <div class="bg-purple-100 p-2.5 rounded-xl">
                    <i data-lucide="users" class="w-5 h-5 text-purple-600"></i>
                </div>
                <span class="text-sm text-gray-500 font-medium">登録ユーザー数</span>
            </div>
            <p class="text-2xl font-bold">{{ number_format($totalUsers) }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <div class="flex items-center space-x-3 mb-3">
                <div class="bg-orange-100 p-2.5 rounded-xl">
                    <i data-lucide="megaphone" class="w-5 h-5 text-orange-600"></i>
                </div>
                <span class="text-sm text-gray-500 font-medium">公開中のお知らせ</span>
            </div>
            <p class="text-2xl font-bold">{{ number_format($publishedAnnouncements) }}</p>
        </div>
    </div>
</x-admin.common>
