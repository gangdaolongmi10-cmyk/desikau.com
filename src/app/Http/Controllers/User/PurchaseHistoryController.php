<?php

namespace App\Http\Controllers\User;

use App\Actions\User\DownloadReceiptAction;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Repositories\OrderRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

/**
 * 購入履歴コントローラー
 */
final class PurchaseHistoryController extends Controller
{
    public function __construct(
        private readonly OrderRepository $orderRepository
    ) {}

    /**
     * 購入履歴一覧を表示
     */
    public function index(): View
    {
        $orders = $this->orderRepository->getPaidOrdersByUserId(Auth::id());

        return view('user.purchase-history.index', compact('orders'));
    }

    /**
     * 領収書PDFをダウンロード
     */
    public function receipt(Request $request, Order $order, DownloadReceiptAction $action): Response
    {
        return $action->execute(Auth::user(), $order, $request);
    }
}
