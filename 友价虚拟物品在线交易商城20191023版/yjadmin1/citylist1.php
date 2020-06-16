<?php
include("../config/conn.php");
include("../config/function.php");
AdminSes_audit();
$pid=$_GET[pid];
while1("*","yjcode_city where bh='".$pid."'");if(!$row1=mysql_fetch_array($res1)){php_toheader("citylist.php");}
$city1=$row1[name1];
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
 
 <!--begin-->
 <div class="bqu1">
 <a class="a1" href="javascript:void(0);"><?=$city1?></a>
 <a href="citylist.php">返回列表</a>
 </div>
 <ul class="ksedi">
 <li class="l2">
 <a href="city2.php?pid=<?=$pid?>" class="a1">新增二级区域</a>
 <a href="javascript:checkDEL('3b','yjcode_city')" class="a2">删除</a>
 </li>
 </ul>
 <ul class="qjlistcap">
 <li class="l1"><input name="C2" type="checkbox" onclick="xuan()" /></li>
 <li class="l2">分类列表</li>
 <li class="l3">序号</li>
 <li class="l4">级别</li>
 <li class="l5">操作</li>
 </ul>
 <?
 while1("*","yjcode_city where level=2 and parentid='".$pid."' order by xh asc");while($row1=mysql_fetch_array($res1)){
 $nu="city2.php?pid=".$pid."&action=update&id=".$row1[id];
 ?>
 <ul class="qjlist1">
 <li class="l1"><input name="C1" type="checkbox" value="<?=$row1[id]?>xcf0" /></li>
 <li class="l2"><a href="<?=$nu?>"><strong><?=$row1[name1]?></strong></a></li>
 <li class="l3"><?=$row1[xh]?></li>
 <li class="l4">二级区域</li>
 <li class="l5"><a href="city3.php?pid=<?=$row1[bh]?>">添加三级区域</a><span></span><a href="<?=$nu?>">编辑</a></li>
 </ul>
 <?
 while2("*","yjcode_city where level=3 and parentid='".$row1[bh]."' order by xh asc");while($row2=mysql_fetch_array($res2)){
 $nu="city3.php?action=update&id=".$row2[id]."&pid=".$row1[bh]; 
 ?>
 <ul class="qjlist2">
 <li class="l1"><input name="C1" type="checkbox" value="0xcf<?=$row2[id]?>" /></li>
 <li class="l2">&nbsp;&nbsp;<a href="typelist45.php?ty1id=<?=$ty1id?>&ty2id=<?=$row1[id]?>&ty3id=<?=$row2[id]?>">- <?=$row2[name1]?></a></li>
 <li class="l3"><?=$row2[xh]?></li>
 <li class="l4">三级区域</li>
 <li class="l5"><a href="<?=$nu?>">编辑</a></li>
 </ul>
 <?
 }
 }
 ?>
 <!--end-->
 
</div>
</div>
<?php include("bottom.php");?>
</body>
</html>