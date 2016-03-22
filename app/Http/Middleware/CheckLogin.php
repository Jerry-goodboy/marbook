<?php
/**
 * @author : MartnLei
 * @version 1.0
 * @package CheckLogin.php
 * @time: 2016/3/22 22:48
 * @des:{}
 */

namespace app\Http\Middleware;


use Closure;

class CheckLogin
{
    public function handle($request, Closure $next)
    {
        $member = $request->session()->get('member', '');
        if($member == '') {
            $return_url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            return redirect('/login?return_url=' . urlencode($return_url));
        }

        return $next($request);
    }
}