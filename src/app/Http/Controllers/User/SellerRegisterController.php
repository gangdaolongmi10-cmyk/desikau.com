<?php

namespace App\Http\Controllers\User;

use App\Actions\User\RegisterSellerAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\SellerRegisterRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

/**
 * 出品者登録コントローラー
 */
final class SellerRegisterController extends Controller
{
    /**
     * 出品者登録画面を表示
     */
    public function index(): View|RedirectResponse
    {
        if (Auth::check() && Auth::user()->seller) {
            return redirect()->route('seller.home.index');
        }

        return view('user.seller.reguster.index');
    }

    /**
     * 出品者登録処理
     */
    public function register(SellerRegisterRequest $request, RegisterSellerAction $action): RedirectResponse
    {
        $action->execute($request->validated());

        return redirect()
            ->route('seller.home.index')
            ->with('success', '出品者登録が完了しました。');
    }
}
