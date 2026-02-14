<?php

namespace App\Actions\User;

use App\Enums\Role;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;

/**
 * ログイン処理アクション
 */
final class LoginAction
{
    public function __construct(
        private readonly CartService $cartService
    ) {}

    /**
     * ログインを実行
     *
     * @return array{success: bool, redirect: string, message: string}
     */
    public function execute(array $credentials, bool $remember, Role $loginType): array
    {
        return match ($loginType) {
            Role::USER => $this->loginAsUser($credentials, $remember),
            Role::SELLER => $this->loginAsSeller($credentials, $remember),
        };
    }

    /**
     * ユーザーとしてログイン
     *
     * @return array{success: bool, redirect: string, message: string}
     */
    private function loginAsUser(array $credentials, bool $remember): array
    {
        if (!Auth::attempt($credentials, $remember)) {
            return [
                'success' => false,
                'redirect' => '',
                'message' => 'メールアドレスまたはパスワードが正しくありません。',
            ];
        }

        session()->regenerate();

        // 出品者情報が紐づいていれば同時ログイン
        /** @var \App\Models\User $user */
        $user = Auth::user();
        /** @var \App\Models\Seller|null $seller */
        $seller = $user->seller;
        if ($seller) {
            Auth::guard('seller')->login($seller, $remember);
        }

        // ゲストカートをマージ
        $this->cartService->mergeGuestCart($user);

        return [
            'success' => true,
            'redirect' => route('user.home.index'),
            'message' => 'ログインしました。',
        ];
    }

    /**
     * 出品者としてログイン
     *
     * @return array{success: bool, redirect: string, message: string}
     */
    private function loginAsSeller(array $credentials, bool $remember): array
    {
        if (!Auth::guard('seller')->attempt($credentials, $remember)) {
            return [
                'success' => false,
                'redirect' => '',
                'message' => 'メールアドレスまたはパスワードが正しくありません。',
            ];
        }

        session()->regenerate();

        // 紐づくユーザーが存在すれば同時ログイン
        /** @var \App\Models\Seller $seller */
        $seller = Auth::guard('seller')->user();
        /** @var \App\Models\User|null $user */
        $user = $seller->user;
        if ($user) {
            Auth::login($user, $remember);
            $this->cartService->mergeGuestCart($user);
        }

        return [
            'success' => true,
            'redirect' => route('seller.home.index'),
            'message' => '出品者としてログインしました。',
        ];
    }
}
