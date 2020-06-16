<?php
namespace app\admin\validate;

use think\Validate;

class AddonsDelName extends Validate
{
    protected $rule = [
        'addon_name'         => [
            'require',
            'regex'=> '/^[a-zA-Z0-9_]+$/i'
        ]
            //'|unique:user|min:2',
    ];

    protected $message = [
        'addon_name.require'         => '请输入插件名称',
        'addon_name.regex'         => '插件名称错误',
    ];
}