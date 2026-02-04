<?php

namespace App\Http\Controllers\User\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

final class RegisterController extends Controller
{
    public function index()
    {
        return view('user.seller.register.index');
    }
}
