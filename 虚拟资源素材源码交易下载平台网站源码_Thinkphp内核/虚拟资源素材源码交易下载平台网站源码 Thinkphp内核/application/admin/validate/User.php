<?php
namespace app\admin\validate;

use think\Validate;

class User extends Validate
{
    protected $rule = [
        'username'         => 'require|unique:user|min:2',
        'password'         => 'confirm:confirm_password|min:6',
        'confirm_password' => 'confirm:password',
        'mobile'           => 'number|length:11',
       'usermail'            => 'email|unique:user',
        'status'           => 'require',
    ];

    protected $message = [
        'username.require'         => '请输入用户名',
    		'username.min'         => '用户名至少2位',
        'username.unique'          => '用户名已存在',
        'password.confirm'         => '两次输入密码不一致',
    		'password.length'         => '密码不小于6位',
        'confirm_password.confirm' => '两次输入密码不一致',
        'mobile.number'            => '手机号格式错误',
        'mobile.length'            => '手机号长度错误',
        'usermail.email'              => '邮箱格式错误',
        'status.require'           => '请选择状态',
    		'usermail.unique'          => '邮箱已存在',
    ];
}