<?php

namespace App\Actions\User;

use App\Models\Order;
use App\Models\PurchaseHistory;
use App\Models\User;
use App\Services\CartService;
use App\Services\StripeService;

/**
 * 決済成功時の処理アクション
 */
final class HandlePaymentSuccessAction
{
    public function __construct(
        private readonly CartService $cartService,
        private readonly StripeService $stripeService
    ) {}

    /**
     * 決済成功を処理
     *
     * @return Order|null 注文情報（失敗時はnull）
     */
    public function execute(User $user, string $sessionId): ?Order
    {
        $order = $this->stripeService->handlePaymentSuccess($sessionId);

        if (!$order) {
            return null;
        }

        if ($order->isPaid()) {
            $this->createPurchaseHistories($order);
            $this->cartService->clear($user);
        }

        $order->load('items.product');

        return $order;
    }

    /**
     * 購入履歴を作成
     */
    private function createPurchaseHistories(Order $order): void
    {
        foreach ($order->items as $item) {
            $exists = PurchaseHistory::where('user_id', $order->user_id)
                ->where('product_id', $item->product_id)
                ->where('purchased_at', $order->paid_at)
                ->exists();

            if (!$exists) {
                PurchaseHistory::create([
                    'user_id' => $order->user_id,
                    'product_id' => $item->product_id,
                    'price' => $item->price,
                    'status' => 1,
                    'purchased_at' => $order->paid_at,
                ]);
            }
        }
    }
}
