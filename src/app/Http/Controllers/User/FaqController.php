<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

final class FaqController extends Controller
{
    public function index()
    {
        return view('user.faq.index');
    }
}
