<?
include("../config/conn.php");
include("../config/function.php");
sesCheck();
if($_GET[action]=="del"){
updatetable("yjcode_user","wxopenid='',unionid='' where uid='".$_SESSION[SHOPUSER]."'");	
php_toheader("weixin.php");
}

$wxlogin=preg_split("/,/",$rowcontrol[wxlogin]);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>用户管理面板 - <?=webname?></title>
<? include("cssjs.html");?>
<link href="css/inf.css" rel="stylesheet" type="text/css" />
</head>
<body>
<? include("../tem/top.html");?>
<? include("top.php");?>
<div class="yjcode">

<? include("left.php");?>

<!--RB-->
<div class="userright">
 
 <? include("rcap1.php");?>
 <script language="javascript">
 document.getElementById("rcap9").className="l1 l2";
 </script>

 <!--白B-->
 <div class="rkuang">
 
 <? systs("恭喜您，操作成功!","weixin.php")?>
 <? if(empty($rowuser[wxopenid])){?>
 <ul class="qqtxt">
 <li class="l1">
 <a href="https://open.weixin.qq.com/connect/qrconnect?appid=<?=$wxlogin[0]?>&redirect_uri=<?=urlencode(weburl."reg/wxlogin.php")?>&response_type=code&scope=snsapi_login#wechat_redirect"><img src="img/wx.gif" width="50" /></a>
 <br>
 点击按钮，立即绑定微信帐号
 </li>
 <li class="l2">
 使用微信帐号登录本站，您可以……<br>
 用微信帐号轻松登录<br>
 无须记住本站的帐号和密码，随时使用微信扫一扫轻松登录
 </li>
 </ul>
 <? }else{?>
 <ul class="qqtxt">
 <li class="l3">
 <strong>您已将本站帐号与微信号码绑定</strong><br>
 解除已绑定帐号？<br>
 <input type="button" class="btn1" onclick="gourl('weixin.php?action=del')" value="确认解除" />
 </li>
 </ul>
 <? }?>
 
 </div>
 <!--白E-->

</div> 
<!--RE-->

</div>

<div class="clear clear15"></div>
<? include("../tem/bottom.html");?>
</body>
</html>