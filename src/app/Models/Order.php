<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * 注文モデル
 *
 * @property int $id
 * @property int $user_id
 * @property string $order_number
 * @property string|null $stripe_checkout_session_id
 * @property string|null $stripe_payment_intent_id
 * @property int $subtotal
 * @property int $tax
 * @property int $total
 * @property string $status
 * @property \Carbon\Carbon|null $paid_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 */
class Order extends Model
{
    use HasFactory;

    /** 注文ステータス: 保留中 */
    public const STATUS_PENDING = 'pending';

    /** 注文ステータス: 支払い完了 */
    public const STATUS_PAID = 'paid';

    /** 注文ステータス: キャンセル */
    public const STATUS_CANCELLED = 'cancelled';

    /** 注文ステータス: 失敗 */
    public const STATUS_FAILED = 'failed';

    protected $fillable = [
        'user_id',
        'order_number',
        'stripe_checkout_session_id',
        'stripe_payment_intent_id',
        'subtotal',
        'tax',
        'total',
        'status',
        'paid_at',
    ];

    protected $casts = [
        'subtotal' => 'integer',
        'tax' => 'integer',
        'total' => 'integer',
        'paid_at' => 'datetime',
    ];

    /**
     * ユーザーを取得
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 注文アイテムを取得
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * 支払い完了かどうか
     */
    public function isPaid(): bool
    {
        return $this->status === self::STATUS_PAID;
    }

    /**
     * 注文番号を生成
     */
    public static function generateOrderNumber(): string
    {
        return 'DK-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
    }
}
