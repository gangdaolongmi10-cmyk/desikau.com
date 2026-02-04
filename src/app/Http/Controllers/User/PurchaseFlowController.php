<?php

namespace App\Http\Controllers\User;

use App\Actions\User\CreateCheckoutSessionAction;
use App\Actions\User\HandlePaymentSuccessAction;
use App\Actions\User\HandleWebhookAction;
use App\Enums\TaxRate;
use App\Http\Controllers\Controller;
use App\Services\CartService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * 購入フローコントローラー
 */
final class PurchaseFlowController extends Controller
{
    public function __construct(
        private readonly CartService $cartService
    ) {}

    /**
     * 購入手続き画面を表示
     */
    public function checkout(): View|RedirectResponse
    {
        $user = Auth::user();
        $cartItems = $this->cartService->getItems($user);

        if ($cartItems->isEmpty()) {
            return redirect()
                ->route('user.cart.index')
                ->with('error', 'カートに商品がありません');
        }

        $subtotal = $this->cartService->getTotal($user);
        $taxRate = TaxRate::default();
        $tax = $taxRate->calculateTax($subtotal);
        $total = $subtotal + $tax;

        return view('user.purchase-flow.checkout', compact('cartItems', 'subtotal', 'tax', 'total', 'taxRate'));
    }

    /**
     * Stripe Checkoutセッションを作成
     */
    public function createSession(CreateCheckoutSessionAction $action): JsonResponse
    {
        $result = $action->execute(Auth::user());

        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'message' => $result['message'],
            ], isset($result['checkout_url']) ? 500 : 400);
        }

        return response()->json([
            'success' => true,
            'checkout_url' => $result['checkout_url'],
            'session_id' => $result['session_id'],
        ]);
    }

    /**
     * 決済成功画面
     */
    public function success(Request $request, HandlePaymentSuccessAction $action): View|RedirectResponse
    {
        $sessionId = $request->query('session_id');

        if (!$sessionId) {
            return redirect()->route('user.home.index');
        }

        $order = $action->execute(Auth::user(), $sessionId);

        if (!$order) {
            return redirect()
                ->route('user.cart.index')
                ->with('error', '決済処理に問題が発生しました');
        }

        return view('user.purchase-flow.success', compact('order'));
    }

    /**
     * 決済キャンセル画面
     */
    public function cancel(): View
    {
        return view('user.purchase-flow.cancel');
    }

    /**
     * Stripe Webhook
     */
    public function webhook(Request $request, HandleWebhookAction $action): JsonResponse
    {
        $signature = $request->header('Stripe-Signature');

        if (!$signature) {
            return response()->json(['error' => 'Missing signature'], 400);
        }

        $result = $action->execute($request->getContent(), $signature);

        if (!$result) {
            return response()->json(['error' => 'Webhook handling failed'], 400);
        }

        return response()->json(['success' => true]);
    }
}
