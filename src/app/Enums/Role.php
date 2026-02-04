<?php

namespace App\Enums;

/**
 * ログインロール（ユーザー種別）
 */
enum Role: string
{
    /** 一般ユーザー */
    case USER = 'user';

    /** 出品者 */
    case SELLER = 'seller';

    /**
     * ラベルを取得
     */
    public function label(): string
    {
        return match ($this) {
            self::USER => 'ユーザー',
            self::SELLER => '出品者',
        };
    }

    /**
     * 認証ガード名を取得
     */
    public function guard(): string
    {
        return match ($this) {
            self::USER => 'web',
            self::SELLER => 'seller',
        };
    }

    /**
     * すべての値を配列で取得
     *
     * @return array<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
