<?php

namespace App\Http\Controllers\User;

use App\Enums\TaxRate;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\CartAddRequest;
use App\Http\Requests\User\CartUpdateRequest;
use App\Services\CartService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

/**
 * カートコントローラー
 */
final class CartController extends Controller
{
    public function __construct(
        private readonly CartService $cartService
    ) {}

    /**
     * カート画面を表示
     */
    public function index(): View
    {
        $user = Auth::user();
        $cartItems = $this->cartService->getItems($user);
        $subtotal = $this->cartService->getTotal($user);
        $taxRate = TaxRate::default();
        $tax = $taxRate->calculateTax($subtotal);
        $total = $subtotal + $tax;

        return view('user.cart.index', compact('cartItems', 'subtotal', 'taxRate', 'tax', 'total'));
    }

    /**
     * カートに商品を追加
     */
    public function add(CartAddRequest $request): JsonResponse
    {
        $user = Auth::user();
        $productId = $request->integer('product_id');
        $quantity = $request->integer('quantity', 1);

        $cartItem = $this->cartService->addItem($productId, $quantity, $user);

        return response()->json([
            'success' => true,
            'message' => 'カートに追加しました',
            'cart_item' => $cartItem,
            'cart_count' => $this->cartService->getItemCount($user),
        ]);
    }

    /**
     * カートアイテムの数量を更新
     */
    public function update(CartUpdateRequest $request, int $cartItemId): JsonResponse
    {
        $user = Auth::user();
        $quantity = $request->integer('quantity');

        $cartItem = $this->cartService->updateQuantity($cartItemId, $quantity, $user);

        if ($quantity <= 0) {
            return response()->json([
                'success' => true,
                'message' => 'カートから削除しました',
                'removed' => true,
                'cart_count' => $this->cartService->getItemCount($user),
                'cart_total' => $this->cartService->getTotal($user),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => '数量を更新しました',
            'cart_item' => $cartItem,
            'cart_count' => $this->cartService->getItemCount($user),
            'cart_total' => $this->cartService->getTotal($user),
        ]);
    }

    /**
     * カートアイテムを削除
     */
    public function remove(int $cartItemId): JsonResponse
    {
        $user = Auth::user();
        $result = $this->cartService->removeItem($cartItemId, $user);

        if (!$result) {
            return response()->json([
                'success' => false,
                'message' => 'カートアイテムが見つかりません',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'カートから削除しました',
            'cart_count' => $this->cartService->getItemCount($user),
            'cart_total' => $this->cartService->getTotal($user),
        ]);
    }

    /**
     * カートを空にする
     */
    public function clear(): JsonResponse
    {
        $user = Auth::user();
        $this->cartService->clear($user);

        return response()->json([
            'success' => true,
            'message' => 'カートを空にしました',
            'cart_count' => 0,
            'cart_total' => 0,
        ]);
    }

    /**
     * カートのアイテム数を取得（API用）
     */
    public function count(): JsonResponse
    {
        $user = Auth::user();

        return response()->json([
            'count' => $this->cartService->getItemCount($user),
        ]);
    }
}
