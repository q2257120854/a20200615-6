<?php
include("../system/api.inc.php");
error_reporting(0);

session_start();
header('Content-type: application/json');

$act=isset($_GET['do'])?daddslashes($_GET['do']):null;

switch($act){
case 'getyzm':
//    include("./Public/sendmail.php");
	$email=daddslashes($_GET['qq'].'@qq.com');	
	$u_email = str_replace("@qq.com","",$email);
	$riw = $DB->get_row("SELECT * FROM auth_site WHERE `uid`='$u_email' limit 1");
    if(!$riw){
	exit('{"code":-1,"msg":"此QQ未查询到是已授权的QQ,禁止获取！"}');	   	
	}	
	$sub = '圣羽云授权中心 - 源码下载申请验证码';
	$code = rand(1111,9999);
	@file_put_contents('./code/'.$code.'.log',$code);
	$msg = '您的验证码是：'.$code;		
	send_mail($email,$sub, $msg);
	exit('{"code":0,"msg":"发送成功'.$email.'"}');
break;
case 'checkyzm':
	$yzm=daddslashes($_GET['yzm']);	
	
	$log_file='./code/'.$yzm.'.log';
	if(file_exists($log_file))
	{
	exit('{"code":0,"msg":"验证成功,正在为你挑选下载路线！"}');
	}else{
	exit('{"code":-1,"msg":"验证码错误,确保验证码准确,否则无法下载源码！"}');		
	}
break;
default:
	exit('{"code":-4,"msg":"No Act"}');
break;
}