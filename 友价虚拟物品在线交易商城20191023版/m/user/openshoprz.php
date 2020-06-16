<?
include("../../config/conn.php");
include("../../config/function.php");
sesCheck_m();
?>
<html>
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
<title>会员中心 <?=webname?></title>
<? include("../tem/cssjs.html");?>
<link href="css/sell.css" rel="stylesheet" type="text/css" />
</head>
<body>
<? 
include("topuser.php");
$rz=0;
if($rowcontrol[ifsell]=="off"){
if(strstr($rowcontrol[shoprz],"xcf1xcf")){if($rowuser[ifmot]!=1){$rz=1;}}
if(strstr($rowcontrol[shoprz],"xcf2xcf")){if($rowuser[ifemail]!=1){$rz=1;}}
if(strstr($rowcontrol[shoprz],"xcf3xcf")){if($rowuser[sfzrz]!=1 && $rowuser[sfzrz]!=0){$rz=1;}}
}
if(empty($rz)){php_toheader("openshop1.php");}
?>

<div class="bfbtop1 box">
 <div class="d1" onClick="gourl('index.php')"><img src="img/topleft.png" height="21" /></div>
 <div class="d2">开店认证</div>
 <div class="d3"></div>
</div>

 <? if($rowuser[sfzrz]!=0 && $rowuser[sfzrz]!=1 && strstr($rowcontrol[shoprz],"xcf3xcf")){?>
 <div class="rzcap box" onClick="gourl('smrz.php')">
  <div class="d2"><strong>实名认证</strong><br>将有助于我们为您提供更好的服务</div>
  <div class="d3">去认证</div>
  <div class="d4"><img src="img/jianright.png" height="15" /></div>
 </div>
 <? }?>

 <? if(1!=$rowuser[ifmot] && strstr($rowcontrol[shoprz],"xcf1xcf")){?>
 <div class="rzcap box" onClick="gourl('mobbd.php')">
  <div class="d2"><strong>手机认证</strong><br>提高帐户及资金安全性</div>
  <div class="d3">去认证</div>
  <div class="d4"><img src="img/jianright.png" height="15" /></div>
 </div>
 <? }?>
 
 <? if(1!=$rowuser[ifemail] && strstr($rowcontrol[shoprz],"xcf2xcf")){?>
 <div class="rzcap box" onClick="gourl('emailbd.php')">
  <div class="d2"><strong>邮箱绑定</strong><br>可以通过邮箱找回密码</div>
  <div class="d3">去绑定</div>
  <div class="d4"><img src="img/jianright.png" height="15" /></div>
 </div>
 <? }?>

</body>
</html>