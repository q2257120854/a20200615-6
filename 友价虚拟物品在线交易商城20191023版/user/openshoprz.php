<?
include("../config/conn.php");
include("../config/function.php");
sesCheck();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>用户管理面板 - <?=webname?></title>
<? include("cssjs.html");?>
<link href="css/sell.css" rel="stylesheet" type="text/css" />
</head>
<body>
<? include("../tem/top.html");?>
<? include("top.php");?>
<div class="yjcode">

<? include("left.php");?>

<!--RB-->
<div class="userright">
 
 <ul class="wz">
 <li class="l1 l2"><a href="openshoprz.php">资质认证</a></li>
 <li class="l1"><a href="openshop1.php">我要开店</a></li>
 </ul>

 <!--白B-->
 <div class="rkuang">
 
 <ul class="uk">
 <li class="l1">温馨提示：</li>
 <li class="l21 red"><strong>尊敬的用户朋友：请先提交以下认证信息，再申请开店</strong></li>
 </ul>

 <? if($rowuser[sfzrz]!=0 && $rowuser[sfzrz]!=1 && strstr($rowcontrol[shoprz],"xcf3xcf")){?>
 <ul class="urz1">
 <li class="l1 err">实名认证</li>
 <li class="l2">通过实名认证将有助于我们为您提供更好的服务</li>
 <li class="l3"><a href="smrz.php">提交认证</a></li>
 </ul>
 <? }?>

 <? if(1!=$rowuser[ifmot] && strstr($rowcontrol[shoprz],"xcf1xcf")){?>
 <ul class="urz1">
 <li class="l1 err">手机绑定</li>
 <li class="l2">将您的手机绑定在您注册时的帐号上，提高帐户及资金安全性</li>
 <li class="l3"><a href="mobbd.php">绑定手机</a></li>
 </ul>
 <? }?>
 
 <? if(1!=$rowuser[ifemail] && strstr($rowcontrol[shoprz],"xcf2xcf")){?>
 <ul class="urz1">
 <li class="l1 err">常用邮箱绑定</li>
 <li class="l2">当你忘记登录密码时，可以通过邮箱找回密码</li>
 <li class="l3"><a href="emailbd.php">绑定邮箱</a></li>
 </ul>
 <? }?>
 
 <div class="clear clear15"></div>

 </div>
 <!--白E-->
 
</div> 
<!--RE-->

</div>

<div class="clear clear15"></div>
<? include("../tem/bottom.html");?>
</body>
</html>