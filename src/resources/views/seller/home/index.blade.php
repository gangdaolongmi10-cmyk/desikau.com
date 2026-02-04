<x-seller.common title="ダッシュボード">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <x-seller.stat-card
            icon="banknote"
            icon-bg="indigo"
            label="今月の売上"
            :value="'¥' . number_format($monthlySales)"
            :change="$salesChange !== null ? ($salesChange >= 0 ? '+' : '') . $salesChange . '%' : '-'"
            :change-type="$salesChange === null ? 'stable' : ($salesChange >= 0 ? 'up' : 'down')"
        />
        <x-seller.stat-card
            icon="shopping-cart"
            icon-bg="purple"
            label="注文数"
            :value="(string) $orderCount"
            :change="$orderChange !== null ? ($orderChange >= 0 ? '+' : '') . $orderChange . '%' : '-'"
            :change-type="$orderChange === null ? 'stable' : ($orderChange >= 0 ? 'up' : 'down')"
        />
        <x-seller.stat-card
            icon="star"
            icon-bg="orange"
            label="平均評価"
            :value="$averageRating ? $averageRating . ' / 5.0' : '- / 5.0'"
            :change="$reviewCount . '件のレビュー'"
            change-type="stable"
        />
    </div>
    <div class="lg:col-span-2 bg-white rounded-[32px] border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-50 flex items-center justify-between">
            <h3 class="font-bold text-lg">最近の売上</h3>
            <a href="#" class="text-xs font-bold text-indigo-600 hover:underline">すべて見る</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-[10px] uppercase font-bold text-gray-400 tracking-widest">
                    <tr>
                        <th class="px-6 py-4">アイテム</th>
                        <th class="px-6 py-4">日付</th>
                        <th class="px-6 py-4">金額</th>
                        <th class="px-6 py-4">ステータス</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-lg bg-gray-100 overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1620641788421-7a1c342ea42e?q=80&w=100" class="object-cover w-full h-full">
                            </div>
                            <span class="text-sm font-bold">Abstract Flow 3D</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 font-medium">2024.05.21</td>
                        <td class="px-6 py-4 text-sm font-bold">¥2,480</td>
                        <td class="px-6 py-4">
                            <span class="text-[10px] bg-green-100 text-green-600 px-2 py-1 rounded-full font-bold">完了</span>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-lg bg-gray-100 overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1587620962725-abab7fe55159?q=80&w=100" class="object-cover w-full h-full">
                            </div>
                            <span class="text-sm font-bold">DarkMagic Engine</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 font-medium">2024.05.20</td>
                        <td class="px-6 py-4 text-sm font-bold">¥4,900</td>
                        <td class="px-6 py-4">
                            <span class="text-[10px] bg-green-100 text-green-600 px-2 py-1 rounded-full font-bold">完了</span>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-lg bg-gray-100 overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1543002588-bfa74002ed7e?q=80&w=100" class="object-cover w-full h-full">
                            </div>
                            <span class="text-sm font-bold">Modern UI Guide</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 font-medium">2024.05.20</td>
                        <td class="px-6 py-4 text-sm font-bold">¥1,800</td>
                        <td class="px-6 py-4">
                            <span class="text-[10px] bg-yellow-100 text-yellow-600 px-2 py-1 rounded-full font-bold">保留中</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-seller.common>
