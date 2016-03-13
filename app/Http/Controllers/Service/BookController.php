<?php

namespace App\Http\Controllers\Service;


use App\Entity\Category;
use App\Http\Controllers\Controller;
use App\Models\M3Result;

class BookController extends Controller
{
    public function getCategoryByParentId($parent_id)
    {
        $categorys = Category::where('parent_id', $parent_id)->get();//查询父类别
        $result = new M3Result();
        $result->message = "返回成功";
        $result->status = '0';
        $result->categorys = $categorys;
        return $result->toJson();
    }

    public function toRegister($value='')
    {
        return view('register');
    }
}
