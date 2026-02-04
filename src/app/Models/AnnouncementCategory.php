<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * お知らせカテゴリモデル
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $color
 * @property int $sort_order
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class AnnouncementCategory extends Model
{
    use HasFactory;

    /** カラー: 赤（重要） */
    public const COLOR_RED = '#ef4444';

    /** カラー: オレンジ（メンテナンス） */
    public const COLOR_ORANGE = '#f59e0b';

    /** カラー: 青（アップデート） */
    public const COLOR_BLUE = '#3b82f6';

    /** カラー: 緑（キャンペーン） */
    public const COLOR_GREEN = '#10b981';

    /** カラー: グレー（その他） */
    public const COLOR_GRAY = '#6b7280';

    /** カラー: インディゴ（デフォルト） */
    public const COLOR_INDIGO = '#6366f1';

    protected $fillable = [
        'name',
        'slug',
        'color',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    /**
     * お知らせを取得
     */
    public function announcements(): HasMany
    {
        return $this->hasMany(Announcement::class, 'category_id');
    }
}
