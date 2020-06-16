<?
include("../../../../config/conn.php");
include("../../../../config/function.php");
include("../../../../config/xy.php");
$sj=getsj();
?>
<html>
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
<meta name="keywords" content="<?=$rowcontrol[webkey]?>">
<meta name="description" content="<?=$rowcontrol[webdes]?>">
<title><?=webname?> - <?=$rowcontrol[webtit]?></title>
<? $cssjsty="b";include("../../../tem/cssjs.html");?>
<script language="javascript" src="js/jQuery.textSlider.js"></script>
</head>
<body>
<div style="display:none;" id="webhttp"><?=weburl?></div>
<div class="indextop box">
 <div class="d1 flex"><a href="./"><img src="<?=returnjgdw("homeimg/logo.png","","img/logo.png")?>" /></a></div>
 <div class="d2"><a href="user/qiandao.php"><img src="homeimg/qian.png" /></a></div>
</div>

<!--图片B-->
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
  <ul id="position" style="display:none;"><? for($j=0;$j<$i;$j++){?><li class="<? if(0==$j){?>cur<? }?>"></li><? }?></ul>
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
<!--图片E-->

<!--图标滑屏B-->
<div class="menuhp">

<div class="swiper-container">
 <div class="swiper-wrapper">
  <?
  $anum=returncount("yjcode_ad where adbh='ADMT04' and zt=0");
  if($anum==0){
  ?>
  <div class="swiper-slide">
  <span class="d1"><a href="alltype/"><img src="img/tb5.png" /><br>全部分类</a></span>
  <span class="d1"><a href="user/order.php"><img src="img/tb2.png" /><br>我的订单</a></span>
  <span class="d1"><a href="task/"><img src="img/tb9.png" /><br>任务大厅</a></span>
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
  <? if($i % 10==0 && $anum>10){?></div><div class="swiper-slide"><? }?>
  <? $i++;}?>
  </div>
  <? }?>
 </div>
 <div class="swiper-pagination"<? if($anum<=10){?> style="display:none;"<? }?>></div>
</div>

</div>
<link rel="stylesheet" href="swiper/css/swiper.min.css">
<script src="swiper/js/swiper.min.js"></script>
<script>
var swiper = new Swiper('.swiper-container', {
pagination: '.swiper-pagination',
paginationClickable: true,
spaceBetween: 30,
});
</script>
<!--图标滑屏E-->

<!--公告B-->
<div class="indexgg box">
 <div class="d1"><img src="homeimg/ggicon.png" /><span></span></div>
 <div class="d2 flex">

  <div class="divm">
   <div class="scrollDiv" id="scrollDiv1">
   <div class="scrollText">
    <ul>
    <? while2("*","yjcode_gg where zt=0 order by sj desc limit 20");while($row2=mysql_fetch_array($res2)){?>
    <li onClick="gourl('help/ggview<?=$row2[id]?>.html')"><?=$row2[tit]?></li>
    <? }?>
    </ul>
   </div>
   </div>
  </div>

 </div>
</div>
<script language="javascript">
$(document).ready(function(){
$(".scrollDiv").textSlider({
line:1,
speed:500,
timer:4000
});
});
</script>
<!--公告E-->

<div class="clear clear10"></div>
<div class="indexcap box">
 <div class="d1 flex">限时促销</div>
 <div class="d2"><a href="product/">更多 ></a></div>
</div>
<!--限时B-->
<div class="swiper-container1">
 <div class="swiper-wrapper">
 <? 
 $i=1;
 while1("*","yjcode_pro where zt=0 and ifxj=0 and iftuan=1 and yhxs=2 and yhsj2>'".$sj."' order by yhsj2 asc limit 5");while($row1=mysql_fetch_array($res1)){
 $money1=returnyhmoney($row1[yhxs],$row1[money2],$row1[money3],$sj,$row1[yhsj1],$row1[yhsj2],$row1[id]);
 $au="product/view".$row1[id].".html";
 $dqsj=str_replace("-","/",$row1[yhsj2]);
 ?>
 <div class="swiper-slide" onClick="gourl('<?=$au?>')">
  <div class="dmain">      
   <span id="dqsj<?=$i?>" style="display:none;"><?=$dqsj?></span>
   <div class="d1"><img src="<?=returntp("bh='".$row1[bh]."' order by xh asc","-1")?>" onerror="this.src='../img/none200x200.gif'" /></div>
   <div class="d2"><?=returntitdian($row1[tit],50)?></div>
   <div class="d3">￥<?=sprintf("%.2f",$money1)?></div>
   <div class="d4"><span class="djs" id="djs<?=$i?>">正在加载</span></div>
  </div>
 </div>
 <? $i++;}?>
 </div>
 <div class="swiper-pagination1"></div>
</div>
<script>
swiper1 = new Swiper('.swiper-container1', {
slidesPerView: 2.7,
spaceBetween:20,
freeMode: true,
pagination: {
el: '.swiper-pagination1',
clickable: true,
},
});
userChecksj();
</script>
<!--限时E-->

<div class="indexcap box">
 <div class="d1 flex">最近更新</div>
 <div class="d2"><a href="product/">更多 ></a></div>
</div>
<div class="prolist box">
<div class="dmain flex">
 <?
 while0("*","yjcode_pro where zt=0 and ifxj=0 order by lastsj desc limit 10");while($row=mysql_fetch_array($res)){
 $money1=returnyhmoney($row[yhxs],$row[money2],$row[money3],$sj,$row[yhsj1],$row[yhsj2],$row[id]);
 ?>
 <a href="product/view<?=$row[id]?>.html">
 <div class="dm">
 <div class="d1"><div><img src="<?=returntp("bh='".$row[bh]."' order by xh asc","-1")?>" onerror="this.src='../img/none200x200.gif'" /></div></div>
 <div class="d2">
  <div class="b1"><?=$row[tit]?></div>
  <div class="b2">
   <div class="sb1">
   <? 
   $a=preg_split("/xcf/",$row[tysx]);
   $sx1arr=array();
   $sxall="xcf";
   $m=0;
   for($i=0;$i<=count($a);$i++){
    $ai=$a[$i];
    if($ai!=""){
     if(!is_numeric($ai)){$z1=preg_split("/:/",$ai);$ai=$z1[0];}
     while1("*","yjcode_typesx where id=".$ai);if($row1=mysql_fetch_array($res1)){
      while2("*","yjcode_typesx where name1='".$row1[name1]."' and admin=1 and ifjd=1");if($row2=mysql_fetch_array($res2)){
       if(!in_array($row1[name1],$sx1arr)){$sx1arr[$m]=$row1[name1];$m++;}
       if(!is_numeric($a[$i])){$z1=preg_split("/:/",$a[$i]);$v=$z1[1];}else{$v=$row1[name2];}
       $sxall=$sxall.$row1[name1].":".$v."xcf";
      }
     }
    }
   }
   for($i=0;$i<count($sx1arr);$i++){
   ?>
   <span><? $b=preg_split("/xcf/",$sxall);for($j=0;$j<=count($b);$j++){if(check_in($sx1arr[$i],$b[$j])){echo str_replace($sx1arr[$i].":","",$b[$j])." ";}}?></span>
   <? }?>    
   </div>
   <div class="sb2">
    <span class="s1">￥<?=$money1?></span>
    <span class="s2">销量 <?=$row[xsnum]?></span>
   </div>
  </div>
  <div class="b3"><span>购买</span></div>
 </div>
 </div>
 </a>
 <? }?>
</div>
</div>

<?
while3("*","yjcode_ad where adbh='ADMT03' and zt=0 order by xh asc");
while0("*","yjcode_type where admin=1 and (iftj is null or iftj=0) order by xh asc");while($row=mysql_fetch_array($res)){
?>
<div class="indexcap box">
 <div class="d1 flex"><?=$row[type1]?></div>
 <div class="d2"><a href="product/search_j<?=$row[id]?>v.html">更多 ></a></div>
</div>

<? if($row3=mysql_fetch_array($res3)){?>
<div class="ggboxN box">
<div class="ggnei"><div class="ad1">
<? adreadID($row3[id],0,0)?>
</div></div>
</div>
<? }?>

<div class="swiper-containerpp">
<div class="swiper-containerp<?=$row[id]?>">
 <div class="swiper-wrapper">
 <? 
 $i=1;
 while1("*","yjcode_pro where zt=0 and ifxj=0 and ty1id=".$row[id]." order by lastsj desc limit 10");while($row1=mysql_fetch_array($res1)){
 $money1=returnyhmoney($row1[yhxs],$row1[money2],$row1[money3],$sj,$row1[yhsj1],$row1[yhsj2],$row1[id]);
 $au="product/view".$row1[id].".html";
 $dqsj=str_replace("-","/",$row1[yhsj2]);
 ?>
 <div class="swiper-slide" onClick="gourl('<?=$au?>')">
  <div class="dmain">      
   <div class="d1"><img src="<?=returntp("bh='".$row1[bh]."' order by xh asc","-1")?>" onerror="this.src='../img/none200x200.gif'" /></div>
   <div class="d2"><?=returntitdian($row1[tit],50)?></div>
   <div class="d3">￥<?=sprintf("%.2f",$money1)?></div>
  </div>
 </div>
 <? $i++;}?>
 </div>
 <div class="swiper-paginationp<?=$row[id]?>"></div>
</div>
</div>
<script>
swiperp<?=$row[id]?> = new Swiper('.swiper-containerp<?=$row[id]?>', {
slidesPerView: 2.7,
spaceBetween:20,
freeMode: true,
pagination: {
el: '.swiper-paginationp<?=$row[id]?>',
clickable: true,
},
});
</script>
<? }?>

<div class="indexcap box">
 <div class="d1 flex">资讯动态</div>
 <div class="d2"><a href="news/newslist.html">更多 ></a></div>
</div>
<?
while1("*","yjcode_news where zt=0 and iftp=1 order by lastsj desc limit 3");while($row1=mysql_fetch_array($res1)){
?>
<a href="news/txtlist_i<?=$row1[id]?>v.html">
<div class="newslist box">
 <div class="d1 flex">
 <span class="s1"><?=$row1[tit]?></span>
 <span class="s2"><?=returnnewstype(1,$row1[type1id])?></span>
 <span class="s3"><?=$row1[sj]?></span>
 </div>
 <div class="d2"><img src="<?=returntp("bh='".$row1[bh]."' order by xh asc","-1")?>" onerror="this.src='../../img/none180x180.gif'" /></div>
</div>
</a>
<? }?>

<? include("tem/bottom.php");?>
</body>
</html>