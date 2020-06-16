<?php
include("../config/conn.php");
include("../config/function.php");
AdminSes_audit();
$ses=" where id>0";
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
</head>
<body>
<? include("top.php");?>
<script language="javascript">
document.getElementById("menu2").className="a1";
</script>
<? if(!strstr($adminqx,",0,")){echo "<div class='noneqx'>无权限</div>";exit;}?>

<div class="yjcode">
<? $leftid=6;include("menu_user.php");?>

<div class="right">
 
 <div class="bqu1">
 <a class="a1" href="adminlist.php">管理员列表</a>
 </div>

 <!--begin-->
 <ul class="ksedi">
 <li class="l2">
 <a href="javascript:checkDEL(11,'yjcode_admin')" class="a1">删除管理员</a>
 <a href="admin.php" class="a2">新增</a>
 </li>
 </ul>
 <ul class="adminlistcap">
 <li class="l1"><input name="C2" type="checkbox" onclick="xuan()" /></li>
 <li class="l2">会员帐号</li>
 <li class="l3">称呼</li>
 <li class="l4">操作</li>
 </ul>
 <?
 pagef($ses,20,"yjcode_admin","order by id desc");
 while($row=mysql_fetch_array($res)){
 $aurl="admin.php?action=update&id=".$row[id];
 ?>
 <ul class="adminlist">
 <li class="l1"><input name="C1" type="checkbox" value="<?=$row[id]?>" /></li>
 <li class="l2"><a href="<?=$aurl?>"><strong><?=$row[adminuid]?></strong></a></li>
 <li class="l3"><?=$row[uname]?></li>
 <li class="l4"><a href="<?=$aurl?>">编辑</a></li>
 </ul>
 <? }?>
 <?
 $nowurl="adminlist.php";
 $nowwd="";
 include("page.php");
 ?>
 <!--end-->
 
</div>
</div>
<?php include("bottom.php");?>
</body>
</html>