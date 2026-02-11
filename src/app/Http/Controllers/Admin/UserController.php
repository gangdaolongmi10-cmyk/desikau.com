<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * 管理画面ユーザー管理コントローラー
 */
final class UserController extends Controller
{
    /**
     * ユーザー一覧を表示
     */
    public function index(Request $request): View
    {
        $query = User::withTrashed()->with('seller');

        // キーワード検索
        $keyword = $request->query('keyword');
        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                  ->orWhere('email', 'like', "%{$keyword}%");
            });
        }

        // ステータスフィルター
        $status = $request->query('status');
        if ($status === 'active') {
            $query->whereNull('deleted_at');
        } elseif ($status === 'deleted') {
            $query->whereNotNull('deleted_at');
        }

        $users = $query->orderByDesc('created_at')->paginate(20);
        $users->appends($request->only(['keyword', 'status']));

        // 統計
        $totalCount = User::withTrashed()->count();
        $activeCount = User::count();
        $deletedCount = User::onlyTrashed()->count();

        return view('admin.user.index', compact(
            'users',
            'keyword',
            'status',
            'totalCount',
            'activeCount',
            'deletedCount',
        ));
    }
}
