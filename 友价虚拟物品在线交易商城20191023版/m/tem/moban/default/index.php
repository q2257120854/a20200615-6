<?
$sj=date("Y-m-d H:i:s");
?>
<html>
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
<title>手机版<?=webname?></title>
<link rel="stylesheet" href="css/basic.css">
<link rel="stylesheet" href="tem/moban/<?=$wapmb?>/css/index.css">
<script language="javascript" src="js/basic.js"></script>
<script language="javascript" src="js/jquery-1.9.1.min.js"></script>
<script language="javascript" src="tem/moban/<?=$wapmb?>/js/index.js"></script>
</head>
<body>
<div class="yjcode">

<!--头部B-->
<div class="indextop box">
 <div class="d1"><img src="img/logo.png" /></div>
 <div class="d2" onClick="gourl('search/main.php');"><span class="s1"></span><span class="s2">请输入搜索关键词！</span></div>
 <div class="d3"><a href="user/"><img src="img/tx.png" /></a></div>
</div>
<!--头部E-->
<div style="display:none;" id="webhttp"><?=weburl?></div>

<!--图片B-->
<div class="qh">
<div class="addWrap">
 <div class="swipe" id="mySwipe">
   <div class="swipe-wrap">
   <?
   $i=0;
   while1("*","yjcode_ad where adbh='ADMT01' and zt=0 order by xh asc");while($row1=mysql_fetch_array($res1)){
   $tp="../".returnjgdw($rowcontrol[addir],"","gg")."/".$row1[bh].".".$row1[jpggif];
   ?>
   <div><a href="<?=$row1[aurl]?>"><img class="img-responsive" src="<?=$tp?>" /></a></div>
   <? $i++;}?>
   </div>
  </div>
  <ul id="position"><? for($j=0;$j<$i;$j++){?><li class="<? if(0==$j){?>cur<? }?>"></li><? }?></ul>
</div>
<script src="js/swipe.js"></script> 
<script type="text/javascript">
var bullets = document.getElementById('position').getElementsByTagName('li');
var banner = Swipe(document.getElementById('mySwipe'), {
auto: 2000,
continuous: true,
disableScroll:false,
callback: function(pos) {
var i = bullets.length;
while (i--) {
bullets[i].className = ' ';
}
bullets[pos].className = 'cur';
}});
</script>
</div>
<!--图片E-->

<!--图标滑屏B-->
<link rel="stylesheet" href="swiper/css/swiper.min.css">
<div class="swiper-container">
 <div class="swiper-wrapper">
  <?
  if(panduan("*","yjcode_ad where adbh='ADMT04' and zt=0")==0){
  ?>
  <div class="swiper-slide">
  <span class="d1"><a href="alltype/"><img src="img/tb5.png" /><br>全部分类</a></span>
  <span class="d1"><a href="user/order.php"><img src="img/tb2.png" /><br>我的订单</a></span>
  <span class="d1"><a href="user/"><img src="img/tb8.png" /><br>个人中心</a></span>
  <span class="d1"><a href="user/favpro.php"><img src="img/tb3.png" /><br>我的收藏</a></span>
  <span class="d1"><a href="news/newslist.html"><img src="img/tb6.png" /><br>行业资讯</a></span>
  <span class="d1"><a href="user/paylog.php"><img src="img/tb4.png" /><br>资金管理</a></span>
  <span class="d1"><a href="user/car.php"><img border="0" src="img/tb1.png" /><br>购物车</a></span>
  <span class="d1"><a href="contact/"><img border="0" src="img/tb7.png" /><br>联系我们</a></span>
  </div>
  <? }else{?>
  <div class="swiper-slide">
  <? $i=1;while1("*","yjcode_ad where adbh='ADMT04' and zt=0 order by xh asc");while($row1=mysql_fetch_array($res1)){?>
  <span class="d1"><a href="<?=$row1[aurl]?>"><img border="0" src="../<?=returnjgdw($rowcontrol[addir],"","gg")?>/<?=$row1[bh]?>.<?=$row1[jpggif]?>" /><br><?=$row1[tit]?></a></span>
  <? if($i % 8==0 && $i>9){?></div><div class="swiper-slide"><? }?>
  <? $i++;}?>
  </div>
  <? }?>
 </div>
 <div class="swiper-pagination"></div>
</div>
<script src="swiper/js/swiper.min.js"></script>
<script>
var swiper = new Swiper('.swiper-container', {
pagination: '.swiper-pagination',
paginationClickable: true,
spaceBetween: 30,
});
</script>
<!--图标滑屏E-->

<div class="ggbox box">
<div class="ggnei">
<? adwhile("ADMT02")?>
</div>
</div>

<!--商品分组B-->
<div class="indexcap box">
 <div class="d1">商品类别</div>
</div>
<div class="indexty box">
 <div class="dm">
 <? while1("*","yjcode_type where admin=1 and iftj<>1 order by xh asc");while($row1=mysql_fetch_array($res1)){?>
 <div class="d1"><a href="product/search_j<?=$row1[id]?>v.html"><img src="../upload/type/type1_<?=$row1[id]?>_m.png" width="45" height="45" ><br><?=$row1[type1]?></a></div>
 <? }?>
 </div>
</div>
<!--商品分组E-->

<!--推荐B-->
<div class="indexcap box">
 <div class="d1">限时折扣</div>
</div>
<div class="prolist box">
<div class="dmain">
<? 
$i=1;
while1("*","yjcode_pro where zt=0 and ifxj=0 and iftuan=1 and yhxs=2 and yhsj2>'".$sj."' order by yhsj2 asc limit 4");while($row1=mysql_fetch_array($res1)){
$money1=returnyhmoney($row1[yhxs],$row1[money2],$row1[money3],$sj,$row1[yhsj1],$row1[yhsj2],$row1[id]);
$au="product/view".$row1[id].".html";
$dqsj=str_replace("-","/",$row1[yhsj2]);
?>
<span id="dqsj<?=$i?>" style="display:none;"><?=$dqsj?></span>
<div class="dm" onClick="gourl('product/view<?=$row1[id]?>.html')">
 <div class="d1"><img class="protp" src="<?=returntppd("../".returntp("bh='".$row1[bh]."'","-1"),"../img/none200x200.gif")?>" /></div>
 <div class="d2"><?=returntitdian($row1[tit],50)?></div>
 <div class="d3">￥<strong><?=sprintf("%.2f",$money1)?></strong></div>
 <div class="d6"><span class="djs" id="djs<?=$i?>">正在加载</span></div>
</div>
<? $i++;}?>
</div>
</div>
<script language="javascript">
userChecksj();
</script>
<!--推荐E-->

<!--热销B-->
<div class="indexcap box">
 <div class="d1">热销排行</div>
</div>
<div class="prolist box">
<div class="dmain">
<?
$i=1;
while1("*","yjcode_pro where zt=0 and ifxj=0 order by xsnum desc limit 6");while($row1=mysql_fetch_array($res1)){
$money1=returnyhmoney($row1[yhxs],$row1[money2],$row1[money3],$sj,$row1[yhsj1],$row1[yhsj2],$row1[id]);
?>
<div class="dm" onClick="gourl('product/view<?=$row1[id]?>.html')">
 <div class="d1"><img class="protp" src="<?=returntppd("../".returntp("bh='".$row1[bh]."'","-1"),"../img/none200x200.gif")?>" /></div>
 <div class="d2"><?=returntitdian($row1[tit],50)?></div>
 <div class="d3">￥<strong><?=sprintf("%.2f",$money1)?></strong></div>
 <div class="d4">立省<?=$row1[money1]-$money1?>元</div>
 <div class="d5"><?=$row1[xsnum]?>人付款</div>
</div>
<? $i++;}?>
</div>
</div>
<!--热销E-->

<!--列表B-->
<? 
$j=1;
autoAD("ADMT03");
while3("*","yjcode_ad where adbh='ADMT03' and zt=0 order by xh asc");
while0("*","yjcode_type where admin=1 and (iftj is null or iftj=0) order by xh asc");while($row=mysql_fetch_array($res)){
?>
<div class="indexcap box">
 <div class="dpro" style="border-left:<?=$row[col]?> solid 3px;color:<?=$row[col]?>;"><?=$j?>F <?=$row[type1]?></div>
</div>

<? if($row3=mysql_fetch_array($res3)){?>
<div class="ggboxN box">
<div class="ggnei"><div class="ad1">
<? adreadID($row3[id],0,0)?>
</div></div>
</div>
<? }?>

<div class="prolist box">
<div class="dmain">
<?
$i=1;
while1("*","yjcode_pro where zt=0 and ifxj=0 and ty1id=".$row[id]." and iftj>0 order by iftj asc limit 6");while($row1=mysql_fetch_array($res1)){
$money1=returnyhmoney($row1[yhxs],$row1[money2],$row1[money3],$sj,$row1[yhsj1],$row1[yhsj2],$row1[id]);
while2("*","yjcode_user where id=".$row1[userid]);$row2=mysql_fetch_array($res2);
?>
<div class="dm" onClick="gourl('product/view<?=$row1[id]?>.html')">
 <div class="d1"><img class="protp" src="<?=returntppd("../".returntp("bh='".$row1[bh]."'","-1"),"../img/none200x200.gif")?>" /></div>
 <div class="d2"><?=returntitdian($row1[tit],50)?></div>
 <div class="d3">￥<strong><?=sprintf("%.2f",$money1)?></strong></div>
 <div class="d4">立省<?=$row1[money1]-$money1?>元</div>
 <div class="d5"><?=$row1[xsnum]?>人付款</div>
</div>
<? }?>
</div>
</div>
<? $j++;}?>
<!--列表E-->

<!--资讯B-->
<div class="indexcap box">
 <div class="d1">行业资讯</div>
</div>
<? 
while0("*","yjcode_news where zt=0 order by lastsj desc limit 5");while($row=mysql_fetch_array($res)){
$tp="../".returntp("bh='".$row[bh]."' order by xh asc","-1");if(!is_file($tp)){$tp="../img/none100x75.jpg";}
?>
<div class="indexzx box" onClick="gourl('news/txtlist_i<?=$row[id]?>.html')">
 <div class="d1"><img src="<?=$tp?>" width="100" height="75" /></div>
 <div class="d2"><strong><?=$row[tit]?></strong><br>关注：<?=$row[djl]?>次 &nbsp;&nbsp; 更新：<?=$row[lastsj]?></div>
</div>
<? }?>
<!--资讯E-->


</div>

<? include("tem/bottom.php");?>
<script language="javascript">
bottomjd(1);
</script>
</body>
</html>