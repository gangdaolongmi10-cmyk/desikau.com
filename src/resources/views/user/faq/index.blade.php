<x-user.common title="よくある質問">
    <div class="max-w-4xl mx-auto px-4">
        {{-- ページタイトル --}}
        <div class="mb-10">
            <h1 class="text-3xl font-extrabold text-gray-900">よくある質問</h1>
            <p class="text-gray-500 mt-2">お客様からよくいただくご質問をまとめました。お問い合わせ前にぜひご確認ください。</p>
        </div>

        {{-- FAQ一覧 --}}
        <div class="space-y-4" x-data="{ openIndex: null }">
            @php
                $faqs = [
                    [
                        'category' => '購入について',
                        'icon' => 'shopping-cart',
                        'color' => 'indigo',
                        'items' => [
                            [
                                'question' => '購入した商品はどこからダウンロードできますか？',
                                'answer' => '購入完了後、「購入履歴」ページからダウンロードいただけます。また、ご登録のメールアドレスにもダウンロードリンクをお送りしています。',
                            ],
                            [
                                'question' => '支払い方法は何が使えますか？',
                                'answer' => 'クレジットカード（Visa、Mastercard、American Express、JCB）でのお支払いに対応しています。決済はStripeを通じて安全に処理されます。',
                            ],
                            [
                                'question' => '購入後のキャンセル・返金はできますか？',
                                'answer' => 'デジタルコンテンツの性質上、ダウンロード後のキャンセル・返金には対応しておりません。ただし、商品に不具合があった場合は、お問い合わせフォームよりご連絡ください。',
                            ],
                            [
                                'question' => '領収書は発行できますか？',
                                'answer' => 'はい、発行可能です。購入履歴ページから、各購入に対して領収書をダウンロードいただけます。',
                            ],
                        ],
                    ],
                    [
                        'category' => 'アカウントについて',
                        'icon' => 'user',
                        'color' => 'emerald',
                        'items' => [
                            [
                                'question' => '会員登録は無料ですか？',
                                'answer' => 'はい、会員登録は無料です。登録いただくと、お気に入り機能や購入履歴の確認など、便利な機能をご利用いただけます。',
                            ],
                            [
                                'question' => 'パスワードを忘れました。',
                                'answer' => 'ログインページの「パスワードをお忘れの方」から、パスワードの再設定が可能です。ご登録のメールアドレスに再設定用のリンクをお送りします。',
                            ],
                            [
                                'question' => 'メールアドレスを変更したいです。',
                                'answer' => 'プロフィール設定ページからメールアドレスの変更が可能です。変更後、新しいメールアドレスに確認メールをお送りします。',
                            ],
                            [
                                'question' => '退会するにはどうすればいいですか？',
                                'answer' => 'プロフィール設定ページの下部にある「アカウントを削除」から退会手続きが可能です。退会後、購入履歴などのデータは削除されますのでご注意ください。',
                            ],
                        ],
                    ],
                    [
                        'category' => '出品について',
                        'icon' => 'store',
                        'color' => 'amber',
                        'items' => [
                            [
                                'question' => '出品者になるにはどうすればいいですか？',
                                'answer' => '会員登録後、「出品者登録」ページから必要事項を入力して申請してください。審査通過後、出品が可能になります。',
                            ],
                            [
                                'question' => '販売手数料はいくらですか？',
                                'answer' => '販売価格の10%を手数料としていただいています。詳細は出品者向け利用規約をご確認ください。',
                            ],
                            [
                                'question' => '売上の振込はいつですか？',
                                'answer' => '毎月末締め、翌月15日払いとなります。最低振込金額は1,000円からです。',
                            ],
                        ],
                    ],
                    [
                        'category' => 'その他',
                        'icon' => 'help-circle',
                        'color' => 'gray',
                        'items' => [
                            [
                                'question' => '商品の動作環境を教えてください。',
                                'answer' => '各商品ページに動作環境を記載しています。ご購入前に必ずご確認ください。ご不明な点があれば、商品ページから出品者にお問い合わせいただくことも可能です。',
                            ],
                            [
                                'question' => '商品に関する質問はどこからできますか？',
                                'answer' => '各商品ページにあるレビュー欄から質問いただくか、出品者に直接お問い合わせください。サービス全般に関するご質問は「お問い合わせ」フォームをご利用ください。',
                            ],
                            [
                                'question' => '利用規約はどこで確認できますか？',
                                'answer' => 'フッターの「利用規約」リンクからご確認いただけます。ご利用前に必ずお読みください。',
                            ],
                        ],
                    ],
                ];

                $globalIndex = 0;
            @endphp

            @foreach ($faqs as $category)
                {{-- カテゴリーヘッダー --}}
                <div class="flex items-center gap-3 mt-8 mb-4 first:mt-0">
                    <div class="w-10 h-10 rounded-xl bg-{{ $category['color'] }}-100 flex items-center justify-center">
                        <i data-lucide="{{ $category['icon'] }}" class="w-5 h-5 text-{{ $category['color'] }}-600"></i>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900">{{ $category['category'] }}</h2>
                </div>

                {{-- FAQ項目 --}}
                <div class="space-y-3">
                    @foreach ($category['items'] as $faq)
                        @php $currentIndex = $globalIndex++; @endphp
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                            {{-- 質問（アコーディオンヘッダー） --}}
                            <button
                                @click="openIndex = openIndex === {{ $currentIndex }} ? null : {{ $currentIndex }}"
                                class="w-full flex items-center justify-between gap-4 p-5 text-left hover:bg-gray-50 transition-colors"
                            >
                                <div class="flex items-start gap-3">
                                    <span class="flex-shrink-0 w-6 h-6 rounded-full bg-{{ $category['color'] }}-100 text-{{ $category['color'] }}-600 flex items-center justify-center text-sm font-bold">Q</span>
                                    <span class="font-semibold text-gray-900">{{ $faq['question'] }}</span>
                                </div>
                                <i
                                    data-lucide="chevron-down"
                                    class="w-5 h-5 text-gray-400 flex-shrink-0 transition-transform duration-200"
                                    :class="openIndex === {{ $currentIndex }} ? 'rotate-180' : ''"
                                ></i>
                            </button>

                            {{-- 回答（アコーディオンコンテンツ） --}}
                            <div
                                x-show="openIndex === {{ $currentIndex }}"
                                x-collapse
                                x-cloak
                            >
                                <div class="px-5 pb-5">
                                    <div class="flex items-start gap-3 pt-3 border-t border-gray-100">
                                        <span class="flex-shrink-0 w-6 h-6 rounded-full bg-gray-100 text-gray-600 flex items-center justify-center text-sm font-bold">A</span>
                                        <p class="text-gray-600 leading-relaxed">{{ $faq['answer'] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>

        {{-- お問い合わせへの誘導 --}}
        <div class="mt-12 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-3xl p-8 text-center text-white">
            <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                <i data-lucide="message-circle-question" class="w-8 h-8"></i>
            </div>
            <h2 class="text-2xl font-bold mb-2">お探しの回答が見つかりませんか？</h2>
            <p class="text-white/80 mb-6">お気軽にお問い合わせください。担当者が丁寧にお答えいたします。</p>
            <a
                href="{{ route('user.inquiry.index') }}"
                class="inline-flex items-center gap-2 bg-white text-indigo-600 font-bold px-8 py-3 rounded-full hover:bg-gray-100 transition-colors"
            >
                <i data-lucide="mail" class="w-5 h-5"></i>
                お問い合わせする
            </a>
        </div>
    </div>
</x-user.common>
