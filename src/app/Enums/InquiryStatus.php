<?php

namespace App\Enums;

/**
 * お問い合わせステータス
 */
enum InquiryStatus: int
{
    /** 未読 */
    case UNREAD = 0;

    /** 既読 */
    case READ = 1;

    /** 返信済み */
    case REPLIED = 2;

    /**
     * ラベルを取得
     */
    public function label(): string
    {
        return match ($this) {
            self::UNREAD => '未読',
            self::READ => '既読',
            self::REPLIED => '返信済み',
        };
    }
}
