<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

/**
 * 出品者モデル
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $email
 * @property string $password
 * @property string $shop_name
 * @property string $slug
 * @property string $main_category
 * @property string|null $description
 * @property string|null $twitter_username
 * @property string|null $youtube_url
 * @property string|null $twitch_username
 * @property string|null $postal_code
 * @property string|null $prefecture
 * @property string|null $city
 * @property string|null $address
 * @property string|null $building
 * @property string|null $phone_number
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 *
 * @property-read User|null $user
 * @property-read \Illuminate\Database\Eloquent\Collection|Product[] $products
 * @property-read SellerLegalInfo|null $legalInfo
 */
class Seller extends Authenticatable
{
    use HasFactory;

    protected $table = 'sellers';

    /**
     * モデルの起動処理
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Seller $seller) {
            if (empty($seller->slug)) {
                $seller->slug = self::generateUniqueSlug($seller->shop_name);
            }
        });
    }

    /**
     * ユニークなスラッグを生成
     */
    private static function generateUniqueSlug(string $shopName): string
    {
        $baseSlug = Str::slug($shopName);

        // 日本語など非ASCII文字の場合はランダム文字列を使用
        if (empty($baseSlug)) {
            $baseSlug = Str::random(10);
        }

        $slug = $baseSlug;
        $counter = 1;

        while (self::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $fillable = [
        'user_id',
        'email',
        'password',
        'shop_name',
        'slug',
        'main_category',
        'description',
        'twitter_username',
        'youtube_url',
        'twitch_username',
        'postal_code',
        'prefecture',
        'city',
        'address',
        'building',
        'phone_number',
    ];

    /**
     * 紐づくユーザーを取得
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 出品商品を取得
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * 特定商取引法に基づく表記を取得
     */
    public function legalInfo(): HasOne
    {
        return $this->hasOne(SellerLegalInfo::class);
    }

    /**
     * メールアドレスでユーザーを紐づける
     */
    public function linkUserByEmail(): void
    {
        $user = User::where('email', $this->email)->first();
        if ($user) {
            $this->user_id = $user->id;
            $this->save();
        }
    }

    /**
     * ルートキーをslugに変更
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
