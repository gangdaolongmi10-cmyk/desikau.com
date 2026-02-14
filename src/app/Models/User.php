<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;

/**
 * ユーザーモデル
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $icon_url
 * @property string|null $postal_code
 * @property string|null $prefecture
 * @property string|null $city
 * @property string|null $address
 * @property string|null $building
 * @property string|null $phone_number
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 *
 * @property-read Seller|null $seller
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Product> $likedProducts
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Review> $reviews
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Order> $orders
 * @property-read \Illuminate\Database\Eloquent\Collection<int, PurchaseHistory> $purchaseHistories
 *
 * @package App\Models
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, Billable, SoftDeletes;

    protected $table = 'users';

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'icon_url',
        'postal_code',
        'prefecture',
        'city',
        'address',
        'building',
        'phone_number',
        'remember_token',
    ];

    /**
     * 出品者情報を取得
     */
    public function seller(): HasOne
    {
        return $this->hasOne(Seller::class);
    }

    /**
     * いいねした商品を取得
     */
    public function likedProducts(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'likes')
            ->withTimestamps();
    }

    /**
     * 投稿したレビューを取得
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * 注文を取得
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * 購入履歴を取得
     */
    public function purchaseHistories(): HasMany
    {
        return $this->hasMany(PurchaseHistory::class);
    }
}
