<?php

namespace App\Enums;

/**
 * 有効/無効状態を表すEnum
 */
enum IsActive: int
{
    case Active = 1;
    case Inactive = 0;

    /**
     * ラベルを取得
     */
    public function label(): string
    {
        return match ($this) {
            self::Active => '有効',
            self::Inactive => '無効',
        };
    }

    /**
     * bool値に変換
     */
    public function toBool(): bool
    {
        return $this === self::Active;
    }

    /**
     * bool値からEnumを取得
     */
    public static function fromBool(bool $value): self
    {
        return $value ? self::Active : self::Inactive;
    }

    /**
     * 全ての値を配列で取得
     *
     * @return array<int, string>
     */
    public static function toArray(): array
    {
        return [
            self::Active->value => self::Active->label(),
            self::Inactive->value => self::Inactive->label(),
        ];
    }
}
