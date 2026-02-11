<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Repositories\AnnouncementRepository;
use Illuminate\Contracts\View\View;

/**
 * お知らせコントローラー
 */
final class AnnouncementController extends Controller
{
    public function __construct(
        private readonly AnnouncementRepository $announcementRepository
    ) {}

    /**
     * お知らせ一覧を表示
     */
    public function index(): View
    {
        $announcements = $this->announcementRepository->getPublishedPaginated();

        return view('user.announcement.index', compact('announcements'));
    }

    /**
     * お知らせ詳細を表示
     */
    public function show(Announcement $announcement): View
    {
        if (!$announcement->isPublished()) {
            abort(404);
        }

        $announcement = $this->announcementRepository->findWithCategory($announcement);

        return view('user.announcement.show', compact('announcement'));
    }
}
