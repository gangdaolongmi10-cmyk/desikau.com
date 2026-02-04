<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * 購入履歴モデル
 *
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property int $price
 * @property int $status
 * @property \Carbon\Carbon $purchased_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 */
class PurchaseHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'price',
        'status',
        'purchased_at',
    ];

    protected $casts = [
        'price' => 'integer',
        'status' => 'integer',
        'purchased_at' => 'datetime',
    ];

    /**
     * ユーザーを取得
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 商品を取得
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
