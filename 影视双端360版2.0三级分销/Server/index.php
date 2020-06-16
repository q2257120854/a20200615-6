<?php
header("Content-Type: text/html;charset=utf-8");
if(file_exists("./Public/install") && !file_exists("./Public/install/install.lock")){
 $url1 = $_SERVER['HTTP_HOST'].trim($_SERVER['SCRIPT_NAME'],'index.php').'Public/install/index.php';
   header("Location:http://$url1");
   die;
}
//授权结束
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 7.0.0 !');
//开启调试模式
define("APP_DEBUG",true);

//定义当前项目应用目录
define("APP_PATH","./Application/");

//导入框架入口文件
require("./ThinkPHP/ThinkPHP.php");