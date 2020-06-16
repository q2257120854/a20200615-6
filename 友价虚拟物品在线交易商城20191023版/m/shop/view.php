<?
include("../../config/conn.php");
include("../../config/function.php");
include("../../config/xy.php");
$uid=$_GET[id];
$sj=date("Y-m-d H:i:s");
$sqluser="select * from yjcode_user where zt=1 and (shopzt=2 or shopzt=4) and id=".$uid;mysql_query("SET NAMES 'GBK'");$resuser=mysql_query($sqluser);
if(!$rowuser=mysql_fetch_array($resuser)){php_toheader("./");}
if(4==$rowuser[shopzt]){php_toheader("dqview".$rowuser[id].".html");}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
<title><?=$rowuser[shopname]?>的网上店铺 - <?=webname?></title>
<? include("../tem/cssjs.html");?>
</head>
<body>
<? include("top.php");?>
<script language="javascript">
document.getElementById("topmenu1").className="a1";
</script>

<div class="zxsj box">
<div class="dmain">
 <div class="d1">最新上架</div>
 <? 
 while1("*","yjcode_pro where userid=".$uid." and zt=0 and ifxj=0 order by lastsj desc limit 8");while($row1=mysql_fetch_array($res1)){
 $au="../product/view".$row1[id].".html";
 $tp=returntp("bh='".$row1[bh]."' order by iffm desc","-2");
 ?>
 <a href="<?=$au?>">
 <ul class="u1">
 <li class="l1"><img src="<?=$tp?>" onerror="this.src='../img/none.png'" /></li>
 <li class="l2"><?=$row1[tit]?></li>
 <li class="l3">
 <strong>￥<?=returnjgdian(returnyhmoney($row1[yhxs],$row1[money2],$row1[money3],$sj,$row1[yhsj1],$row1[yhsj2],$row1[id]))?></strong>
 <s>￥<?=sprintf("%.2f",$row1[money1])?></s>
 </li>
 </ul>
 </a>
 <? }?>
</div>
</div>

<? include("../tem/moban/".$rowcontrol[wapmb]."/tem/bottom.php");?>
</body>
</html>