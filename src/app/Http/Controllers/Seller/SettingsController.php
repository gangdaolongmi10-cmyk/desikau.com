<?php

namespace App\Http\Controllers\Seller;

use App\Actions\Seller\UpdateSellerSettingsAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Seller\SellerSettingsRequest;
use App\Models\Seller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * 出品者設定コントローラー
 */
class SettingsController extends Controller
{
    /**
     * 現在のSellerユーザーを取得
     */
    private function seller(): Seller
    {
        return Auth::guard('seller')->user();
    }

    /**
     * 設定画面を表示
     */
    public function edit(): View
    {
        $seller = $this->seller();

        return view('seller.settings.edit', compact('seller'));
    }

    /**
     * 設定を更新
     */
    public function update(SellerSettingsRequest $request, UpdateSellerSettingsAction $action): RedirectResponse
    {
        $action->execute($this->seller(), $request->validated());

        return redirect()
            ->route('seller.settings.edit')
            ->with('success', '設定を保存しました。');
    }
}
