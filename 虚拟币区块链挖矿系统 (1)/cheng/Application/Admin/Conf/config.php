<?php
return array(
	//'配置项'=>'配置值'
    'SHOW_PAGE_TRACE' =>true,


    //权限验证设置
    'AUTH_CONFIG'=>array(
        'AUTH_ON' => true, //认证开关
        'AUTH_TYPE' => 1, // 认证方式，1为时时认证；2为登录认证。
        'AUTH_GROUP' => 'ds_auth_group', //用户组数据表名
        'AUTH_GROUP_ACCESS' => 'ds_auth_group_access', //用户组明细表
        'AUTH_RULE' => 'ds_auth_rule', //权限规则表
        'AUTH_USER' => 'ds_member'//用户信息表
    ),

    //超级管理员uid array( uid列表 )
    'ADMINISTRATOR'=>array('1','2'),
);
