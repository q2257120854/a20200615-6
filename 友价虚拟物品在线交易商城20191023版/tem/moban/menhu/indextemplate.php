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
<script type="text/javascript" src="js/jquery.min.js"></script>
<script language="javascript" src="js/index.js"></script>
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
document.getElementById("topmenu1").className="a1";
</script>

 <!--切换B-->
 <div class="banner" id="banner" >
 <? autoAD("shang_01");$i=0;while1("*","yjcode_ad where adbh='menhu_01' and zt=0 order by xh asc");while($row1=mysql_fetch_array($res1)){?>
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
<!--公告调用结束-->
</div>

<div class="bfb"></div>

<div class="yjcode">
 <div class="tjad"><? adread("shang_03",220,140)?></div>
 <!--统计B-->
 <div class="tongji fontyh">
  <ul class="u1">
  <li class="l1">数据统计</li>
  <?
  $inittjarr=array(0,0,0,0);
  $inittjb=preg_split("/,/",$rowcontrol[inittj]);
  for($i=0;$i<count($inittjb);$i++){
  if(is_numeric($inittjb[$i])){$inittjarr[$i]=$inittjb[$i];}
  }
  ?>
  <li class="l2">会员：<strong> <?=returncount("yjcode_user")+$inittjarr[0]?> </strong>位</li>
  <li class="l2">商品：<strong> <?=returncount("yjcode_pro where zt=0 and ifxj=0")+$inittjarr[1]?> </strong>件</li>
  <li class="l2">交易：<strong> <?=returncount("yjcode_order where (ddzt='wait' or ddzt='db' or ddzt='back' or ddzt='suc')")+$inittjarr[2]?> </strong>笔</li>
  <li class="l2">金额：<strong> <?=sprintf("%.0f",$inittjarr[3]+returnsum("money1*num","yjcode_order where ddzt<>'backsuc' and ddzt<>'close'"))?> </strong>元</li>
  </ul>
  <ul class="u2">
  <li class="l1">网站公告</li>
  <li class="l2">
  <? while0("*","yjcode_gg where zt=0 order by sj desc limit 4");while($row=mysql_fetch_array($res)){?>
  <a href="help/ggview<?=$row[id]?>.html" title="<?=$row[tit]?>" target="_blank">[<?=dateMD($row[sj])?>] <?=returntitdian($row[tit],36)?></a>
  <? }?>
  </li>
  </ul>
 </div>
 <!--统计E-->
 
 <!--推荐产品B-->
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
 <ul class="u1 u1<?=$i?>" onMouseOver="this.className='u1 u1<?=$i?> u21';" onMouseOut="this.className='u1 u1<?=$i?>';">
 <li class="l1"><a href="<?=$au?>" target="_blank"><img class="tp" border="0" src="<?=returntp("bh='".$row1[bh]."'","-1")?>" onerror="this.src='img/none200x200.gif'" width="200" height="180" /></a><span class="djs" id="djs<?=$i?>">正在加载</span><img class="xs" src="homeimg/xs.png" /></li>
 <li class="l2"><a href="<?=$au?>" title="<?=$row1[tit]?>" target="_blank"><?=strgb2312($row1[tit],0,56)?></a></li>
 <li class="l3">￥<?=$money1?></li>
 <li class="l4"><a href="<?=$au?>" target="_blank">去看看</a></li>
 </ul>
 <? $i++;}?>
 </div>
 <script language="javascript">
 userChecksj();
 </script>
 <!--推荐产品E-->

 <!--列表B-->
 <?
 $i=1;
 while1("*","yjcode_type where admin=1 and iftj=0 order by xh asc");while($row1=mysql_fetch_array($res1)){
 ?>
 <div class="icaplist fontyh">
  <div class="d1" style="border-left:<?=$row1[col]?> solid 3px;"><?=$row1[type1]?></div>
  <ul class="u1">
  <li class="l1 l11" id="icap<?=$i?>_1" onMouseOver="icapover(<?=$i?>,1)">推荐商品</li>
  <li class="l1" id="icap<?=$i?>_2" onMouseOver="icapover(<?=$i?>,2)">热销商品</li>
  <li class="l2">
  <? while2("*","yjcode_type where admin=2 and type1='".$row1[type1]."' order by xh asc limit 4");while($row2=mysql_fetch_array($res2)){?>
  <a href="product/search_j<?=$row1[id]?>v_k<?=$row2[id]?>v.html"><?=$row2[type2]?></a> | 
  <? }?>
  <a href="product/search_j<?=$row1[id]?>v.html">更多>></a>
  </li>
  </ul>
 </div>
 
 <div class="ilistleft">
  <div class="d1">最新上架商品</div>
  <? 
  while0("*","yjcode_pro where ifxj=0 and zt=0 and ty1id=".$row1[id]." order by lastsj desc limit 8");while($row=mysql_fetch_array($res)){
  $au="product/view".$row[id].".html";
  $money1=returnjgdian(returnyhmoney($row[yhxs],$row[money2],$row[money3],$sj,$row[yhsj1],$row[yhsj2],$row[id]));
  ?>
  <ul class="u1">
  <li class="l1"><a href="<?=$au?>" target="_blank"><img border="0" src="<?=returntp("bh='".$row[bh]."'","-2")?>" onerror="this.src='img/none60x60.gif'" width="45" height="45" /></a></li>
  <li class="l2"><a href="<?=$au?>" target="_blank" title="<?=$row[tit]?>"><?=returntitdian($row[tit],19)?></a><br><span class="s1">￥<?=$money1?></span></li>
  </ul>
  <? }?>
 </div>
 
 <div class="ilist" id="ilist<?=$i?>_1">
  <?
  while0("*","yjcode_pro where ifxj=0 and zt=0 and iftj>0 and ty1id=".$row1[id]." order by iftj asc limit 10");while($row=mysql_fetch_array($res)){
  $au="product/view".$row[id].".html";
  $money1=returnyhmoney($row[yhxs],$row[money2],$row[money3],$sj,$row[yhsj1],$row[yhsj2],$row[id]);
  ?>
  <div class="d1">
  <ul class="u1">
  <li class="l1"><a href="<?=$au?>" target="_blank"><img border="0" src="<?=returntp("bh='".$row[bh]."'","-2")?>" onerror="this.src='img/none60x60.gif'" width="165" height="165" /></a></li>
  <li class="l2">优惠价:<strong><?=$money1?>元</strong></li>
  <li class="l3"><?=sprintf("%.1f",10*$money1/$row[money1])?>折</li>
  <li class="l4"><a href="<?=$au?>" class="a1" target="_blank" title="<?=$row[tit]?>"><?=strgb2312($row[tit],0,47)?></a></li>
  </ul>
  </div>
  <? }?>
 </div>
 
 <div class="ilist" id="ilist<?=$i?>_2" style="display:none;">
  <?
  while0("*","yjcode_pro where ifxj=0 and zt=0 and iftj>0 and ty1id=".$row1[id]." order by xsnum asc limit 10");while($row=mysql_fetch_array($res)){
  $au="product/view".$row[id].".html";
  $money1=returnyhmoney($row[yhxs],$row[money2],$row[money3],$sj,$row[yhsj1],$row[yhsj2],$row[id]);
  ?>
  <div class="d1">
  <ul class="u1">
  <li class="l1"><a href="<?=$au?>" target="_blank"><img border="0" src="<?=returntp("bh='".$row[bh]."'","-2")?>" onerror="this.src='img/none60x60.gif'" width="165" height="165" /></a></li>
  <li class="l2">优惠价:<strong><?=$money1?>元</strong></li>
  <li class="l3"><?=sprintf("%.1f",10*$money1/$row[money1])?>折</li>
  <li class="l4"><a href="<?=$au?>" class="a1" target="_blank" title="<?=$row[tit]?>"><?=strgb2312($row[tit],0,47)?></a></li>
  </ul>
  </div>
  <? }?>
 </div>
 
 <? $i++;}?>
 <!--列表E-->

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


</body>
</html>