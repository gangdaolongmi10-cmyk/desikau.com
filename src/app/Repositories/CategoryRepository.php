<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

/**
 * カテゴリーリポジトリ
 */
final class CategoryRepository
{
    /**
     * コンストラクタ
     */
    public function __construct(
        private readonly Category $category
    ) {
    }

    /**
     * 有効なカテゴリー一覧を取得
     *
     * @return Collection<int, Category>
     */
    public function getList(): Collection
    {
        return $this->category
            ->active()
            ->orderBy('sort_no')
            ->get();
    }
}
