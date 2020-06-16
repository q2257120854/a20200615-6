<?
include("../config/conn.php");
include("../config/function.php");
include("../config/xy.php");

$id=$_GET[id];
while0("*","yj_domain_pro where zt<>99 and id=".$id);if(!$row=mysql_fetch_array($res)){php_toheader("../");}
ymztT($row[id]);
$sj=date("Y-m-d H:i:s");

$sqluser="select * from yj_domain_user where id=".$row[userid];mysql_query("SET NAMES 'utf8'");$resuser=mysql_query($sqluser);
if(!$rowuser=mysql_fetch_array($resuser)){php_toheader("./");}

?>
<html>
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="<?=$row[tit]?>">
<meta name="description" content="<?=strip_tags($row[txt])?>">
<title><?=$row[tit]?> - <?=webname?></title>
<link href="../css/basic.css" rel="stylesheet" type="text/css" />
<link href="index.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script language="javascript" src="../js/jquery.SuperSlide.2.1.1.js"></script>
<script language="javascript" src="../js/jquery.SuperSlide.2.1.1.source.js"></script>
<script language="javascript" src="../js/basic.js"></script>
<script language="javascript" src="index.js"></script>
</head>
<body>
<? include("../tem/openwv.php");?>
<!--竞拍弹B-->
<div id="pai" class="pai" style="display:none;">
<iframe name="paif" id="paif" marginwidth="1" scrolling="no" marginheight="1" height="292px" width="100%" border="0" frameborder="0" src="pai.php?id=<?=$id?>"></iframe>
</div>
<!--竞拍弹E-->
<!--询价弹B-->
<div id="xun" class="xun" style="display:none;">
<iframe name="paix" id="paix" marginwidth="1" scrolling="no" marginheight="1" height="192px" width="100%" border="0" frameborder="0" src="xun.php?id=<?=$id?>"></iframe>
</div>
<!--询价弹E-->
<? include("../tem/top.html");?>
<? include("../tem/top1.html");?>
<? include("../tem/top2.html");?>

<div class="yjcode">

 <div class="dqwz">
 <ul class="u1">
 <li class="l1"><img src="../img/home.gif" width="21" height="21" /></li>
 <li class="l2">当前位置：<a href="<?=weburl?>">首页</a> > <a href="search_l<?=$row[jyfs]?>v.html"><?=returnjyfs($row[jyfs])?>域名</a> > 域名详情</li>
 </ul>
 </div>

 <!--左B-->
 <div class="mainleft">
  <div class="utitcap">
   <h1><?=$row[tit]?></h1>
   <ul class="u1">
   <li class="l1">
   <a href="http://www.cxw.com/whois?domain=<?=$row[tit]?>" target="_blank">whois</a> &nbsp;
   <a href="https://www.baidu.com/s?word=<?=$row[tit]?>" target="_blank">百度</a> &nbsp;
   <a href="http://www.google.com.hk/search?hl=en&safe=off&btnG=Search&q=site:<?=$row[tit]?>" target="_blank">google</a>
   </li>
   <li class="l2">
   <? 
   $a1="none";$a2="none";
   if($_SESSION["DOMAINUSER"]==""){$a1="";}else{
   $nuid=returnuserid($_SESSION["DOMAINUSER"]);
   if(panduan("probh,userid","yj_domain_profav where probh='".$row[bh]."' and userid=".$nuid)==1){$a2="";}else{$a1="";}
   }
   ?>
   <span id="favpno" class="s1" style="display:<?=$a1?>;"><a href="javascript:profavInto('<?=$row[bh]?>')">收藏</a></span>
   <span id="favpyes" class="s1" style="display:<?=$a2?>;"><a href="../user/profav.php">已收藏</a></span>
   </li>
   </ul>
  </div>
  
  <div class="main">
   <table width="100%" class="mtable">
   <? if(!empty($row[txt])){?>
   <tr>
   <td class="align_right">域名简介</td>
   <td><?=$row[txt]?></td>
   </tr>
   <? }?>
   <tr>
   <td class="align_right">备案信息</td>
   <td><? if(!empty($row[bah])){echo $row[baxz]."备案 (".$row[bah].")";}else{echo "未备案";}?></td>
   </tr>
   
   <? $zcs=returnjgdw(returnzcs($row[zcs]),"",$row[zcs]);if(!empty($zcs)){?>
   <tr>
   <td class="align_right">注册商</td>
   <td><?=$zcs?></td>
   </tr>
   <? }?>
   
   <? if(!empty($row[zcsj])){?>
   <tr>
   <td class="align_right">注册时间</td>
   <td><?=dateYMD($row[zcsj])?></td>
   </tr>
   <? }?>
   
   <? if(!empty($row[dqsj])){?>
   <tr>
   <td class="align_right">域名到期</td>
   <td><?=dateYMD($row[dqsj])?></td>
   </tr>
   <? }?>

   <? if($row[jyfs]==1){?>
   <tr>
   <td class="align_right">售价</td>
   <td><span class="red money"><?=$row[money1]?></span>元</td>
   </tr>
   <? }elseif($row[jyfs]==2){?>
   <tr>
   <td class="align_right">起拍价</td>
   <td><span class="red money"><?=$row[money2]?></span>元</td>
   </tr>
   <tr>
   <td class="align_right">加价幅度</td>
   <td><span class="red money"><?=$row[money3]?></span>元</td>
   </tr>
   <tr>
   <td class="align_right">当前价格</td>
   <td><span class="red money"><?=returnjgdw($row[money5],"",$row[money2])?></span>元</td>
   </tr>
   <? }?>
 
   <tr>
   <td class="align_right">剩余时间</td>
   <td><span id="djs">正在加载</span></td>
   </tr>
  
   <tr>
   <td class="align_right td0"></td>
   <td class="td0">
   <? if($row[zt]==1 && $row[jyfs]==1){?>
   <a href="javascript:buyInto('<?=$row[bh]?>')" class="order buy">立刻购买</a>
   <? }elseif($row[zt]==1 && $row[jyfs]==2){?>
   <a href="javascript:paiInto('<?=$row[bh]?>')" class="order buy">参与竞拍</a>
   <? }elseif($row[zt]==1 && $row[jyfs]==3){?>
   <a href="javascript:xunInto('<?=$row[bh]?>')" class="order buy">提交报价</a>
   <? }elseif($row[zt]==2){?>
   <strong class="blue">该域名已经下架，当前仅为快照记录</strong>
   <? }else{?>
   <strong class="red"><?=strip_tags(returnpztv($row[zt],$row[rzzt],$row[ifxj],$row[yxq]))?>，当前仅为快照信息</strong>
   <? }?>
   </td>
   </tr>
   </table>
  </div>
  
  <? if($row[jyfs]==2){?>
  <div class="chujia">
   <ul class="cap">
   <li class="l1">出价会员</li>
   <li class="l2">给出报价</li>
   <li class="l3">报价时间</li>
   </ul>
   <? while1("*","yj_domain_paimailog where probh='".$row[bh]."' order by id desc");while($row1=mysql_fetch_array($res1)){?>
   <ul class="u1">
   <li class="l1"><?=substr_cut(returnnc($row1[userid]))?></li>
   <li class="l2">￥<?=sprintf("%.2f",$row1[money1])?></li>
   <li class="l3"><?=$row1[sj]?></li>
   </ul>
   <? }?>
  </div>
  <? }?>
  
 </div>
 <!--左E-->
 
 <!--右B-->
 <div class="mainright">
  <? $uw=weburl."shop/shoplist_i".$rowuser[id]."v.html";?>
  <ul class="mai">
  <li class="cap"><a href="<?=$uw?>" target="_blank"><?=$rowuser[shopname]?></a></li>
  <li class="l1">
  <? $sucnum=returnjgdw($rowuser[xinyong],"",returnxy($rowuser[id],1));?>
  店铺掌柜：<?=$rowuser[nc]?><br>
  卖家信用：<?=$sucnum?> <img src="../img/dj/<?=returnxytp($sucnum)?>" /><br>
  在售域名：<?=returncount("yj_domain_pro where userid=".$rowuser[id]." and zt=1")?>个<br>
  注册时间：<?=dateYMD($rowuser[sj])?>
  </li>
  <li class="l2">
  <img src="<?=weburl?>tem/getqr.php?u=<?=$uw?>&size=3" />
  </li>
  </ul>
  <ul class="guiz">
  <li class="l1 blue">《一口价域名规则》</li>
  <li class="l2">
  <strong>购买规则：</strong><br>
  1、买家支付费用后，这笔款项暂由平台接管担保<br>
  2、卖方根据买方的过户信息，将域名过户给买方<br>
  3、买方确认收货后，款项解冻自动打入卖方账号<br>
  </li>
  </ul>
  
 </div>
 <!--右E-->

</div>

<? include("../tem/bottom.html");?>
<script language="javascript">
addTimer("djs", <?=DateDiff(date("Y-m-d H:i:s",$row[yxq]),$sj,"s");?>); 
</script>

</body>
</html>