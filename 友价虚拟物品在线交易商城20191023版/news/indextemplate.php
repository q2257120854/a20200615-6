<?
include("../config/conn.php");
include("../config/function.php");
?>
<html>
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>新闻资讯 - <?=webname?></title>
<? include("../tem/cssjs.html");?>
<link rel="stylesheet" href="../css/owl.carousel.css" />
<script type="text/javascript" src="../js/owl.carousel.js"></script>
<script language="javascript">
$(function(){
	$('#owl-demo').owlCarousel({
		items: 1,
		navigation: true,
		navigationText: ["上一个","下一个"],
		autoPlay: true,
		stopOnHover: true
	}).hover(function(){
		$('.owl-buttons').show();
	}, function(){
		$('.owl-buttons').hide();
	});
});
</script>
</head>
<body>
<? include("../tem/top.html");?>
<? include("../tem/top1.html");?>

<div class="yjcode">

 <!--左B-->
 <div class="nmleft">
  
  <!--图片B-->
  <div class="iqh">
  <div id="owl-demo" class="owl-carousel">
  <? while1("*","yjcode_ad where adbh='ADN00' and zt=0 order by xh asc");while($row1=mysql_fetch_array($res1)){?>
  <a class="item" href="<?=$row1[aurl]?>" title="<?=$row1[tit]?>" target="_blank"><img src="../<?=returnjgdw($rowcontrol[addir],"","gg")?>/<?=$row1[bh]?>.<?=$row1[jpggif]?>" alt=""><b></b></a>
  <? }?>
  </div>
  </div>
  <!--图片E-->
  
  <!--推荐B-->
  <ul class="cap">
  <li class="l1">关注度最高</li>
  </ul>
  <div class="tj">
  <? 
  while1("*","yjcode_news where zt=0 order by djl desc limit 6");while($row1=mysql_fetch_array($res1)){
  $tp=returntp("bh='".$row1[bh]."' order by xh asc","-1");
  ?>
  <a href="txtlist_i<?=$row1[id]?>v.html" title="<?=$row1[tit]?>" target="_blank">
  <ul class="u1">
   <li class="l1"><img src="<?=$tp?>" onerror="this.src='../img/none200x160.gif'" width="200" height="160" /></li>
  <li class="l2"><?=returntitcss(returntitdian($row1[tit],36),$row1[ifjc],$row1[titys])?></li>
  <li class="l3"><?=returntitdian($row1[wdes],70)?></li>
  <li class="l4"><?=$row1[lastsj]?></li>
  </ul>
  </a>
  <? }?>
  </div>
  <!--推荐E-->
  
  <!--分类展示B-->
  <?
  $sqlty="select * from yjcode_newstype where admin=1 order by xh asc limit 6";mysql_query("SET NAMES 'gbk'");
  $resty=mysql_query($sqlty);for($tyi=1;$tyi<=3;$tyi++){
  if($rowty=mysql_fetch_array($resty)){
  ?>
  <div class="cap"><?=$rowty[name1]?></div>
  <div class="fllist">
  
   <div class="d1">
   <? 
   while1("*","yjcode_news where type1id=".$rowty[id]." and zt=0 order by lastsj desc limit 6");for($i=1;$i<=2;$i++){
   if($row1=mysql_fetch_array($res1)){
   $tp=returntp("bh='".$row1[bh]."' order by xh asc","-1");
   ?>
   <a href="txtlist_i<?=$row1[id]?>v.html" target="_blank">
   <ul class="u1">
   <li class="l1"><img src="<?=$tp?>" onerror="this.src='../img/none200x160.gif'" width="200" height="161" /></li>
   <li class="l2"><?=returntitcss(returntitdian($row1[tit],40),$row1[ifjc],$row1[titys])?></li>
   <li class="l3"><?=returntitdian($row1[wdes],70)?></li>
   <li class="l4"><?=$row1[lastsj]?></li>
   </ul>
   </a>
   <? }}?>
   </div>
   
   <? while($row1=mysql_fetch_array($res1)){?>
   <ul class="u2"><li class="l1"><a href="txtlist_i<?=$row1[id]?>v.html" target="_blank"><?=returntitcss($row1[tit],$row1[ifjc],$row1[titys])?></a></li><li class="l2"><?=$row1[lastsj]?></li></ul>
   <? }?>
   
  </div>
  <? }}?>
  <!--分类展示E-->
  
 </div>
 <!--左E-->

 <!--右B-->
 <div class="nmright">
  
  <!--焦点B-->
  <div class="jiao">
   <ul class="u1"><li class="l0"></li><li class="l1">24小时</li><li class="l2"><a href="newslist.html">More>></a></li></ul>
   <? while1("*","yjcode_news where zt=0 order by lastsj desc limit 4");while($row1=mysql_fetch_array($res1)){?>
   <ul class="u2"><li class="l1"><a href="txtlist_i<?=$row1[id]?>v.html" target="_blank"><?=returntitcss($row1[tit],$row1[ifjc],$row1[titys])?></a></li><li class="l2"><?=$row1[lastsj]?></li></ul>
   <? }?>
  </div>
  <!--焦点E-->
  
  <!--分类B-->
  <div class="fenlei">
   <ul class="u1"><li class="l0"></li><li class="l1">分类</li><li class="l2"></li></ul>
   <div class="d1">
   <? while1("*","yjcode_newstype where admin=1 order by xh asc");while($row1=mysql_fetch_array($res1)){?>
   <a href="newslist_j<?=$row1[id]?>v.html"><?=$row1[name1]?></a>
   <? }?>
   </div>
  </div>
  <!--分类E-->
  
  <? if($rowty=mysql_fetch_array($resty)){?>
  <div class="huodong">
   <ul class="u1"><li class="l0"></li><li class="l1"><?=$rowty[name1]?></li><li class="l2"><a href="newslist_j<?=$rowty[id]?>v.html" target="_blank">More>></a></li></ul>
   <? 
   while1("*","yjcode_news where type1id=".$rowty[id]." and zt=0 order by lastsj desc limit 2");while($row1=mysql_fetch_array($res1)){
   $tp=returntp("bh='".$row1[bh]."' order by xh asc","-1");
   ?>
   <a href="txtlist_i<?=$row1[id]?>v.html" target="_blank">
   <ul class="u2">
   <li class="l1"><img src="<?=$tp?>" onerror="this.src='../img/none200x160.gif'" /></li>
   <li class="l2"><?=returntitcss(returntitdian($row1[tit],40),$row1[ifjc],$row1[titys])?></li>
   <li class="l3"><?=$row1[wdes]?></li>
   </ul>
   </a>
   <? }?>
  </div>
  <? }?>
  
  <? if($rowty=mysql_fetch_array($resty)){?>
  <div class="zazhi">
   <ul class="u1"><li class="l0"></li><li class="l1"><?=$rowty[name1]?></li><li class="l2"><a href="newslist-j<?=$rowty[id]?>v.html" target="_blank">More>></a></li></ul>
   <? 
   while1("*","yjcode_news where type1id=".$rowty[id]." and zt=0 order by lastsj desc limit 3");while($row1=mysql_fetch_array($res1)){
   $tp=returntp("bh='".$row1[bh]."' order by xh asc","-1");
   ?>
   <ul class="u2">
   <li class="l1"><a href="txtlist_i<?=$row1[id]?>v.html" target="_blank"><img src="<?=$tp?>" onerror="this.src='../img/none200x160.gif'" /></a></li>
   <li class="l2"><a href="txtlist_i<?=$row1[id]?>v.html" target="_blank"><?=returntitcss(returntitdian($row1[tit],36),$row1[ifjc],$row1[titys])?></a></li>
   <li class="l3"><a href="txtlist_i<?=$row1[id]?>v.html" target="_blank">查看详情</a></li>
   </ul>
   <? }?>
  </div>
  <? }?>
  
  <? if($rowty=mysql_fetch_array($resty)){?>
  <!--数据B-->
  <div class="shuju">
   <ul class="u1"><li class="l0"></li><li class="l1"><?=$rowty[name1]?></li><li class="l2"><a href="newslist_j<?=$rowty[id]?>v.html" target="_blank">More>></a></li></ul>
   <? 
   while1("*","yjcode_news where type1id=".$rowty[id]." and zt=0 order by lastsj desc limit 6");while($row1=mysql_fetch_array($res1)){
   ?>
   <ul class="u2">
   <li class="l1"><a href="txtlist_i<?=$row1[id]?>v.html" target="_blank"><?=returntitcss($row1[tit],$row1[ifjc],$row1[titys])?></a></li>
   <li class="l2"><?=$row1[sj]?></li>
   </ul>
   <? }?>
  </div>
  <!--数据E-->
  <? }?>
  
 </div>
 <!--右E-->

</div>

<? include("../tem/bottom.html");?>
</body>
</html>