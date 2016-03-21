<?php

namespace App\Http\Controllers\Service;


use App\Entity\CartItem;
use App\Http\Controllers\Controller;
use App\Models\M3Result;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function addCart(Request $request,$product_id)
    {
        $m3_result = new M3Result;
        $m3_result->status = 0;
        $m3_result->message = '添加成功';

        //判断用户是否登录
        $member = $request->session()->get('member','');
        if ($member != '') {
            $cartItems = CartItem::where('member_id',$member->id)-get();
            $exit = false;
            //判断当前添加商品在用户的购物车中是否存在
            foreach ($cartItems as $cartItem) {
                if ($cartItem->product_id == $product_id) {
                    //存在--则添加增加购物车中的数量
                    $exit = true;
                    $cartItem->count ++;
                    $cartItem->save();
                    break;
                }
            }

            if (!$exit) {
                //不存在
                $cart_item = new CartItem;
                $cartItem->product_id = $product_id;
                $cartItem->count = 1;
                $cart_item->member_id = $member->id;
                $cartItem->save();

            }
            //登录状态无需处理session中---直接处理用户数据库中得数据
            return $m3_result->toJson();
        }
        //处理非登录得状态
        //从cookie中取出---之前添加购物车信息
        $bk_cart = $request->cookie('bk_cart');
        $bk_cart_arr = ($bk_cart !=null ? explode(',',$bk_cart):array());

        $count = 1;//记录购物车数量的变化--没有变化的--即在之前的cookie中没有记录
        foreach ($bk_cart_arr as &$value) {//传引用
            //对value处理--判断":"的位置
            $index = strpos($value, ':');
            //取出--key:value各自的值
            if (substr($value, 0, $index) == $product_id) {
                $count = ((int) substr($value, $index+1)) + 1;
                //修改对应数组中得值
                $value = $product_id.':'.$count;
                break;
            }
        }
        if ($count == 1) {
            //表示之前的记录中并没有当前商品---将商品添加到数组末尾
            array_push($bk_cart_arr,$product_id.':'.$count);
        }
        //最后组合返回数据--传入cookie
        return response($m3_result->toJson())->withCookie('bk_cart',implode(',',$bk_cart_arr));
    }

    public function removeCart(Request $request){
        $m3_result = new M3Result;
        $m3_result->status = 0;
        $m3_result->message = '删除成功';

        $product_ids = $request->input('product_ids', '');
        if($product_ids == '') {
            $m3_result->status = 1;
            $m3_result->message = '书籍ID为空';
            return $m3_result->toJson();
        }
        $product_ids_arr = explode(',', $product_ids);

        $member = $request->session()->get('member', '');
        if($member != '') {
            // 已经登录在数据库中删除对应的--商品
            CartItem::whereIn('product_id', $product_ids_arr)->delete();
            return $m3_result->toJson();
        }

        //没有登录---重cookie中取出购物车
        $bk_cart = $request->cookie('bk_cart');
        $bk_cart_arr = ($bk_cart!=null ? explode(',', $bk_cart) : array());
        foreach ($bk_cart_arr as $key => $value) {
            $index = strpos($value, ':');
            $product_id = substr($value, 0, $index);
            //裁剪数组--删除
            if(in_array($product_id, $product_ids_arr)) {
                array_splice($bk_cart_arr, $key, 1);
                continue;
            }
        }

        return response($m3_result->toJson())->withCookie('bk_cart', implode(',', $bk_cart_arr));
    }
}
