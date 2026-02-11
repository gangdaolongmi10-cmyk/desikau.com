<?php

namespace App\Repositories;

use App\Models\Announcement;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * お知らせリポジトリ
 */
final class AnnouncementRepository
{
    /**
     * 公開中のお知らせを新着順でページネーション取得
     *
     * @param int $perPage 1ページあたりの件数
     */
    public function getPublishedPaginated(int $perPage = 10): LengthAwarePaginator
    {
        return Announcement::with('category')
            ->published()
            ->orderByDesc('published_at')
            ->paginate($perPage);
    }

    /**
     * お知らせをカテゴリ付きで取得
     */
    public function findWithCategory(Announcement $announcement): Announcement
    {
        $announcement->load('category');

        return $announcement;
    }
}
