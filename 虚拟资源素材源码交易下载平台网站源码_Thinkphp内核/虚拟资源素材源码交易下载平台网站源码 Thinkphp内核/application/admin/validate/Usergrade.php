<?php
namespace app\admin\validate;

use think\Validate;

class Usergrade extends Validate
{
    protected $rule = [
        'name'         => 'require|unique:usergrade',
       'score'            => 'number|unique:usergrade',
   
    ];

    protected $message = [
        'name.require'         => '请输入会员等级名',
   
        'name.unique'          => '会员等级名已存在',
  
        'score.number'           => '积分必为整数',
    		'score.unique'          => '积分不能跟其他重复',
    ];
}