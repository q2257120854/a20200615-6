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
<span id="leftnone" style="display:none">0</span>
<script language="javascript">
leftmenuover();
yhifdis(0);
document.getElementById("topmenu1").className="a1";
</script>


<!--对联广告判断开始-->
<? while1("*","yjcode_ad where adbh='ADDL' and zt=0 order by xh asc limit 1");if($row1=mysql_fetch_array($res1)){?>
<script language="JavaScript" src="js/dlad.js"></script>
<script language="javascript">
 var theFloaters= new floaters();
 //右面
 theFloaters.addItem('followDiv1','document.body.clientWidth-106',80,'<?=adwhile("ADDL",1)?><span class="dlclo" onclick="dlonc()">关闭</span>');
 //左面
 theFloaters.addItem('followDiv2',6,80,'<?=adwhile("ADDL",1)?><span class="dlclo" onclick="dlonc()">关闭</span>');
 theFloaters.play();
</script>
<? }?>
<!--对联广告判断结束-->

 <!--切换B-->
 <div class="banner" id="banner" >
 <? autoAD("shun_qh");$i=0;while1("*","yjcode_ad where adbh='shun_qh' and zt=0 order by xh asc");while($row1=mysql_fetch_array($res1)){?>
 <a href="<?=$row1[aurl]?>" class="d1" target="_blank" style="background:url(gg/<?=$row1[bh]?>.<?=$row1[jpggif]?>) center no-repeat;"></a>
 <? $i++;}?>
 <div class="d2" id="banner_id">
 <ul style="margin-left:-<?=86*$i/2?>px;">
 <? for($j=0;$j<$i;$j++){?><li></li><? }?>
 </ul>
 </div>
 </div>
 <script type="text/javascript">banner();</script>
 <!--切换E-->



<div class="bfb"></div>

<div class="yjcode">
 
 <div class="qhad">
 <? adwhile("shun_06");?>
 </div>
 
 <!--推荐产品B-->
 <ul class="procap fontyh">
 <li class="l1">限时优惠促销</li>
 <li class="l2"><a href="product/" target="_blank">查看更多>></a></li>
 </ul>
 
 
 <div class="dtj fontyh">
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
 <li class="l1"><a href="<?=$au?>" target="_blank"><img border="0" src="<?=returntp("bh='".$row1[bh]."'","-1")?>" onerror="this.src='img/none180x180.gif'" /></a><span class="djs" id="djs<?=$i?>">正在加载</span></li>
 <li class="l2"><a href="<?=$au?>" target="_blank" title="<?=$row1[tit]?>"><?=strgb2312($row1[tit],0,47)?></a></li>
 <li class="l3">￥<?=sprintf("%.2f",$money1)?></li>
 <li class="l4"><a href="shop/view<?=$row2[id]?>.html" target="_blank"><?=strgb2312($row2[shopname],0,17)?></a></li>
 </ul>
 <? $i++;}?>
 </div>
 <script language="javascript">
 userChecksj();
 </script>
 <!--推荐产品E-->
 
 <!--热门商品B-->
 <ul class="procap fontyh">
 <li class="l1">热门商品</li>
 <li class="l2"><a href="product/" target="_blank">查看更多>></a></li>
 </ul>
 <div class="dtj fontyh">
 <? 
 $i=1;
 while0("*","yjcode_pro where zt=0 and ifxj=0 and iftj>0 order by iftj asc limit 5");while($row=mysql_fetch_array($res)){
 $money1=returnjgdian(returnyhmoney($row[yhxs],$row[money2],$row[money3],$sj,$row[yhsj1],$row[yhsj2],$row[id]));
 $au="product/view".$row[id].".html";
 while3("*","yjcode_user where id=".$row[userid]);$row3=mysql_fetch_array($res3);
 ?>
 <ul class="u1 u1<?=$i?>">
 <li class="l1"><a href="<?=$au?>" target="_blank"><img border="0" src="<?=returntp("bh='".$row[bh]."'","-1")?>" onerror="this.src='img/none180x180.gif'" /></a></li>
 <li class="l2"><a href="<?=$au?>" target="_blank" title="<?=$row[tit]?>"><?=strgb2312($row[tit],0,47)?></a></li>
 <li class="l3">￥<?=sprintf("%.2f",$money1)?></li>
 <li class="l4"><a href="shop/view<?=$row3[id]?>.html" target="_blank"><?=strgb2312($row3[shopname],0,17)?></a></li>
 </ul>
 <? $i++;}?>
 </div>
 <!--热门商品E-->
 
 <div class="rmgg">
 <? adwhile("shun_03");?>
 </div>
 
</div>

 <!--产品列表B-->
 <?
 autoAD("shun_01");
 autoAD("shun_02");
 $sqlad="select * from yjcode_ad where adbh='shun_01' and zt=0 order by xh asc";mysql_query("SET NAMES 'GBK'");$resad=mysql_query($sqlad);
 $sqlad1="select * from yjcode_ad where adbh='shun_02' and zt=0 order by xh asc";mysql_query("SET NAMES 'GBK'");$resad1=mysql_query($sqlad1);
 $ni=1;
 while1("*","yjcode_type where admin=1 and (iftj is null or iftj=0) order by xh asc");while($row1=mysql_fetch_array($res1)){
 ?>
 <div class="bfb fontyh<? if($ni % 2==0){?> bfbtype1<? }else{?> bfbtype2<? }?>">
 <div class="yjcode">
 
  <ul class="typecap">
  <li class="l1"><?=$row1[type1]?></li>
  <li class="l2">
  <a href="javascript:void(0);" class="a1" onMouseOver="typeaover(<?=$ni?>,0)" id="typea<?=$ni?>_0">推荐</a>
  <? $j=1;while2("*","yjcode_type where admin=2 and type1='".$row1[type1]."' order by xh asc limit 8");while($row2=mysql_fetch_array($res2)){?>
  <a href="product/search_j<?=$row1[id]?>v_k<?=$row2[id]?>v.html" target="_blank" id="typea<?=$ni?>_<?=$j?>" onMouseOver="typeaover(<?=$ni?>,<?=$j?>)"><?=$row2[type2]?></a>
  <? $j++;}?>
  <span id="typea<?=$ni?>" style="display:none;"><?=$j?></span>
  </li>
  </ul>
  
  <div class="leftgg"><? if($rowad=mysql_fetch_array($resad)){adreadID($rowad[id],220,420);}?><div class="gg1"><? if($rowad1=mysql_fetch_array($resad1)){adreadID($rowad1[id],220,160);}?></div></div>
  
  <div class="pdright fontyh" id="dright<?=$ni?>_0">
  <? 
  while0("*","yjcode_pro where zt=0 and ifxj=0 and ty1id=".$row1[id]." and iftj>0 order by iftj asc limit 6");while($row=mysql_fetch_array($res)){
  $money1=returnjgdian(returnyhmoney($row[yhxs],$row[money2],$row[money3],$sj,$row[yhsj1],$row[yhsj2],$row[id]));
  $au="product/view".$row[id].".html";
  while3("*","yjcode_user where id=".$row[userid]);$row3=mysql_fetch_array($res3);
  ?>
  <ul class="u1">
  <li class="l1"><a href="<?=$au?>" target="_blank"><img border="0" src="<?=returntp("bh='".$row[bh]."'","-1")?>" onerror="this.src='img/none180x180.gif'" /></a></li>
  <li class="l2"><a href="<?=$au?>" target="_blank" title="<?=$row[tit]?>"><?=strgb2312($row[tit],0,47)?></a></li>
  <li class="l3">￥<?=sprintf("%.2f",$money1)?></li>
  <li class="l4"><a href="shop/view<?=$row3[id]?>.html" target="_blank"><?=strgb2312($row3[shopname],0,17)?></a></li>
  </ul>
  <? }?>
  </div>

  <? $j=1;while2("*","yjcode_type where admin=2 and type1='".$row1[type1]."' order by xh asc limit 8");while($row2=mysql_fetch_array($res2)){?>
  <div class="pdright fontyh" id="dright<?=$ni?>_<?=$j?>" style="display:none;">
  <? 
  while0("*","yjcode_pro where zt=0 and ifxj=0 and ty1id=".$row1[id]." and ty2id=".$row2[id]." order by lastsj desc limit 6");while($row=mysql_fetch_array($res)){
  $money1=returnjgdian(returnyhmoney($row[yhxs],$row[money2],$row[money3],$sj,$row[yhsj1],$row[yhsj2],$row[id]));
  $au="product/view".$row[id].".html";
  while3("*","yjcode_user where id=".$row[userid]);$row3=mysql_fetch_array($res3);
  ?>
  <ul class="u1">
  <li class="l1"><a href="<?=$au?>" target="_blank"><img border="0" src="<?=returntp("bh='".$row[bh]."'","-1")?>" onerror="this.src='img/none180x180.gif'" /></a></li>
  <li class="l2"><a href="<?=$au?>" target="_blank"><?=strgb2312($row[tit],0,47)?></a></li>
  <li class="l3">￥<?=sprintf("%.2f",$money1)?></li>
  <li class="l4"><a href="shop/view<?=$row3[id]?>.html" target="_blank"><?=$row3[shopname]?></a></li>
  </ul>
  <? }?>
  </div>
  <? $j++;}?>
  
  <div class="rxph">
  <ul class="u1"><li class="l1">热销排行榜</li><li class="l2"></li></ul>
  <? 
  while0("*","yjcode_pro where zt=0 and ifxj=0 and ty1id=".$row1[id]." order by xsnum desc limit 10");for($i=1;$i<=3;$i++){if($row=mysql_fetch_array($res)){
  $money1=returnjgdian(returnyhmoney($row[yhxs],$row[money2],$row[money3],$sj,$row[yhsj1],$row[yhsj2],$row[id]));
  $au="product/view".$row[id].".html";
  ?>
  <ul class="u2 u2<?=$i?>">
  <li class="l1"><a href="<?=$au?>" title="<?=$row[tit]?>" target="_blank"><?=strgb2312($row[tit],0,22)?></a></li>
  <li class="l2">
  <a href="<?=$au?>" target="_blank"><img align="left" border="0" src="<?=returntp("bh='".$row[bh]."'","-2")?>" onerror="this.src='img/none180x180.gif'" /></a>
  已售<?=$row[xsnum]?>份<br>
  <strong>￥<?=$money1?></strong>
  </li>
  </ul>
  <? }}?>
  <?
  while($row=mysql_fetch_array($res)){
  $au="product/view".$row[id].".html";
  ?>
  <ul class="u3">
  <li class="l1"><img src="homeimg/ph<?=$i?>.gif" /></li>
  <li class="l2"><a href="<?=$au?>" title="<?=$row[tit]?>" target="_blank"><?=returntitdian($row[tit],24)?></a></li>
  </ul>
  <? $i++;}?>
  </div>
 
 </div>
 </div>
 <? $ni++;}?>
 <!--产品列表E-->
 

<!--商学院B-->
<div class="yjcode">

 <div class="syy fontyh">
 
  <div class="cap"><?=webname?>商学院</div>
  
  <ul class="u1">
  <? $ntyarr=array();$i=1;while1("*","yjcode_newstype where admin=1 order by xh asc limit 3");while($row1=mysql_fetch_array($res1)){?>
  <li class="l1<? if($i==1){?> l11<? }?>" id="syycap<?=$i?>" onMouseOver="ssycapover(<?=$i?>)"><?=$row1[name1]?></li>
  <? $ntyarr[$i-1]=$row1[id];$i++;}?>
  <li class="l2"><a href="news/">查看更多</a></li>
  </ul>
  
  <? for($i=1;$i<=3;$i++){?>
  <div class="ssym" id="ssym<?=$i?>"<? if($i>1){?> style="display:none;"<? }?>>
  <? 
  $tid=$ntyarr[$i-1];
  while1("*","yjcode_news where zt=0 and type1id=".$tid." and iftp=1 order by lastsj desc limit 4");while($row1=mysql_fetch_array($res1)){
  $au="news/txtlist_i".$row1[id]."v.html";
  ?>
   <ul class="u2">
   <li class="l1"><a href="<?=$au?>" target="_blank"><img border="0" src="../<?=returntp("bh='".$row1[bh]."' order by xh asc","")?>" /></li>
   <li class="l2"><a href="<?=$au?>" target="_blank" title="<?=$row2[tit]?>"><?=strgb2312($row1[tit],0,40)?></a></li>
   <li class="l3"><?=strgb2312($row1[wdes],0,200)?></li>
   </ul>
  <? }?>
  </div>
  <? }?>
  
 </div>

</div>
<!--商学院E-->
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