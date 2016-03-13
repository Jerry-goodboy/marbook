<?php

namespace App\Http\Controllers\View;


use App\Entity\Category;
use App\Entity\Product;
use App\Http\Controllers\Controller;

class BookController extends Controller
{
    public function toCategory($value='')
    {
        $categorys = Category::whereNull('parent_id')->get();//查询父类别
        return view('category')->with('categorys',$categorys);
    }

    public function productByCategoryId($category_id)
    {
        $products = Product::where('category_id',$category_id)->get();
        return view('produces')-with('$products',$products);
    }
}
