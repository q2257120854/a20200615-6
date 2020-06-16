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
 document.getElementById("rcap2").className="l1 l2";
 </script>

 <!--白B-->
 <div class="rkuang">
 
 <div class="ksedi">
 <div class="d1">
 <a href="javascript:NcheckDEL(3,'yjcode_task')" class="a1">删除</a>
 <a href="../task/taskadd.php" class="a2">发布任务</a>
 </div>
 </div>


 <ul class="taskcap">
 <li class="l0"><input name="C2" type="checkbox" onclick="xuan()" /></li>
 <li class="l1">任务</li>
 <li class="l2">预算</li>
 <li class="l3">份数</li>
 <li class="l7">任务进度</li>
 <li class="l6">操作</li>
 </ul>
  
 <?
 $ses=" where taskty=1 and userid=".$luserid;
 $page=$_GET["page"];if($page==""){$page=1;}else{$page=intval($_GET["page"]);}
 pagef($ses,30,"yjcode_task","order by sj desc");while($row=mysql_fetch_array($res)){
 taskok($row["id"]);
 ?>
 <ul class="tasklist">
 <li class="l0"><? if($row[zt]==0 || $row[zt]==1 || $row[zt]==2|| $row[zt]==5 || $row[zt]==6 || $row[zt]==7 || $row[zt]==9){?><input name="C1" type="checkbox" value="<?=$row[bh]?>" /><? }?></li>
 <li class="l1">
 <a href="../task/view<?=$row[id]?>.html" target="_blank" title="<?=$row[tit]?>"><?=returntitdian($row[tit],40)?></a><span class="zt"><?=returntask($row[zt])?></span>
 <span class="sj">发布时间：<?=$row[sj]?></span>
 </li>
 <li class="l2">
 <strong><?=$row[money1]?></strong>元
 <span class="zb">单份:<?=sprintf("%.0f",$row[money1]/$row[tasknum])?>元</span>
 </li>
 <li class="l3"><strong><?=$row[tasknum]?></strong>份</li>
 <li class="l7">
 <span class="s1">剩余<strong><?=$row[tasknum]-$row[taskcy]?></strong>份</span>
 <span class="s2"></span>
 <span class="s3" style="width:<? $okbfb=$row[taskcy]/$row[tasknum];echo 100*$okbfb;?>px;"></span>
 <span class="s4"><?=sprintf("%.2f",$okbfb*100)?>%</span>
 </li>
 <li class="l6">
 <?
 $needys=returncount("yjcode_taskhf where bh='".$row[bh]."' and taskty=1 and zt=1");
 ?>
 <? if($needys>0){?>
 <a href="taskbjlist1.php?bh=<?=$row[bh]?>&zt=1" class="btna btna1">进行验收</a>
 <? }?>
 <? if($row[zt]==100){?>
 <a href="taskmoney.php?bh=<?=$row[bh]?>" class="btna btna1">缴纳费用</a>
 <? }?>
 </li>
 </ul>
 <? }?>

 <div class="npa">
 <?
 $nowurl="tasklist1.php";
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