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
</head>
<body>
<div class="bfbtop1 box">
 <div class="d1" onClick="gourl('index.php')"><img src="img/topleft.png" height="21" /></div>
 <div class="d2">系统提示</div>
 <div class="d3"></div>
</div>
<div class="wait box" onClick="gourl('index.php')">
 <div class="d1">
  <span class="s1">亲，该功能即将上线，敬请关注^_^</span>
  <span class="s2">[点击返回会员中心]</span>
 </div>
</div>
</body>
</html>