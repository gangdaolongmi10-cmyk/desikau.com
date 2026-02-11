<x-seller.common title="売上・精算管理">
    {{-- サマリーカード --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <x-seller.stat-card
            icon="banknote"
            icon-bg="indigo"
            label="総売上"
            :value="'¥' . number_format($totalSales)"
        />
        <x-seller.stat-card
            icon="trending-up"
            icon-bg="green"
            label="今月の売上"
            :value="'¥' . number_format($monthlySales)"
            :change="$salesChange !== null ? ($salesChange >= 0 ? '+' : '') . $salesChange . '%' : '-'"
            :change-type="$salesChange === null ? 'stable' : ($salesChange >= 0 ? 'up' : 'down')"
        />
        <x-seller.stat-card
            icon="shopping-cart"
            icon-bg="purple"
            label="今月の売上件数"
            :value="(string) $orderCount"
            :change="$orderChange !== null ? ($orderChange >= 0 ? '+' : '') . $orderChange . '%' : '-'"
            :change-type="$orderChange === null ? 'stable' : ($orderChange >= 0 ? 'up' : 'down')"
        />
    </div>

    {{-- フィルター --}}
    <div class="bg-white rounded-[24px] border border-gray-100 shadow-sm p-4">
        <div class="flex items-center flex-wrap gap-2">
            <span class="text-sm text-gray-500 font-medium mr-2">期間:</span>
            @php
                $periods = [
                    'current_month' => '今月',
                    'last_month' => '先月',
                    'last_3_months' => '過去3ヶ月',
                    'all' => '全期間',
                ];
            @endphp
            @foreach ($periods as $key => $label)
                <a href="{{ route('seller.sales.index', ['period' => $key]) }}" class="px-4 py-2 rounded-full text-sm font-bold transition-all {{ $currentPeriod === $key ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    {{ $label }}
                </a>
            @endforeach
            {{-- カスタム期間ボタン --}}
            <button type="button" id="custom-period-btn" class="px-4 py-2 rounded-full text-sm font-bold transition-all flex items-center space-x-1.5 {{ $currentPeriod === 'custom' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                <i data-lucide="calendar" class="w-4 h-4"></i>
                <span>
                    @if ($currentPeriod === 'custom' && $startDate && $endDate)
                        {{ \Carbon\Carbon::parse($startDate)->format('Y/m/d') }} 〜 {{ \Carbon\Carbon::parse($endDate)->format('Y/m/d') }}
                    @else
                        期間を指定
                    @endif
                </span>
            </button>
        </div>

        {{-- カレンダーパネル --}}
        <div id="calendar-panel" class="mt-4 {{ $currentPeriod === 'custom' ? '' : 'hidden' }}">
            <div class="border border-gray-200 rounded-2xl p-4">
                <div class="flex flex-col lg:flex-row gap-6">
                    {{-- 開始日カレンダー --}}
                    <div class="flex-1">
                        <p class="text-xs font-bold text-gray-500 mb-2">開始日</p>
                        <div id="cal-start" data-selected="{{ $startDate ?? '' }}"></div>
                    </div>
                    {{-- 終了日カレンダー --}}
                    <div class="flex-1">
                        <p class="text-xs font-bold text-gray-500 mb-2">終了日</p>
                        <div id="cal-end" data-selected="{{ $endDate ?? '' }}"></div>
                    </div>
                </div>
                {{-- 選択状態と適用ボタン --}}
                <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-100">
                    <p class="text-sm text-gray-500">
                        <span id="selected-range-text">日付を選択してください</span>
                    </p>
                    <button type="button" id="apply-period-btn" disabled class="px-5 py-2 bg-indigo-600 text-white rounded-xl text-sm font-bold hover:bg-indigo-700 transition-all disabled:opacity-40 disabled:cursor-not-allowed">
                        適用
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- 売上テーブル --}}
    <div class="bg-white rounded-[32px] border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-50 flex items-center justify-between">
            <h3 class="font-bold text-lg">売上一覧</h3>
            <span class="text-sm text-gray-400">{{ $sales->total() }}件</span>
        </div>
        @if ($sales->isEmpty())
            <div class="p-12 text-center text-gray-400">
                <i data-lucide="receipt" class="w-10 h-10 mx-auto mb-3"></i>
                <p class="text-sm">この期間の売上データはありません</p>
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
                        @foreach ($sales as $item)
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
            {{-- ページネーション --}}
            @if ($sales->hasPages())
                <div class="p-6 border-t border-gray-50">
                    {{ $sales->links() }}
                </div>
            @endif
        @endif
    </div>

    {{-- カレンダーJS --}}
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const baseUrl = '{{ route('seller.sales.index') }}';
        const panel = document.getElementById('calendar-panel');
        const btn = document.getElementById('custom-period-btn');
        const applyBtn = document.getElementById('apply-period-btn');
        const rangeText = document.getElementById('selected-range-text');

        let selectedStart = document.getElementById('cal-start').dataset.selected || null;
        let selectedEnd = document.getElementById('cal-end').dataset.selected || null;

        /** カレンダーパネルの開閉 */
        btn.addEventListener('click', function () {
            panel.classList.toggle('hidden');
            // パネルを開いた時にアイコンを再描画
            if (!panel.classList.contains('hidden')) {
                lucide.createIcons();
            }
        });

        /** カレンダーを描画 */
        function renderCalendar(containerId, year, month, type) {
            const container = document.getElementById(containerId);
            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            const startDow = firstDay.getDay();
            const daysInMonth = lastDay.getDate();
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            const monthNames = ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'];
            const dayNames = ['日', '月', '火', '水', '木', '金', '土'];

            let html = '';
            // ヘッダー（前月・次月ナビ）
            html += '<div class="flex items-center justify-between mb-3">';
            html += '<button type="button" data-action="prev" class="p-1.5 rounded-lg hover:bg-gray-100 transition-all"><i data-lucide="chevron-left" class="w-4 h-4 text-gray-500"></i></button>';
            html += '<span class="text-sm font-bold text-gray-700">' + year + '年 ' + monthNames[month] + '</span>';
            html += '<button type="button" data-action="next" class="p-1.5 rounded-lg hover:bg-gray-100 transition-all"><i data-lucide="chevron-right" class="w-4 h-4 text-gray-500"></i></button>';
            html += '</div>';

            // 曜日ヘッダー
            html += '<div class="grid grid-cols-7 mb-1">';
            dayNames.forEach(function (d, i) {
                let color = i === 0 ? 'text-red-400' : (i === 6 ? 'text-blue-400' : 'text-gray-400');
                html += '<div class="text-center text-[10px] font-bold ' + color + ' py-1">' + d + '</div>';
            });
            html += '</div>';

            // 日付グリッド
            html += '<div class="grid grid-cols-7 gap-0.5">';

            // 前月の空セル
            for (let i = 0; i < startDow; i++) {
                html += '<div></div>';
            }

            const selected = type === 'start' ? selectedStart : selectedEnd;

            for (let d = 1; d <= daysInMonth; d++) {
                const dateStr = year + '-' + String(month + 1).padStart(2, '0') + '-' + String(d).padStart(2, '0');
                const dateObj = new Date(year, month, d);
                const isToday = dateObj.getTime() === today.getTime();
                const isSelected = dateStr === selected;

                // 範囲内ハイライト
                let inRange = false;
                if (selectedStart && selectedEnd) {
                    const s = new Date(selectedStart);
                    const e = new Date(selectedEnd);
                    inRange = dateObj >= s && dateObj <= e;
                }

                let classes = 'w-full aspect-square flex items-center justify-center text-sm rounded-lg cursor-pointer transition-all ';
                if (isSelected) {
                    classes += 'bg-indigo-600 text-white font-bold';
                } else if (inRange) {
                    classes += 'bg-indigo-50 text-indigo-700 font-medium hover:bg-indigo-100';
                } else if (isToday) {
                    classes += 'bg-gray-100 text-gray-900 font-bold hover:bg-gray-200';
                } else {
                    classes += 'text-gray-700 hover:bg-gray-100';
                }

                html += '<button type="button" data-date="' + dateStr + '" class="' + classes + '">' + d + '</button>';
            }

            html += '</div>';

            container.innerHTML = html;

            // イベント: 前月・次月
            container.querySelector('[data-action="prev"]').addEventListener('click', function () {
                let newMonth = month - 1;
                let newYear = year;
                if (newMonth < 0) { newMonth = 11; newYear--; }
                renderCalendar(containerId, newYear, newMonth, type);
            });
            container.querySelector('[data-action="next"]').addEventListener('click', function () {
                let newMonth = month + 1;
                let newYear = year;
                if (newMonth > 11) { newMonth = 0; newYear++; }
                renderCalendar(containerId, newYear, newMonth, type);
            });

            // イベント: 日付クリック
            container.querySelectorAll('[data-date]').forEach(function (el) {
                el.addEventListener('click', function () {
                    if (type === 'start') {
                        selectedStart = el.dataset.date;
                        // 開始日が終了日より後なら終了日をリセット
                        if (selectedEnd && selectedStart > selectedEnd) {
                            selectedEnd = null;
                        }
                    } else {
                        selectedEnd = el.dataset.date;
                        // 終了日が開始日より前なら開始日をリセット
                        if (selectedStart && selectedEnd < selectedStart) {
                            selectedStart = null;
                        }
                    }
                    updateUI();
                });
            });

            lucide.createIcons();
        }

        /** UIの状態を更新 */
        function updateUI() {
            // 両カレンダーを再描画して選択状態を反映
            const startCal = document.getElementById('cal-start');
            const endCal = document.getElementById('cal-end');

            // 現在表示中の年月を保持して再描画
            const startHeader = startCal.querySelector('.text-sm.font-bold');
            const endHeader = endCal.querySelector('.text-sm.font-bold');

            let sy, sm, ey, em;
            if (startHeader) {
                const m = startHeader.textContent.match(/(\d+)年\s*(\d+)月/);
                if (m) { sy = parseInt(m[1]); sm = parseInt(m[2]) - 1; }
            }
            if (endHeader) {
                const m = endHeader.textContent.match(/(\d+)年\s*(\d+)月/);
                if (m) { ey = parseInt(m[1]); em = parseInt(m[2]) - 1; }
            }

            if (sy !== undefined) renderCalendar('cal-start', sy, sm, 'start');
            if (ey !== undefined) renderCalendar('cal-end', ey, em, 'end');

            // テキストと適用ボタン
            if (selectedStart && selectedEnd) {
                rangeText.textContent = selectedStart.replace(/-/g, '/') + ' 〜 ' + selectedEnd.replace(/-/g, '/');
                applyBtn.disabled = false;
            } else if (selectedStart) {
                rangeText.textContent = selectedStart.replace(/-/g, '/') + ' 〜 （終了日を選択）';
                applyBtn.disabled = true;
            } else if (selectedEnd) {
                rangeText.textContent = '（開始日を選択） 〜 ' + selectedEnd.replace(/-/g, '/');
                applyBtn.disabled = true;
            } else {
                rangeText.textContent = '日付を選択してください';
                applyBtn.disabled = true;
            }
        }

        /** 適用ボタン */
        applyBtn.addEventListener('click', function () {
            if (selectedStart && selectedEnd) {
                window.location.href = baseUrl + '?period=custom&start_date=' + selectedStart + '&end_date=' + selectedEnd;
            }
        });

        // 初期描画
        const now = new Date();
        let initStartYear = now.getFullYear();
        let initStartMonth = now.getMonth();
        let initEndYear = now.getFullYear();
        let initEndMonth = now.getMonth();

        // 選択済みの日付があればそのカレンダー月を表示
        if (selectedStart) {
            const d = new Date(selectedStart);
            initStartYear = d.getFullYear();
            initStartMonth = d.getMonth();
        }
        if (selectedEnd) {
            const d = new Date(selectedEnd);
            initEndYear = d.getFullYear();
            initEndMonth = d.getMonth();
        }

        renderCalendar('cal-start', initStartYear, initStartMonth, 'start');
        renderCalendar('cal-end', initEndYear, initEndMonth, 'end');
        updateUI();
    });
    </script>
</x-seller.common>
