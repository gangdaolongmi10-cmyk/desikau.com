<?php

namespace App\Http\Controllers\User;

use App\Actions\User\StoreInquiryAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\InquiryRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

/**
 * お問い合わせコントローラー
 */
final class InquiryController extends Controller
{
    /**
     * お問い合わせフォーム表示
     */
    public function index(): View
    {
        return view('user.inquiry.index');
    }

    /**
     * お問い合わせ送信処理
     */
    public function store(InquiryRequest $request, StoreInquiryAction $action): JsonResponse
    {
        $action->execute($request->validated(), Auth::user());

        return response()->json([
            'success' => true,
            'message' => 'お問い合わせを受け付けました。',
        ]);
    }
}
