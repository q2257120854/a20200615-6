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
<script language="javascript" src="homeimg/index1.js"></script>
<script language="javascript" src="homeimg/layui.js"></script>
<script language="javascript" src="homeimg/common.js"></script>
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

<div class="yjcode">
 
 <div class="mleft"></div>
 
 <div class="qh">
 <!--切换开始-->
 <div class="container" id="idTransformView">
  <ul class="slider" id="idSlider">
  <?
  $i=1;
  while1("*","yjcode_ad where adbh='aiyou_02' and zt=0 order by xh asc");while($row1=mysql_fetch_array($res1)){
  ?>
    <li><a href="<?=$row1[aurl]?>" target="_blank"><img src="<?=returnjgdw($rowcontrol[addir],"","gg")?>/<?=$row1[bh]?>.<?=$row1[jpggif]?>" width="712" height="280" border="0" /></a></li>
  <?
  $i++;
  }
  ?>
  </ul>
  <span style="display:none" id="qhai"><?=$i-1?></span>
  <ul class="num" id="idNum">
   <? for($j=1;$j<$i;$j++){?><li><?=$j?></li><? }?>
  </ul>
 </div>  
 <!--切换结束-->
 
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
   <? $i=0;while1("*","yjcode_order where (ddzt='wait' or ddzt='db' or ddzt='suc') order by sj desc limit 30");while($row1=mysql_fetch_array($res1)){?>
   <li><strong><?=returnjiami(returnnc($row1[userid]))?></strong> 购买了<span class="green">  <a href="product/view<?=returnproid($row1[probh])?>.html"  target="_blank" ><?=returntitdian($row1[tit],40)?></a></span> 成交价：<font  color="#ff6600"><strong>￥<?=$row1[money1]?></strong> </font>
   <span style="color: #f00">[<?=returnorderzt($row1[ddzt])?>]</span></li>
   <? $i++;}?>
   </ul>
  </div>
 </div>
 <!--最新交易E-->
 </div>
 
 <!--公告B-->
 <? $wxlogin=preg_split("/,/",$rowcontrol[wxlogin]);?>
 <div class="ggright">
 
  <ul class="u1" id="idlno">
  <li class="l1"><a href="reg/reg.php" class="a1"></a><a href="reg/" class="a2"></a></li>
  <li class="l2">第三方帐号登录：</li>
  <li class="l3">
  <? if($rowcontrol[wxlogin]!="" && $rowcontrol[wxlogin]!=","){?>
  <a href="https://open.weixin.qq.com/connect/qrconnect?appid=<?=$wxlogin[0]?>&redirect_uri=<?=urlencode(weburl."reg/wxlogin.php")?>&response_type=code&scope=snsapi_login#wechat_redirect" target="_blank" class="a1"></a>
  <? }?>
  <a href="<?=weburl?>config/qq/oauth/index.php" target="_blank" class="a2"></a>
  </li>
  </ul>
  
  <ul class="u11" id="idlyes" style="display:none;">
  <li class="l1"><a href="user/"><img border=0 src="" id="itouxiang"></a></li>
  <li class="l2">
  <span class="s1">欢 迎 您：<a id="iuserid" href="user/"></a></span>
  <span class="s2">可用余额：<span id="imoney"></span>元</span>
  </li>
  <li class="l3">
  <a href="user/" target="_blank">会员中心</a>
  <a href="user/favpro.php" target="_blank">我的收藏</a>
  <a href="user/order.php" target="_blank">订单</a>
  <a href="user/jflog.php" target="_blank">积分</a>
  <a href="user/un.php">退出</a>
  </li>
  </ul>
  <script language="javascript">idldl();</script>
  
  <?
  $inittjarr=array(0,0,0,0);
  $inittjb=preg_split("/,/",$rowcontrol[inittj]);
  for($i=0;$i<count($inittjb);$i++){
  if(is_numeric($inittjb[$i])){$inittjarr[$i]=$inittjb[$i];}
  }
  ?>
  <ul class="u2">
  <li class="l1">平台统计指数：</li>
  <li class="l2">商品: <strong><?=$inittjarr[1]+returncount("yjcode_pro where zt=0 and ifxj=0")?></strong> 个</li>
  <li class="l2">会员: <strong><?=$inittjarr[0]+returncount("yjcode_user")?></strong> 位</li>
  <li class="l2">交易: <strong><?=$inittjarr[2]+returncount("yjcode_order where (ddzt='wait' or ddzt='db' or ddzt='back' or ddzt='suc')")?></strong> 笔</li>
  <li class="l2">成交: <strong><?=sprintf("%.0f",$inittjarr[3]+returnsum("money1*num","yjcode_order where ddzt<>'backsuc' and ddzt<>'close'"))?></strong> 元</li>
  </ul>
  <ul class="u3">
  <h3></h3>
  <? while0("*","yjcode_gg where zt=0 order by sj desc limit 4");while($row=mysql_fetch_array($res)){?>
  <li class="l3">· <a href="help/ggview<?=$row[id]?>.html" title="<?=$row[tit]?>" target="_blank"><?=strgb2312($row[tit],0,26)?></a></li>
  <li class="l4">[<?=dateMD($row[sj])?>]</li>
  <? }?>
  </ul>
     <ul class="u4">
				<dt>
					<ul class="curr">
						<a href="help/gglist.html" target="_blank"><em class="icons i-kj"></em>				
							<p>快捷方便</p>
						</a>
				 </ul>
					<ul class="">
						<a href="help/gglist.html" target="_blank"><em class="icons i-jy"></em>			
							<p>担保交易</p>
						</a>
						 </ul>
					<ul class="">
						<a href="help/gglist.html" target="_blank"><em class="icons i-xb"></em>
							<p>消费保障</p>	
						</a>
						 </ul>
					<ul class="last">
						<a href="help/gglist.html" target="_blank"><em class="icons i-sm"></em>
							<p>实名商家</p>						
						</a>
					 </ul>
				</dt>
			  </ul>
 </div>
 <!--公告E-->
 
 <? adwhile("aiyou_06");?>
 <!--推荐产品B-->
 <ul class="dtjcap">
 <li class="l1">限时优惠</li>
 <li class="l2">
 <? while1("*","yjcode_ad where adbh='aiyou_09' and zt=0 order by xh asc");while($row1=mysql_fetch_array($res1)){?>
 <a href="<?=$row1[aurl]?>" target="_blank"><?=$row1[tit]?></a>
 <? }?>
 </li>
 <li class="l3"><a href="product/" target="_blank">查看更多>></a></li>
 </ul>
 <div class="dtj">
 <? 
 $i=1;
 while1("*","yjcode_pro where zt=0 and ifxj=0 and iftuan=1 and yhxs=2 and yhsj2>'".$sj."' order by yhsj2 asc limit 5");while($row1=mysql_fetch_array($res1)){
 $money1=returnyhmoney($row1[yhxs],$row1[money2],$row1[money3],$sj,$row1[yhsj1],$row1[yhsj2],$row1[id]);
 $au="product/view".$row1[id].".html";
 $dqsj=str_replace("-","/",$row1[yhsj2]);
 while2("*","yjcode_user where id=".$row1[userid]);$row2=mysql_fetch_array($res2);
 ?>
 <ul class="u1 u1<?=$i?>">
 <li class="l1">
 <span id="dqsj<?=$i?>" style="display:none;"><?=$dqsj?></span>
 <img border="0" src="<?=returntp("bh='".$row1[bh]."'","-1")?>" />
 <div class="d1"><a target="_blank" href="<?=$au?>"><span class="list-name" id="djs<?=$i?>">正在加载</span><span class="sfont">限时销售<br>安全放心</span><em class="look-but">立即购买 ></em></a></div>
 </li>
 <li class="l3"><? if($row1[iftj]>0){?><span class="s1">本站</span><span class="s2">精选</span><? }?><a href="<?=$au?>" target="_blank" title="<?=$row1[tit]?>"><?=$row1[tit]?></a></li>
 <li class="l2">￥<?=$money1?></li>
 <li class="l5"><a href="<?=returnmyweb($row2[id],$row2[myweb])?>" charset="g_ac2" title="<?=$row2[shopname]?>" target="_blank"><?=$row2[shopname]?></a></li>
 <li class="l6">
 <span class="s0"><?=returnshoptype($row2[shoptype])?></span>
 <? if($row1[fhxs]==2 || $row1[fhxs]==3 || $row1[fhxs]==4){?>
 <span class="s1" title="自动发货商品，付款后即可获取该商品的发货信息（如下载地址、相关密码等）">自</span>
 <? }?>
 <? if(1==$row1[ifuserdj]){?><span class="s1" title="该商品已经加入会员等级折扣体系，本站会员可以享受相应的折价优惠">折</span><? }?>
 <? if($row2[baomoney]>0){?><span class="s1" title="已加入消保，商家已缴纳(<?=$row2[baomoney]?>元)保证金">保</span><? }?>
 </li>
 </ul>
 <? $i++;}?>
 </div>
 <script language="javascript">
 userChecksj();
 </script>
 <!--推荐产品E-->
 
 <? adwhile("aiyou_07");?>
 <!--热门商品B-->
 <ul class="rmcap">
 <li class="l1">畅销商品</li>
 <li class="l2">
 <? while1("*","yjcode_ad where adbh='aiyou_10' and zt=0 order by xh asc");while($row1=mysql_fetch_array($res1)){?>
 <a href="<?=$row1[aurl]?>" target="_blank"><?=$row1[tit]?></a>
 <? }?>
 </li>
 <li class="l3"><a href="product/" target="_blank">查看更多>></a></li>
 </ul>
 <div class="rmlist">
 <?
 while1("*","yjcode_pro where ifxj=0 and zt=0 order by xsnum desc limit 15");while($row1=mysql_fetch_array($res1)){
 $money1=returnyhmoney($row1[yhxs],$row1[money2],$row1[money3],$sj,$row1[yhsj1],$row1[yhsj2],$row1[id]);
 $au="product/view".$row1[id].".html";
 while2("*","yjcode_user where id=".$row1[userid]);$row2=mysql_fetch_array($res2);
 ?>
 <ul class="u1">
 <li class="l1">￥<?=sprintf("%.2f",$money1)?></li>
 <li class="l2"><a href="<?=$au?>" target="_blank" title="<?=$row1[tit]?>"><?=$row1[tit]?></a></li>
 <li class="l3"><a href="shop/view<?=$row2[id]?>.html" target="_blank" title="<?=$row2[shopname]?>"><?=$row2[shopname]?></a></li>
 </ul>
 <? }?>
 </div>
 <!--热门商品E-->
 
 <? adwhile("aiyou_08");?>
 <!--商家B-->
 <ul class="tjsj">
 <li class="l1">推荐商家</li>
 <li class="l2">
 <? while1("*","yjcode_ad where adbh='aiyou_11' and zt=0 order by xh asc");while($row1=mysql_fetch_array($res1)){?>
 <a href="<?=$row1[aurl]?>" target="_blank"><?=$row1[tit]?></a>
 <? }?>
 </li>
 <li class="l3"><span>近30天收入排行榜</span></li>
 </ul>
 <div class="tjsjleft">
 <? 
 while1("*","yjcode_user where zt=1 and shopzt=2 and shopname<>'' and pm>0 order by pm asc limit 8");while($row1=mysql_fetch_array($res1)){
 $sucnum=returnjgdw($row1[xinyong],"",returnxy($row1[id],1));
 $au=returnmyweb($row1[id],$row1[myweb]);
 ?>
 <ul class="u1">
 <li class="l1">
  <a href="<?=$au?>" target="_blank" class="a1"><img src="upload/<?=$row1[id]?>/shop.jpg" onerror="this.src='img/none180x180.gif'" /></a>
  <a href="<?=$au?>" target="_blank" class="a2"><?=$row1[shopname]?></a>
  <span class="s1"><img src="img/dj/<?=returnxytp($sucnum)?>" title="信用值<?=$sucnum?>" /></span>
  <a href="<?=$au?>" target="_blank" class="a3">TA的店铺</a>
 </li>
 <li class="l2"><strong>TA的宝贝<i>(<?=returncount("yjcode_pro where userid=".$row1[id]." and zt=0 and ifxj=0")?>)</i></strong></li>
 <li class="l3">
 <? 
 while2("*","yjcode_pro where userid=".$row1[id]." and zt=0 and ifxj=0 order by lastsj desc");if($row2=mysql_fetch_array($res2)){
 $money1=returnjgdian(returnyhmoney($row2[yhxs],$row2[money2],$row2[money3],$sj,$row2[yhsj1],$row2[yhsj2],$row2[id]));
 ?>
 <i class="s1">￥<?=sprintf("%.2f",$money1)?></i>&nbsp;&nbsp;
 <a href="product/view<?=$row2[id]?>.html" target="_blank" title="<?=$row2[tit]?>"><?=$row2[tit]?></a>
 <? }?>
 </li>
 </ul>
 <? }?>
 </div>
 <div class="tjsjright">
 <? 
 $i=1;while1("*","yjcode_user where shopname<>'' and shopzt=2 and zt=1 order by sellmyue desc limit 5");if($row1=mysql_fetch_array($res1)){
 $au=returnmyweb($row1[id],$row1[myweb]);
 ?>
 <ul class="u1">
 <li class="l1"><a href="<?=$au?>" target="_blank"><img src="upload/<?=$row1[id]?>/shop.jpg" onerror="this.src='img/none180x180.gif'" /></a></li>
 <li class="l2">
 <a href="<?=$au?>" target="_blank" class="a1"><?=$row1[shopname]?></a>
 <span class="s1">收入：</span>
 <span class="s2">￥<strong><?=$row1[sellmyue]?></strong></span>
 </li>
 </ul>
 <? }?>
 <? while($row1=mysql_fetch_array($res1)){$au=returnmyweb($row1[id],$row1[myweb]);?>
 <ul class="u2">
 <li class="l1"><a href="<?=$au?>" target="_blank"><img src="upload/<?=$row1[id]?>/shop.jpg" onerror="this.src='img/none180x180.gif'" /></a></li>
 <li class="l2"></li>
 <li class="l3">
 <a href="<?=$au?>" target="_blank" class="a1"><?=$row1[shopname]?></a>
 <span class="s1">收入：</span>
 <span class="s2">￥<strong><?=$row1[sellmyue]?></strong></span>
 </li>
 </ul>
 <? }?>
 </div>
 <!--商家E-->
 
 <!--合作B-->
 <ul class="linkcap">
 <li class="l1">友情链接</li>
 <li class="l2">
 </li>
 <li class="l3"><a href="help/aboutview3.html" target="_blank">申请链接</a></li>
 </ul>
 <ul class="linkmain">
 <li class="l1">
 <? while0("*","yjcode_ad where adbh='ADI13' and zt=0 order by xh asc");while($row=mysql_fetch_array($res)){?>
 <a href="<?=$row[aurl]?>" target="_blank"><img alt="<?=$row[tit]?>" border=0 src="<?=returnjgdw($rowcontrol[addir],"","gg")?>/<?=$row[bh]?>.<?=$row[jpggif]?>" width="100" height="35"></a>
 <? }?>
 </li>
 <li class="l2">
 <? while0("*","yjcode_ad where adbh='ADI14' and zt=0 and type1='文字' order by xh asc");while($row=mysql_fetch_array($res)){?>
 <a href="<?=$row[aurl]?>" target="_blank"><?=$row[tit]?></a>&nbsp;&nbsp;&nbsp;&nbsp;
 <? }?>
 </li>
 </ul>
 <!--合作E-->

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