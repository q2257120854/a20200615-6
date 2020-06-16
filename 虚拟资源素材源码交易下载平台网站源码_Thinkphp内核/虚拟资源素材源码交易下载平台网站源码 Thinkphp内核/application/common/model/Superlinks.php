<?php
namespace app\common\model;

use think\Model;
use think\Session;

class Superlinks extends Model
{
    protected $insert = ['create_time'];

   

    /**
     * 创建时间
     * @return bool|string
     */
    protected function setCreateTimeAttr()
    {
        return time();
    }

}