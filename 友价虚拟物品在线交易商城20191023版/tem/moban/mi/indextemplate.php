<?
include("../../../config/conn.php");
include("../../../config/function.php");
include("../../../config/xy.php");
$sj=date("Y-m-d H:i:s");
?>
<html>
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="keywords" content="<?=$rowcontrol[webkey]?>">
<meta name="description" content="<?=$rowcontrol[webdes]?>">
<title><?=$rowcontrol[webtit]?> - <?=webname?></title>
<link rel="shortcut icon" href="img/favicon.ico" />
<link href="css/basic.css" rel="stylesheet" type="text/css" />
<link href="css/index.css" rel="stylesheet" type="text/css" />
<link href="homeimg/jquery.flexslider.css" rel="stylesheet" type="text/css" >
<script language="javascript" src="js/basic.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script language="javascript" src="js/index.js"></script>
<script type="text/javascript" src="homeimg/jquery.flexslider-min.js"></script>
<? if(empty($rowcontrol[ifwap])){?>
<script language="javascript">
if(is_mobile()) {document.location.href= '<?=weburl?>m/';}
</script>
<? }?>
</head>
<body>
<? 
autoAD("ADI00");
while1("*","yjcode_ad where adbh='ADI00' and zt=0 order by xh asc");while($row1=mysql_fetch_array($res1)){
$tp="gg/".$row1[bh].".".$row1[jpggif];
$image_size= getimagesize("../../../".$tp);
?>
<div class="topbanner_hj" style="background:url(<?=$tp?>) no-repeat center 0;height:<?=$image_size[1]?>px;"><a href="<?=$row1[aurl]?>" target="_blank"></a></div>
<? }?>

<? include("../../../tem/top.html");?>
<? include("../../../tem/top1.html");?>
<span id="leftnone" style="display:none;"></span>
<script language="javascript">
leftmenuover();
yhifdis(0);
document.getElementById("zhuTop").className="bfb bfbtop1 bfbtop1N"
document.getElementById("topmenu1").className="a1";
</script>

 <!--切换B-->
 <div class="yjcode">
 <div class="banner" id="banner" >
 <? autoAD("shang_01");$i=0;while1("*","yjcode_ad where adbh='mi_02' and zt=0 order by xh asc");while($row1=mysql_fetch_array($res1)){?>
 <a href="<?=$row1[aurl]?>" class="d1" target="_blank" style="background:url(gg/<?=$row1[bh]?>.<?=$row1[jpggif]?>) center no-repeat;"></a>
 <? $i++;}?>
 <div class="d2" id="banner_id">
 <ul style="margin-left:-<?=86*$i/2?>px;">
 <? for($j=0;$j<$i;$j++){?><li></li><? }?>
 </ul>
 </div>
 </div>
 <script type="text/javascript">banner();</script>
 </div>
 <!--切换E-->

<div class="bfb"></div>

<div class="yjcode">
 
 <div class="qhD">
  <div class="d1"><? adread("mi_03",220,170);?></div>
  <div class="d2"><? adwhile("mi_04",3);?></div>
 </div>
 
 <!--推荐产品B-->
 <div class="tjspcap fontyh">推荐商品</div>
 <div class="tjpro fontyh">
 <? 
 $i=1;
 while1("*","yjcode_pro where zt=0 and ifxj=0 and iftuan=1 and yhxs=2 and yhsj2>'".$sj."' order by yhsj2 asc limit 5");while($row1=mysql_fetch_array($res1)){
 $money1=returnyhmoney($row1[yhxs],$row1[money2],$row1[money3],$sj,$row1[yhsj1],$row1[yhsj2],$row1[id]);
 $au="product/view".$row1[id].".html";
 $dqsj=str_replace("-","/",$row1[yhsj2]);
 while2("*","yjcode_user where id=".$row1[userid]);$row2=mysql_fetch_array($res2);
 ?>
 <span id="dqsj<?=$i?>" style="display:none;"><?=$dqsj?></span>
 <ul class="u1 u1<?=$i?>">
 <li class="l1"><a href="<?=$au?>" target="_blank"><img class="tp" border="0" src="<?=returntp("bh='".$row1[bh]."'","-1")?>" onerror="this.src='img/none200x200.gif'" width="198" height="198" /></a><span class="djs" id="djs<?=$i?>">正在加载</span></li>
 <li class="l2"><a href="<?=$au?>" title="<?=$row1[tit]?>" target="_blank"><?=strgb2312($row1[tit],0,50)?></a></li>
 <li class="l3"><?=$money1?>元</li>
 </ul>
 <? $i++;}?>
 </div>
 <script language="javascript">
 userChecksj();
 </script>
 <!--推荐产品E-->

</div>

<div class="bfb bfbh fontyh">
<div class="yjcode">
 <!--列表B-->
 <div class="listcap">
  <div class="d1">新品上架</div>
  <div class="d2">
  <? $i=1;while1("*","yjcode_type where admin=1 and iftj=0 order by xh asc");while($row1=mysql_fetch_array($res1)){?>
  <a href="javascript:void(0);" id="lista<?=$i?>" onMouseOver="listcapover(<?=$i?>)"<? if($i==1){?> class="a1"<? }?>><?=$row1[type1]?></a>
  <? $i++;}?>
  </div>
 </div>
 <span id="listcapA" style="display:none;"><?=$i?></span>
 <? $i=1;while1("*","yjcode_type where admin=1 and iftj=0 order by xh asc");while($row1=mysql_fetch_array($res1)){?>
 <div class="container" id="list<?=$i?>"<? if($i!=1){?> style="display:none;"<? }?>>
 <!-- Effect-1 -->
 <?
 $j=1;
 while0("*","yjcode_pro where ifxj=0 and zt=0 and ty1id=".$row1[id]." order by lastsj asc limit 8");while($row=mysql_fetch_array($res)){
 $au="product/view".$row[id].".html";
 $money1=returnyhmoney($row[yhxs],$row[money2],$row[money3],$sj,$row[yhsj1],$row[yhsj2],$row[id]);
 ?>
 <div class="list<? if($j==1 || $j==5){?> list0<? }?>">
 <ul class="u1">
 <li>
 <div class="port-1 effect-2">
  <div class="image-box"><img src="<?=returntp("bh='".$row[bh]."'","-1")?>" onerror="this.src='img/none180x180.gif'" width="257" height="257" alt="<?=$row[tit]?>"></div>
  <div class="text-desc"><h3><?=returntype(2,$row[ty2id])?></h3><p><?=strgb2312($row[wdes],0,300)?></p><a href="<?=$au?>" target="_blank" class="btn">立即购买</a>
  </div>
 </div>
 </li>
 </ul>
 <ul class="u2">
 <li class="l1"><a href="<?=$au?>" target="_blank" title="<?=$row[tit]?>"><?=strgb2312($row[tit],0,60)?></a></li>
 <li class="l2"><strong>￥<?=sprintf("%.2f",$money1)?></strong></li>
 <li class="l3"><?=sprintf("%.1f",10*$money1/$row[money1])?>折</li>
 </ul>
 </div>
 <? $j++;}?>
 <!-- Effect-1 End -->
 </div>
 <? $i++;}?>
 
 <!--列表E-->
 
 <!--商家B-->
 <div class="listcap listcap1">
  <div class="d1">优质商家</div>
 </div>
 <div class="shoplist">
 <? 
 $i=1;
 while1("*","yjcode_user where pm>0 and shopzt=2 and zt=1 order by pm asc limit 4");while($row1=mysql_fetch_array($res1)){
 $xy=returnjgdw($row1[xinyong],"",returnxy($row1[id],1));
 ?>
 <div class="shop shop<?=$i?>">
  <div class="d1"><img src="<?="upload/".$row1[id]."/shop.jpg"?>" onerror="this.src='img/none300x300.gif'" width="261" height="261"></div>
  <div class="d2"><?=returntitdian($row1[seodes],100)?></div>
  <div class="d3">我已经赚了<?=sprintf("%.2f",$row1[sellmall])?>元</div>
  <div class="d4">
  <span class="s1"><a href="shop/view<?=$row1[id]?>.html" target="_blank"><?=$row1[shopname]?></a></span>
  <span class="s2"><img src="img/dj/<?=returnxytp($xy)?>" title="<?=$xy?>分" /></span>
  </div>
 </div>
 <? $i++;}?>
 </div>
 <!--商家E-->
 

<!--资讯B-->
<div class="inews fontyh">
 <ul class="u1">
 <li class="l1">资讯速递</li>
 <li class="l2">
 <? while1("*","yjcode_newstype where admin=1 order by xh asc limit 7");while($row1=mysql_fetch_array($res1)){?>
 <a href="news/newslist_j<?=$row1[id]?>v.html" target="_blank"><?=$row1[name1]?></a> / 
 <? }?>
 </li>
 </ul>
 <div class="dmain">
 
  <div class="d1">
   <div class="flexslider">
   <ul class="slides">
   <? while1("*","yjcode_ad where adbh='mi_05' and zt=0 order by xh asc");while($row1=mysql_fetch_array($res1)){?>
   <li><a href="<?=$row1[aurl]?>" target="_blank"><img src="gg/<?=$row1[bh]?>.<?=$row1[jpggif]?>" width="425" height="226" border="0" /></a></li>
   <? }?>
   </ul>
   </div>
  </div>
  
  <div class="d2">
  <? while1("*","yjcode_news where zt=0 order by lastsj desc limit 16");if($row1=mysql_fetch_array($res1)){?>
  <a href="news/txtlist_i<?=$row1[id]?>v.html" target="_blank" class="a1" title="<?=$row1[tit]?>"><?=strgb2312($row1[tit],0,38)?></a>
  <? }?>
  <? for($i=1;$i<=6;$i++){if($row1=mysql_fetch_array($res1)){?>
  <a href="news/txtlist_i<?=$row1[id]?>v.html" class="a2" target="_blank" title="<?=$row1[tit]?>"><?=strgb2312($row1[tit],0,38)?></a>
  <? }}?>
  </div>
  <div class="d3">
  <ul class="du1">
  <li class="l1">行业资讯</li>
  <li class="l2"><a href="news/" target="_blank">更多</a></li>
  <? while($row1=mysql_fetch_array($res1)){?>
  <li class="l3"><a href="news/txtlist_i<?=$row1[id]?>v.html" target="_blank" title="<?=$row1[tit]?>"><?=strgb2312($row1[tit],0,35)?></a></li>
  <? }?>
  </ul>
  </div>
 </div>
 <div class="dad"><? adwhile("mi_06",2)?></div> 
</div>
<!--资讯E-->

 
</div>
</div>

<? include("../../../tem/bottom.html");?>
<script language="javascript">
if(document.getElementById("rightcontact")){
document.getElementById("rightcontact").className="contact fontyh disyes";
document.getElementById("righttel").className="tel fontyh disno";
}
</script>

<script language="javascript">
$(function(){
 $('.flexslider').flexslider({
 controlNav: false
 });
 $('.flexslider2').cxScroll({
 direction: "top",
 step:5 
 });
});
</script>

</body>
</html>