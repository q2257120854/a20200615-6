<?
include("../config/conn.php");
include("../config/function.php");
sesCheck();
$userid=returnuserid($_SESSION[SHOPUSER]);

if($_GET[e]=="back"){
 $id=$_GET[id];
 while0("*","yjcode_tixian where id=".$id." and userid=".$userid." and zt=4");if($row=mysql_fetch_array($res)){
  updatetable("yjcode_tixian","zt=3,sm='用户撤销' where id=".$id);
  PointUpdateM($userid,$row[money1]);
  PointIntoM($userid,"撤消提现申请",$row[money1]);
 }
 php_toheader("tixianlog.php");
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>用户管理面板 - <?=webname?></title>
<? include("cssjs.html");?>
<link href="css/pay.css" rel="stylesheet" type="text/css" />
</head>
<body>
<? include("../tem/top.html");?>
<? include("top.php");?>
<div class="yjcode">

<? include("left.php");?>

<!--RB-->
<div class="userright">
 
 <? include("rcap2.php");?>
 <script language="javascript">
 document.getElementById("rcap5").className="l1 l2";
 </script>

 <!--白B-->
 <div class="rkuang">
 
 <? systs("操作成功!","tixianlog.php")?>
 <ul class="txlogcap">
 <li class="l1">时间</li>
 <li class="l2">提现金额</li>
 <li class="l3">说明</li>
 <li class="l4">操作</li>
 </ul>
   
 <?
 $ses=" where userid=".$userid;
 $page=$_GET["page"];if($page==""){$page=1;}else{$page=intval($_GET["page"]);}
 pagef($ses,30,"yjcode_tixian","order by sj desc");while($row=mysql_fetch_array($res)){
 $cz="";
 if($row[zt]==4){$cz="【<a href='tixianlog.php?e=back&id=".$row[id]."'>撤消申请</a>】";}
 ?>
 <ul class="txlog">
 <li class="l1"><?=$row[sj]?></li>
 <li class="l2"><strong class="feng"><?=$row[money1]?></strong></li>
 <li class="l3"><strong><?=returntxzt($row[zt],$row[sm])?></strong><br>&nbsp;&nbsp;&nbsp;收款人：<?=$row[txname]?>，<?=$row[txyh]?>（<?=$row[txzh]?>）</li>
 <li class="l4"><?=$cz?></li>
 </ul>
 <? }?>

 <div class="npa">
 <?
 $nowurl="tixianlog.php";
 $nowwd="";
 require("page.php");
 ?>
 </div>
 
 <div class="clear clear10"></div>

 </div>
 <!--白E-->

</div> 
<!--RE-->

</div>

<div class="clear clear15"></div>
<? include("../tem/bottom.html");?>
</body>
</html>