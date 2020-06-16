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
<script language="javascript" type="text/javascript" src="homeimg/ss.js"></script>
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
 <div class="banner" id="banner" >
 <? autoAD("928vip_qh");$i=0;while1("*","yjcode_ad where adbh='928vip_qh' and zt=0 order by xh asc");while($row1=mysql_fetch_array($res1)){?>
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
 <div class="index_login">
		<div class="w1190">
			<div class="indetail">
            <div id="idlno">
				<div class="user"><a href="/reg/"><img src="images/userlogo.png" alt="" /></a>
				</div>
				<h2 class="h2tit"><a href="/reg/">Hi，请登录</a></h2>
				<div class="login_re">
				<a href="/reg/" class="mr">登录</a><a href="/reg/reg.php">注册</a>
				</div>
            </div>
             <div id="idlyes" style="display:none;">
				<div class="user">
				<a href="user/" target="_blank"><img border="0" src="user/img/nonetx.gif" id="idltx1" width="70"></a>
				</div>
				<h2 class="h2tit"><a href="user/" id="idl2">Hi，请登录</a></h2>
				<div class="login_re">
				<a href="user/" class="mr">面板</a><a href="user/un.php">注销</a>
				</div>
            </div>
            <script language="javascript">idldl(1);</script>
			<div class="webinfor">网站公告</div><div class="list">
		<ul>
 <? while0("*","yjcode_gg where zt=0 order by sj desc limit 7");while($row=mysql_fetch_array($res)){?>
 <li><a href="help/ggview<?=$row[id]?>.html" title="<?=$row[tit]?>" target="_blank"><?=strgb2312($row[tit],0,20)?></a></li>
 <? }?>
					</ul>
				</div>
			</div>
		</div>
	</div>
			<div class="bd">
				<ul><? $i=0;while1("*","yjcode_ad where adbh='dz_qh' and zt=0 order by xh asc");while($row1=mysql_fetch_array($res1)){?>
					<li style="background:url(gg/<?=$row1[bh]?>.<?=$row1[jpggif]?>)  center 0 no-repeat;"></li>
                    <? }?>
				</ul>
			</div>
		<div class="hd"><ul></ul></div>
	</div>
	<script type="text/javascript">
		jQuery(".fullSlide").slide({ titCell:".hd ul", mainCell:".bd ul", effect:"fold",  autoPlay:true, autoPage:true, trigger:"click" });
	</script>
	</div>
</div>

<div class="bfb"></div>

<div class="yjcode">

<div class="bfb bfbtoj">
<div class="yjcode">

 <div class="d1">
 <div class="right">
			<em class="icons"></em>		
			<span>指数：</span>
			</div>
 <?
 $inittjarr=array(0,0,0,0);
 $inittjb=preg_split("/,/",$rowcontrol[inittj]);
 for($i=0;$i<count($inittjb);$i++){
 if(is_numeric($inittjb[$i])){$inittjarr[$i]=$inittjb[$i];}
 }
 ?>
 商品：<strong><?=$inittjarr[1]+returncount("yjcode_pro where zt=0 and ifxj=0")?></strong> 个&nbsp;&nbsp;&nbsp;
 会员：<strong><?=$inittjarr[0]+returncount("yjcode_user")?></strong> 位&nbsp;&nbsp;&nbsp;
 商家：<strong><?=returncount("yjcode_user where shopzt=2")?></strong> 家&nbsp;&nbsp;&nbsp;
 交易：<strong><?=$inittjarr[2]+returncount("yjcode_order where (ddzt='wait' or ddzt='db' or ddzt='back' or ddzt='suc')")?></strong> 笔&nbsp;&nbsp;&nbsp;
 成交：<strong><?=sprintf("%.0f",$inittjarr[3]+returnsum("money1*num","yjcode_order where ddzt<>'backsuc' and ddzt<>'close'"))?></strong> 元
 </div>
 <div class="d2">
 <div class="d3"></div>
 <div class="d4">最新交易：</div>
  <div class="newjy">
   <ul id="rolltxt">
   <? $i=0;while1("*","yjcode_order where (ddzt='wait' or ddzt='db' or ddzt='suc') order by sj desc limit 20");while($row1=mysql_fetch_array($res1)){
 $mot=substr($row1[mot],0,3)."*****".substr($row1[mot],8,3);
?>
   <li>	<span class="blue"><?=mb_substr(returnnc($row1[userid]),0,2);?>***<?=mb_substr(returnnc($row1[userid]),-2,2);?>&nbsp;&nbsp;购买了</span> <?=returntitdian($row1[tit],30)?>&nbsp;&nbsp;[<?=returnorderzt($row1[ddzt])?>]</li>
   <? $i++;}?>
   </div>
     </div>
     <span id="jynum" style="display:none;"><?=$i?></span>
      <script language="javascript" src="<?=weburl?>homeimg/jy.js"> </script>
   </div>
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
 <li class="l1"><a href="<?=$au?>" target="_blank"><img border="0" src="<?=returntp("bh='".$row1[bh]."'","-1")?>" /></a><span class="djs" id="djs<?=$i?>">正在加载</span></li>
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
 <li class="l1"><a href="<?=$au?>" target="_blank"><img border="0" src="<?=returntp("bh='".$row[bh]."'","-1")?>" /></a></li>
 <li class="l2"><a href="<?=$au?>" target="_blank" title="<?=$row[tit]?>"><?=strgb2312($row[tit],0,47)?></a></li>
 <li class="l3">￥<?=sprintf("%.2f",$money1)?></li>
 <li class="l4"><a href="shop/view<?=$row3[id]?>.html" target="_blank"><?=strgb2312($row3[shopname],0,17)?></a></li>
 </ul>
 <? $i++;}?>
 </div>
 <!--热门商品E-->
 
 <div class="rmgg">
 <? adwhile("928vip_03");?>
 </div>
 
</div>

 <!--产品列表B-->
 <?
 autoAD("928vip_01");
 autoAD("928vip_02");
 $sqlad="select * from yjcode_ad where adbh='928vip_01' and zt=0 order by xh asc";mysql_query("SET NAMES 'GBK'");$resad=mysql_query($sqlad);
 $sqlad1="select * from yjcode_ad where adbh='928vip_02' and zt=0 order by xh asc";mysql_query("SET NAMES 'GBK'");$resad1=mysql_query($sqlad1);
 $ni=1;
 while1("*","yjcode_type where admin=1 and (iftj is null or iftj=0) order by xh asc");while($row1=mysql_fetch_array($res1)){
 ?>
 <div class="bfb fontyh<? if($ni % 2==0){?> bfbtype1<? }else{?> bfbtype2<? }?>">
 <div class="yjcode">
 
  <ul class="typecap">
  <li class="l1"><?=$row1[type1]?></li>
  <li class="l2">
  <a href="" class="a1" onMouseOver="typeaover(<?=$ni?>,0)" id="typea<?=$ni?>_0">推荐</a>
  <? $j=1;while2("*","yjcode_type where admin=2 and type1='".$row1[type1]."' order by xh asc limit 5");while($row2=mysql_fetch_array($res2)){?>
  <a href="" id="typea<?=$ni?>_<?=$j?>" onMouseOver="typeaover(<?=$ni?>,<?=$j?>)"><?=$row2[type2]?></a>
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
  <li class="l1"><a href="<?=$au?>" target="_blank"><img border="0" src="<?=returntp("bh='".$row[bh]."'","-1")?>" /></a></li>
  <li class="l2"><a href="<?=$au?>" target="_blank" title="<?=$row[tit]?>"><?=strgb2312($row[tit],0,47)?></a></li>
  <li class="l3">￥<?=sprintf("%.2f",$money1)?></li>
  <li class="l4"><a href="shop/view<?=$row3[id]?>.html" target="_blank"><?=strgb2312($row3[shopname],0,17)?></a></li>
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
  <li class="l1"><a href="<?=$au?>" target="_blank"><img border="0" src="<?=returntp("bh='".$row[bh]."'","-1")?>" /></a></li>
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
  <a href="<?=$au?>" target="_blank"><img align="left" border="0" src="<?=returntp("bh='".$row[bh]."'","-2")?>" /></a>
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

<!--合作伙伴B-->
<div class="indexcap fontyh">合作伙伴</div>

<div class="mr_frbox">
  <img class="mr_frBtnL prev" src="homeimg/mfrL.jpg" width="28" height="46" />
  <div class="mr_frUl">
  <ul>
   
	 <? autoAD("ADI13");while0("*","yjcode_ad where adbh='ADI13' and zt=0 order by xh asc");while($row=mysql_fetch_array($res)){?>
 
	<li><a href="<?=$row[aurl]?>" target="_blank"> <img alt="<?=$row[tit]?>" border=0 src="gg/<?=$row[bh]?>.<?=$row[jpggif]?>" width="140" height="49"></a></li>
 <? }?>
    </ul>
  </div>
  <img class="mr_frBtnR next" src="homeimg/mfrR.jpg" width="28" height="46" />
</div>
<script language="javascript">
$(".mr_frUl ul li img").hover(function(){$(this).css("border-color","#A0C0EB");},function(){$(this).css("border-color","#d8d8d8")});
jQuery(".mr_frbox").slide({titCell:"",mainCell:".mr_frUl ul",autoPage:true,effect:"leftLoop",autoPlay:true,vis:7});
</script>
<!--合作伙伴E-->

</div>

 <!--友情E-->
</div>
</div>

</div>
<? include("../../../tem/bottom.html");?>
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