<?php

namespace App\Models;

use App\Enums\InquiryStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * お問い合わせモデル
 */
class Inquiry extends Model
{
    use HasFactory;

    /**
     * 一括代入可能な属性
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'guest_token',
        'name',
        'email',
        'message',
        'status',
    ];

    /**
     * キャストする属性
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => InquiryStatus::class,
    ];

    /**
     * 投稿者（ログインユーザー）を取得
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 未読のお問い合わせをスコープ
     */
    public function scopeUnread($query)
    {
        return $query->where('status', InquiryStatus::UNREAD);
    }

    /**
     * 既読のお問い合わせをスコープ
     */
    public function scopeRead($query)
    {
        return $query->where('status', InquiryStatus::READ);
    }

    /**
     * 返信済みのお問い合わせをスコープ
     */
    public function scopeReplied($query)
    {
        return $query->where('status', InquiryStatus::REPLIED);
    }
}
