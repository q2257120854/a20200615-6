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
<link href="css/task.css" rel="stylesheet" type="text/css" />
</head>
<body>
<? include("topuser.php");?>
<div class="bfbtop1 box">
 <div class="d1" onClick="gourl('./')"><img src="img/topleft.png" height="21" /></div>
 <div class="d2">单人任务</div>
 <div class="d3"></div>
</div>

<div class="listcontrol box">
 <div class="d1"><input name="C2" type="checkbox" onClick="xuan()" /></div>
 <div class="d2">
 <a href="javascript:void(0)" onClick="javascript:NcheckDEL(3,'yjcode_task')" class="a2">删除</a>
 <a href="taskadd.php" class="a1">发布任务</a>
 </div>
</div>

 <?
 $ses=" where taskty=0 and userid=".$rowuser[id];
 $page=$_GET["page"];if($page==""){$page=1;}else{$page=intval($_GET["page"]);}
 pagef($ses,20,"yjcode_task","order by sj desc");while($row=mysql_fetch_array($res)){
 while1("*","yjcode_taskhf where bh='".$row[bh]."' order by money1 desc");if($row1=mysql_fetch_array($res1)){$moneyg=$row1[money1];}$moneyg=returnjgdw($moneyg,"",0);
 while1("*","yjcode_taskhf where bh='".$row[bh]."' order by money1 asc");if($row1=mysql_fetch_array($res1)){$moneyd=$row1[money1];}$moneyd=returnjgdw($moneyd,"",0);
 $bmnum=returncount("yjcode_taskhf where bh='".$row[bh]."' and userid=".$rowuser[id]);
 taskok($row["id"]);
 ?>
 <div class="tasklist box">
  <div class="d1"><? if($row[zt]==0 || $row[zt]==1 || $row[zt]==2|| $row[zt]==5 || $row[zt]==6 || $row[zt]==7 || $row[zt]==9 || $row[zt]==10){?><input name="C1" type="checkbox" value="<?=$row[bh]?>" /><? }?></div>
  <div class="d2"><a href="../task/view<?=$row[id]?>.html"><?=$row[tit]?></a></div>
  <div class="d3 feng"><?=returntask($row[zt])?></div>
 </div>
 <div class="tasklist1 box">
  <div class="d1 flex">
   <span class="s1">报名 <?=$bmnum?>人</span>
   <span class="s2">最高 <?=$moneyg?>元</span>
   <span class="s3">最低 <?=$moneyd?>元</span>
   <span class="s4">预算 <?=$row[money1]?>元</span>
   <? if(!empty($row[money2])){?>
   <span class="s5">中标 <?=$row[money2]?>元</span>
   <? }?>
  </div>
 </div>
 <div class="tasklist2 box">
  <div class="d0"><?=$row[sj]?></div>
  <div class="d1 flex">
  <? if($bmnum>0 && empty($row[zt])){?>
  <a href="taskbjlist.php?bh=<?=$row[bh]?>" class="btna btna3">选择用户</a>
  <? }?>
  <? if(4==$row[zt]){?>
  <a href="taskys.php?bh=<?=$row[bh]?>" class="btna btna1">进行验收</a>
  <? }?>
  <? if(!empty($row[useridhf])){?>
  <a href="taskgts.php?bh=<?=$row[bh]?>" class="btna btna2">沟通记录</a>
  <? }?>
  </div>
 </div>
 <? }?>
 <div class="npa">
 <? 
 $nowurl="tasklist.php";
 $nowwd="";
 require("page.html");
 ?>
 </div>

</body>
</html>