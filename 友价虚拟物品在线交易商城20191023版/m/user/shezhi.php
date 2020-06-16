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
<link href="css/buy.css" rel="stylesheet" type="text/css" />
</head>
<body>
<? include("topuser.php");?>

<div class="bfbtop1 box">
 <div class="d1" onClick="gourl('index.php')"><img src="img/topleft.png" height="21" /></div>
 <div class="d2">设置</div>
 <div class="d3"></div>
</div>

<div class="shezhi shezhi1 box" onClick="gourl('inf.php')"><div class="d1">基本资料</div><div class="d2"><img src="img/jianright.png" height="14" /></div></div>
<div class="shezhi box" onClick="gourl('touxiang.php')"><div class="d1">设置头像</div><div class="d2"><img src="img/jianright.png" height="14" /></div></div>

<div class="shezhi shezhi1 box" onClick="gourl('emailbd.php')"><div class="d1">邮箱绑定</div><div class="d2"><img src="img/jianright.png" height="14" /></div></div>
<div class="shezhi box" onClick="gourl('mobbd.php')"><div class="d1">手机绑定</div><div class="d2"><img src="img/jianright.png" height="14" /></div></div>
<div class="shezhi box" onClick="gourl('shdzlist.php')"><div class="d1">我的收货地址</div><div class="d2"><img src="img/jianright.png" height="14" /></div></div>

<div class="shezhi shezhi1 box" onClick="gourl('pwd.php')"><div class="d1">修改密码</div><div class="d2"><img src="img/jianright.png" height="14" /></div></div>

<div class="botbtnF"></div>
<div class="botbtn" onClick="gourl('un.php')">
 <div class="d1">退出当前账户</div>
</div>
</body>
</html>