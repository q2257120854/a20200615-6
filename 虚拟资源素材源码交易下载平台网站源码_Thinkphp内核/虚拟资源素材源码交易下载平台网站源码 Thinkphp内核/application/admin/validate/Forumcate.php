<?php
namespace app\admin\validate;

use think\Validate;

class Forumcate extends Validate
{
    protected $rule = [
        'tid'  => 'require',
        'name' => 'require',
        'sort' => 'require|number'
    ];

    protected $message = [
        'tid.require'  => '请选择上级版块',
        'name.require' => '请输入版块名称',
        'sort.require' => '请输入排序',
        'sort.number'  => '排序只能填写数字'
    ];
}