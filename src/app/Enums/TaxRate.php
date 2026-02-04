<?php

namespace App\Enums;

/**
 * 消費税率
 */
enum TaxRate: int
{
    /** 標準税率 10% */
    case STANDARD = 10;

    /** 軽減税率 8% */
    case REDUCED = 8;

    /**
     * 税率をパーセント表示で取得
     */
    public function label(): string
    {
        return $this->value . '%';
    }

    /**
     * 税率を小数で取得
     */
    public function rate(): float
    {
        return $this->value / 100;
    }

    /**
     * 税額を計算（税抜価格から）
     */
    public function calculateTax(int $price): int
    {
        return (int) floor($price * $this->rate());
    }

    /**
     * 税込価格を計算
     */
    public function calculateTotalWithTax(int $price): int
    {
        return $price + $this->calculateTax($price);
    }

    /**
     * デフォルトの税率を取得
     */
    public static function default(): self
    {
        return self::STANDARD;
    }
}
