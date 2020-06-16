<?
include("../config/conn.php");
include("../config/function.php");
sesCheck();
$userid=returnuserid($_SESSION["SHOPUSER"]);
$ses=" where selluserid=".$userid;
$sestj=$ses;
if($_GET[t1v]!=""){$ses=$ses." and tit like '%".$_GET[t1v]."%'";$sestj=$ses;}
if($_GET[t2v]!=""){$ses=$ses." and sj>='".$_GET[t2v]."'";$sestj=$ses;}
if($_GET[t3v]!=""){$ses=$ses." and sj<='".$_GET[t3v]."'";$sestj=$ses;}
if($_GET[t4v]!=""){$ses=$ses." and orderbh='".$_GET[t4v]."'";$sestj=$ses;}
if($_GET[ddzt]!=""){$ses=$ses." and ddzt='".$_GET[ddzt]."'";}
if($_GET[page]!=""){$page=$_GET[page];}else{$page=1;}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>用户管理面板 - <?=webname?></title>
<? include("cssjs.html");?>
<link href="css/sell.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/adddate.js" ></script> 
<script language="javascript">
function ser(){
 str="t1v="+document.getElementById("t1").value;
 str=str+"&t2v="+document.getElementById("t2").value;
 str=str+"&t3v="+document.getElementById("t3").value;
 str=str+"&t4v="+document.getElementById("t4").value;
 str=str+"&ddzt="+document.getElementById("ddztv").value;
 location.href="sellorder.php?"+str;
}
</script>
</head>
<body>
<? include("../tem/top.html");?>
<? include("top.php");?>
<div class="yjcode">

<? include("left.php");?>

<!--RB-->
<div class="userright">
 
 <? include("sellzf.php");?>
 <? include("rcap6.php");?>
 <script language="javascript">
 document.getElementById("rcap<?=$_GET[ddzt]?>").className="l1 l2";
 </script>

 <!--搜索B-->
 <div class="kssel">
 <ul class="u1">
 <li class="l1">订单标题：</li>
 <li class="l2"><input type="text" value="<?=$_GET[t1v]?>" id="t1" style="width:155px;" /></li>
 <li class="l1">订单编号：</li>
 <li class="l2"><input type="text" value="<?=$_GET[t4v]?>" id="t4" style="width:155px;" /></li>
 <li class="l1">交易状态：</li>
 <li class="l2">
 <select id="ddztv">
 <option value="">不限</option>
 <option value="wait"<? if($_GET[ddzt]=="wait"){?> selected="selected"<? }?>>等待发货</option>
 <option value="db"<? if($_GET[ddzt]=="db"){?> selected="selected"<? }?>>等待买家确认</option>
 <option value="suc"<? if($_GET[ddzt]=="suc"){?> selected="selected"<? }?>>交易成功</option>
 <option value="back"<? if($_GET[ddzt]=="back"){?> selected="selected"<? }?>>退款申请中</option>
 <option value="backerr"<? if($_GET[ddzt]=="backerr"){?> selected="selected"<? }?>>不同意的退款</option>
 <option value="backsuc"<? if($_GET[ddzt]=="backsuc"){?> selected="selected"<? }?>>退款成功</option>
 </select>
 </li>
 <li class="l1">开始时间：</li>
 <li class="l2">
 <input type="text" value="<?=$_GET[t2v]?>" style="width:155px;" id="t2" readonly="readonly" onclick="SelectDate(this,'yyyy-MM-dd hh:mm:ss')" />
 </li>
 <li class="l1">结束时间：</li>
 <li class="l2">
 <input type="text" value="<?=$_GET[t3v]?>" style="width:155px;" id="t3"readonly="readonly" onclick="SelectDate(this,'yyyy-MM-dd hh:mm:ss')" />
 </li>
 <li class="ltj"><input type="button" onclick="ser()" class="bt1" value="搜索" /> <input type="button" onclick="gourl('sellorder.php')" class="bt2" value="重置" /></li>
 </ul>
 </div>
 <!--搜索E-->

 <!--白B-->
 <div class="rkuang">

 <div class="ksedi">
  <div class="d1">
  <a href="javascript:codecheckDEL(3,'code_down')" class="a1">删除订单</a>
  </div>
  <div class="d3">
  <?
  $sqlq="select sum(money1*num+yunfei) as orderall from yjcode_order".$sestj." and ddzt='db'";mysql_query("SET NAMES 'GBK'");$resq=mysql_query($sqlq);$rowq=mysql_fetch_array($resq);
  $money1=sprintf("%.2f",$rowq[orderall]);
  ?>
  正在担保（<strong class="blue"><?=$money1?>元</strong>）
  </div>
 </div>

 <ul class="sellordercap">
 <li class="l0"><input name="C2" onclick="xuan()" type="checkbox" /></li>
 <li class="l1">商品信息</li>
 <li class="l2">订单价格</li>
 <li class="l3">数量</li>
 <li class="l4">订单信息</li>
 <li class="l5">操作</li>
 </ul>
 <!--列表开始-->
 <?
 pagef($ses,10,"yjcode_order","order by sj desc");while($row=mysql_fetch_array($res)){
 $au="sellorderview.php?orderbh=".$row[orderbh];
 $tp=returntp("bh='".$row[probh]."' order by iffm desc","-2");
 $cz="";
 if($row[ddzt]=="suc"){ //交易成功
 
 }elseif($row[ddzt]=="wait"){ //等待发货
 $cz="<a href='fahuo.php?orderbh=".$row[orderbh]."' class='btn'>发货</a>";
 $cz=$cz."<br><a href='sellclose.php?orderbh=".$row[orderbh]."' class='hui'>取消订单</a>";
 
 }elseif($row[ddzt]=="back"){ //退款处理中
 $cz="<a href='selltk.php?orderbh=".$row[orderbh]."' class='hui'>处理退款</a>";
 $cz=$cz."<a href='orderjf2.php?orderbh=".$row[orderbh]."' class='btn'>沟通</a>";

 }elseif($row[ddzt]=="backerr"){ //退款不同意
 $cz="<a href='orderjf2.php?orderbh=".$row[orderbh]."' class='btn'>沟通</a>";

 }elseif($row[ddzt]=="backsuc"){ //退款成功
 $cz="<a href='orderjf2.php?orderbh=".$row[orderbh]."' class='btn'>沟通</a>";

 }elseif($row[ddzt]=="db"){ //担保中

 }elseif($row[ddzt]=="wpay"){ //等待买家付款

 }elseif($row[ddzt]=="jf"){ //纠纷处理中 
 $cz="<a href='orderjf2.php?orderbh=".$row[orderbh]."' class='btn'>沟通</a>";

 }elseif($row[ddzt]=="jfbuy"){ //买家胜诉 
 $cz="<a href='orderjf2.php?orderbh=".$row[orderbh]."' class='btn'>沟通</a>";

 }elseif($row[ddzt]=="jfsell"){ //卖家胜诉 
 $cz="<a href='orderjf2.php?orderbh=".$row[orderbh]."' class='btn'>沟通</a>";
  
 }
 ?>
 <ul class="sellorder1">
 <li class="l1"><? if($row[ddzt]=="wpay"){?><input name="C1" type="checkbox" value="<?=$row[id]?>" /><? }?></li>
 <li class="l2"><?=dateYMD($row[sj])?></li>
 <li class="l3">订单编号：<?=$row[orderbh]?></li>
 <li class="l4">买家：<?=returnnc($row[userid])?></li>
 <li class="l5"><a href="javascript:void(0);" onclick="opentangqq('<?=returnqq($row[userid])?>')"><img src="../img/qq.png" border="0" /></a></li>
 </ul>
 <ul class="sellorder2">
 <li class="l1"><a href="<?=$au?>"><img class="tp" src="<?=$tp?>" onerror="this.src='img/none60x60.gif'" /></a></li>
 <li class="l2">
 <a title="<?=$row["tit"]?>" href="<?=$au?>" class="a1"><?=returntitdian($row["tit"],102)?></a><br>
 发货形式：<?=returnfhxs($row[fhxs])?><br>
 <? if(!empty($row[tcv])){?>套餐：<?=$row[tcv]?><? }?>
 </li>
 <li class="l3">￥<?=returnjgdian($row[money1]*$row[num]+$row[yunfei])?></li>
 <li class="l4"><?=$row[num]?></li>
 <li class="l5"><?=returnorderzt($row[ddzt])?><br><a href="<?=$au?>">订单详情</a></li>
 <li class="l6"><?=$cz?></li>
 </ul>
 <? }?>
 <!--列表结束-->
 <div class="npa">
 <?
 $nowurl="sellorder.php";
 $nowwd="ddzt=".$_GET[ddzt]."&t1v=".$_GET[t1v]."&t2v=".$_GET[t2v]."&t3v=".$_GET[t3v]."&t4v=".$_GET[t4];
 require("page.php");
 ?>
 </div>

 <div class="clear clear15"></div>
 
 </div>
 <!--白E-->

</div> 
<!--RE-->

</div>

<div class="clear clear15"></div>
<? include("../tem/bottom.html");?>
</body>
</html>