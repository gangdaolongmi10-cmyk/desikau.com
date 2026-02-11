<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AnnouncementStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AnnouncementRequest;
use App\Models\Announcement;
use App\Models\AnnouncementCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * 管理画面お知らせ管理コントローラー
 */
final class AnnouncementController extends Controller
{
    /**
     * お知らせ一覧を表示
     */
    public function index(Request $request): View
    {
        $query = Announcement::with('category');

        // ステータスフィルター
        $status = $request->query('status');
        if ($status && AnnouncementStatus::tryFrom($status)) {
            $query->where('status', $status);
        }

        $announcements = $query->orderByDesc('created_at')->paginate(20);
        $announcements->appends($request->only('status'));

        return view('admin.announcement.index', compact('announcements', 'status'));
    }

    /**
     * 作成フォームを表示
     */
    public function create(): View
    {
        $categories = AnnouncementCategory::orderBy('sort_order')->get();

        return view('admin.announcement.create', compact('categories'));
    }

    /**
     * お知らせを保存
     */
    public function store(AnnouncementRequest $request): RedirectResponse
    {
        Announcement::create($request->validated());

        return redirect()
            ->route('admin.announcement.index')
            ->with('success', 'お知らせを作成しました。');
    }

    /**
     * 編集フォームを表示
     */
    public function edit(Announcement $announcement): View
    {
        $categories = AnnouncementCategory::orderBy('sort_order')->get();

        return view('admin.announcement.edit', compact('announcement', 'categories'));
    }

    /**
     * お知らせを更新
     */
    public function update(AnnouncementRequest $request, Announcement $announcement): RedirectResponse
    {
        $announcement->update($request->validated());

        return redirect()
            ->route('admin.announcement.index')
            ->with('success', 'お知らせを更新しました。');
    }

    /**
     * お知らせを削除
     */
    public function destroy(Announcement $announcement): RedirectResponse
    {
        $announcement->delete();

        return redirect()
            ->route('admin.announcement.index')
            ->with('success', 'お知らせを削除しました。');
    }
}
