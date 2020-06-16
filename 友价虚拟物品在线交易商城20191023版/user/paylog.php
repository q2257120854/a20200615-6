<?
include("../config/conn.php");
include("../config/function.php");
sesCheck();
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
 document.getElementById("rcap1").className="l1 l2";
 </script>

 <!--白B-->
 <div class="rkuang">
 
 <ul class="paylogcap">
 <li class="l1">时间</li>
 <li class="l2">金额</li>
 <li class="l4">收支</li>
 <li class="l3">说明</li>
 </ul>
 <?
 $ses=" where userid=".$luserid;
 $page=$_GET["page"];if($page==""){$page=1;}else{$page=intval($_GET["page"]);}
 pagef($ses,30,"yjcode_moneyrecord","order by sj desc");while($row=mysql_fetch_array($res)){
 ?>
 <ul class="paylog">
 <li class="l1"><?=$row[sj]?></li>
 <li class="l2"><?=$row[moneynum]?></li>
 <li class="l4"><? if($row[moneynum]>0){?><span class="blue">收入</span><? }else{?><span class="red">支出</span><? }?></li>
 <li class="l3"><?=$row[tit]?></li>
 </ul>
 <? }?>
 <div class="npa">
 <?
 $nowurl="paylog.php";
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