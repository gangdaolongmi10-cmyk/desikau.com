<?php

namespace App\Services;

use App\Enums\TaxRate;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Stripe\Checkout\Session as StripeSession;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;
use Stripe\Webhook;

/**
 * Stripe決済サービス
 */
class StripeService
{
    /**
     * コンストラクタ
     */
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    /**
     * Checkoutセッションを作成
     *
     * @param User $user ユーザー
     * @param Collection $cartItems カートアイテム
     * @param int $subtotal 小計
     * @param int $tax 税額
     * @param int $total 合計
     * @return array{session: StripeSession, order: Order}
     * @throws ApiErrorException
     */
    public function createCheckoutSession(
        User $user,
        Collection $cartItems,
        int $subtotal,
        int $tax,
        int $total
    ): array {
        return DB::transaction(function () use ($user, $cartItems, $subtotal, $tax, $total) {
            // 注文を作成
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => Order::generateOrderNumber(),
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
                'status' => Order::STATUS_PENDING,
            ]);

            // 注文アイテムを作成
            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'product_name' => $cartItem->product->name,
                    'price' => $cartItem->product->price,
                    'quantity' => $cartItem->quantity,
                ]);
            }

            // Stripe Checkoutセッションを作成
            $lineItems = $this->buildLineItems($cartItems);

            // 税金を追加
            $taxRate = TaxRate::default();
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => '消費税 (' . $taxRate->label() . ')',
                    ],
                    'unit_amount' => $tax,
                ],
                'quantity' => 1,
            ];

            $session = StripeSession::create([
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => route('user.checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('user.checkout.cancel'),
                'customer_email' => $user->email,
                'metadata' => [
                    'order_id' => (string) $order->id,
                    'order_number' => $order->order_number,
                ],
                'locale' => 'ja',
            ]);

            // Checkoutセッション IDを保存
            $order->update([
                'stripe_checkout_session_id' => $session->id,
            ]);

            return [
                'session' => $session,
                'order' => $order,
            ];
        });
    }

    /**
     * Checkoutセッションを取得
     *
     * @param string $sessionId セッションID
     * @return StripeSession|null
     */
    public function retrieveCheckoutSession(string $sessionId): ?StripeSession
    {
        try {
            return StripeSession::retrieve($sessionId);
        } catch (ApiErrorException $e) {
            Log::error('Stripe session retrieve failed', [
                'session_id' => $sessionId,
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }

    /**
     * 支払い完了処理
     *
     * @param string $sessionId CheckoutセッションID
     * @return Order|null
     */
    public function handlePaymentSuccess(string $sessionId): ?Order
    {
        $session = $this->retrieveCheckoutSession($sessionId);

        if (!$session || $session->payment_status !== 'paid') {
            return null;
        }

        $order = Order::where('stripe_checkout_session_id', $sessionId)->first();

        if (!$order || $order->isPaid()) {
            return $order;
        }

        $order->update([
            'stripe_payment_intent_id' => $session->payment_intent,
            'status' => Order::STATUS_PAID,
            'paid_at' => now(),
        ]);

        return $order;
    }

    /**
     * Webhookイベントを処理
     *
     * @param string $payload ペイロード
     * @param string $signature シグネチャ
     * @return bool
     */
    public function handleWebhook(string $payload, string $signature): bool
    {
        try {
            $event = Webhook::constructEvent(
                $payload,
                $signature,
                config('services.stripe.webhook_secret')
            );

            switch ($event->type) {
                case 'checkout.session.completed':
                    $session = $event->data->object;
                    $this->handlePaymentSuccess($session->id);
                    break;

                case 'checkout.session.expired':
                    $session = $event->data->object;
                    $this->handleSessionExpired($session->id);
                    break;
            }

            return true;
        } catch (\Exception $e) {
            Log::error('Stripe webhook handling failed', [
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * セッション期限切れ処理
     *
     * @param string $sessionId セッションID
     */
    private function handleSessionExpired(string $sessionId): void
    {
        $order = Order::where('stripe_checkout_session_id', $sessionId)->first();

        if ($order && $order->status === Order::STATUS_PENDING) {
            $order->update([
                'status' => Order::STATUS_CANCELLED,
            ]);
        }
    }

    /**
     * カートアイテムからStripe line_itemsを構築
     *
     * @param Collection $cartItems カートアイテム
     * @return array
     */
    private function buildLineItems(Collection $cartItems): array
    {
        return $cartItems->map(function ($item) {
            return [
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $item->product->name,
                        'description' => $item->product->seller->shop_name ?? '',
                        'images' => $item->product->image_url ? [$item->product->image_url] : [],
                    ],
                    'unit_amount' => $item->product->price,
                ],
                'quantity' => $item->quantity,
            ];
        })->values()->toArray();
    }
}
