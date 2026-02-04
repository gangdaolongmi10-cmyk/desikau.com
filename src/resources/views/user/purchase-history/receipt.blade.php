<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>領収書 - {{ $order->order_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'ipagp', 'ipag', sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            padding: 40px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 2px solid #333;
        }
        .header h1 {
            font-size: 28px;
            font-weight: bold;
            letter-spacing: 8px;
        }
        .recipient {
            margin-bottom: 30px;
        }
        .recipient-name {
            font-size: 18px;
            font-weight: bold;
            border-bottom: 1px solid #333;
            padding-bottom: 5px;
            display: inline-block;
        }
        .recipient-suffix {
            font-size: 14px;
            margin-left: 10px;
        }
        .amount-section {
            background: #f5f5f5;
            padding: 20px;
            margin-bottom: 30px;
            text-align: center;
        }
        .amount-label {
            font-size: 12px;
            color: #666;
            margin-bottom: 5px;
        }
        .amount {
            font-size: 32px;
            font-weight: bold;
        }
        .amount-yen {
            font-size: 18px;
        }
        .info-table {
            width: 100%;
            margin-bottom: 30px;
        }
        .info-table th,
        .info-table td {
            padding: 8px 0;
            text-align: left;
            vertical-align: top;
        }
        .info-table th {
            width: 120px;
            color: #666;
            font-weight: normal;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .items-table th {
            background: #333;
            color: #fff;
            padding: 10px;
            text-align: left;
            font-weight: normal;
        }
        .items-table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        .items-table .price {
            text-align: right;
        }
        .summary-table {
            width: 300px;
            margin-left: auto;
            margin-bottom: 30px;
        }
        .summary-table td {
            padding: 8px 0;
        }
        .summary-table .label {
            text-align: left;
        }
        .summary-table .value {
            text-align: right;
        }
        .summary-table .total-row {
            border-top: 2px solid #333;
            font-weight: bold;
            font-size: 14px;
        }
        .tax-summary {
            background: #f9f9f9;
            padding: 15px;
            margin-bottom: 30px;
            border: 1px solid #ddd;
        }
        .tax-summary h3 {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .tax-summary-table {
            width: 100%;
        }
        .tax-summary-table th,
        .tax-summary-table td {
            padding: 5px 10px;
            text-align: right;
        }
        .tax-summary-table th {
            text-align: left;
            font-weight: normal;
            color: #666;
        }
        .issuer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }
        .issuer-name {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .issuer-info {
            font-size: 11px;
            color: #666;
            line-height: 1.8;
        }
        .invoice-number {
            margin-top: 10px;
            font-size: 11px;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #999;
        }
        .stamp-area {
            position: absolute;
            right: 60px;
            top: 180px;
            width: 80px;
            height: 80px;
            border: 2px solid #cc0000;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #cc0000;
            font-size: 11px;
            text-align: center;
            line-height: 1.3;
        }
    </style>
</head>
<body>
    <div class="container">
        {{-- ヘッダー --}}
        <div class="header">
            <h1>領 収 書</h1>
        </div>

        {{-- 宛名 --}}
        <div class="recipient">
            <span class="recipient-name">{{ $user->name }}</span>
            <span class="recipient-suffix">様</span>
        </div>

        {{-- 金額 --}}
        <div class="amount-section">
            <div class="amount-label">領収金額</div>
            <div class="amount">
                <span class="amount-yen">¥</span>{{ number_format($order->total) }}<span class="amount-yen">-</span>
            </div>
        </div>

        {{-- 基本情報 --}}
        <table class="info-table">
            <tr>
                <th>発行日</th>
                <td>{{ $order->paid_at->format('Y年n月j日') }}</td>
            </tr>
            <tr>
                <th>注文番号</th>
                <td>{{ $order->order_number }}</td>
            </tr>
            <tr>
                <th>お支払い方法</th>
                <td>クレジットカード決済</td>
            </tr>
        </table>

        {{-- 商品明細 --}}
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 60%;">商品名</th>
                    <th style="width: 20%;">数量</th>
                    <th style="width: 20%;" class="price">金額（税込）</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td>{{ $item->product_name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td class="price">¥{{ number_format($item->price * $item->quantity) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- 合計 --}}
        <table class="summary-table">
            <tr>
                <td class="label">小計</td>
                <td class="value">¥{{ number_format($order->subtotal) }}</td>
            </tr>
            <tr>
                <td class="label">消費税（10%）</td>
                <td class="value">¥{{ number_format($order->tax) }}</td>
            </tr>
            <tr class="total-row">
                <td class="label">合計</td>
                <td class="value">¥{{ number_format($order->total) }}</td>
            </tr>
        </table>

        {{-- 税率別内訳（インボイス制度対応） --}}
        <div class="tax-summary">
            <h3>税率別内訳（適格請求書等保存方式対応）</h3>
            <table class="tax-summary-table">
                <tr>
                    <th>税率</th>
                    <th>対象金額（税込）</th>
                    <th>消費税額</th>
                </tr>
                <tr>
                    <td>10%</td>
                    <td>¥{{ number_format($order->total) }}</td>
                    <td>¥{{ number_format($order->tax) }}</td>
                </tr>
                {{-- 将来の軽減税率対応用（現在はデジタルコンテンツのみのため使用しない） --}}
                {{-- <tr>
                    <td>8%（軽減税率）</td>
                    <td>¥0</td>
                    <td>¥0</td>
                </tr> --}}
            </table>
        </div>

        {{-- 発行者情報 --}}
        <div class="issuer">
            <div class="issuer-name">Desikau（デシカウ）</div>
            <div class="issuer-info">
                〒000-0000 東京都○○区○○1-2-3<br>
                TEL: 03-0000-0000<br>
                Email: support@desikau.local
            </div>
            <div class="invoice-number">
                登録番号: T0000000000000（適格請求書発行事業者）
            </div>
        </div>

        {{-- フッター --}}
        <div class="footer">
            この領収書は電子的に発行されたものです。<br>
            電子帳簿保存法に基づき適切に保存してください。
        </div>
    </div>
</body>
</html>
