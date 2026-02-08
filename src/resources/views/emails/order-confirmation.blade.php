{{-- 購入者向け注文確認メール --}}
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ご注文確認</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f4f5; font-family: 'Helvetica Neue', Arial, 'Hiragino Kaku Gothic ProN', 'Hiragino Sans', Meiryo, sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f4f4f5; padding: 32px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; overflow: hidden;">
                    {{-- ヘッダー --}}
                    <tr>
                        <td style="background-color: #1f2937; padding: 24px; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 24px;">desikau</h1>
                        </td>
                    </tr>

                    {{-- メイン --}}
                    <tr>
                        <td style="padding: 32px 24px;">
                            <p style="font-size: 16px; color: #1f2937; margin: 0 0 8px;">
                                {{ $order->user->name }} 様
                            </p>
                            <p style="font-size: 14px; color: #374151; margin: 0 0 24px; line-height: 1.6;">
                                この度はdesikauをご利用いただき、誠にありがとうございます。<br>
                                ご注文が完了いたしましたので、内容をお知らせいたします。
                            </p>

                            {{-- 注文情報 --}}
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 24px; background-color: #f9fafb; border-radius: 6px; padding: 16px;">
                                <tr>
                                    <td style="padding: 8px 16px;">
                                        <p style="font-size: 12px; color: #6b7280; margin: 0;">注文番号</p>
                                        <p style="font-size: 14px; color: #1f2937; margin: 4px 0 0; font-weight: bold;">{{ $order->order_number }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 16px;">
                                        <p style="font-size: 12px; color: #6b7280; margin: 0;">注文日時</p>
                                        <p style="font-size: 14px; color: #1f2937; margin: 4px 0 0;">{{ $order->paid_at->format('Y年m月d日 H:i') }}</p>
                                    </td>
                                </tr>
                            </table>

                            {{-- 商品明細 --}}
                            <h2 style="font-size: 16px; color: #1f2937; margin: 0 0 12px; border-bottom: 2px solid #e5e7eb; padding-bottom: 8px;">ご注文内容</h2>
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 16px;">
                                <thead>
                                    <tr style="border-bottom: 1px solid #e5e7eb;">
                                        <th style="text-align: left; padding: 8px 4px; font-size: 12px; color: #6b7280; font-weight: normal;">商品名</th>
                                        <th style="text-align: center; padding: 8px 4px; font-size: 12px; color: #6b7280; font-weight: normal;">数量</th>
                                        <th style="text-align: right; padding: 8px 4px; font-size: 12px; color: #6b7280; font-weight: normal;">価格</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($items as $item)
                                        <tr style="border-bottom: 1px solid #f3f4f6;">
                                            <td style="padding: 12px 4px; font-size: 14px; color: #374151;">{{ $item->product_name }}</td>
                                            <td style="padding: 12px 4px; font-size: 14px; color: #374151; text-align: center;">{{ $item->quantity }}</td>
                                            <td style="padding: 12px 4px; font-size: 14px; color: #374151; text-align: right;">&yen;{{ number_format($item->subtotal) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {{-- 合計 --}}
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 24px;">
                                <tr style="border-bottom: 1px solid #e5e7eb;">
                                    <td style="padding: 8px 4px; font-size: 14px; color: #6b7280;">小計</td>
                                    <td style="padding: 8px 4px; font-size: 14px; color: #374151; text-align: right;">&yen;{{ number_format($order->subtotal) }}</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #e5e7eb;">
                                    <td style="padding: 8px 4px; font-size: 14px; color: #6b7280;">消費税</td>
                                    <td style="padding: 8px 4px; font-size: 14px; color: #374151; text-align: right;">&yen;{{ number_format($order->tax) }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 4px; font-size: 16px; color: #1f2937; font-weight: bold;">合計（税込）</td>
                                    <td style="padding: 12px 4px; font-size: 16px; color: #1f2937; font-weight: bold; text-align: right;">&yen;{{ number_format($order->total) }}</td>
                                </tr>
                            </table>

                            <p style="font-size: 13px; color: #6b7280; line-height: 1.6; margin: 0;">
                                ご不明な点がございましたら、お気軽にお問い合わせください。
                            </p>
                        </td>
                    </tr>

                    {{-- フッター --}}
                    <tr>
                        <td style="background-color: #f9fafb; padding: 16px 24px; text-align: center; border-top: 1px solid #e5e7eb;">
                            <p style="font-size: 12px; color: #9ca3af; margin: 0;">
                                &copy; {{ date('Y') }} desikau All rights reserved.
                            </p>
                            <p style="font-size: 11px; color: #9ca3af; margin: 8px 0 0;">
                                ※このメールは自動送信されています。このメールに返信されても対応できません。
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
