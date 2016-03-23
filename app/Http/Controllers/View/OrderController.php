<?php
/**
 * @author : MartnLei
 * @version 1.0
 * @package OrderController.php
 * @time: 2016/3/22 22:20
 * @des:{}
 */

namespace app\Http\Controllers\View;


use App\Entity\CartItem;
use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * 获取订单详情
     * @param Request $request
     */
    public function toOrderList(Request $request)
    {
        //获取成员
        $member = $request->session()->get('member', '');
        $orders = Order::where('member_id', $member->id)->get();//获取和用户相关的订单

    }

    /**
     * 提交订单界面
     * @param Request $request
     */
    public function toOrderCommit(Request $request)
    {
        //获取提交的商品id
        $product_ids = $request->input('product_ids', '');

        $product_ids_arr = ($product_ids!='' ? explode(',', $product_ids) : array());

        $member = $request->session()->get('member', '');
        //查询购物车中得相关信息
        $cart_items = CartItem::where('member_id', $member->id)->whereIn('product_id', $product_ids_arr)->get();
        //创建一个订单
        $order = new Order;
        $order->member_id = $member->id;
        $order->save();

        //返回给界面显示的
        $cart_items_arr = array();
        $cart_items_ids_arr = array();
        //总的价格
        $total_price = 0;
        $name = '';

        foreach ($cart_items as $cart_item) {
            $cart_item->product = Product::find($cart_item->product_id);
            if($cart_item->product != null) {
                $total_price += $cart_item->product->price * $cart_item->count;
                $name .= ('《'.$cart_item->product->name.'》');
                array_push($cart_items_arr, $cart_item);
                array_push($cart_items_ids_arr, $cart_item->id);

                //生成订单的组成
                $order_item = new OrderItem;
                $order_item->order_id = $order->id;
                $order_item->product_id = $cart_item->product_id;
                $order_item->count = $cart_item->count;
                $order_item->pdt_snapshot = json_encode($cart_item->product);//保存商品快照
                $order_item->save();
            }
        }

        //生成订单---删除购物车中数据
        CartItem::whereIn('id', $cart_items_ids_arr)->delete();

        $order->name = $name;
        $order->total_price = $total_price;
        $order->order_no = 'E'.time().''.$order->id;
        $order->save();


        return view('order_commit')->with('cart_items', $cart_items_arr)
            ->with('total_price', $total_price)
            ->with('name', $name)
            ->with('order_no', $order->order_no);
    }
}