<?php

namespace App\Enums;

/**
 * お知らせステータス
 */
enum AnnouncementStatus: string
{
    /** 公開中 */
    case PUBLISHED = 'published';

    /** 終了 */
    case ARCHIVED = 'archived';

    /**
     * ラベルを取得
     */
    public function label(): string
    {
        return match ($this) {
            self::PUBLISHED => '公開中',
            self::ARCHIVED => '終了',
        };
    }

    /**
     * 全ての値を取得
     *
     * @return array<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
