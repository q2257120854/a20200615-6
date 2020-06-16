<?
include("../config/conn.php");
include("../config/function.php");
$getstr=$_GET[str];
$ses=" where zt=0";
if(returnsx("p")!=-1){$page=returnsx("p");}else{$page=1;}
?>
<html>
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>网站公告 - <?=webname?></title>
<? include("../tem/cssjs.html");?>
</head>
<body>
<? include("../tem/top.html");?>
<? include("../tem/top1.html");?>

<div class="yjcode">

<? include("left.php");?>

<!--列表开始-->
<div class="helpright">
 <div class="wz">
 您当前的位置：<a href="<?=weburl?>">首页</a> <span>>></span> 网站公告
 </div>
 
 <ul class="helplist">
 <?
 pagef($ses,20,"yjcode_gg","order by sj desc");
 $i=1;
 while($row=mysql_fetch_array($res)){
 ?>
 <li class="l1">·<a href="<?=weburl?>help/ggview<?=$row[id]?>.html"><?=$row[tit]?></a></li>
 <li class="l2"><?=dateYMD($row[sj])?></li>
 <? if($i % 5==0){?><li class="l3"></li><? }?>
 <? $i++;}?>
 </ul>
 <div class="npa">
 <?
 $nowurl="gglist";
 $nowwd="";
 require("../tem/page.html");
 ?>
 </div>
</div>
<!--列表结束-->

</div>
<? include("../tem/bottom.html");?>
</body>
</html>