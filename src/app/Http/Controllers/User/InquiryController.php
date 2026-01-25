<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

final class InquiryController extends Controller
{
    public function index(): View
    {
        return view('user.inquiry.index');
    }
}
