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
<script language="javascript" src="js/basic.js"></script>
<script language="javascript" src="js/jquery.min.js"></script>
<script src="homeimg/imgload.js" type="text/javascript"></script> 
<script language="javascript" src="js/index.js"></script>
<? if(empty($rowcontrol[ifwap])){?>
<script language="javascript">
if(is_mobile()) {document.location.href= '<?=weburl?>m/';}
</script>
<? }?>
</head>
<body>
<? include("../../../tem/top.html");?>
<? 
autoAD("ADI00");
while1("*","yjcode_ad where adbh='ADI00' and zt=0 order by xh asc");while($row1=mysql_fetch_array($res1)){
$tp="gg/".$row1[bh].".".$row1[jpggif];
$image_size= getimagesize("../../../".$tp);
?>
<div class="topbanner_hj" style="background:url(<?=$tp?>) no-repeat center 0;height:<?=$image_size[1]?>px;"><a href="<?=$row1[aurl]?>" target="_blank"></a></div>
<? }?>
<? include("../../../tem/top1.html");?>

<!--切换B-->
<div class="banner">
 <div class="flexslider">
 <ul class="slides">
 <? autoAD("jiandan_01");$i=0;while1("*","yjcode_ad where adbh='jiandan_01' and zt=0 order by xh asc");while($row1=mysql_fetch_array($res1)){if($i==0){$s=" center";}else{$s=" 50% 0";}?>
 <li style="background:url(<?=weburl?>gg/<?=$row1[bh]?>.<?=$row1[jpggif]?>)<?=$s?> no-repeat;"><a href="<?=$row1[aurl]?>" target="_blank"></a></li>
 <? $i++;}?>
 </ul>
 </div>
</div>
<script type="text/javascript" src="homeimg/jquery.flexslider-min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
 $('.flexslider').flexslider({
 directionNav: true,
 pauseOnAction: false,
 pauseOnHover:true,
});
})
</script>
<!--切换E-->

<div class="yjcode fontyh">

<div class="typelist">
 <? $i=1;while1("*","yjcode_type where admin=1 and (iftj is null or iftj=0) order by xh asc limit 4");while($row1=mysql_fetch_array($res1)){?>
 <div class="d1<? if($i==4){?> d0<? }?>">
  <div class="ds1"><a href="product/search_j<?=$row1[id]?>v.html" target="_blank"><?=$row1[type1]?></a></div>
  <div class="ds2">
  <? while2("*","yjcode_type where type1='".$row1[type1]."' and admin=2 order by xh asc limit 14");while($row2=mysql_fetch_array($res2)){?>
  <a href="product/search_j<?=$row1[id]?>v_k<?=$row2[id]?>v.html" target="_blank"><?=$row2[type2]?></a>
  <? }?>
  </div>
 </div>
 <? $i++;}?>
</div>

<div class="pcap">
<a href="javascript:void(0);" onMouseMove="plistaover(1)" id="plista1" class="a1 a11">热门精品</a>
<a href="javascript:void(0);" onMouseMove="plistaover(2)" id="plista2" class="a1">最新发布</a>
<form name="topf1" method="post" onSubmit="return indextj()">
<ul class="u1">
<li class="l2"><input name="topt" placeholder="请输入商品搜索关键词" id="topt" type="text" /></li>
<li class="l3"><input type="image" src="<?=weburl?>homeimg/btn1.gif" width="24" height="24" /></li>
</ul>
</form>
</div>

<div class="plist" id="plistma1">
 <? 
 $i=1;
 while0("*","yjcode_pro where ifxj=0 and zt=0 and iftj>0 order by iftj asc limit 20");while($row=mysql_fetch_array($res)){
 if($i % 5==0){$nc=" u0";}else{$nc="";}
 $au="product/view".$row[id].".html";
 $money1=returnjgdian(returnyhmoney($row[yhxs],$row[money2],$row[money3],$sj,$row[yhsj1],$row[yhsj2],$row[id]));
 ?>
 <ul class="u1<?=$nc?>">
 <li class="l1"><a href="<?=$au?>" target="_blank"><img border=0 src="<?=returntp("bh='".$row[bh]."'","-1")?>" onerror="this.src='img/none200x200.gif'" width="213" height="213"></a></li>
 <li class="l2"><a href="<?=$au?>" class="title" target="_blank" title="<?=$row[tit]?>"><?=strgb2312($row[tit],0,45)?></a></li>
 <li class="l3"><?=$money1?></li>
 <li class="l4"><?=dateYMD($row[lastsj])?></li>
 </ul>
 <? $i++;}?>
</div>

<div class="plist" id="plistma2" style="display:none;">
 <? 
 $i=1;
 while0("*","yjcode_pro where ifxj=0 and zt=0 order by lastsj desc limit 20");while($row=mysql_fetch_array($res)){
 if($i % 5==0){$nc=" u0";}else{$nc="";}
 $au="product/view".$row[id].".html";
 $money1=returnjgdian(returnyhmoney($row[yhxs],$row[money2],$row[money3],$sj,$row[yhsj1],$row[yhsj2],$row[id]));
 ?>
 <ul class="u1<?=$nc?>">
 <li class="l1"><a href="<?=$au?>" target="_blank"><img border=0 src="<?=returntp("bh='".$row[bh]."'","-1")?>" onerror="this.src='img/none200x200.gif'" width="213" height="213"></a></li>
 <li class="l2"><a href="<?=$au?>" class="title" target="_blank" title="<?=$row[tit]?>"><?=strgb2312($row[tit],0,45)?></a></li>
 <li class="l3"><?=$money1?></li>
 <li class="l4"><?=dateYMD($row[lastsj])?></li>
 </ul>
 <? $i++;}?>
</div>

<div class="pcap">
<? $i=1;while1("*","yjcode_type where admin=1 and (iftj is null or iftj=0) order by xh asc limit 6");while($row1=mysql_fetch_array($res1)){?>
<a href="javascript:void(0);" onMouseMove="plistbover(<?=$i?>)" id="plistb<?=$i?>" class="a1"><?=$row1[type1]?></a>
<? $i++;}?>
</div>


<? $j=1;while1("*","yjcode_type where admin=1 and (iftj is null or iftj=0) order by xh asc limit 6");while($row1=mysql_fetch_array($res1)){?>
<div class="plist" id="plistmb<?=$j?>" style="display:none;">
 <? 
 $i=1;
 while0("*","yjcode_pro where ifxj=0 and zt=0 and ty1id=".$row1[id]." order by lastsj desc limit 10");while($row=mysql_fetch_array($res)){
 if($i % 5==0){$nc=" u0";}else{$nc="";}
 $au="product/view".$row[id].".html";
 $money1=returnjgdian(returnyhmoney($row[yhxs],$row[money2],$row[money3],$sj,$row[yhsj1],$row[yhsj2],$row[id]));
 ?>
 <ul class="u1<?=$nc?>">
 <li class="l1"><a href="<?=$au?>" target="_blank"><img border=0 src="<?=returntp("bh='".$row[bh]."'","-1")?>" onerror="this.src='img/none200x200.gif'" width="213" height="213"></a></li>
 <li class="l2"><a href="<?=$au?>" class="title" target="_blank" title="<?=$row[tit]?>"><?=strgb2312($row[tit],0,45)?></a></li>
 <li class="l3"><?=$money1?></li>
 <li class="l4"><?=dateYMD($row[lastsj])?></li>
 </ul>
 <? $i++;}?>
</div>
<? $j++;}?>
<span id="itynum" style="display:none;"><?=$j?></span>
<script language="javascript">plistbover(1);</script>

<!--推荐卖家B-->
<div class="tjshop">
<ul class="u1">
<li class="l1">推荐卖家</li>
<li class="l2"><a href="reg/reg.php">现在注册加入我们</a></li>
</ul>
<div class="d1">
<? while1("*","yjcode_user where shopname<>'' and shopzt=2 and zt=1 order by sellmall desc limit 18");while($row1=mysql_fetch_array($res1)){?>
<a href="shop/view<?=$row1[id]?>.html" title="<?=$row1[shopname]?>"><div class="pic"><span>收入<br>￥<?=$row1[sellmall]?></span><img src="<?="upload/".$row1[id]."/shop.jpg"?>" onerror="this.src='img/none180x180.gif'" width="90" height="90"></div><em><?=strgb2312($row1[shopname],0,12)?></em></a>
<? }?>
</div>
</div>
<!--推荐卖家E-->

<!--友情B-->
<div class="bolink">
<ul class="u1">
<li class="l1 fontyh"><?=webname?>合作伙伴</li>
<li class="l2">
<? autoAD("ADI13");while0("*","yjcode_ad where adbh='ADI13' and zt=0 order by xh asc");while($row=mysql_fetch_array($res)){?>
<a href="<?=$row[aurl]?>" target="_blank"><img alt="<?=$row[tit]?>" border=0 src="gg/<?=$row[bh]?>.<?=$row[jpggif]?>" width="100" height="35"></a>
<? }?>
</li>
</ul>
<ul class="u1">
<li class="l1 fontyh"><?=webname?>友情链接</li>
<li class="l3">
<? autoAD("ADI14");while0("*","yjcode_ad where adbh='ADI14' and type1='文字' and zt=0 order by xh asc");while($row=mysql_fetch_array($res)){?>
<a href="<?=$row[aurl]?>" target="_blank"><?=$row[tit]?></a>
<? }?>
</li>
</ul>
</div>
<!--友情E-->

</div>
<? include("../../../tem/bottom.html");?>
<script language="javascript">
if(document.getElementById("rightcontact")){
document.getElementById("rightcontact").className="contact fontyh disyes";
document.getElementById("righttel").className="tel fontyh disno";
}
</script>

<script type="text/javascript">
function scrollpic(obj){
	var scrollObj;
	var currentTop = 0;
		$(obj).children('div:eq(2)').mousemove(function () {
			clearInterval(scrollObj);
			scrollObj = setInterval(function () {
				var mainH = $(obj).children('div:eq(0)').children().height();			
				if (currentTop + mainH > $(obj).height())
				{
					currentTop--;
					currentTop--;
					$(obj).children('div:eq(0)').css('top', currentTop);
				}
			}, 10);
		}).mouseleave(function () {
			clearInterval(scrollObj);
		}).css('margin-top', $(obj).height() / 2);

		$(obj).children('div:eq(1)').mouseover(function () {
			clearInterval(scrollObj);
			
			scrollObj = setInterval(function () {
				var mainH = $(obj).children('div:eq(0)').children().height();
				
				if (currentTop < 0) {
					currentTop++;
					currentTop++;
				
					$(obj).children('div:eq(0)').css('top', currentTop);
				}
			}, 10);
		}).mouseleave(function () {
			clearInterval(scrollObj);
		});	
			
	
}
$(function(){
	$(".scrollpic").each(function(){
		scrollpic($(this));
	});
});
</script>
</body>
</html>