<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * 入力禁止文字を検証するルール
 */
final class ProhibitedCharacters implements ValidationRule
{
    /**
     * 入力禁止文字パターン（SQLインジェクション、XSS等の対策）
     */
    private const PROHIBITED_PATTERN = '/[<>\'";\\\\`\x00-\x1f]/';

    /**
     * バリデーションを実行
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (preg_match(self::PROHIBITED_PATTERN, $value)) {
            $fail('使用できない文字が含まれています。');
        }
    }
}
