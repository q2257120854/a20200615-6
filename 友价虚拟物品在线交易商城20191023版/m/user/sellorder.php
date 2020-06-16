<?
include("../../config/conn.php");
include("../../config/function.php");
sesCheck_m();
$userid=returnuserid($_SESSION["SHOPUSER"]);
$ses=" where selluserid=".$userid;
$ddzt=$_GET[ddzt];if($ddzt!=""){$ses=$ses." and ddzt='".$ddzt."'";}
if($_GET[page]!=""){$page=$_GET[page];}else{$page=1;}
?>
<html>
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
<title>会员中心 <?=webname?></title>
<? include("../tem/cssjs.html");?>
<link href="css/sell.css" rel="stylesheet" type="text/css" />
</head>
<body>
<? include("topuser.php");?>
<div class="sellordertopfd">
<div class="sellordertop box">
 <div class="d1" onClick="gourl('sell.php')"><img src="img/topleft1.png" height="21" /></div>
 <div class="d2">我的订单</div>
 <div class="d3"></div>
</div>
<div class="sellordertop1 box">
 <div class="d1<? if(empty($ddzt)){?> d11<? }?>" onClick="gourl('sellorder.php')">全部</div>
 <div class="d1<? if($ddzt=="wait"){?> d11<? }?>" onClick="gourl('sellorder.php?ddzt=wait')">待发货</div>
 <div class="d1<? if($ddzt=="db"){?> d11<? }?>" onClick="gourl('sellorder.php?ddzt=db')">待收货</div>
 <div class="d1<? if($ddzt=="back"){?> d11<? }?>" onClick="gourl('sellorder.php?ddzt=back')">退款处理</div>
 <div class="d1<? if($ddzt=="jf"){?> d11<? }?>" onClick="gourl('sellorder.php?ddzt=jf')">交易纠纷</div>
</div>
</div>
<div class="sellordertopfdv"></div>


 <!--列表开始-->
 <?
 pagef($ses,10,"yjcode_order","order by sj desc");while($row=mysql_fetch_array($res)){
 $au="sellorderview.php?orderbh=".$row[orderbh];
 $tp=returntp("bh='".$row[probh]."' order by iffm desc","-2");
 $cz="";
 if($row[ddzt]=="suc"){ //交易成功
 
 }elseif($row[ddzt]=="wait"){ //等待发货
 $cz="<a href='fahuo.php?orderbh=".$row[orderbh]."' class='a1'>发货</a>";
 $cz=$cz."<a href='sellclose.php?orderbh=".$row[orderbh]."'>取消订单</a>";
 
 }elseif($row[ddzt]=="back"){ //退款处理中
 $cz="<a href='selltk.php?orderbh=".$row[orderbh]."'>处理退款</a>";
 $cz=$cz."<a href='orderjf2.php?orderbh=".$row[orderbh]."'>沟通</a>";
 
 }elseif($row[ddzt]=="backerr"){ //退款不同意
 $cz="<a href='orderjf2.php?orderbh=".$row[orderbh]."'>沟通</a>";
 
 }elseif($row[ddzt]=="backsuc"){ //退款成功
 $cz="<a href='orderjf2.php?orderbh=".$row[orderbh]."'>沟通</a>";

 }elseif($row[ddzt]=="db"){ //担保中

 }elseif($row1[ddzt]=="wpay"){ //等待买家付款

 }elseif($row[ddzt]=="jf"){ //纠纷处理中 
 $cz="<a href='orderjf2.php?orderbh=".$row[orderbh]."'>沟通</a>";

 }elseif($row[ddzt]=="jfbuy"){ //买家胜诉 
 $cz="<a href='orderjf2.php?orderbh=".$row[orderbh]."'>沟通</a>";

 }elseif($row[ddzt]=="jfsell"){ //卖家胜诉 
 $cz="<a href='orderjf2.php?orderbh=".$row[orderbh]."'>沟通</a>";
  
 }
 ?>
 <div class="sellorderlist box">
  <div class="d1"><img src="img/user.png" height="18" /></div>
  <div class="d2"><?=returnnc($row[userid])?></div>
  <div class="d3 feng"><?=strip_tags(returnorderzt($row[ddzt]))?></div>
 </div>
 <div class="sellorderlist1 box" onClick="gourl('sellorderview.php?orderbh=<?=$row[orderbh]?>')">
  <div class="d1"><img src="<?=$tp?>" onerror="this.src='../img/none70x70.gif'" width="70" height="70" /></div>
  <div class="d2"><?=$row["tit"]?><br><? if(!empty($row[tcv])){echo "<span class='hui'>".$row[tcv]."</span>";}?></div>
  <div class="d3">￥<?=$row[money1]?><br><span class="hui">x<?=$row[num]?></span></div>
 </div>
 <div class="sellorderlist2 box">
  <div class="d1">编号 <?=$row[orderbh]?><br><?=$row[sj]?></div>
  <div class="d2">共<span class="feng">￥<?=returnjgdian($row[money1]*$row[num]+$row[yunfei])?></span>(运费￥<?=$row[yunfei]?>)<br>共<?=$row[num]?>件商品</div>
 </div>
 <div class="sellorderlist4 box">
  <div class="d1">
  <?=$cz?>
  </div>
 </div>
 <? }?>
 <!--列表结束-->
 <div class="npa">
 <?
 $nowurl="sellorder.php";
 $nowwd="ddzt=".$_GET[ddzt];
 require("page.html");
 ?>
 </div>
</body>
</html>