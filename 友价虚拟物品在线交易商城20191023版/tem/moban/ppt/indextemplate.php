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
<script type="text/javascript" src="js/jquery.min.js"></script>
<script language="javascript" src="js/basic.js"></script>
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
$tp=returnjgdw($rowcontrol[addir],"","gg")."/".$row1[bh].".".$row1[jpggif];
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

 <!--切换B-->
 <div class="banner" id="banner" >
 <? autoAD("ppt_qh");$i=0;while1("*","yjcode_ad where adbh='ppt_qh' and zt=0 order by xh asc");while($row1=mysql_fetch_array($res1)){?>
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
<div class="yjcode">
<!--公告调用开始-->
<div class="iright">
<div class="cap">最新交易</div>
<div class="igd" id="Marquee">
<!--滚动开始-->
<?
while1("*","yjcode_order where (ddzt='suc' or ddzt='db' or ddzt='wait') order by sj desc limit 30");while($row1=mysql_fetch_array($res1)){
?>
<div class="gd">
<table align="left" width="210" style="color:#fff;">
<tr>
<td width="210" style="line-height:20px;"><?=strgb2312(returnnc($row1[userid]),0,10)?> 购买了 <span><?=returntitdian($row1[tit],33)?></span> <strong class="feng">￥<?=$row1[money1]*$row1[num]?></strong> [<?=strip_tags(returnorderzt($row1[ddzt]))?>]</td>
</tr>
</table>
</div>
<? }?>
<script>
var Mar = document.getElementById("Marquee");
var child_div=Mar.getElementsByTagName("div")
var picH = 47;//移动高度
var scrollstep=3;//移动步幅,越大越快
var scrolltime=20;//移动频度(毫秒)越大越慢
var stoptime=3000;//间断时间(毫秒)
var tmpH = 0;
Mar.innerHTML += Mar.innerHTML;
function start(){
if(tmpH < picH){
tmpH += scrollstep;
if(tmpH > picH )tmpH = picH ;
Mar.scrollTop = tmpH;
setTimeout(start,scrolltime);
}else{
tmpH = 0;
Mar.appendChild(child_div[0]);
Mar.scrollTop = 0;
setTimeout(start,stoptime);
}
}
setTimeout(start,stoptime);
</script>
<!--滚动结束-->
</div>

<div class="cap">推荐店铺</div>
<? while1("*","yjcode_user where zt=1 and shopzt=2 and shopname<>'' and pm>0 order by pm asc limit 4");while($row1=mysql_fetch_array($res1)){sellmoneytj($row1[id]);?>
<ul class="stj">
<li class="l1"><a href="shop/view<?=$row1[id]?>.html" target="_blank"><img width="50" height="50" src="<?="upload/".$row1[id]."/shop.jpg"?>" onerror="this.src='img/none180x180.gif'" /></a></li>
<li class="l2"><a href="shop/view<?=$row1[id]?>.html" target="_blank"><?=strgb2312($row1[shopname],0,17)?></a><br>销售收入：<span class="feng">￥<?=$row1[sellmall]?></span></li>
</ul>
<? }?>
</div>
<div class="bfb"></div>

<div class="yjcode">
 
 <div class="qhad"> </div>

 <!--推荐产品B-->
 <ul class="procap fontyh">
 <li class="l1">限时优惠促销</li>
 <li class="l2"><a href="product/" target="_blank">查看更多>></a></li>
 </ul>
 
 
 <div class="dtj fontyh">
 <? 
 $i=1;
 while1("*","yjcode_pro where zt=0 and ifxj=0 and iftuan=1 and yhxs=2 and yhsj2>'".$sj."' order by yhsj2 asc limit 4");while($row1=mysql_fetch_array($res1)){
 $money1=returnyhmoney($row1[yhxs],$row1[money2],$row1[money3],$sj,$row1[yhsj1],$row1[yhsj2],$row1[id]);
 $au="product/view".$row1[id].".html";
 $dqsj=str_replace("-","/",$row1[yhsj2]);
 while2("*","yjcode_user where id=".$row1[userid]);$row2=mysql_fetch_array($res2);
 ?>
 <span id="dqsj<?=$i?>" style="display:none;"><?=$dqsj?></span>
 <ul class="u1 u1<?=$i?>">
 <li class="l1"><a href="<?=$au?>" target="_blank"><img border="0" src="<?=returntp("bh='".$row1[bh]."'","-1")?>" onerror="this.src='img/none180x180.gif'" /></a><span class="djs" id="djs<?=$i?>">正在加载</span></li>
 <li class="l2"><a href="<?=$au?>" target="_blank" title="<?=$row1[tit]?>"><?=strgb2312($row1[tit],0,47)?></a></li>
 <li class="l3"><?=$row1[djl]?></li>
 <li class="l4"><?=$row1[xsnum]?></li>
 <li class="l5"><a href="shop/view<?=$row2[id]?>.html" target="_blank"><?=strgb2312($row2[shopname],0,17)?></a></li>
 </ul>
 
 <? $i++;}?>
 </div>
 
 <script language="javascript">
 userChecksj();
 </script>
 <!--推荐产品E-->
  <!--今日更新B-->
 <ul class="procap fontyh">
 <li class="l1">今日更新</li>
 <li class="l2"><a href="product/" target="_blank">查看更多</a></li>
 </ul>
 <div class="dtj fontyh">
  <? 
 $i=1;
 while0("*","yjcode_pro where ifxj=0 and zt=0 order by lastsj desc limit 4");while($row=mysql_fetch_array($res)){
 $money1=returnjgdian(returnyhmoney($row[yhxs],$row[money2],$row[money3],$sj,$row[yhsj1],$row[yhsj2],$row[id]));
 $au="product/view".$row[id].".html";
 while3("*","yjcode_user where id=".$row[userid]);$row3=mysql_fetch_array($res3);
 ?>
 <ul class="u1 u1<?=$i?>">
  <li class="l1"><a href="<?=$au?>" target="_blank"><img alt="<?=$row[tit]?>" border="0" src="<?=returntp("bh='".$row[bh]."'","-1")?>" onerror="this.src='img/none180x180.gif'" width="275"/></a></li>
 <li class="l2"><a href="<?=$au?>" target="_blank" title="<?=$row[tit]?>"><?=strgb2312($row[tit],0,47)?></a></li>
 <li class="l3"><?=$row[djl]?></li>
 <li class="l4"><?=$row[xsnum]?></li>
 <li class="l5 f_gr"><?=strgb2312($row2[shopname],0,17)?></li>
  </ul>
   <? $i++;}?>
  </div>
 <!--今日更新E-->
 <div class="rmgg">
  </div>
</div>
</div>
 <!--产品列表B-->
  <?
 autoAD("ppt_01");
 autoAD("ppt_02");
 $sqlad="select * from yjcode_ad where adbh='ppt_01' and zt=0 order by xh asc";mysql_query("SET NAMES 'GBK'");$resad=mysql_query($sqlad);
 $sqlad1="select * from yjcode_ad where adbh='ppt_02' and zt=0 order by xh asc";mysql_query("SET NAMES 'GBK'");$resad1=mysql_query($sqlad1);
 $ni=1;
 while1("*","yjcode_type where admin=1 and (iftj is null or iftj=0) order by xh asc limit 5");while($row1=mysql_fetch_array($res1)){
 ?>
 <div class="bfb fontyh<? if($ni % 2==0){?> bfbtype1<? }else{?> bfbtype2<? }?>">
 <div class="yjcode">
 
  <ul class="typecap">
  <li class="l1"><?=$row1[type1]?></li>
  <li class="l2">
  <a href="javascript:void(0);" class="a1" onMouseOver="typeaover(<?=$ni?>,0)" id="typea<?=$ni?>_0">推荐</a>
  <? $j=1;while2("*","yjcode_type where admin=2 and type1='".$row1[type1]."' order by xh asc limit 5");while($row2=mysql_fetch_array($res2)){?>
  <a href="product/search_j<?=$row1[id]?>v_k<?=$row2[id]?>v.html" target="_blank" id="typea<?=$ni?>_<?=$j?>" onMouseOver="typeaover(<?=$ni?>,<?=$j?>)"><?=$row2[type2]?></a>
  <? $j++;}?>
  <span id="typea<?=$ni?>" style="display:none;"><?=$j?></span>
  </li>
  </ul>
  <div class="leftgg"><div class="gg0"><? if($rowad=mysql_fetch_array($resad)){adreadID($rowad[id],275,380);}?>    </div><div class="gg1"><? if($rowad1=mysql_fetch_array($resad1)){adreadID($rowad1[id],275,380);}?></div></div>
  
   <div class="pdright fontyh" id="dright<?=$ni?>_0">
   
   
  <? 
  while0("*","yjcode_pro where zt=0 and ifxj=0 and ty1id=".$row1[id]." and iftj>0 order by iftj asc limit 6");while($row=mysql_fetch_array($res)){
  $money1=returnjgdian(returnyhmoney($row[yhxs],$row[money2],$row[money3],$sj,$row[yhsj1],$row[yhsj2],$row[id]));
  $au="product/view".$row[id].".html";
  while3("*","yjcode_user where id=".$row[userid]);$row3=mysql_fetch_array($res3);
  ?>
   
   <ul class="u1">
  <li class="l1"><a href="<?=$au?>" target="_blank"><img alt="<?=$row[tit]?>" border="0" src="<?=returntp("bh='".$row[bh]."'","-1")?>" onerror="this.src='img/none180x180.gif'" /></a></li>
  <li class="l2"><h3><a href="<?=$au?>" target="_blank" title="<?=$row[tit]?>"><?=strgb2312($row[tit],0,47)?></a></h3></li>
  <li class="l3"><?=$row[djl]?></li>
  <li class="l4"><?=$row[xsnum]?></li>
    <li class="l5 f_gr"><?=strgb2312($row3[shopname],0,17)?></li>
    </ul>
	  <? }?>
    </div>

   <? $j=1;while2("*","yjcode_type where admin=2 and type1='".$row1[type1]."' order by xh asc limit 5");while($row2=mysql_fetch_array($res2)){?>
  <div class="pdright fontyh" id="dright<?=$ni?>_<?=$j?>" style="display:none;">
  <? 
  while0("*","yjcode_pro where zt=0 and ifxj=0 and ty1id=".$row1[id]." and ty2id=".$row2[id]." order by lastsj desc limit 6");while($row=mysql_fetch_array($res)){
  $money1=returnjgdian(returnyhmoney($row[yhxs],$row[money2],$row[money3],$sj,$row[yhsj1],$row[yhsj2],$row[id]));
  $au="product/view".$row[id].".html";
  while3("*","yjcode_user where id=".$row[userid]);$row3=mysql_fetch_array($res3);
  ?>
    <ul class="u1">
  <li class="l1"><a href="<?=$au?>" target="_blank"><img alt="<?=$row[tit]?>" border="0" src="<?=returntp("bh='".$row[bh]."'","-1")?>" onerror="this.src='img/none180x180.gif'" /></a></li>
  <li class="l2"><h3><a href="<?=$au?>" target="_blank"><?=strgb2312($row[tit],0,47)?></a></h3></li>
  <li class="l3"><?=$row[djl]?></li>
  <li class="l4"><?=$row[xsnum]?></li>
  <li class="l5 f_gr"><?=strgb2312($row3[shopname],0,17)?></li>
    </ul>
	  <? }?>
    </div>
  <? $j++;}?>
    
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
     <? while1("*","yjcode_ad where adbh='ppt_04' and zt=0 order by xh asc");while($row1=mysql_fetch_array($res1)){?>
    <li><a href="<?=$row1[aurl]?>" target="_blank"><img src="gg/<?=$row1[bh]?>.<?=$row1[jpggif]?>" width="425" height="226" border="0" /></a></li>
   <? }?>
   </ul>
   </div>
  </div>
  
  <div class="d2">
    <? while1("*","yjcode_news where zt=0 order by lastsj desc limit 16");if($row1=mysql_fetch_array($res1)){?>

  <li> <a href="news/txtlist_i<?=$row1[id]?>v.html" class="a1" target="_blank" title="<?=$row1[tit]?>"><?=strgb2312($row1[tit],0,38)?></a></li>
  <? }?>
  <? for($i=1;$i<=6;$i++){if($row1=mysql_fetch_array($res1)){?>
  <li> <a href="news/txtlist_i<?=$row1[id]?>v.html" target="_blank" class="a2 acyn" title="<?=$row1[tit]?>"><?=strgb2312($row1[tit],0,38)?></a></li>
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
  <div class="dad"><? adwhile("ppt_05",140,280)?></div> 
</div>
<!--资讯E-->
</div>

<div class="bfb bfbhz">
<div class="yjcode fontyh">
 <!--友情B-->
 <ul class="u1">
 <li class="l1">我们的优质客户<span>数千家政府部门、企事业单位选择我们，超过10万用户认可</span></li>
 <li class="l2">

 <? autoAD("ADI13");while0("*","yjcode_ad where adbh='ADI13' and zt=0 order by xh asc");while($row=mysql_fetch_array($res)){?>
 
 
<a><img class="a1" alt="<?=$row[tit]?>" border=0 src="gg/<?=$row[bh]?>.<?=$row[jpggif]?>" width="220" height="84" ></a> 
 <? }?>

  </li>

 <li class="l3"><span>友情链接：</span>
 <? autoAD("ADI14");while0("*","yjcode_ad where adbh='ADI14' and type1='文字' and zt=0 order by xh asc");while($row=mysql_fetch_array($res)){?>
 <a href="<?=$row[aurl]?>" target="_blank"><?=$row[tit]?></a>
 <? }?>
  </li>
 </ul>
 <!--友情E-->
</div>
</div>
<? include("../../../tem/bottom.html");?>
<script language="javascript" >
$(".rightfd .d4").hide()

$(window).scroll(function(){
    if($(window).scrollTop() > 100){
        $(".rightfd .d4").fadeIn()
    }else {
        $(".rightfd .d4").fadeOut()
    }
});
</script>
<!--**********右侧浮动结束***************--><script language="javascript">
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