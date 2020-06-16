<?php
include("../config/conn.php");
include("../config/function.php");
AdminSes_audit();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><?=webname?>管理后台</title>
<link href="css/basic.css" rel="stylesheet" type="text/css" />
<link href="css/quanju.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script language="javascript" src="js/basic.js"></script>
<script language="javascript" src="js/layer.js"></script>
</head>
<body>
<? include("top.php");?>
<script language="javascript">
document.getElementById("menu1").className="a1";
</script>
<? if(!strstr($adminqx,",0,") && !strstr($adminqx,",0302,")){echo "<div class='noneqx'>无权限</div>";exit;}?>

<div class="yjcode">
 <? $leftid=1;include("menu_quan.php");?>

<div class="right">
 
 <div class="bqu1">
 <a class="a1" href="citylist.php">全国区域</a>
 </div>

 <!--begin-->
 <ul class="ksedi">
 <li class="l2">
 <a href="city1.php" class="a1">新增区域</a>
 <a href="javascript:checkDEL('4a','yjcode_city')" class="a2">删除</a>
 </li>
 </ul>
 <ul class="qjlistcap">
 <li class="l1"><input name="C2" type="checkbox" onclick="xuan()" /></li>
 <li class="l2">名称</li>
 <li class="l3">序号</li>
 <li class="l4">级别</li>
 <li class="l5">操作</li>
 </ul>
 <?
 while1("*","yjcode_city where level=1 order by xh asc");while($row1=mysql_fetch_array($res1)){
 $nu="city1.php?action=update&id=".$row1[id];
 ?>
 <ul class="qjlist1">
 <li class="l1"><input name="C1" type="checkbox" value="<?=$row1[id]?>" /></li>
 <li class="l2"><a href="citylist1.php?pid=<?=$row1[bh]?>"><strong><?=$row1[name1]?></strong></a></li>
 <li class="l3"><?=$row1[xh]?></li>
 <li class="l4">一级区域</li>
 <li class="l5">
 <a href="citylist1.php?pid=<?=$row1[bh]?>">查看二级区域</a><span></span><a href="<?=$nu?>">编辑</a>
 </li>
 </ul>
 <? }?>
 <!--end-->
 
</div>
</div>
<?php include("bottom.php");?>
</body>
</html>