<?
include("../../config/conn.php");
include("../../config/function.php");
?>
<html>
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="viewport" content="initial-scale=1, width=device-width, maximum-scale=1, user-scalable=no" />
<title>联系我们 - <?=webname?></title>
<? include("../tem/cssjs.html");?>
</head>
<body>
<? $nowpagetit="联系我们";include("../tem/moban/".$rowcontrol[wapmb]."/tem/top.php");?>

<div class="shezhi box"><div class="d1"><img src="../img/regmot.png" /></div><div class="d2">联系电话</div><div class="d3"><img src="../img/icon1.png" /></div></div>
<div class="txt box">
 <div class="d1"><?=$rowcontrol[webtelv]?></div>
</div>
<div class="shezhi box"><div class="d1"><img src="../img/regqq.png" /></div><div class="d2">客服QQ</div><div class="d3"><img src="../img/icon1.png" /></div></div>
<div class="txt box">
 <div class="d1">
 <?
 $a1=preg_split("/,/",$rowcontrol[webqqv]);
 for($i=0;$i<count($a1);$i++){
  $b1=preg_split("/\*/",$a1[$i]);
  echo "<a href='http://wpa.qq.com/msgrd?v=3&uin=".$b1[0]."&site=".weburl."&menu=yes'>".$b1[1]."：".$b1[0]."</a><br>";
 }
 ?>
 </div>
</div>

<? include("../tem/moban/".$rowcontrol[wapmb]."/tem/bottom.php");?>
</body>
</html>