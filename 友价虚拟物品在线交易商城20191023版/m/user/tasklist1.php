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
 <div class="d2">多人任务</div>
 <div class="d3"></div>
</div>

<div class="listcontrol box">
 <div class="d1"><label><input name="C2" type="checkbox" onClick="xuan()" /> 全选</label></div>
 <div class="d2">
 <a href="javascript:void(0)" onClick="javascript:NcheckDEL(3,'yjcode_task')" class="a2">删除</a>
 <a href="taskadd.php" class="a1">发布任务</a>
 </div>
</div>

 <?
 $ses=" where taskty=1 and userid=".$rowuser[id];
 $page=$_GET["page"];if($page==""){$page=1;}else{$page=intval($_GET["page"]);}
 pagef($ses,30,"yjcode_task","order by sj desc");while($row=mysql_fetch_array($res)){
 taskok($row["id"]);
 ?>
 <div class="tasklist box">
  <? if($row[zt]==0 || $row[zt]==1 || $row[zt]==2|| $row[zt]==5 || $row[zt]==6 || $row[zt]==7 || $row[zt]==9){?>
  <div class="d1"><input name="C1" type="checkbox" value="<?=$row[bh]?>" /></div>
  <? }?>
  <div class="d2"><a href="../task/view<?=$row[id]?>.html"><?=$row[tit]?></a></div>
  <div class="d3 feng"><?=returntask($row[zt])?></div>
 </div>
 <div class="tasklist1 box">
  <div class="d1 flex">
   <span class="s1">共<?=$row[tasknum]?>份</span>
   <span class="s2">剩<?=$row[tasknum]-$row[taskcy]?>份</span>
   <span class="s3">单份 <?=sprintf("%.0f",$row[money1]/$row[tasknum])?>元</span>
   <span class="s5">总预算 <?=$row[money1]?>元</span>
  </div>
 </div>
 <div class="tasklist2 box">
  <div class="d0"><?=$row[sj]?></div>
  <div class="d1 flex">
  <? $needys=returncount("yjcode_taskhf where bh='".$row[bh]."' and taskty=1 and zt=1");?>
  <? if($needys>0){?>
  <a href="taskbjlist1.php?bh=<?=$row[bh]?>&zt=1" class="btna btna1">进行验收</a>
  <? }?>
  <? if($row[zt]==100){?>
  <a href="taskmoney.php?bh=<?=$row[bh]?>" class="btna btna1">缴纳费用</a>
  <? }?>
  </div>
 </div>
 <? }?>
 <div class="npa">
 <? 
 $nowurl="tasklist1.php";
 $nowwd="";
 require("page.html");
 ?>
 </div>

</body>
</html>