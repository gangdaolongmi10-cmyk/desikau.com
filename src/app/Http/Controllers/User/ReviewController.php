<?php

namespace App\Http\Controllers\User;

use App\Actions\User\DestroyReviewAction;
use App\Actions\User\StoreReviewAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\ReviewRequest;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

/**
 * レビューコントローラー
 */
final class ReviewController extends Controller
{
    /**
     * レビューを投稿
     */
    public function store(ReviewRequest $request, Product $product, StoreReviewAction $action): RedirectResponse
    {
        $result = $action->execute(Auth::user(), $product, $request->validated());

        return back()->with($result['success'] ? 'success' : 'error', $result['message']);
    }

    /**
     * レビューを削除
     */
    public function destroy(Product $product, Review $review, DestroyReviewAction $action): RedirectResponse
    {
        $result = $action->execute(Auth::user(), $review);

        return back()->with($result['success'] ? 'success' : 'error', $result['message']);
    }
}
