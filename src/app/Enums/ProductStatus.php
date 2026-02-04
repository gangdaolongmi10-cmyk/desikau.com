<?php

namespace App\Enums;

/**
 * 商品公開ステータス
 */
enum ProductStatus: int
{
    /** 非公開 */
    case DRAFT = 0;

    /** 公開中 */
    case PUBLISHED = 1;

    /**
     * ラベルを取得
     */
    public function label(): string
    {
        return match ($this) {
            self::DRAFT => '非公開',
            self::PUBLISHED => '公開中',
        };
    }
}
