<?php
//error_reporting(E_ALL); ini_set("display_errors", 1);
error_reporting(0);
define('IN_CRONLITE', true);
define('ROOT', dirname(__FILE__).'/');
define('TEMPLATE_ROOT', ROOT.'/template/');
define('SYS_KEY', 'miaozanba0101');

date_default_timezone_set("PRC");
$date = date("Y-m-d H:i:s");
session_start();

if(is_file(ROOT.'360safe/360webscan.php')){//360网站卫士
    require_once(ROOT.'360safe/360webscan.php');
}

$scriptpath=str_replace('\\','/',$_SERVER['SCRIPT_NAME']);
$sitepath = substr($scriptpath, 0, strrpos($scriptpath, '/'));
$siteurl = ($_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://').$_SERVER['HTTP_HOST'].$sitepath.'/';

require ROOT.'config.php';

if(!isset($port))$port='3306';
//连接数据库
include_once(ROOT."db.class.php");
$DB=new DB($host,$user,$pwd,$dbname,$port);
$conf=$DB->get_row("SELECT * FROM auth_config WHERE id='1' limit 1");//获取系统配置
$password_hash='!@#%!s!';
include ROOT."function.php";
include_once ROOT.'/smtp.class.php';
include ROOT."member.php";


?>