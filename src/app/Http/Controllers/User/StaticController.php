<?php

namespace App\Http\Controllers\User;

use App\Enums\StaticPage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

final class StaticController extends Controller
{
    public function index(Request $request, string $slug)
    {
        if (StaticPage::tryFrom($slug) === null) {
            abort(404);
        }

        return view("user.static.$slug");
    }
}
