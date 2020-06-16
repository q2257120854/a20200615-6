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
 <? autoAD("gao_qh");$i=0;while1("*","yjcode_ad where adbh='gao_qh' and zt=0 order by xh asc");while($row1=mysql_fetch_array($res1)){?>
 <a href="<?=$row1[aurl]?>" class="d1" target="_blank" style="background:url(gg/<?=$row1[bh]?>.<?=$row1[jpggif]?>) center no-repeat;"></a>
 <? $i++;}?>
 <div class="d2" id="banner_id">
 <ul style="margin-left:-<?=16*$i/2?>px;">
 <? for($j=0;$j<$i;$j++){?><li></li><? }?>
 </ul>
 </div>
 </div>
 <script type="text/javascript">banner();</script>
 <!--切换E-->

 

<div class="yjcode fontyh">
 <div class="ksdl">
 <div id="idlno">
 <ul class="u1">
 <li class="l1"><img src="user/img/nonetx.gif" width="70" height="70" /></li>
<li class="l2">您好，欢迎回来！<br>
 </li>
 <li class="login-btn">
 <a href="reg/" class="a1">登录</a>
 <a href="reg/reg.php" class="a1">注册</a></li>
 </ul>
 </div>
 <div id="idlyes" style="display:none;">
 <ul class="u1">
 <li class="l1"> <a href="user/" target="_blank"><img border="0" src="user/img/nonetx.gif" id="idltx1" width="70"></li>
 <li class="l2">
 您好：<a id="idl1" href="user/" class="green"></a><br>
 总额：<span id="idl2" class="feng"></span>元<br>
 [<a href="user/">管理</a> | &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="user/un.php">退出</a>]
 </li>
 </ul>
 </div>
 <script language="javascript">idldl(1);</script>
 <div class="ksm3">
 <ul class="tit">商城 -<span class="bz">最新公告</span></ul>
 <ul>
 <div class="ksm">
 <? while0("*","yjcode_gg where zt=0 order by sj desc limit 7");while($row=mysql_fetch_array($res)){?>
 [<?=dateMD($row[sj])?>] <a href="help/ggview<?=$row[id]?>.html" title="<?=$row[tit]?>" target="_blank"><?=strgb2312($row[tit],0,18)?></a><br>
 <? }?>
  </div>
   </div>
  </div>
 </div>
<div class="bfb bfbtoj">
<div class="yjcode">
 <div class="d1">
   <div class="newjy">
   <ul id="rolltxt">
   <? $i=0;while1("*","yjcode_order where (ddzt='wait' or ddzt='db' or ddzt='suc') order by sj desc limit 20");while($row1=mysql_fetch_array($res1)){
 $mot=substr($row1[mot],0,3)."*****".substr($row1[mot],8,3);
?>
   <li><span class="blue"><?=mb_substr(returnnc($row1[userid]),0,2);?>***<?=mb_substr(returnnc($row1[userid]),-2,2);?>&nbsp;&nbsp;购买了</span> <?=returntitdian($row1[tit],30)?>&nbsp;&nbsp;[<?=returnorderzt($row1[ddzt])?>]</li>
   <? $i++;}?>
   </div>
     </div>
 <div class="d2">
 <?
 $inittjarr=array(0,0,0,0);
 $inittjb=preg_split("/,/",$rowcontrol[inittj]);
 for($i=0;$i<count($inittjb);$i++){
 if(is_numeric($inittjb[$i])){$inittjarr[$i]=$inittjb[$i];}
 }
 ?>
 会员：<strong><?=$inittjarr[0]+returncount("yjcode_user")?></strong> 位&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 商家：<strong><?=returncount("yjcode_user where shopzt=2")?></strong> 家&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 商品：<strong><?=$inittjarr[1]+returncount("yjcode_pro where zt=0 and ifxj=0")?></strong> 个&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 交易：<strong><?=$inittjarr[2]+returncount("yjcode_order where (ddzt='wait' or ddzt='db' or ddzt='back' or ddzt='suc')")?></strong> 笔&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 成交：<strong><?=sprintf("%.0f",$inittjarr[3]+returnsum("money1*num","yjcode_order where ddzt<>'backsuc' and ddzt<>'close'"))?></strong> 元
 </div>
     <span id="jynum" style="display:none;"><?=$i?></span>
      <script language="javascript" src="<?=weburl?>homeimg/jy.js"> </script>
   </div>
</div>
<div class="yjcode">
 
 <? adwhile("gao_01");?>
 

<!--推荐产品B-->
<div class="tjpro">
 <ul class="u0"><li class="l1"><span class="s0"><img src="homeimg/tj.png" /></span><span class="s1">限时优惠促销</span></li><li class="l2"><a href="product/"class="l2">查看更多 ></a></li></ul>
 <? 
 $i=1;
 while1("*","yjcode_pro where zt=0 and ifxj=0 and iftuan=1 and yhxs=2 and yhsj2>'".$sj."' order by yhsj2 asc limit 4");while($row1=mysql_fetch_array($res1)){
 $money1=returnyhmoney($row1[yhxs],$row1[money2],$row1[money3],$sj,$row1[yhsj1],$row1[yhsj2],$row1[id]);
 $au="product/view".$row1[id].".html";
 $dqsj=str_replace("-","/",$row1[yhsj2]);
 ?>
 <ul class="u1">
 <li class="l1">
 <span id="dqsj<?=$i?>" style="display:none;"><?=$dqsj?></span>
 <img src="<?=returntp("bh='".$row1[bh]."'","-1")?>">
 <div class="d1"><a target="_blank" href="<?=$au?>"><span class="list-name" id="djs<?=$i?>">正在加载</span><em class="look-but">点击查看 ></em></a></div>
 </li>
 <li class="l2"><a href="<?=$au?>" target="_blank"><?=strgb2312($row1[tit],0,34)?></a></li>
  <div class="d2">
  <? if($row1[fhxs]==2 || $row1[fhxs]==3 || $row1[fhxs]==4){?>
   <span class="a5">自动发货</span><? }else{?><span class="a5">手动发货</span><? }?>&nbsp;&nbsp;<font size="2" color=""><?=dateYMD($row1[sj])?></font></time>
   <em class="a4">￥<?=$money1?></em></span>
 </ul>
 <? $i++;}?>
</div>
<script language="javascript">
userChecksj();
</script>
<!--推荐产品E-->


<!--产品列表B-->
<?
$sqla="select * from yjcode_ad where zt=0 and adbh='gao_03' order by xh asc";mysql_query("SET NAMES 'GBK'");
$resa=mysql_query($sqla);
while1("*","yjcode_type where admin=1 and (iftj is null or iftj=0) order by xh asc");while($row1=mysql_fetch_array($res1)){
$rowa=mysql_fetch_array($resa);
?>
<div class="prolist">
 <ul class="u0"><li class="l1"><span class="s0"><img src="<?=weburl?>gg/<?=$rowa[bh].".".$rowa[jpggif]?>" /></span><span class="s1"><?=$row1[type1]?></span><span class="s2"><?=$rowa[tit]?></span></li><li class="l2"><a href="product/search_j<?=$row1[id]?>v.html"class="l2">查看更多 ></a></li></ul>
 <ul class="u1">
 <? 
 while0("*","yjcode_pro where zt=0 and ifxj=0 and ty1id=".$row1[id]." and iftj>0 order by iftj asc limit 8");while($row=mysql_fetch_array($res)){
 $money1=returnjgdian(returnyhmoney($row[yhxs],$row[money2],$row[money3],$sj,$row[yhsj1],$row[yhsj2],$row[id]));
 $au="product/view".$row[id].".html";
 ?>
 <li class="l1">

  <a target="_blank" href="<?=$au?>" class="a1"><img src="<?=returntp("bh='".$row[bh]."'","-1")?>" width="252" height="252"></a>
  <a target="_blank" href="<?=$au?>" class="a2"><?=strgb2312($row[tit],0,37)?></a>
  <div class="d2">
  <? if($row[fhxs]==2 || $row[fhxs]==3 || $row[fhxs]==4){?>
  <span class="a5">自动发货</span><? }else{?><span class="a5">手动发货</span><? }?>&nbsp;&nbsp;<font size="2" color=""><?=dateYMD($row[sj])?></font></time>
   <em class="a4">￥<?=$money1?></em></span>
   <div class="d1">
  <a class="s1" href="<?=$au?>" class="a1">详情</a>
  <a target="_blank" href="<?=$au?>" class="a3">购买</a>
 </div>
 </li>
 <? }?>
 </ul>
</div>
<? }?>

<!--产品列表E-->

<!--任务B-->
<div class="taskm">
 <ul class="u1">
 <li class="l1 l11" id="taska1" onMouseOver="taskover(1)">热点需求</li>
 <li class="l0"><span></span></li>
 <li class="l1" id="taska2" onMouseOver="taskover(2)">最新需求</li>
 <li class="l2"><a href="task/">更多需求>></a></li>
 </ul>
 
 <div class="d1" id="taskm1">
  <? while1("*","yjcode_task where (zt=0 or zt=3 or zt=4 or zt=5 or zt=101 or zt=102) order by djl desc limit 21");while($row1=mysql_fetch_array($res1)){?>
  <ul class="u2">
  <li class="l1"><span class="feng">￥<?=$row1[money1]?></span> <a href="task/view<?=$row1[id]?>.html" title="<?=$row1[tit]?>" target="_blank"><?=returntitdian($row1[tit],30)?></a></li>
  <li class="l2"><?=returnnc($row1[userid])?>发布 <?=$row1[taskcy]?>投标</li>
  </ul>
  <? }?>
 </div>
 
 <div class="d1" id="taskm2" style="display:none;">
  <? while1("*","yjcode_task where (zt=0 or zt=3 or zt=4 or zt=5 or zt=101 or zt=102) order by sj desc limit 21");while($row1=mysql_fetch_array($res1)){?>
  <ul class="u2">
  <li class="l1"><span class="feng">￥<?=$row1[money1]?></span> <a href="task/view<?=$row1[id]?>.html" title="<?=$row1[tit]?>" target="_blank"><?=returntitdian($row1[tit],30)?></a></li>
  <li class="l2"><?=returnnc($row1[userid])?>发布 <?=$row1[taskcy]?>投标</li>
  </ul>
  <? }?>
 </div>
 
 <div class="d2">
  <a href="task/taskadd.php" class="a1">免费发布需求</a>
  <? while1("*","yjcode_task where (zt=0 or zt=3 or zt=4 or zt=5 or zt=101 or zt=102) order by money1 desc limit 6");while($row1=mysql_fetch_array($res1)){?>
  <ul class="u2">
  <li class="l1"><span class="feng">￥<?=$row1[money1]?></span> <a href="task/view<?=$row1[id]?>.html" title="<?=$row1[tit]?>" target="_blank"><?=returntitdian($row1[tit],17)?></a></li>
  <li class="l2"><?=$row1[taskcy]?>个服务商参与</li>
  <li class="l3"><?=$row1[rwzq]?>天完成</li>
  </ul>
  <? }?>
 </div>
</div>
<!--任务E-->
  
<!--合作伙伴B-->
<div class="indexcap fontyh">合作伙伴</div>

<div class="mr_frbox">
  <img class="mr_frBtnL prev" src="homeimg/mfrL.jpg" width="28" height="46" />
  <div class="mr_frUl">
  <ul>
  <? autoAD("ADI13");while0("*","yjcode_ad where adbh='ADI13' and zt=0 order by xh asc");while($row=mysql_fetch_array($res)){?>
  <li><a href="<?=$row[aurl]?>" target="_blank"><img alt="<?=$row[tit]?>" border=0 src="gg/<?=$row[bh]?>.<?=$row[jpggif]?>" width="140" height="49"></a></li>
  <? }?>
  </ul>
  </div>
  <img class="mr_frBtnR next" src="homeimg/mfrR.jpg" width="28" height="46" />
</div>
<script language="javascript">
$(".mr_frUl ul li img").hover(function(){$(this).css("border-color","#A0C0EB");},function(){$(this).css("border-color","#d8d8d8")});
jQuery(".mr_frbox").slide({titCell:"",mainCell:".mr_frUl ul",autoPage:true,effect:"leftLoop",autoPlay:true,vis:7});
</script>

<!--文字友情-->

<div class="indexcap fontyh">

        <div class="friend-link">
            <div class="linkBox-nav">
                <span class="current-link-li">友情连接</span>
    <? autoAD("ADI14");while0("*","yjcode_ad where adbh='ADI14' and zt=0 and type1='文字' order by xh asc");while($row=mysql_fetch_array($res)){?>
    <a href="<?=$row[aurl]?>" target="_blank"> <span class="link-li" for="<?=$i?>"><?=$row[tit]?></span>
     <? }?>
      </div>
     </div>

<!--合作伙伴E-->
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
    $(this).find('.d1').eq(0).stop().animate({'top': '6px'}, 200);
});
$(".prolist .u1 .l1").mouseleave(function () {
    $(this).find('.d1').eq(0).stop().animate({'top': '-50px'}, 200);
});
</script>
</body>
</html>