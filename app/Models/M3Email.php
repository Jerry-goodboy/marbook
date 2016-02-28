<?php
/**
 * @author : MartnLei
 * @version 1.0
 * @package M3Email.php
 * @time: 2016/2/28 12:35
 * @des:{邮件信息视图类---返回}
 */

namespace App\Models;


class M3Email
{
    public $from;  // 发件人邮箱
    public $to; // 收件人邮箱
    public $cc; // 抄送
    public $attach; // 附件
    public $subject; // 主题
    public $content; // 内容

}