<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

final class ProductController extends Controller
{
    public function detail(string $slug)
    {
        return view('user.product.detail');
    }
}
