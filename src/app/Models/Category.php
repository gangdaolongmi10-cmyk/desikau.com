<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Models\Traits\HasActiveScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * カテゴリーモデル
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $sort_no
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder active() 有効なレコードのみ取得
 * @method static Builder inactive() 無効なレコードのみ取得
 *
 * @package App\Models
 */
class Category extends Model
{
    use HasFactory;
    use HasActiveScope;

    protected $table = 'categories';

    protected $casts = [
        'sort_no' => 'int',
        'is_active' => 'bool',
    ];

    protected $fillable = [
        'name',
        'slug',
        'sort_no',
        'is_active',
    ];
}
