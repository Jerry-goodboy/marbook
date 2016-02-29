<?php
/**
 * @author : MartnLei
 * @version 1.0
 * @package TempPhone.php
 * @time: 2016/2/28 22:28
 * @des:{短信验证码记录}
 */

namespace app\Entity;


use Illuminate\Database\Eloquent\Model;

class TempPhone extends Model
{
    protected $table = 'temp_phone';
    protected $primaryKey = 'id';
    public $timestamps = false;

}