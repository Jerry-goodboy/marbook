<?php

namespace App\Http\Controllers\Service;

use app\Entity\TempPhone;
use App\Models\M3Result;
use App\Tool\SMS\SendTemplateSMS;
use App\Tool\Validate\ValidateCode;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ValidateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * 生成验证码图片
     * @param Request $request
     */
    public function create(Request $request)
    {
        $validateCode = new ValidateCode();
        //验证码---数据生成传入session
        $request->session()->put('validate_code', $validateCode->getCode());
        //服务器端生成验证码图片
        $validateCode->doimg();
    }

    /**
     * 发送短信
     * @param Request $request
     */
    public function sendSMS(Request $request)
    {
        //json数据返回
        $m3_result = new M3Result;
        $phone = $request->input('phone', '');
        if($phone == '') {
            $m3_result->status = 1;
            $m3_result->message = '手机号不能为空';
            return $m3_result->toJson();
        }
        if(strlen($phone) != 11 || $phone[0] != '1') {
            $m3_result->status = 2;
            $m3_result->message = '手机格式不正确';
            return $m3_result->toJson();
        }
        //短信发送
        $sendTemplateSMS = new SendTemplateSMS;
        $code = '';
        $charset = '1234567890';

        $_len = strlen($charset) - 1;
        for ($i = 0;$i < 6;++$i) {
            $code .= $charset[mt_rand(0, $_len)];
        }
        //生成验证码--的代码

        $m3_result = $sendTemplateSMS->sendTemplateSMS($phone,array($code, 60),1);
        if ($m3_result->status == 0) {
            $tempPhone = TempPhone::where('phone',$phone)->first();
            if ($tempPhone == null) {
                $tempPhone = new TempPhone;
            }
            $tempPhone->phone = $phone;
            $tempPhone->code = $code;
            $tempPhone->deadline = date('Y-m-d H-i-s',time()+60*60);//过期时间---60分钟后过期
            $tempPhone->save();
        }
        return $m3_result->toJson();
    }
}
