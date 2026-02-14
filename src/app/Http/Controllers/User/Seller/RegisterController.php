<?php

namespace App\Http\Controllers\User\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

final class RegisterController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        // @phpstan-ignore-next-line view-string型の厳格なチェックを無視
        return view('user.seller.register.index');
    }
}
