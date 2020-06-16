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
<title><?=$rowcontrol[webtit]?></title>
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
<script language="javascript">
document.getElementById("topmenu1").className="a1";
</script>

 <!--切换B-->
 <div class="banner" id="banner" >
 <? autoAD("shang_01");$i=0;while1("*","yjcode_ad where adbh='shang_01' and zt=0 order by xh asc");while($row1=mysql_fetch_array($res1)){?>
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
 <!--快速登录B-->
 <div id="idlno">
 <ul class="u1 fontyh">
 <li class="l1">快速登录网站</li>
 <li class="l2">登录名：</li>
 <li class="l3"><a href="reg/reg.php">免费注册</a></li>
 <li class="l4"><input type="text" id="it1" /></li>
 <li class="l2">登录密码：</li>
 <li class="l3"><a href="reg/getmm.php">忘记密码？</a></li>
 <li class="l4"><input type="password" id="it2" /></li>
 <li class="l5"><input type="button" id="idl" value="登录" onClick="idldl(0)" /><input type="button" id="idling" disabled style="display:none;" value="正在登录" /></li>
 <li class="l6"><a href="config/qq/oauth/index.php"><img border="0" src="img/qq_login.png" /></a></li>
 </ul>
 </div>
 <div id="idlyes" style="display:none;">
 <ul class="u1 fontyh">
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
 <ul class="tjprocap fontyh">
 <li class="l1">限时优惠促销</li>
 <li class="l2"><a href="product/" target="_blank">查看更多>></a></li>
 </ul>
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
 <li class="l1"><a href="<?=$au?>" target="_blank"><img class="tp" border="0" src="<?=returntp("bh='".$row1[bh]."'","-1")?>" onerror="this.src='img/none200x200.gif'" width="200" height="180" /></a><span class="djs" id="djs<?=$i?>">正在加载</span></li>
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
 
 <!--推荐商家B-->
 <ul class="tjshopcap fontyh">
 <li class="l1">推荐商家</li>
 <li class="l2"><a href="reg/reg.php" target="_blank">我也要入驻</a></li>
 </ul>
 <div class="tjshop fontyh">
  <div class="dleft">
  <? while1("*","yjcode_user where shopname<>'' and shopzt=2 and zt=1 order by sellmall desc limit 5");if($row1=mysql_fetch_array($res1)){?>
  <ul class="u1">
  <li class="l1"><img width="85" height="85" src="<?="upload/".$row1[id]."/shop.jpg"?>" onerror="this.src='img/none180x180.gif'" /></li>
  <li class="l2">
  <a href="shop/view<?=$row1[id]?>.html" target="_blank"><?=strgb2312($row1[shopname],0,15)?></a>
  <span class="s1">收入：</span>
  <span class="s2">￥<strong><?=$row1[sellmall]?></strong></span>
  </li>
  </ul>
  <? }?>
  <? $i=1;while($row1=mysql_fetch_array($res1)){?>
  <ul class="u2">
  <li class="l1"><img width="40" height="40" src="<?="upload/".$row1[id]."/shop.jpg"?>" onerror="this.src='img/none60x60.gif'" /></li>
  <li class="l2 l2<?=$i+1?>">
  <a href="shop/view<?=$row1[id]?>.html" target="_blank"><?=strgb2312($row1[shopname],0,17)?></a>
  <span class="s1">收入：</span>
  <span class="s2">￥<strong><?=$row1[sellmall]?></strong></span>
  </li>
  </ul>
  <? $i++;}?>
  </div>
  
  <div class="dright">
   <? 
   while1("*","yjcode_user where zt=1 and shopzt=2 and shopname<>'' and pm>0 order by pm asc limit 7");for($i=1;$i<=2;$i++){
   if($row1=mysql_fetch_array($res1)){
   $sucnum=returnjgdw($row1[xinyong],"",returnxy($row1[id],1));
   ?>
   <div class="d1">
   <ul class="u1">
   <li class="l1"><a href="shop/view<?=$row1[id]?>.html" target="_blank"><img width="110" height="110" src="<?="upload/".$row1[id]."/shop.jpg"?>" onerror="this.src='img/none180x180.gif'" /></a></li>
   <li class="l2">
   <a href="shop/view<?=$row1[id]?>.html" target="_blank" class="a1 yanse1"><?=strgb2312($row1[shopname],0,17)?></a><br>
   <img src="../img/dj/<?=returnxytp($sucnum)?>" class="img1" title="信用值<?=$sucnum?>" /><br>
   <? while2("*","yjcode_pro where userid=".$row1[id]." and zt=0 and ifxj=0 and iftj>0 order by iftj asc");if($row2=mysql_fetch_array($res2)){?>
   <span class="s1"><a href="product/view<?=$row2[id]?>.html" target="_blank"><?=returntitdian($row2[tit],30)?></a></span>
   <span class="s2">￥<?=returnjgdian(returnyhmoney($row2[yhxs],$row2[money2],$row2[money3],$sj,$row2[yhsj1],$row2[yhsj2],$row2[id]))?></span>
   <? }?>
   <a class="s3" href="">主营：<?=strgb2312($row1[seokey],0,24)?></a>
   </li>
   </ul>
   </div>
   <? }}?>
   <? for($i=1;$i<=3;$i++){
   if($row1=mysql_fetch_array($res1)){
   ?>
   <div class="d2 d2<?=$i?>">
   <ul class="u1">
   <li class="l1"><a href="shop/view<?=$row1[id]?>.html" target="_blank"><img width="110" height="110" src="<?="upload/".$row1[id]."/shop.jpg"?>" onerror="this.src='img/none180x180.gif'" /></a></li>
   <li class="l2">
   <a href="shop/view<?=$row1[id]?>.html" target="_blank" class="a1 yanse1"><?=strgb2312($row1[shopname],0,17)?></a><br>
   <? while2("*","yjcode_pro where userid=".$row1[id]." and zt=0 and ifxj=0 and iftj>0 order by iftj asc");if($row2=mysql_fetch_array($res2)){?>
   <span class="s1"><a href="product/view<?=$row2[id]?>.html" target="_blank"><?=returntitdian($row2[tit],25)?></a></span>
   <span class="s2">￥<?=returnjgdian(returnyhmoney($row2[yhxs],$row2[money2],$row2[money3],$sj,$row2[yhsj1],$row2[yhsj2],$row2[id]))?></span>
   <? }?>
   </li>
   </ul>
   </div>
   <? }}?>
  </div>
  
 </div>
 <!--推荐商家E-->

 <!--产品列表B-->
 <?
 autoAD("shang_02");
 $sqlad="select * from yjcode_ad where adbh='shang_02' and zt=0 order by xh asc";mysql_query("SET NAMES 'GBK'");$resad=mysql_query($sqlad);
 $ni=1;
 while1("*","yjcode_type where admin=1 and (iftj is null or iftj=0) order by xh asc");while($row1=mysql_fetch_array($res1)){
 ?>
 <ul class="typecap fontyh">
 <li class="l1"><?=$ni?>F <?=$row1[type1]?></li>
 <li class="l2">
 <? while2("*","yjcode_type where type1='".$row1[type1]."' and admin=2 order by xh asc limit 4");while($row2=mysql_fetch_array($res2)){?>
 <a href="product/search_j<?=$row1[id]?>v_k<?=$row2[id]?>v.html" target="_blank"><?=$row2[type2]?></a> / 
 <? }?>
 </li>
 </ul>
 <div class="typem fontyh">
  <div class="dleft">
   <div class="d1">
   <? 
   while0("*","yjcode_pro where ifxj=0 and zt=0 and ty1id=".$row1[id]." order by lastsj desc limit 4");while($row=mysql_fetch_array($res)){
   $au="product/view".$row[id].".html";
   $money1=returnjgdian(returnyhmoney($row[yhxs],$row[money2],$row[money3],$sj,$row[yhsj1],$row[yhsj2],$row[id]));
   ?>
   <ul class="u1">
   <li class="l1"><a href="<?=$au?>" target="_blank"><img border="0" src="<?=returntp("bh='".$row[bh]."'","-2")?>" onerror="this.src='img/none60x60.gif'" width="40" height="40" /></a></li>
   <li class="l2"><a href="<?=$au?>" target="_blank" title="<?=$row[tit]?>"><?=strgb2312($row[tit],0,25)?></a><br><span class="s1">￥<?=$money1?></span><span class="s2">售:<?=$row[xsnum]?>件</span></li>
   </ul>
   <? }?>
   <div class="ad"><? if($rowad=mysql_fetch_array($resad)){adreadID($rowad[id],240,230);}?></div>
   </div>
  </div>
  
  <div class="dright">
   <?
   while0("*","yjcode_pro where ifxj=0 and zt=0 and iftj>0 and ty1id=".$row1[id]." order by iftj asc limit 10");while($row=mysql_fetch_array($res)){
   $au="product/view".$row[id].".html";
   $money1=returnyhmoney($row[yhxs],$row[money2],$row[money3],$sj,$row[yhsj1],$row[yhsj2],$row[id]);
   ?>
   <div class="d1" onMouseOver="this.className='d1 d11';" onMouseOut="this.className='d1';">
   <ul class="u1">
   <li class="l1"><a href="<?=$au?>" target="_blank"><img border="0" src="<?=returntp("bh='".$row[bh]."'","-2")?>" onerror="this.src='img/none180x180.gif'" width="166" height="166" /></a></li>
   <li class="l2">
   <a href="<?=$au?>" class="a1" target="_blank" title="<?=$row[tit]?>"><?=strgb2312($row[tit],0,37)?></a>
   <span class="s1">￥<?=$money1?></span>
   <span class="s2"><?=$row[xsnum]?>人已购</span>
   </li>
   </ul>
   </div>
   <? }?>
  </div>
  
 </div>
 <? $ni++;}?>
 <!--产品列表E-->
 

<!--评论B-->
<div class="pl">

<div class="gdmain">
<ul class="u1"><li class="l1">热门评论</li><li class="l2"></li></ul>
<div class="igd" id="Marquee">
<!--滚动开始-->
<?
while1("*","yjcode_propj order by sj desc limit 30");while($row1=mysql_fetch_array($res1)){
while2("*","yjcode_pro where bh='".$row1[probh]."'");$row2=mysql_fetch_array($res2);
$au="product/view".$row2[id].".html";
?>
<div class="gd">
<table align="left" width="358">
<tr>
<td width="65" valign="middle"><a href="<?=$au?>" target="_blank"><img alt="<?=$row1[tit]?>" src="<?=returntp("bh='".$row2[bh]."' order by xh asc","-2")?>" width="58" height="58" class="tp" /></a></td>
<td width="293" style="line-height:20px;">
<span class="hui"><?=strgb2312($row2[tit],0,44)?><br><?=dateYMDHM($row1[sj])?></span><br><?=returntitdian($row1[txt],40)?>
</td>
</tr>
</table>
</div>
<? }?>
<script>
var Mar = document.getElementById("Marquee");
var child_div=Mar.getElementsByTagName("div")
var picH = 67;//移动高度
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
</div>

<? while1("*","yjcode_newstype where admin=1 order by xh asc limit 2");while($row1=mysql_fetch_array($res1)){?>
<ul class="u2">
<li class="l1"><?=$row1[name1]?></li><li class="l2"><a href="news/newslist_j<?=$row1[id]?>v.html" target="_blank">更多</a></li>
<? while2("*","yjcode_news where type1id=".$row1[id]." and zt=0 order by lastsj desc limit 8");while($row2=mysql_fetch_array($res2)){?>
<li class="l3"><a href="news/txtlist_i<?=$row2[id]?>v.html" title="<?=$row2[tit]?>" target="_blank"><?=returntitcss(strgb2312($row2[tit],0,53),$row2[ifjc],$row2[titys])?></a></li>
<? }?>
</ul>
<? }?>
</div>
<!--评论E-->

<!--排名B-->
<div class="pm pm1">
<ul class="ucap"><li class="l1">销售排行榜</li><li class="l2">销售额</li></ul>
<ul class="u1">
<? $i=1;while1("*","yjcode_user where shopname<>'' and shopzt=2 and zt=1 order by sellmall desc limit 10");while($row1=mysql_fetch_array($res1)){?>
<li class="l1"><a href="shop/view<?=$row1[id]?>.html" target="_blank"><?=strgb2312($row1[shopname],0,30)?></a></li>
<li class="l2 feng">￥<?=$row1[sellmall]?></li>
<? $i++;}?>
</ul>
</div>
<div class="pm pm2">
<ul class="ucap"><li class="l1">最新入驻商家</li><li class="l2">商品数</li></ul>
<ul class="u1">
<? $i=1;while1("*","yjcode_user where shopname<>'' and shopzt=2 and zt=1 order by sj desc limit 10");while($row1=mysql_fetch_array($res1)){?>
<li class="l1"><a href="shop/view<?=$row1[id]?>.html" target="_blank"><?=strgb2312($row1[shopname],0,30)?></a></li>
<li class="l2 feng"><?=returncount("yjcode_pro where userid=".$row1[id]." and ifxj=0 and zt=0")?>件</li>
<? $i++;}?>
</ul>
</div>
<div class="pm pm3">
<ul class="ucap"><li class="l1">30天销售额</li><li class="l2">销售额</li></ul>
<ul class="u1">
<? $i=1;while1("*","yjcode_user where shopname<>'' and shopzt=2 and zt=1 order by sellmyue desc limit 10");while($row1=mysql_fetch_array($res1)){?>
<li class="l1"><a href="shop/view<?=$row1[id]?>.html" target="_blank"><?=strgb2312($row1[shopname],0,30)?></a></li>
<li class="l2 feng">￥<?=$row1[sellmyue]?></li>
<? $i++;}?>
</ul>
</div>
<div class="pm pm4">
<ul class="ucap"><li class="l1">任务大厅</li><li class="l2">时间</li></ul>
<ul class="u1">
<? $i=1;while1("*","yjcode_task where zt=0 order by sj desc limit 10");while($row1=mysql_fetch_array($res1)){?>
<li class="l1"><a href="task/view<?=$row1[id]?>.html" target="_blank"><?=strgb2312($row1[tit],0,30)?></a></li>
<li class="l2"><?=dateYMD($row1[sj])?></li>
<? $i++;}?>
</ul>
</div>
<!--排名E-->

<!--买卖流程B-->
<ul class="tjshopcap fontyh">
<li class="l1">买卖流程</li>
<li class="l2"><a href="reg/reg.php" target="_blank">马上注册</a></li>
</ul>
<div class="maimai">
 <div class="dleft"><div class="d1"></div><div class="d2"></div></div>
 <ul class="u1">
 <li><strong>1、注册账号</strong><br>只需简单的几步便可以轻松完成注册<br><a href="reg/reg.php" target="_blank">立即注册</a></li>
 <li><strong>2、发布商品</strong><br>通过填写资料，申请开店，便可发布商品<br><a href="user/productlx.php" target="_blank">发布商品</a></li>
 <li><strong>3、发货</strong><br>买家拍下商品并支付货款后，自动发货<br><a href="user/sellorder.php" target="_blank">已卖出的商品</a></li>
 <li><strong>4、回复评论</strong><br>买家确认收货并评论，卖家可回复评论<br><a href="user/sellorder.php?ddzt=suc" target="_blank">评价管理</a></li>
 <li class="l5"><strong>1、注册账号</strong><br>在这里，简单几步便可以轻松完成注册<br><a href="reg/reg.php" target="_blank">立即注册</a></li>
 <li class="l5"><strong>2、购买/支付</strong><br>找到所需商品，确认数量后，拍下支付<br><a href="user/car.php" target="_blank">我的购物车</a></li>
 <li class="l5"><strong>3、收货/验货</strong><br>收到商品后，及时验证商品<br><a href="user/order.php" target="_blank">我的商品订单</a></li>
 <li class="l5"><strong>4、收货/评价</strong><br>验证商品不存问题后，确认收货并评价<br><a href="user/order.php?ddzt=db" target="_blank">收货</a></li>
 </ul>
 <div class="blue01"><? adread("blue_01",130,260)?></div>
</div>
<!--买卖流程E-->

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