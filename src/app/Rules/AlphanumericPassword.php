<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * パスワードが英字と数字の組み合わせであることを検証するルール
 */
final class AlphanumericPassword implements ValidationRule
{
    /**
     * バリデーションを実行
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // 英字を含むか
        $hasAlpha = preg_match('/[a-zA-Z]/', $value);
        // 数字を含むか
        $hasNumeric = preg_match('/[0-9]/', $value);

        if (!$hasAlpha || !$hasNumeric) {
            $fail('パスワードは英字と数字を組み合わせて入力してください。');
        }
    }
}
