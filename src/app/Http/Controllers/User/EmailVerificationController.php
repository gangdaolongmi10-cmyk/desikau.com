<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * メール認証コントローラー
 */
final class EmailVerificationController extends Controller
{
    /**
     * メール認証待ち画面を表示
     */
    public function notice(): View
    {
        return view('user.email.verify');
    }

    /**
     * メール認証を実行
     */
    public function verify(EmailVerificationRequest $request): RedirectResponse
    {
        $request->fulfill();

        return redirect()->route('user.home.index')
            ->with('success', 'メールアドレスの認証が完了しました。');
    }

    /**
     * 認証メールを再送信
     */
    public function resend(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('user.home.index');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('success', '認証メールを再送信しました。');
    }
}
