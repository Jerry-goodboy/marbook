<?php

namespace App\Http\Controllers\View;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MemberController extends Controller
{
    public function toLogin($value='')
    {
        return view('login');
    }

    public function toRegister($value='')
    {
        return view('register');
    }
}
