<?php

namespace App\Http\Controllers\Seller;

use App\Actions\Seller\UpsertSellerLegalInfoAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Seller\SellerLegalInfoRequest;
use App\Models\Seller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * 特定商取引法に基づく表記コントローラー
 */
class SellerLegalInfoController extends Controller
{
    /**
     * 現在のSellerユーザーを取得
     */
    private function seller(): Seller
    {
        return Auth::guard('seller')->user();
    }

    /**
     * 編集フォームを表示
     */
    public function edit(): View
    {
        $legalInfo = $this->seller()->legalInfo;

        return view('seller.legal-info.edit', compact('legalInfo'));
    }

    /**
     * 特定商取引法に基づく表記を保存
     */
    public function update(SellerLegalInfoRequest $request, UpsertSellerLegalInfoAction $action): RedirectResponse
    {
        $action->execute($this->seller(), $request->validated());

        return redirect()
            ->route('seller.legal-info.edit')
            ->with('success', '特定商取引法に基づく表記を保存しました。');
    }
}
