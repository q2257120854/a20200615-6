<?php
return array(
	//'配置项'=>'配置值'
	'APP_GROUP_LIST'           =>  'Index,systemlogined',
	'DEFAULT_GROUP'            =>  'Index',
	'TMPL_VAR_IDENTIFY'        =>  'array',
    //URL设置
    'URL_MODEL'                 => 1,
    //设置独立分组
    'APP_GROUP_MODE'            =>  1,          //启用独立分组
    'APP_GROUP_MODE`ROUP_PATH'            =>  'Modules',
	 /* 数据库设置 */
    'DB_TYPE'               =>  'mysql',        // 数据库类型
    'DB_HOST'               =>  '127.0.0.1',    // 服务器地址
    'DB_NAME'               =>  'wakuang',   // 数据库名
    'DB_USER'               =>  'root',         // 用户名
    'DB_PWD'                =>  'root',             // 密码
    'DB_PORT'               =>  '3306',         // 端口
    'DB_PREFIX'             =>  'ds_',          // 数据库表前缀
    'SESSION_TYPE'          =>  'Db',           //将session写入数据库
	
    // 缓存类型为File
    'type'  =>  'File', 
    // 缓存有效期为永久有效
    'expire'=>  0, 
    //缓存前缀
    'prefix'=>  'shop',
	
		/* 无法加载模块错误补丁 */
	'URL_CASE_INSENSITIVE'  => true,         //不区分大小写
    //多语言配置
    'LANG_SWITCH_ON'        => true,
    'LANG_AUTO_DETECT' => true, // 自动侦测语言 开启多语言功能后有效
    'DEFAULT_LANG' => 'zh-cn', // 默认语言
    'LANG_LIST'        => 'zh-cn,zh-tw,en-us', // 允许切换的语言列表 用逗号分隔
    'VAR_LANGUAGE'     => 'l', // 默认语言切换变量
	'VAR_FILTERS'	=>	'stripslashes,strip_tags,htmlspecialchars',
    //调试信息显示
    'SHOW_PAGE_TRACE'       =>    false,        // 显示页面Trace信息
    //公司名称
    'COMPANY_NAME'          =>  'FC',
    //加载扩展配置
    'LOAD_EXT_CONFIG'       => 'system,tuopu,tuopuq,tuopu1,tuopu2',
    'API_URL'               => "http://".$_SERVER['HTTP_HOST']    //$_SERVER['HTTP_HOST']
);
?>