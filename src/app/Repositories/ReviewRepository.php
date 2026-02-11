<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Database\Eloquent\Collection;

/**
 * レビューリポジトリ
 */
final class ReviewRepository
{
    /**
     * 商品のレビューをユーザー情報付きで新着順に取得
     *
     * @return Collection<int, Review>
     */
    public function getByProduct(Product $product): Collection
    {
        return $product->reviews()
            ->with('user')
            ->orderByDesc('created_at')
            ->get();
    }

    /**
     * レビュー統計を計算
     *
     * @param Collection<int, Review> $reviews
     * @return array{average: float, count: int, distribution: array<int, array{count: int, percentage: int}>}
     */
    public function calculateStats(Collection $reviews): array
    {
        $count = $reviews->count();

        if ($count === 0) {
            return [
                'average' => 0,
                'count' => 0,
                'distribution' => [
                    5 => ['count' => 0, 'percentage' => 0],
                    4 => ['count' => 0, 'percentage' => 0],
                    3 => ['count' => 0, 'percentage' => 0],
                    2 => ['count' => 0, 'percentage' => 0],
                    1 => ['count' => 0, 'percentage' => 0],
                ],
            ];
        }

        $average = round($reviews->avg('rating'), 1);

        $distribution = [];
        for ($i = 5; $i >= 1; $i--) {
            $ratingCount = $reviews->where('rating', $i)->count();
            $distribution[$i] = [
                'count' => $ratingCount,
                'percentage' => round(($ratingCount / $count) * 100),
            ];
        }

        return [
            'average' => $average,
            'count' => $count,
            'distribution' => $distribution,
        ];
    }
}
