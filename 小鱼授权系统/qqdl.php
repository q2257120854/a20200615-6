<?php 
$mod='blank';
include("./system/api.inc.php");
$siteurl = ($_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://') . $_SERVER['HTTP_HOST']. '/';//获取本地域名
$allapi	 ='http://yun.6zds.cn/';//QQ快捷登录API地址
class Oauth
{
    function __construct()
    {
        global $siteurl;
        $this->callback = $siteurl . 'qqdl.php';//登录回调地址
    }
    public function login()
    {
        global $allapi;
		
		//-------生成唯一随机串防CSRF攻击
        $state = md5(uniqid(rand(), TRUE));
		
		setcookie("Oauth_state",$state,time()+600,'/');
		
        $keysArr = array("call_back" => $this->callback, "state" => $state);
		
        $login_url = $allapi . 'return/connect.php?' . http_build_query($keysArr);
		
		header("Location:{$login_url}");
		
	}
    public function callback()
    {
        global $allapi;
		
		//--------验证state防止CSRF攻击
		if ($_GET['state'] != $_GET['state']) {
			
         echo"<h2>The state does not match. You may be a victim of CSRF.</h2>";
		 
		}else{
			
        $keysArr = array("check"=>'check',"a" =>$_GET['code'], "b" =>$_GET['state'],"call_back" => $this->callback);
		
        $token_url = $allapi . 'return/connect.php?' . http_build_query($keysArr);
		
        $response = file_get_contents($token_url);
		
        $arr = json_decode($response, true);
		
        if ($arr['code']!=0) {
			
         echo'<h3>msg  :</h3>' . $arr['msg'];
        }		
        return $response;
		}
    }
}
$Oauth = new Oauth();
header("Content-Type: text/html; charset=UTF-8");
if ($_GET['code']) {
    $array = $Oauth->callback();
   	$json = json_decode($array,true); 
    echo $array;
} else {	
    $Oauth->login();
}