<?php
$mod='blank';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
$siteurl = ($_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://') . $_SERVER['HTTP_HOST']. '/';
$allapi	 ='http://www.qqmzz.cn/';
class Oauth
{
    function __construct()
    {
        global $siteurl;
        $this->callback = $siteurl . 'syyun/link.php';
    }
    public function login()
    {
        global $allapi;
        $state = md5(uniqid(rand(), TRUE));
		setcookie("Oauth_state",$state,time()+600,'/');
        $keysArr = array("redirect_uri" => $this->callback, "state" => $state);
        $login_url = $allapi . 'qqlogin/qqlogin.php?' . http_build_query($keysArr);
		header("Location:{$login_url}");
	    }
    public function callback()
    {
        global $allapi;
		if ($_GET['state'] != $_COOKIE['Oauth_state']) {
         echo"<h2>The state does not match. You may be a victim of CSRF.</h2>";
		}else{
        $keysArr = array("code" =>$_GET['code'], "state" =>$_COOKIE['Oauth_state'], "key" =>"zero2109877665");
        $token_url = $allapi . 'qqlogin/qqlogin.php?' . http_build_query($keysArr);
        $response = file_get_contents($token_url);
        $arr = json_decode($response, true);
        if ($arr['code']!=1) {	
         echo'<h3>提示  :</h3>绑定成功';
        }		
        return $arr;
		}
    }
}
$Oauth = new Oauth();
if ($_GET['code']) {
    $array = $Oauth->callback();
    $social_uid	  	=	 $array['social_uid'];
    $access_token 	=	 $array['access_token'];
    $gender		  	=	 $array['gender'];
	$nickname	 	=	 $array['nickname'];
    $figureurl_qq_1 =	 $array['figureurl_qq_1'];
    $figureurl_qq_2	=	 $array['figureurl_qq_2'];
	$vip	 	 	=	 $array['vip'];
    $level			=	 $array['level'];
	$is_yellow_year_vip= $array['is_yellow_year_vip'];
	$row = $DB->get_row("SELECT * FROM auth_user WHERE token='$access_token' limit 1");
	if($row['token']==$access_token) {
//		exit("<script language='javascript'>alert('该QQ已绑定其他用户！');history.go(-1);</script>");
	}else{
	$DB->query("update `auth_user` set `token` ='".$access_token."' where `uid`='".$udata['uid']."'");
	echo "<script language='javascript'>alert('绑定成功！');window.location.href='./';</script>";
	}
} else {
    $Oauth->login();
}