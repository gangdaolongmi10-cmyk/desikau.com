<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * 領収書ダウンロードログモデル（電子帳簿保存法対応）
 *
 * @property int $id
 * @property int $order_id
 * @property int $user_id
 * @property string $order_number
 * @property int $total
 * @property int $tax
 * @property string|null $ip_address
 * @property string|null $user_agent
 * @property Carbon $downloaded_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class ReceiptDownloadLog extends Model
{
    protected $fillable = [
        'order_id',
        'user_id',
        'order_number',
        'total',
        'tax',
        'ip_address',
        'user_agent',
        'downloaded_at',
    ];

    protected $casts = [
        'total' => 'integer',
        'tax' => 'integer',
        'downloaded_at' => 'datetime',
    ];

    /**
     * 注文を取得
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * ユーザーを取得
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
