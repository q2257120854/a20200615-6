<?php
include("../config/conn.php");
include("../config/function.php");
AdminSes_audit();
$typeid=$_GET[typeid];if(empty($typeid)){php_toheader("default.php");}
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
 <a class="a1" href="javascript:void(0);"><?=returntype(1,$typeid)?>附加选项</a>
 <a href="typelist.php">返回列表</a>
 </div>
 <!--begin-->
 <ul class="ksedi">
 <li class="l2">
 <a href="typesx.php?typeid=<?=$typeid?>" class="a1">新增选项</a>
 <a href="javascript:checkDEL(18,'yjcode_typesx')" class="a2">删除</a>
 </li>
 </ul>
 <ul class="qjlistcap">
 <li class="l1"><input name="C2" type="checkbox" onclick="xuan()" /></li>
 <li class="l2">附加选项列表</li>
 <li class="l3">序号</li>
 <li class="l4">编辑时间</li>
 <li class="l5">操作</li>
 </ul>
 <?
 while1("*","yjcode_typesx where admin=1 and typeid=".$typeid." order by xh asc");while($row1=mysql_fetch_array($res1)){
 $nu="typesx.php?action=update&id=".$row1[id]."&typeid=".$typeid;
 ?>
 <ul class="qjlist1">
 <li class="l1"><input name="C1" type="checkbox" value="<?=$row1[id]?>xcf0" /></li>
 <li class="l2"><a href="<?=$nu?>"><strong><?=$row1[name1]?></strong></a></li>
 <li class="l3"><?=$row1[xh]?></li>
 <li class="l4"><?=$row1[sj]?></li>
 <li class="l5"><a href="typesx1.php?ty1id=<?=$row1[id]?>">添加二级选项</a><span></span><a href="<?=$nu?>">编辑</a></li>
 </ul>
 <?
 while2("*","yjcode_typesx where admin=2 and name1='".$row1[name1]."' and typeid=".$typeid." order by xh asc");while($row2=mysql_fetch_array($res2)){
 $nu="typesx1.php?action=update&id=".$row2[id]."&ty1id=".$row1[id]; 
 ?>
 <ul class="qjlist2">
 <li class="l1"><input name="C1" type="checkbox" value="xcf<?=$row2[id]?>" /></li>
 <li class="l2">&nbsp;&nbsp;- <a href="<?=$nu?>"><?=$row2[name2]?></a></li>
 <li class="l3"><?=$row2[xh]?></li>
 <li class="l4"><?=$row2[sj]?></li>
 <li class="l5"><a href="<?=$nu?>">编辑</a></li>
 </ul>
 <? }}?>
 <!--end-->
 
</div>
</div>
<?php include("bottom.php");?>
</body>
</html>