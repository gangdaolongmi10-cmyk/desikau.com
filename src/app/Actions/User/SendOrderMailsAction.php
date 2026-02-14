<?php

namespace App\Actions\User;

use App\Mail\OrderConfirmationMail;
use App\Mail\OrderNotificationMail;
use App\Models\Order;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * 注文完了メール送信アクション
 *
 * 購入者への注文確認メールと出品者への新規注文通知メールを送信する。
 */
final class SendOrderMailsAction
{
    /**
     * 注文完了メールを送信
     */
    public function execute(Order $order): void
    {
        $order->load(['user', 'items.product.seller']);

        $this->sendConfirmationMail($order);
        $this->sendNotificationMails($order);
    }

    /**
     * 購入者へ注文確認メールを送信
     */
    private function sendConfirmationMail(Order $order): void
    {
        try {
            Mail::to($order->user->email)
                ->send(new OrderConfirmationMail($order));
        } catch (\Throwable $e) {
            Log::error('購入者への注文確認メール送信に失敗しました', [
                'order_id' => $order->id,
                'user_id' => $order->user_id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * 出品者へ新規注文通知メールを送信（出品者ごとにグループ化）
     */
    private function sendNotificationMails(Order $order): void
    {
        /** @var \Illuminate\Support\Collection<int, \Illuminate\Support\Collection<int, \App\Models\OrderItem>> $sellerGroups 出品者ごとにグループ化した注文アイテム */
        $sellerGroups = $order->items
            ->groupBy(fn (\App\Models\OrderItem $item) => $item->product?->seller_id)
            ->filter(fn ($items, $sellerId) => !empty($sellerId));

        foreach ($sellerGroups as $sellerId => $items) {
            $seller = $items->first()->product->seller;

            try {
                Mail::to($seller->email)
                    ->send(new OrderNotificationMail($order, $seller, $items));
            } catch (\Throwable $e) {
                Log::error('出品者への注文通知メール送信に失敗しました', [
                    'order_id' => $order->id,
                    'seller_id' => $sellerId,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }
}
