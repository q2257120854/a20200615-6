<?php
namespace app\admin\validate;

use think\Validate;

class Hooks extends Validate
{
    protected $rule = [
        'name'         => 'require|unique:hooks',
        'description'            => 'require',
    ];

    protected $message = [
        'name.require'         => '请输入钩子名称',
        'name.unique'          => '钩子名称已存在',
        'description.require'           => '请输入钩子描述',
    ];
}