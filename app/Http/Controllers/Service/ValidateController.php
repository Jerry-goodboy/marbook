<?php

namespace App\Http\Controllers\Service;

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

    }
}
