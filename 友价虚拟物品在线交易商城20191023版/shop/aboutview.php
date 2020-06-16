<?
include("../config/conn.php");
include("../config/function.php");
include("../config/xy.php");
$sj=date("Y-m-d H:i:s");
$uid=$_GET[id];
$sqluser="select * from yjcode_user where zt=1 and shopzt=2 and id=".$uid;mysql_query("SET NAMES 'GBK'");$resuser=mysql_query($sqluser);
if(!$rowuser=mysql_fetch_array($resuser)){php_toheader("./");}
?>
<html>
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><?=$rowuser[shopname]?>好不好？<?=$rowuser[shopname]?>怎么样，<?=$rowuser[shopname]?>是做什么的 - <?=webname?></title>
<? include("../tem/cssjs.html");?>
<link href="shop.css" rel="stylesheet" type="text/css" />
</head>
<body>
<? include("top.php");?>
<script language="javascript">
document.getElementById("shopmenu3").className="a1";
</script>

<div class="yjcode">
 <!--左B-->
 <? include("left.php");?>
 <!--左E-->

 <!--右B-->
 <div class="right">
 
  <div class="about">
  <ul class="rcap"><li class="l1">关于我们</li><li class="l2"></li></ul>
  <div class="txt"><?=$rowuser[txt]?></div>
  </div>

 </div>
 <!--右E-->

</div>

<? include("../tem/bottom.html");?>
</body>
</html>