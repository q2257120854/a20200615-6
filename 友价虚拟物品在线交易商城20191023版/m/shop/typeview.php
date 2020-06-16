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
document.getElementById("topmenu3").className="a1";
</script>

<? while1("*","yjcode_protype where admin=1 and userid=".$uid." and zt=0 order by xh asc");while($row1=mysql_fetch_array($res1)){?>
<div class="type1 box" onClick="gourl('prolist_i<?=$uid?>v_j<?=$row1[id]?>v.html')"><div class="d1"><?=$row1[name1]?></div></div>
 <div class="type2 box">
 <div class="dm">
 <? while2("*","yjcode_protype where admin=2 and userid=".$uid." and zt=0 and name1='".$row1[name1]."' order by xh asc");while($row2=mysql_fetch_array($res2)){?>
 <div class="d1" onClick="gourl('prolist_i<?=$uid?>v_j<?=$row1[id]?>v_k<?=$row2[id]?>v.html')"><?=$row2[name2]?></div>
 <? }?>
 </div>
 </div>
<? }?>

<? include("../tem/moban/".$rowcontrol[wapmb]."/tem/bottom.php");?>
</body>
</html>