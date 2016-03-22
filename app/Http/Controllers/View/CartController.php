<?php

namespace App\Http\Controllers\View;


use App\Entity\CartItem;
use App\Entity\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartController extends Controller
{

    /**
     * 到购物车界面
     * @param Request $request
     */
    public function toCart(Request $request){
        $cart_items = array();
        //获取cookie中的item
        $bk_cart = $request->cookie('bk_cart');
        $bk_cart_arr = $bk_cart!=''? explode(",",$bk_cart):array();

        //判断是否登录
        $member = $request->session()->get("member",'');
        if ($member != '') {
            //登录
            $cart_items = $this->syncCart($member->id,$bk_cart_arr);
            return response()->view('cart',['cart_items'=>$cart_items])->withCookie('bk_cart', null);
        }

        //未登录
        foreach ($bk_cart_arr as $key => $value) {
            $index = strpos($value, ':');
            $cart = new CartItem;
            $cart->id = $key;
            $cart->product_id = substr($value, 0, $index);
            $cart->count = (int) substr($value, $index+1);
            $cart->product = Product::find($cart->product_id);
            if($cart->product != null) {
                array_push($cart_items, $cart);
            }
        }
        return view('cart')->with('cart_items', $cart_items);
    }

    public function syncCart($id,$bk_cart_arr)
    {
        $cart_items = CartItem::where('member_id',$id)->get();//数据库中查出对应用户在数据库中的购物车

        $cart_items_arr = array();//存放购物车数据

        foreach ($bk_cart_arr as $bk_cart_item) {
            //获取每一个key--value--string
            $index = strpos($bk_cart_item,':');
            $product_id = substr($bk_cart_item,0,$index);
            $count = substr($bk_cart_item,$index+1);

            $exist = false;
            //比较在数据库中是否存在--更新数据库
            foreach ($cart_items as $cart) {
                if ($cart->product_id == $product_id) {
                    $exist = true;
                    //取两者中大的
                    if ($cart->count < $count) {
                        $cart->count = $count;
                        $cart->save();
                    }
                    break;
                }
            }

            //如果没有在数据库中--创建新的数据库记录
            if (!$exist) {
                $cart = new CartItem;
                $cart->product_id = $product_id;
                $cart->member_id = $id;
                $cart->count = $count;
                $cart->save();
                $cart->product = Product::find($cart->product_id);
                array_push($cart_items_arr,$cart);
            }
        }

        foreach ($cart_items as $cart) {
            $cart->product = Product::find($cart->product_id);
            array_push($cart_items_arr,$cart);
        }
        return $cart_items_arr;
    }
}
