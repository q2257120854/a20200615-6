<?php
if(!defined('IN_CRONLITE'))exit();

$my=isset($_GET['my'])?$_GET['my']:null;

$clientip=$_SERVER['REMOTE_ADDR'];

if(isset($_COOKIE["auth_token"]))
{
	$token=authcode(daddslashes($_COOKIE['auth_token']), 'DECODE', SYS_KEY);
	list($user, $sid) = explode("\t", $token);
	$udata = $DB->get_row("SELECT * FROM auth_user WHERE user='$user' limit 1");
	$session=md5($udata['user'].$udata['pass'].$password_hash);
	if($session==$sid) {
		$DB->query("UPDATE auth_user SET last='$date',dlip='$clientip' WHERE user = '$user'");
		$islogin=1;
		if($udata['active']==0){
			@header('Content-Type: text/html; charset=UTF-8');
			exit('您的授权平台账号已被封禁！联系QQ2081636709，询问原因');
		}
	}
}
?>