<?php

namespace App\Enums;

/**
 * ソート順を表すEnum
 */
enum SortOrder: string
{
    /** 新しい順（降順） */
    case NEWEST = 'newest';

    /** 古い順（昇順） */
    case OLDEST = 'oldest';

    /**
     * SQLのORDER BY句で使用する方向を取得
     */
    public function direction(): string
    {
        return match ($this) {
            self::NEWEST => 'desc',
            self::OLDEST => 'asc',
        };
    }

    /**
     * 表示用のラベルを取得
     */
    public function label(): string
    {
        return match ($this) {
            self::NEWEST => '新しい順',
            self::OLDEST => '古い順',
        };
    }

    /**
     * 文字列から安全にEnumを取得（無効な値はデフォルトを返す）
     */
    public static function fromString(?string $value): self
    {
        return self::tryFrom($value ?? '') ?? self::NEWEST;
    }
}
