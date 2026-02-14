<?php

namespace App\Models;

use App\Enums\ProductStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

/**
 * 商品モデル
 *
 * @property int $id
 * @property int|null $seller_id
 * @property int|null $category_id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property int $price
 * @property int|null $original_price
 * @property string|null $image_url
 * @property string|null $file_format
 * @property string|null $file_size
 * @property string|null $file_path
 * @property ProductStatus $status
 * @property int $likes_count
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property bool $liked_by_me 動的プロパティ: ユーザーがいいね済みかどうか
 *
 * @property-read Seller|null $seller
 * @property-read Category|null $category
 * @property-read \Illuminate\Database\Eloquent\Collection<int, User> $likedUsers
 */
class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $casts = [
        'price' => 'integer',
        'original_price' => 'integer',
        'status' => ProductStatus::class,
    ];

    protected $fillable = [
        'seller_id',
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'original_price',
        'image_url',
        'file_format',
        'file_size',
        'file_path',
        'status',
        'likes_count',
    ];

    /**
     * 出品者を取得
     */
    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }

    /**
     * カテゴリーを取得
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * この商品をいいねしたユーザーを取得
     */
    public function likedUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'likes')
            ->withTimestamps();
    }

    /**
     * この商品のレビューを取得
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * 公開中かどうかを判定
     */
    public function isPublished(): bool
    {
        return $this->status === ProductStatus::PUBLISHED;
    }

    /**
     * 非公開かどうかを判定
     */
    public function isDraft(): bool
    {
        return $this->status === ProductStatus::DRAFT;
    }

    /**
     * ダウンロード可能なファイルが存在するか判定
     */
    public function hasFile(): bool
    {
        return $this->file_path !== null
            && Storage::disk('local')->exists($this->file_path);
    }
}
