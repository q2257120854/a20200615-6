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
 <? autoAD("DIY_qh");$i=0;while1("*","yjcode_ad where adbh='DIY_qh' and zt=0 order by xh asc");while($row1=mysql_fetch_array($res1)){?>
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


<div class="topic">  
<div class="feggwrap">
    <div class="fegg comfff wow fadeInUp">
    <div class="feggspan">最新交易</div>
    <b></b>
    <div class="feggc">
        <div class="announce-wrap"id="rolltxt">
		  <? $i=0;while1("*","yjcode_order where (ddzt='wait' or ddzt='db' or ddzt='suc') order by sj desc limit 30");while($row1=mysql_fetch_array($res1)){?>
            <div class="gd">
			<ul class="announce-list relative" style="top: 0px;">
          <li><span class="blue"><?=mb_substr(returnnc($row1[userid]),0,2);?>***<?=mb_substr(returnnc($row1[userid]),-2,2);?>&nbsp;&nbsp;购买了</span><a href="product/view<?=returnproid($row1[probh])?>.html"  target="_blank" ><?=returntitdian($row1[tit],40)?> </a> 成交价：<font  color="#ff6600"><strong>￥<?=$row1[money1]?></strong> </font>&nbsp;&nbsp;[<?=returnorderzt($row1[ddzt])?>] </li>
			</ul>
		 </div>  
		  <? }?>
      </div>
	</div>

<script>
var Mar = document.getElementById("rolltxt");
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
    <div class="clear"></div>
  </div>
    <div class="fechart">
    <ul>
        <li class="fechart1"><i></i>
        <div class="fechartdiv"><span>会员</span>
            <div class="clear"></div>
            <em><?=returncount("yjcode_user")+$inittjarr[0]?> </em></div>
        <div class="clear"></div>
      </li>
        <li class="fechart2"><i></i>
        <div class="fechartdiv"><span>商品</span>
            <div class="clear"></div>
            <em> <?=returncount("yjcode_pro where zt=0 and ifxj=0")+$inittjarr[1]?></em></div>
        <div class="clear"></div>
      </li>
        <li class="fechart3"><i></i>
        <div class="fechartdiv"><span>交易</span>
            <div class="clear"></div>
            <em> <?=returncount("yjcode_order where (ddzt='wait' or ddzt='db' or ddzt='back' or ddzt='suc')")+$inittjarr[2]?> </em></div>
        <div class="clear"></div>
      </li>
        <li class="fechart4"><i></i>
        <div class="fechartdiv"><span>金额</span>
            <div class="clear"></div>
            <em><?=sprintf("%.0f",$inittjarr[3]+returnsum("money1*num","yjcode_order where ddzt<>'backsuc' and ddzt<>'close'"))?> </em></div>
      </li>
        <div class="clear"></div>
      </ul>
  </div>
    <div class="clear"></div>
  </div>

<div class="design_list">
    <div class="f-design_lbox05" style="background-color: transparent;"> <a href="/reg/reg.php" class="f-design_blue" style="margin-bottom:0px;">
      <div class="f-design_bigicon"><i class="icon_tbs icon_aew1"></i></div>
      <div class="f-design_pictxt">
      <h4>邀请注册</h4>
      <p>获取丰厚的佣金奖励</p>
    </div>
      </a> </div>
    <div class="f-design_lbox05" style="background-color: transparent;"> <a href="/user/qiandao.php" class="f-design_red" style="margin-bottom:0px;">
      <div class="f-design_bigicon"><i class="icon_tbs icon_aew2"></i></div>
      <div class="f-design_pictxt">
      <h4>每日签到</h4>
      <p>积分奖励(最高可获得10分)</p>
    </div>
      </a> </div>
    <div class="f-design_lbox05" style="background-color: transparent;"> <a href="https://jq.qq.com/?_wv=1027&k=5wrEUAW" target="_blank" class="f-design_black" style="margin-bottom:0px;">
      <div class="f-design_bigicon"><i class="icon_tbs icon_aew3"></i></div>
      <div class="f-design_pictxt">
      <h4>QQ群联盟</h4>
      <p>加入群联盟 享特殊福利</p>
    </div>
      </a> </div>
    <div class="f-design_lbox05" style="background-color: transparent;"> <a href="#" target="_blank" class="f-design_green" title="Html5+Css3教程" style="margin-bottom:0px;">
      <div class="f-design_bigicon"><i class="icon_tbs icon_aew4"></i></div>
      <div class="f-design_pictxt">
      <h4>PS教程</h4>
      <p>让你少走10000米弯路</p>
    </div>
      </a> 
	  </div>
  </div>
</div>

<div class="bfb"></div>

 <div class="guanggao"><? adwhile("DIY_03");?></div>
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
<div class="guanggao"><? adwhile("DIY_04");?></div>
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
  <a href="product/search_j<?=$row1[id]?>v.html">查看更多>></a>
  </li>
  </ul>
 </div>
 <div class="prolist" id="ilist<?=$i?>_1">
  <ul class="u1">
  <?
  while0("*","yjcode_pro where ifxj=0 and zt=0 and iftj>0 and ty1id=".$row1[id]." order by iftj asc limit 10");while($row=mysql_fetch_array($res)){
  $au="product/view".$row[id].".html";
  $money1=returnyhmoney($row[yhxs],$row[money2],$row[money3],$sj,$row[yhsj1],$row[yhsj2],$row[id]);
  while3("*","yjcode_user where id=".$row[userid]);$row3=mysql_fetch_array($res3);
  ?>

  <li class="l1">

  <a target="_blank" href="<?=$au?>" class="a1"><img src="<?=returntp("bh='".$row[bh]."'","-1")?>"width="210" height="200"></a>
  <a target="_blank" href="<?=$au?>" class="a2"><?=strgb2312($row[tit],0,30)?></a>
  <div class="d2">
  <? if($row[fhxs]==2 || $row[fhxs]==3 || $row[fhxs]==4){?>
  <span class="a5">自动发货</span><? }else{?><span class="a5">手动发货</span><? }?>&nbsp;&nbsp;<font size="2" color=""><?=dateYMD($row[sj])?></font></time>
   <em class="a4">￥<?=$money1?></em></span>
   <div class="d1">
   <a class="s1" href="shop/view<?=$row3[id]?>.html" target="_blank"><img src="upload/<?=$row3[id]?>/shop.jpg"></a>
   <em><?=strgb2312($row3[shopname],0,17)?></em>
  <a target="_blank" href="<?=$au?>" class="a3"><?=dateMD($row[sj])?></a>
 </div>
 </li>
  <? }?>
   </ul>
 </div>
 
 <div class="prolist" id="ilist<?=$i?>_2" style="display:none;">
   <ul class="u1">
  <?
  while0("*","yjcode_pro where ifxj=0 and zt=0 and iftj>0 and ty1id=".$row1[id]." order by xsnum asc limit 10");while($row=mysql_fetch_array($res)){
  $au="product/view".$row[id].".html";
  $money1=returnyhmoney($row[yhxs],$row[money2],$row[money3],$sj,$row[yhsj1],$row[yhsj2],$row[id]);
  while3("*","yjcode_user where id=".$row[userid]);$row3=mysql_fetch_array($res3);
  ?>
   <li class="l1">

  <a target="_blank" href="<?=$au?>" class="a1"><img src="<?=returntp("bh='".$row[bh]."'","-1")?>"width="210" height="200"></a>
  <a target="_blank" href="<?=$au?>" class="a2"><?=strgb2312($row[tit],0,30)?></a>
  <div class="d2">
  <? if($row[fhxs]==2 || $row[fhxs]==3 || $row[fhxs]==4){?>
  <span class="a5">自动发货</span><? }else{?><span class="a5">手动发货</span><? }?>&nbsp;&nbsp;<font size="2" color=""><?=dateYMD($row[sj])?></font></time>
   <em class="a4">￥<?=$money1?></em></span>
   <div class="d1">
   <a class="s1" href="shop/view<?=$row3[id]?>.html" target="_blank"><img src="upload/<?=$row3[id]?>/shop.jpg"></a>
   <em><?=strgb2312($row3[shopname],0,17)?></em>
  <a target="_blank" href="<?=$au?>" class="a3"><?=dateMD($row[sj])?></a>
 </div>
 </li>
  <? }?>
 </div>
 <? $i++;}?>
 <!--列表E-->
<div class="guanggao"><? adwhile("DIY_05");?></div>
 <!--友情B-->
 <div class="bolink">
 <ul class="u1">
 <li class="l1 fontyh">友情链接</li>
 <li class="l3">
 <? autoAD("ADI14");while0("*","yjcode_ad where adbh='ADI14' and type1='文字' and zt=0 order by xh asc");while($row=mysql_fetch_array($res)){?>
 <a href="<?=$row[aurl]?>" target="_blank"><?=$row[tit]?></a>
 <? }?>
 </li>
 </ul>
 </div>
 <!--友情E-->

</div>
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
$(".prolist .u1 .l1").mouseenter(function () {
    $(this).find('.d1').eq(0).stop().animate({'top': '178px'}, 200);
});
$(".prolist .u1 .l1").mouseleave(function () {
    $(this).find('.d1').eq(0).stop().animate({'top': '280px'}, 200);
});
</script>
</body>
</html>