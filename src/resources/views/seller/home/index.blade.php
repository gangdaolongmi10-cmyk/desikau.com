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
    {{-- 最近の売上 --}}
    <div class="bg-white rounded-[32px] border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-50 flex items-center justify-between">
            <h3 class="font-bold text-lg">最近の売上</h3>
        </div>
        @if ($recentSales->isEmpty())
            <div class="p-12 text-center text-gray-400">
                <i data-lucide="receipt" class="w-10 h-10 mx-auto mb-3"></i>
                <p class="text-sm">まだ売上データがありません</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 text-[10px] uppercase font-bold text-gray-400 tracking-widest">
                        <tr>
                            <th class="px-6 py-4">アイテム</th>
                            <th class="px-6 py-4">注文番号</th>
                            <th class="px-6 py-4">数量</th>
                            <th class="px-6 py-4">日付</th>
                            <th class="px-6 py-4">金額</th>
                            <th class="px-6 py-4">ステータス</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach ($recentSales as $item)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 rounded-lg bg-gray-100 overflow-hidden flex-shrink-0">
                                            @if ($item->product?->image_url)
                                                <img src="{{ $item->product->image_url }}" alt="{{ $item->product_name }}" class="object-cover w-full h-full">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center">
                                                    <i data-lucide="package" class="w-5 h-5 text-gray-400"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <span class="text-sm font-bold truncate max-w-[200px]">{{ $item->product_name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-xs text-gray-500 font-mono">{{ $item->order?->order_number }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $item->quantity }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500 font-medium whitespace-nowrap">{{ $item->order?->paid_at?->format('Y.m.d') ?? $item->created_at->format('Y.m.d') }}</td>
                                <td class="px-6 py-4 text-sm font-bold whitespace-nowrap">¥{{ number_format($item->price * $item->quantity) }}</td>
                                <td class="px-6 py-4">
                                    @if ($item->order?->status === 'paid')
                                        <span class="text-[10px] bg-green-100 text-green-600 px-2 py-1 rounded-full font-bold">完了</span>
                                    @elseif ($item->order?->status === 'pending')
                                        <span class="text-[10px] bg-yellow-100 text-yellow-600 px-2 py-1 rounded-full font-bold">保留中</span>
                                    @elseif ($item->order?->status === 'cancelled')
                                        <span class="text-[10px] bg-gray-100 text-gray-500 px-2 py-1 rounded-full font-bold">キャンセル</span>
                                    @else
                                        <span class="text-[10px] bg-red-100 text-red-600 px-2 py-1 rounded-full font-bold">失敗</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-seller.common>
