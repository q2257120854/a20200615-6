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
<link href="css/global.css" rel="stylesheet" type="text/css" />
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
 <? autoAD("ke_qh");$i=0;while1("*","yjcode_ad where adbh='ke_qh' and zt=0 order by xh asc");while($row1=mysql_fetch_array($res1)){?>
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

<div class="yjcode fontyh">
 <!--快速登录B-->
 <div id="idlno">
 <ul class="u1">
   	<li class="log"><img border="0" src="../homeimg/dl.gif" id="tx" width="100" height="100" align="left"></li>
 	<li class="l1">欢迎来到<?=webname?>！</li>
   <li class="l3 mylogin"><a class="myBtn1" href="reg/">登录</a><a class="myBtn1" href="reg/reg.php">注册</a></li>
   <li class="l3 myuser" style="display:none"><a class="myBtn1" href="user/">去个人中心</a></li>
   <li class="l3"><div class="p"><?=sprintf("%.0f",$inittjarr[3]+returnsum("money1*num","yjcode_order where ddzt<>'backsuc' and ddzt<>'close'"))?><i>元</i></div></li>
   <li class="l3 moy">平台成交总金额</li>
   <li class="l3"><a href="help/">帮助</a></li>
 </ul>
 </div>
 <div id="idlyes" style="display:none;">
 <ul class="u1">
 <li class="l1">登录用户信息</li>
 <li class="l2">
 用 户 名：<span id="idl1" class="blue"></span><br>
 帐户总额：<span id="idl2" class="feng"></span>元<br>
 帐户冻结：<span id="idl3" class="feng"></span>元<br>
 可提现额：<span id="idl4" class="feng"></span>元<br>
 可用积分：<span id="idl5" class="feng"></span>分<br>
 </li>
 <li class="l3">[<a href="user/">会员中心</a> | <a href="user/un.php">退出登录</a>]</li>
 </ul>
 </div>
 <script language="javascript">idldl(1);</script>
 <!--快速登录E-->
</div>

<div class="bfb"></div>

<div class="yjcode">
 
 <div class="qhad">
  <!--最新交易B-->
 <div class="scrollbox">
  <div class="scroltit">
   <strong>最新交易</strong>
   <em>实时交易网站播报</em>
   <small title="向上" id="but_up" style="cursor: pointer;"><i class="iconfont"><img src="homeimg/j1.gif" /></i></small>
   <small title="向下" id="but_down" style="cursor:pointer;"><i class="iconfont"><img src="homeimg/j2.gif" /></i></small>
  </div>
  <div id="scrollDiv">
   <ul style="margin-top: 0px;">
      </ul>
  </div>
 </div>
 <!--最新交易E-->
 </div>
 
 <div class="zxgg">
  <div class="d1">网站公告</div>
  <ul class="u1">
    <li class="l1 l11"><a href="help/ggview23.html" title="北京世间万象网络科技有限公司旗下世间万象商城上线试运营中" target="_blank">·北京世间万象网络科技有限公</a></li>
  <li class="l2 l11">[06/10]</li>
    </ul>
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
 <? adwhile("ke_03");?>
 </div>
 
</div>

 <!--产品列表B-->
 <?
 autoAD("ke_01");
 autoAD("ke_02");
 $sqlad="select * from yjcode_ad where adbh='ke_01' and zt=0 order by xh asc";mysql_query("SET NAMES 'GBK'");$resad=mysql_query($sqlad);
 $sqlad1="select * from yjcode_ad where adbh='ke_02' and zt=0 order by xh asc";mysql_query("SET NAMES 'GBK'");$resad1=mysql_query($sqlad1);
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
 
<div class="yjcode">

<!--资讯B-->
<div class="inews fontyh">
 <ul class="u1">
 <li class="l1">资讯速递</li>
 <li class="l2">
 <? while1("*","yjcode_newstype where admin=1 order by xh asc limit 7");while($row1=mysql_fetch_array($res1)){?>
 <a href="news/newslist_j<?=$row1[id]?>v.html" target="_blank" class="acy"><?=$row1[name1]?></a> / 
 <? }?>
 </li>
 </ul>
 <div class="dmain">
 
  <div class="d1">
   <div class="flexslider">
   <ul class="slides">
   <? while1("*","yjcode_ad where adbh='ke_04' and zt=0 order by xh asc");while($row1=mysql_fetch_array($res1)){?>
   <li><a href="<?=$row1[aurl]?>" target="_blank"><img src="gg/<?=$row1[bh]?>.<?=$row1[jpggif]?>" width="425" height="226" border="0" /></a></li>
   <? }?>
   </ul>
   </div>
  </div>
  
  <div class="d2">
  <? while1("*","yjcode_news where zt=0 order by lastsj desc limit 16");if($row1=mysql_fetch_array($res1)){?>
  <a href="news/txtlist_i<?=$row1[id]?>v.html" class="a1" target="_blank" title="<?=$row1[tit]?>"><?=strgb2312($row1[tit],0,38)?></a>
  <? }?>
  <? for($i=1;$i<=6;$i++){if($row1=mysql_fetch_array($res1)){?>
  <a href="news/txtlist_i<?=$row1[id]?>v.html" target="_blank" class="a2 acyn" title="<?=$row1[tit]?>"><?=strgb2312($row1[tit],0,38)?></a>
  <? }}?>
  </div>
  <div class="d3">
  <ul class="du1">
  <li class="l1">行业资讯</li>
  <li class="l2"><a href="news/" class="acyn" target="_blank">更多</a></li>
  <? while($row1=mysql_fetch_array($res1)){?>
  <li class="l3"><a href="news/txtlist_i<?=$row1[id]?>v.html" target="_blank" title="<?=$row1[tit]?>" class="acyn"><?=strgb2312($row1[tit],0,35)?></a></li>
  <? }?>
  </ul>
  </div>
 </div>
 <div class="dad"><? adwhile("ke_05",2)?></div> 
</div>
<!--资讯E-->

</div>

<div class="bfb bfbhz">
<div class="yjcode fontyh">
 <!--友情B-->
 <ul class="u1">
 <li class="l1">合作链接</li>
 <li class="l2">
 <? autoAD("ADI13");while0("*","yjcode_ad where adbh='ADI13' and zt=0 order by xh asc");while($row=mysql_fetch_array($res)){?>
 <a href="<?=$row[aurl]?>" target="_blank"><img alt="<?=$row[tit]?>" border=0 src="gg/<?=$row[bh]?>.<?=$row[jpggif]?>" width="100" height="35"></a>
 <? }?>
 </li>
 <li class="l3">
 <? autoAD("ADI14");while0("*","yjcode_ad where adbh='ADI14' and type1='文字' and zt=0 order by xh asc");while($row=mysql_fetch_array($res)){?>
 <a href="<?=$row[aurl]?>" target="_blank"><?=$row[tit]?></a>
 <? }?>
 </li>
 </ul>
 <!--友情E-->
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