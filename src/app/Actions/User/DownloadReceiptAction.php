<?php

namespace App\Actions\User;

use App\Models\Order;
use App\Models\ReceiptDownloadLog;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * 領収書ダウンロードアクション
 */
final class DownloadReceiptAction
{
    /**
     * 領収書PDFを生成してダウンロード
     *
     * 自分の注文でない場合または未払いの場合は403をスロー
     */
    public function execute(User $user, Order $order, Request $request): Response
    {
        if ($order->user_id !== $user->id || !$order->isPaid()) {
            abort(403);
        }

        // ダウンロードログを記録（電子帳簿保存法対応）
        ReceiptDownloadLog::create([
            'order_id' => $order->id,
            'user_id' => $user->id,
            'order_number' => $order->order_number,
            'total' => $order->total,
            'tax' => $order->tax,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'downloaded_at' => now(),
        ]);

        $pdf = Pdf::loadView('user.purchase-history.receipt', [
            'order' => $order->load('items'),
            'user' => $user,
        ]);

        $filename = sprintf(
            '領収書_%s_%s.pdf',
            $order->order_number,
            $order->paid_at->format('Ymd')
        );

        return $pdf->download($filename);
    }
}
