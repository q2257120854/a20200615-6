<?php 
$mod='blank';
include("../api.inc.php");
$siteurl = ($_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://') . $_SERVER['HTTP_HOST']. '/';//获取本地域名
$allapi	 ='http://www.qqmzz.cn/';//QQ快捷登录API地址
class Oauth
{
    function __construct()
    {
        global $siteurl;
        $this->callback = $siteurl . 'syyun/social.php';//登录回调地址
    }
    public function login()
    {
        global $allapi;
		
		//-------生成唯一随机串防CSRF攻击
        $state = md5(uniqid(rand(), TRUE));
		
		setcookie("Oauth_state",$state,time()+600,'/');
		
        $keysArr = array("redirect_uri" => $this->callback, "state" => $state);
		
        $login_url = $allapi . 'qqlogin/qqlogin.php?' . http_build_query($keysArr);
		
		header("Location:{$login_url}");
		
	    }
    public function callback()
    {
        global $allapi;
		
		//--------验证state防止CSRF攻击
		if ($_GET['state'] != $_COOKIE['Oauth_state']) {
			
         echo"<h2>The state does not match. You may be a victim of CSRF.</h2>";
		 
		}else{
			
        $keysArr = array("code" =>$_GET['code'], "state" =>$_COOKIE['Oauth_state'], "key" =>"zero2109877665");
		
        $token_url = $allapi . 'qqlogin/qqlogin.php?' . http_build_query($keysArr);
		
        $response = file_get_contents($token_url);
		
        $arr = json_decode($response, true);
		
        if ($arr['code']!=1) {
			
         echo'<h3>msg  :</h3>' . $arr['msg'];
        }		
        return $arr;
		}
    }
}
$Oauth = new Oauth();
header("Content-Type: text/html; charset=UTF-8");
if ($_GET['code']) {
    $array = $Oauth->callback();
    $social_uid	  	=	 $array['social_uid'];//固定值 可作为账号
    $access_token 	=	 $array['access_token'];//固定值 可作为密码
    $gender		  	=	 $array['gender'];//性别
	$nickname	 	=	 $array['nickname'];//QQ名称
    $figureurl_qq_1 =	 $array['figureurl_qq_1'];//大小为40×40像素的QQ头像URL
    $figureurl_qq_2	=	 $array['figureurl_qq_2'];//[大小为100×100像素的QQ头像URL。不是所有的用户都拥有QQ的100×100的头像。]
	$vip	 	 	=	 $array['vip'];//标识用户是否为黄钻用户（0：不是；1：是）
    $level			=	 $array['level'];//黄钻等级
	$is_yellow_year_vip= $array['is_yellow_year_vip'];//标识是否为年费黄钻用户（0：不是； 1：是）

	$row = $DB->get_row("SELECT * FROM auth_user WHERE token='$access_token' limit 1");
	if($row['token']=='') {
		@header('Content-Type: text/html; charset=UTF-8');
		exit("<script language='javascript'>alert('该QQ未绑定用户！');history.go(-1);</script>");
	}elseif($row['token']==$access_token){
		$user=$row['user'];
		$pass=$row['pass'];
		$session=md5($user.$pass.$password_hash);
		$token=authcode("{$user}\t{$session}", 'ENCODE', SYS_KEY);
		setcookie("auth_token", $token, time() + 604800);
		@header('Content-Type: text/html; charset=UTF-8');
		$city=get_ip_city($clientip);
		$DB->query("insert into `auth_log` (`uid`,`type`,`date`,`city`,`data`) values ('".$user."','登陆平台','".$date."','".$city."','IP:".$clientip."')");
		exit("<script language='javascript'>alert('登陆授权平台成功！');window.location.href='./';</script>");
	}
} else {
	
    $Oauth->login();
}