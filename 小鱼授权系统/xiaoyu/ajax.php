<?php
include("../system/api.inc.php");
$act=isset($_GET['act'])?daddslashes($_GET['act']):null;

@header('Content-Type: application/json; charset=UTF-8');

switch($act){
case 'captcha':
	require_once SYSTEM_ROOT.'class.geetestlib.php';
	$GtSdk = new GeetestLib($conf['CAPTCHA_ID'], $conf['PRIVATE_KEY']);
	$data = array(
		'user_id' => isset($pid)?$pid:'public', # 网站用户id
		'client_type' => "web", # web:电脑上的浏览器；h5:手机上的浏览器，包括移动应用内完全内置的web_view；native：通过原生SDK植入APP应用的方式
		'ip_address' => $clientip # 请在此处传输用户请求验证时所携带的IP
	);
	$status = $GtSdk->pre_process($data, 1);
	$_SESSION['gtserver'] = $status;
	$_SESSION['user_id'] = isset($pid)?$pid:'public';
	echo $GtSdk->get_response_str();
break;
case 'sendcode':
	$email=daddslashes($_POST['email']);	
	$u_email = str_replace("@qq.com","",$email);
	$riw = $DB->get_row("SELECT * FROM auth_user WHERE dlqq='$u_email' limit 1");
    if(!$riw){
	exit('{"code":-1,"msg":"此邮箱未查询到是授权商,禁止登陆！"}');	   	
	}	
	$sub = '小鱼授权中心 - 登录验证码获取';
	$code = rand(11111,99999);
	@file_put_contents('./code/'.$code.'.log',$code);
	$msg = '您的验证码是：'.$code;		
	send_mail($email,$sub, $msg);
	exit('{"code":0,"msg":"发送成功'.$email.'"}');
break;
default:
	exit('{"code":-4,"msg":"No Act"}');
break;
}