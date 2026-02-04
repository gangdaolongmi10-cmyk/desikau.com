<?php

namespace App\Actions\User;

use App\Enums\TaxRate;
use App\Models\User;
use App\Services\CartService;
use App\Services\StripeService;
use Illuminate\Support\Facades\Log;

/**
 * Stripe Checkoutセッション作成アクション
 */
final class CreateCheckoutSessionAction
{
    public function __construct(
        private readonly CartService $cartService,
        private readonly StripeService $stripeService
    ) {}

    /**
     * Checkoutセッションを作成
     *
     * @return array{success: bool, checkout_url?: string, session_id?: string, message?: string}
     */
    public function execute(User $user): array
    {
        $cartItems = $this->cartService->getItems($user);

        if ($cartItems->isEmpty()) {
            return [
                'success' => false,
                'message' => 'カートに商品がありません',
            ];
        }

        $subtotal = $this->cartService->getTotal($user);
        $taxRate = TaxRate::default();
        $tax = $taxRate->calculateTax($subtotal);
        $total = $subtotal + $tax;

        try {
            $result = $this->stripeService->createCheckoutSession(
                $user,
                $cartItems,
                $subtotal,
                $tax,
                $total
            );

            return [
                'success' => true,
                'checkout_url' => $result['session']->url,
                'session_id' => $result['session']->id,
            ];
        } catch (\Exception $e) {
            Log::error('Stripe checkout session creation failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => '決済処理の開始に失敗しました。しばらく経ってからお試しください。',
            ];
        }
    }
}
