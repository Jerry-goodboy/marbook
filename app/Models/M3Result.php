<?php
/**
 * @author : MartnLei
 * @version 1.0
 * @package M3Result.php
 * @time: 2016/2/28 12:32
 * @des:{返回的实体数据}
 */

namespace App\Models;


class M3Result
{
    public $message;//返回数据的消息
    public $status;//返回数据的状态

    /**
     * 将返回对象数据转换为json
     * @return string
     */
    public function toJson()
    {
        return json_encode($this, JSON_UNESCAPED_UNICODE);
    }
}