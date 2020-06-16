<?
include("../../config/conn.php");
include("../../config/function.php");
sesCheck_m();
?>
<html>
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
<title>会员中心 <?=webname?></title>
<? include("../tem/cssjs.html");?>
<link href="css/buy.css" rel="stylesheet" type="text/css" />
</head>
<body>
<? include("top.php");?>

<div class="infcap box">
 <div class="d1"><img src="img/infcap4.png" /></div>
 <div class="d2">我的订单</div>
 <div class="d3" onClick="gourl('order.php')">查看全部订单</div>
 <div class="d4" onClick="gourl('order.php')"><img src="img/jianright.png" /></div>
</div>
<div class="infmain box">
 <div class="d1">
  <? $a=returncount("yjcode_car where userid=".$rowuser[id]."");?>
  <div onClick="gourl('car.php')"><img src="img/order1.png" /><? if($a>0){?><span><?=$a?></span><? }?><br>等待付款</div>
  <? $a=returncount("yjcode_order where userid=".$rowuser[id]." and ddzt='wait'");?>
  <div onClick="gourl('order.php?ddzt=wait')"><img src="img/order2.png" /><? if($a>0){?><span><?=$a?></span><? }?><br>等待发货</div>
  <? $a=returncount("yjcode_order where userid=".$rowuser[id]." and ddzt='db'");?>
  <div onClick="gourl('order.php?ddzt=db')"><img src="img/order3.png" /><? if($a>0){?><span><?=$a?></span><? }?><br>等待收货</div>
  <? $a=returncount("yjcode_order where userid=".$rowuser[id]." and ddzt='back'");?>
  <div onClick="gourl('order.php?ddzt=back')"><img src="img/order4.png" /><? if($a>0){?><span><?=$a?></span><? }?><br>退款处理</div>
  <? $a=returncount("yjcode_order where userid=".$rowuser[id]." and ddzt='jf'");?>
  <div onClick="gourl('order.php?ddzt=jf')"><img src="img/order5.png" /><? if($a>0){?><span><?=$a?></span><? }?><br>交易纠纷</div>
 </div>
</div>

<div class="infcap box">
 <div class="d1"><img src="img/infcap3.png" /></div>
 <div class="d2">资产管理</div>
 <div class="d3" onClick="gourl('paylog.php')"><?=sprintf("%.2f",$rowuser[money1])?>元</div>
 <div class="d4" onClick="gourl('paylog.php')"><img src="img/jianright.png" /></div>
</div>
<div class="infmain box">
 <div class="d1">
  <div onClick="gourl('pay.php')" class="red"><img src="img/money2.png" /><br>去充值</div>
  <div onClick="gourl('paylog.php')"><img src="img/money1.png" /><br>资金记录</div>
  <div onClick="gourl('jflog.php')"><img src="img/money5.png" /><br>积分记录</div>
  <div onClick="gourl('jfbank.php')"><img src="img/money4.png" /><br>积分银行</div>
  <div onClick="gourl('tixian.php')"><img src="img/money3.png" /><br>去提现</div>
 </div>
</div>

<div class="infcap box">
 <div class="d1"><img src="img/infcap2.png" /></div>
 <div class="d2">任务大厅</div>
 <div class="d3" onClick="gourl('taskadd.php')">发布任务</div>
 <div class="d4" onClick="gourl('tasklist.php')"><img src="img/jianright.png" /></div>
</div>
<div class="infmain box">
 <div class="dtask">
 <ul class="u1">
 <? $a=returncount("yjcode_task where userid=".$rowuser[id]." and taskty=0");?>
 <li onClick="gourl('tasklist.php')"><span class="s1">我发布的单人任务</span><span class="s2"><?=$a?>个</span></li>
 <? $a=returncount("yjcode_task where userid=".$rowuser[id]." and taskty=1");?>
 <li onClick="gourl('tasklist1.php')"><span class="s1">我发布的多人任务</span><span class="s2"><?=$a?>个</span></li>
 <? $a=returncount("yjcode_taskhf where useridhf=".$rowuser[id]." and taskty=0");?>
 <li onClick="gourl('taskhflist.php')"><span class="s1">我接手的单人任务</span><span class="s2"><?=$a?>个</span></li>
 <? $a=returncount("yjcode_taskhf where useridhf=".$rowuser[id]." and taskty=1");?>
 <li onClick="gourl('taskhflist1.php')"><span class="s1">我接手的多人任务</span><span class="s2"><?=$a?>个</span></li>
 </ul>
 </div>
</div>

<div class="infcap box">
 <div class="d1"><img src="img/infcap1.png" /></div>
 <div class="d2" onClick="gourl('shdzlist.php')">收货地址管理</div>
 <div class="d4" onClick="gourl('shdzlist.php')"><img src="img/jianright.png" /></div>
</div>

<div class="infcap box">
 <div class="d1"><img src="img/infcap5.png" /></div>
 <div class="d2" onClick="gourl('shezhi.php')">用户设置</div>
 <div class="d4" onClick="gourl('shezhi.php')"><img src="img/jianright.png" /></div>
</div>

<? include("bottom.php");?>
<script language="javascript">
bottomjd(4);
</script>
</body>
</html>