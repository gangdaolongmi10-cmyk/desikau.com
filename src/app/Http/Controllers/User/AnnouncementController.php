<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Contracts\View\View;

/**
 * お知らせコントローラー
 */
final class AnnouncementController extends Controller
{
    /**
     * お知らせ一覧を表示
     */
    public function index(): View
    {
        $announcements = Announcement::with('category')
            ->published()
            ->orderByDesc('published_at')
            ->paginate(10);

        return view('user.announcement.index', compact('announcements'));
    }

    /**
     * お知らせ詳細を表示
     */
    public function show(Announcement $announcement): View
    {
        // 公開中でない場合は404
        if (!$announcement->isPublished()) {
            abort(404);
        }

        $announcement->load('category');

        return view('user.announcement.show', compact('announcement'));
    }
}
