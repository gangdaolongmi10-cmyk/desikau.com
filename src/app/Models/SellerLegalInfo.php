<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * 特定商取引法に基づく表記モデル
 *
 * @property int $id
 * @property int $seller_id
 * @property string $company_name
 * @property string $representative_name
 * @property string $postal_code
 * @property string $address
 * @property string $phone_number
 * @property string $email
 * @property string $price_description
 * @property string $payment_method
 * @property string $delivery_period
 * @property string $return_policy
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 *
 * @property-read Seller $seller
 */
class SellerLegalInfo extends Model
{
    use HasFactory;

    protected $table = 'seller_legal_infos';

    protected $fillable = [
        'seller_id',
        'company_name',
        'representative_name',
        'postal_code',
        'address',
        'phone_number',
        'email',
        'price_description',
        'payment_method',
        'delivery_period',
        'return_policy',
    ];

    /**
     * 紐づく出品者を取得
     */
    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }
}
