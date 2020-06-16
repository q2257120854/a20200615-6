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
<link href="css/hudong.css" rel="stylesheet" type="text/css" />
</head>
<body>
<? include("../tem/top.html");?>
<? include("top.php");?>
<div class="yjcode">

<? include("left.php");?>

<!--RB-->
<div class="userright">
 
 <!--白B-->
 <div class="rkuang">
 
 <ul class="tjuidcap">
 <li class="l1">会员昵称</li>
 <li class="l2">注册时间</li>
 </ul>
   
 <?
 $ses=" where tjuserid=".$luserid;
 $page=$_GET["page"];if($page==""){$page=1;}else{$page=intval($_GET["page"]);}
 pagef($ses,30,"yjcode_user","order by sj desc");while($row=mysql_fetch_array($res)){
 ?>
 <ul class="tjuid">
 <li class="l1"><?=returnnc($row[id])?></li>
 <li class="l2"><?=$row[sj]?></li>
 </ul>
 <? }?>

 <div class="npa">
 <?
 $nowurl="tjuid.php";
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