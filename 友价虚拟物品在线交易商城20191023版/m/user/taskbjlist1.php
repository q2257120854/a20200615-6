<?
include("../../config/conn.php");
include("../../config/function.php");
sesCheck_m();
$bh=$_GET[bh];
$userid=returnuserid($_SESSION[SHOPUSER]);
$sqltask="select * from yjcode_task where bh='".$bh."' and taskty=1 and userid=".$userid."";mysql_query("SET NAMES 'GBK'");$restask=mysql_query($sqltask);
if(!$rowtask=mysql_fetch_array($restask)){php_toheader("tasklist1.php");}
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
 <div class="d1" onClick="gourl('../task/view<?=$rowtask[id]?>.html')"><img src="img/topleft.png" height="21" /></div>
 <div class="d2">多人任务验收</div>
 <div class="d3"></div>
</div>

<? include("taskv.php");?>

<div class="taskmain1 box"><div class="d1"></div><div class="d2">验收列表</div></div>
 <?
 $ses=" where taskty=1 and bh='".$bh."'";
 $page=$_GET["page"];if($page==""){$page=1;}else{$page=intval($_GET["page"]);}
 pagef($ses,20,"yjcode_taskhf","order by sj desc");while($row=mysql_fetch_array($res)){
 while2("*","yjcode_user where id=".$row[useridhf]);$row2=mysql_fetch_array($res2);
 ?>
 <div class="taskbjlist box">
  <div class="d1"><img src="../../upload/<?=$row2[id]?>/user.jpg" onerror="this.src='../../img/none180x180.gif'" /></div>
  <div class="d2 flex">
  <strong><?=$row2[nc]?></strong><br>
  佣金：<?=$row[money1]?>元<br>
  QQ：<a href="javascript:void(0);" onClick="qqtang('<?=$row2[uqq]?>')"><?=$row2[uqq]?></a><? if(!empty($row2[mot])){?> / 手机：<?=$row2[mot]?><? }?><br>
  状态：<?=returntask1($row[zt])?>
  </div>
  <div class="d3">
  <? if(1==$row[zt]){?>
  <a href="taskys1.php?bh=<?=$bh?>&hfid=<?=$row[id]?>" class="btna1">进行验收</a>
  <? }?>
  </div>
 </div>
 <div class="taskbjlist1 box">
  <div class="d1 flex">
  接手留言：<?=strip_tags(returnjgdw($row[txt],"","未填写任何说明"))?>
  </div>
 </div>
 <? }?>
 <div class="npa">
 <?
 $nowurl="taskbjlist.php";
 $nowwd="bh=".$bh;
 require("page.html");
 ?>
 </div>

</body>
</html>