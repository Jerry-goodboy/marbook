<?php
/**
 * @author : MartnLei
 * @version 1.0
 * @package OrderController.php
 * @time: 2016/3/22 22:20
 * @des:{}
 */

namespace app\Http\Controllers\View;


use App\Entity\Order;
use Illuminate\Http\Request;

class OrderController
{
    /**
     * 获取订单详情
     */
    public function toOrderList(Request $request)
    {
        //获取成员
        $member = $request->session()->get('member', '');
        $orders = Order::where('member_id', $member->id)->get();//获取和用户相关的订单

    }
}