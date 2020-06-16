<?php
namespace app\common\model;

use think\Model;
use think\Session;

class Forum extends Model
{
    protected $insert = ['time'];

   

    /**
     * 反转义HTML实体标签
     * @param $value
     * @return string
     */
    protected function setContentAttr($value)
    {
        return htmlspecialchars_decode($value);
    }




    /**
     * 创建时间
     * @return bool|string
     */
    protected function setTimeAttr()
    {
        return time();
    }
}