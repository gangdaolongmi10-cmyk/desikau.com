<?php

namespace App\Models;

use App\Enums\AnnouncementStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * お知らせモデル
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property AnnouncementStatus $status
 * @property int|null $category_id
 * @property Carbon $published_at
 * @property Carbon|null $closed_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read AnnouncementCategory|null $category
 */
class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'status',
        'category_id',
        'published_at',
        'closed_at',
    ];

    protected $casts = [
        'status' => AnnouncementStatus::class,
        'published_at' => 'datetime',
        'closed_at' => 'datetime',
    ];

    /**
     * カテゴリを取得
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(AnnouncementCategory::class, 'category_id');
    }

    /**
     * 公開中のお知らせのみ取得するスコープ
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('status', AnnouncementStatus::PUBLISHED)
            ->where('published_at', '<=', now())
            ->where(function ($q) {
                $q->whereNull('closed_at')
                  ->orWhere('closed_at', '>', now());
            });
    }

    /**
     * 公開中かどうかを判定
     */
    public function isPublished(): bool
    {
        if ($this->status !== AnnouncementStatus::PUBLISHED) {
            return false;
        }

        if ($this->published_at > now()) {
            return false;
        }

        if ($this->closed_at !== null && $this->closed_at <= now()) {
            return false;
        }

        return true;
    }
}
