<?php
namespace app\common\model;

use think\Model;
use think\Session;

class Sms extends Model
{
    protected $insert = ['created_at'];


    /**
     * 创建时间
     * @return bool|string
     */
    protected function setCreatedAtAttr()
    {
        return date('Y-m-d H:i:s',time());
    }
}