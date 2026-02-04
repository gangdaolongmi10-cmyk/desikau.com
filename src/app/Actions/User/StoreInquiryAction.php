<?php

namespace App\Actions\User;

use App\Models\Inquiry;
use App\Models\User;
use Illuminate\Support\Str;

/**
 * お問い合わせ送信アクション
 */
final class StoreInquiryAction
{
    /**
     * お問い合わせを保存
     */
    public function execute(array $validated, ?User $user = null): Inquiry
    {
        $inquiry = new Inquiry();
        $inquiry->fill($validated);
        $inquiry->user_id = $user?->id;
        $inquiry->guest_token = $user ? null : (string) Str::uuid();
        $inquiry->save();

        return $inquiry;
    }
}
