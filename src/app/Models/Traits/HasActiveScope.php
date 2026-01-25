<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

/**
 * is_activeカラムによる絞り込みスコープを提供するトレイト
 */
trait HasActiveScope
{
    /**
     * 有効なレコードのみ取得
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * 無効なレコードのみ取得
     */
    public function scopeInactive(Builder $query): Builder
    {
        return $query->where('is_active', false);
    }
}
