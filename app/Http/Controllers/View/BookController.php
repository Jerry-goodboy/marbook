<?php

namespace App\Http\Controllers\View;


use App\Entity\Category;
use App\Http\Controllers\Controller;

class BookController extends Controller
{
    public function toCategory($value='')
    {
        $categorys = Category::whereNull('parent_id')->get();//查询父类别
        return view('category')->with('categorys',$categorys);
    }

    public function toRegister($value='')
    {
        return view('register');
    }
}
