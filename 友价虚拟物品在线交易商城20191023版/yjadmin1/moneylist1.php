<?php
include("../config/conn.php");
include("../config/function.php");
AdminSes_audit();
$ses=" where ifok=1";
if($_GET[st1]!=""){$userid=returnuserid($_GET[st1]);$ses=$ses." and userid=".$userid;}
if($_GET[st2]!=""){$ses=$ses." and ddbh = '".$_GET[st2]."'";}
$page=$_GET["page"];if($page==""){$page=1;}else{$page=intval($_GET["page"]);}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><?=webname?>管理系统</title>
<link href="css/basic.css" rel="stylesheet" type="text/css" />
<link href="css/user.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script language="javascript" src="js/basic.js"></script>
<script language="javascript" src="js/layer.js"></script>
<script language="javascript">
function ser(){
location.href="moneylist1.php?st1="+document.getElementById("st1").value+"&st2="+document.getElementById("st2").value;	
}
</script>
</head>
<body>
<? include("top.php");?>
<script language="javascript">
document.getElementById("menu2").className="a1";
</script>
<? if(!strstr($adminqx,",0,") && !strstr($adminqx,",0702,")){echo "<div class='noneqx'>无权限</div>";exit;}?>

<div class="yjcode">
 <? $leftid=2;include("menu_user.php");?>

<div class="right">
 
 <div class="bqu1">
 <a class="a1" href="moneylist1.php">充值接口资金记录</a>
 </div>
 <div class="rights">
 <strong>提示：</strong><br>
 <span class="red">可删除每条记录，删除后，可能导致会员的对帐记录不同步，但不会涉及到金额调整</span>
 </div>
 <!--B-->
 <ul class="psel">
 <li class="l1">会员帐号：</li><li class="l2"><input value="<?=$_GET[st1]?>" type="text" id="st1" size="15" /></li>
 <li class="l1">订单编号：</li><li class="l2"><input value="<?=$_GET[st2]?>" type="text" id="st2" size="15" /></li>
 <li class="l3"><a href="javascript:ser()" class="a2">搜索</a></li>
 </ul>
 <ul class="ksedi">
 <li class="l2">
 <a href="javascript:checkDEL('26a','yjcode_moneyrecord')" class="a2">删除</a>
 </li>
 </ul>
 <ul class="mlistcap">
 <li class="l1"><input name="C2" type="checkbox" onclick="xuan()" /></li>
 <li class="l2">说明</li>
 <li class="l3">资金</li>
 <li class="l4">操作IP</li>
 <li class="l5">操作时间</li>
 <li class="l6">会员</li>
 </ul>
 <? pagef($ses,20,"yjcode_dingdang","order by sj desc");while($row=mysql_fetch_array($res)){?>
 <ul class="mlist">
 <li class="l1"><input name="C1" type="checkbox" value="<?=$row[id]?>" /></li>
 <li class="l2"><?=returnjgdw($row[bz],"","支付宝")?> (订单号：<?=$row[ddbh]?>)</li>
 <li class="l3"><span class="blue"><?=$row[money1]?></span></li>
 <li class="l4"><a href="http://www.baidu.com/s?wd=<?=$row[uip]?>" target="_blank"><?=$row[uip]?></a></li>
 <li class="l5"><?=$row[sj]?></li>
 <li class="l6"><?=returnuser($row[userid])?></li>
 </ul>
 <? }?>
 <?
 $nowurl="moneylist1.php";
 $nowwd="st1=".$_GET[st1]."&st2=".$_GET[st2];
 include("page.php");
 ?>
 <!--E-->
 
</div>
</div>
<?php include("bottom.php");?>
</body>
</html>