<?php

namespace App\View\Components\User\Ui;

use App\Repositories\CategoryRepository;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

/**
 * カテゴリーフィルターコンポーネント
 */
final class CategoryFilter extends Component
{
    /**
     * カテゴリー一覧
     */
    public readonly Collection $categories;

    /**
     * 選択中のカテゴリーID
     */
    public readonly ?int $selectedCategory;

    /**
     * コンストラクタ
     */
    public function __construct(
        CategoryRepository $categoryRepository,
        ?int $selectedCategory = null
    ) {
        $this->categories = $categoryRepository->getList();
        $this->selectedCategory = $selectedCategory;
    }

    /**
     * コンポーネントのビューを取得
     */
    public function render(): View|Closure|string
    {
        return view('components.user.ui.category-filter');
    }
}
