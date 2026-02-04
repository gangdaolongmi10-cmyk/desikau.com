<x-user.common title="特定商取引法に基づく表記">
    <div class="max-w-3xl mx-auto">
        <x-user.page-title title="特定商取引法に基づく表記" />

        <!-- Content Card -->
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 md:p-12">

            <div class="space-y-8">
                <!-- 販売業者 -->
                <div class="border-b border-gray-100 pb-6">
                    <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-2">販売業者</h2>
                    <p class="text-gray-900">{{ config('app.name') }} 運営事務局</p>
                </div>

                <!-- 運営統括責任者 -->
                <div class="border-b border-gray-100 pb-6">
                    <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-2">運営統括責任者</h2>
                    <p class="text-gray-900">代表者名</p>
                </div>

                <!-- 所在地 -->
                <div class="border-b border-gray-100 pb-6">
                    <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-2">所在地</h2>
                    <p class="text-gray-900">〒000-0000<br>東京都○○区○○ 0-0-0</p>
                </div>

                <!-- 電話番号 -->
                <div class="border-b border-gray-100 pb-6">
                    <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-2">電話番号</h2>
                    <p class="text-gray-900">お問い合わせはメールにて承っております</p>
                </div>

                <!-- メールアドレス -->
                <div class="border-b border-gray-100 pb-6">
                    <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-2">メールアドレス</h2>
                    <p class="text-gray-900">support@example.com</p>
                </div>

                <!-- 販売URL -->
                <div class="border-b border-gray-100 pb-6">
                    <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-2">販売URL</h2>
                    <p class="text-gray-900">{{ config('app.url') }}</p>
                </div>

                <!-- 販売価格 -->
                <div class="border-b border-gray-100 pb-6">
                    <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-2">販売価格</h2>
                    <p class="text-gray-900">各商品ページに記載の価格（税込）</p>
                </div>

                <!-- 商品代金以外の必要料金 -->
                <div class="border-b border-gray-100 pb-6">
                    <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-2">商品代金以外の必要料金</h2>
                    <p class="text-gray-900">なし（デジタルコンテンツのため送料は発生しません）</p>
                </div>

                <!-- 支払方法 -->
                <div class="border-b border-gray-100 pb-6">
                    <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-2">支払方法</h2>
                    <p class="text-gray-900">クレジットカード決済（Visa、Mastercard、American Express、JCB）</p>
                </div>

                <!-- 支払時期 -->
                <div class="border-b border-gray-100 pb-6">
                    <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-2">支払時期</h2>
                    <p class="text-gray-900">商品購入時に即時決済</p>
                </div>

                <!-- 商品の引渡時期 -->
                <div class="border-b border-gray-100 pb-6">
                    <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-2">商品の引渡時期</h2>
                    <p class="text-gray-900">決済完了後、即時ダウンロード可能</p>
                </div>

                <!-- 返品・キャンセルについて -->
                <div class="border-b border-gray-100 pb-6">
                    <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-2">返品・キャンセルについて</h2>
                    <p class="text-gray-900">
                        デジタルコンテンツという商品の性質上、購入後の返品・キャンセル・返金はお受けしておりません。<br>
                        ただし、以下の場合は返金対応いたします。
                    </p>
                    <ul class="list-disc pl-5 mt-3 text-gray-600 space-y-1">
                        <li>商品データが破損していた場合</li>
                        <li>商品説明と著しく異なる内容であった場合</li>
                        <li>ダウンロードができない技術的問題が発生した場合</li>
                    </ul>
                </div>

                <!-- 動作環境 -->
                <div class="border-b border-gray-100 pb-6">
                    <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-2">動作環境</h2>
                    <p class="text-gray-900">各商品ページに記載の動作環境をご確認ください</p>
                </div>

                <!-- その他 -->
                <div>
                    <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-2">その他</h2>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        当サービスはプラットフォームとして、出品者（クリエイター）が制作したデジタルコンテンツを販売しております。
                        各商品に関するお問い合わせは、商品ページのお問い合わせ機能をご利用ください。
                    </p>
                </div>
            </div>

        </div>
    </div>
</x-user.common>
