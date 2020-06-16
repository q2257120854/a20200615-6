<?php
return array(
//*************************************数据库设置*************************************
    'DB_TYPE'               =>  'mysqli',                 // 数据库类型
    'DB_HOST'               =>  '127.0.0.1',     // 服务器地址
    'DB_NAME'               =>  'h5app_360',     // 数据库名
    'DB_USER'               =>  'h5app_360',     // 用户名
    'DB_PWD'                =>  'h5app_360',      // 密码
    'DB_PORT'               =>  '3306',     // 端口
    'DB_PREFIX'             =>  'bc_',   // 数据库表前缀
	// URL地址不区分大小写
	'URL_CASE_INSENSITIVE' => true,
	//REWRITE模式
	'URL_MODEL'=>'2',
	'MODULE_ALLOW_LIST'    =>    array('Home','Houtai','App','Index'),
	'DEFAULT_MODULE'       =>    'Index',
);