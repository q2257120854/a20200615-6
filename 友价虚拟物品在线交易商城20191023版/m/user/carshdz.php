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
 <div class="d1" onClick="gourl('car.php')"><img src="img/topleft.png" height="21" /></div>
 <div class="d2">选择收货地址</div>
 <div class="d4" onClick="gourl('shdzlist.php')">管理</div>
</div>
 
<? if(panduan("*","yjcode_shdz where zt=0 and userid=".$rowuser[id])==1){?>
 <?
 while0("*","yjcode_shdz where zt=0 and userid=".$rowuser[id]);while($row=mysql_fetch_array($res)){
 $addr=returnarea($row[add1])." ".returnarea($row[add2])." ".returnarea($row[add3])." ".$row[addr];
 $au="car.php?shdz=".$row[id];
 ?>
 <div class="shdzlist box" onClick="gourl('<?=$au?>')">
  <div class="d1"><?=$row[lxr]?></div>
  <div class="d2"><?=$row[mot]?></div>
 </div>
 <div class="shdzlist1 box" onClick="gourl('<?=$au?>')">
  <div class="d0"></div>
  <div class="d1"><? if(1==$row[ifmr]){?><span class="red">[默认地址]</span> <? }?><?=$addr?></div>
  <div class="d0"></div>
 </div>
 <? }?>
 
<? }else{?>
<div class="wait box" onClick="gourl('shdzlx.php')">
 <div class="d1">
  <span class="s0"><img src="img/shdz.png" width="70" /></span>
  <span class="s1">您还没有添加收货地址</span>
  <span class="s2">添加新地址</span>
 </div>
</div>
<? }?>
 
</body>
</html>