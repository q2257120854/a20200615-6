<?
include("../../config/conn.php");
include("../../config/function.php");
sesCheck_m();
$a=$_GET[a];
if($a=="order"){$urlv="order.php";$urlv1="car.php";}else{$urlv="paylog.php";$urlv1="pay.php";}
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
<? include("topuser.php");?>

<div class="bfbtop2 box">
 <div class="d1" onClick="gourl('<?=$urlv?>')"><img src="img/topleft1.png" height="21" /></div>
 <div class="d2">付款结果</div>
 <div class="d3"></div>
</div>

<div class="czts box">
 <div class="d1">
 <a href="<?=$urlv?>">付款成功，查看结果</a>
 <a href="<?=$urlv1?>">付款失败，重新操作</a>
 </div>
</div>

</body>
</html>