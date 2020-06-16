<?
include("../config/conn.php");
include("../config/function.php");
sesCheck();
$bh=$_GET[bh];
$userid=returnuserid($_SESSION[SHOPUSER]);
$sqltask="select * from yjcode_task where bh='".$bh."' and taskty=0 and userid=".$userid."";mysql_query("SET NAMES 'GBK'");$restask=mysql_query($sqltask);
if(!$rowtask=mysql_fetch_array($restask)){php_toheader("tasklist.php");}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>用户管理面板 - <?=webname?></title>
<? include("cssjs.html");?>
<link href="css/task.css" rel="stylesheet" type="text/css" />
</head>
<body>
<? include("../tem/top.html");?>
<? include("top.php");?>
<div class="yjcode">

<? include("left.php");?>

<!--RB-->
<div class="userright">
 
 <? include("rcap17.php");?>
 <script language="javascript">
 document.getElementById("rcap1").className="l1 l2";
 </script>

 <!--白B-->
 <div class="rkuang">
 
 <? include("taskv.php");?>

 <ul class="taskbjcap">
 <li class="l1">接手方信息</li>
 <li class="l2">报价</li>
 <li class="l3">交易成功</li>
 <li class="l4">交易失败</li>
 <li class="l5">QQ</li>
 <li class="l6">手机</li>
 <li class="l7">操作</li>
 </ul>
 <?
 $ses=" where taskty=0 and bh='".$bh."'";
 $page=$_GET["page"];if($page==""){$page=1;}else{$page=intval($_GET["page"]);}
 pagef($ses,20,"yjcode_taskhf","order by sj desc");while($row=mysql_fetch_array($res)){
 while2("*","yjcode_user where id=".$row[useridhf]);$row2=mysql_fetch_array($res2);
 ?>
 <ul class="taskbj">
 <li class="l1"><?=$row2[nc]?></li>
 <li class="l2"><strong><?=$row[money1]?></strong>元</li>
 <li class="l3"><strong><?=returncount("yjcode_task where zt=5 and useridhf=".$row[useridhf]."")?></strong>次</li>
 <li class="l4"><strong><?=returncount("yjcode_task where zt=9 and useridhf=".$row[useridhf]."")?></strong>次</li>
 <li class="l5"><a href="http://wpa.qq.com/msgrd?v=3&uin=<?=$row2[uqq]?>&site=<?=weburl?>&menu=yes" target="_blank"><?=$row2[uqq]?></a></li>
 <li class="l6"><?=$row2[mot]?></li>
 <li class="l7">
 <? if(0==$rowtask[zt]){?>
 <a href="taskbjsel.php?bh=<?=$bh?>&mid=<?=$row[id]?>" class="btna1">选择TA</a>
 <? }elseif(3==$rowtask[zt] && $rowtask[useridhf]==$row[useridhf]){?>
 <a href="taskgts.php?bh=<?=$bh?>" class="btna2">已中标</a>
 <? }?>
 </li>
 </ul>
 <div class="taskbjsm">接手留言：<?=strip_tags(returnjgdw($row[txt],"","未填写任何说明"))?></div>
 <div class="taskxx"></div>
 <? }?>
 <div class="npa">
 <?
 $nowurl="taskbjlist.php";
 $nowwd="bh=".$bh;
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