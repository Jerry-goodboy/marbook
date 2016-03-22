<?php

namespace App\Http\Controllers\View;

use Barryvdh\Debugbar\Middleware\Debugbar;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MemberController extends Controller
{
    public function toLogin(Request $value)
    {
        $return_url = $value->input("return_url",'');
        return view('login')->with("return_url",urldecode($return_url));
    }

    public function toRegister($value='')
    {
        return view('register');
    }
}
