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
 <a class="a1" href="typelist.php">商品分组</a>
 </div>
 <div class="rights">
 <strong>提示：</strong><br>
 1、每个分组的层级最少1级，最多5级。<br>
 2、但为了使网站的美观和实用性最佳，<span class="blue">我们推荐能使分组达到3级</span>。
 </div>

 <!--begin-->
 <ul class="ksedi">
 <li class="l2">
 <a href="type1.php" class="a1">新增分类</a>
 <a href="javascript:checkDEL(4,'yjcode_type')" class="a2">删除</a>
 </li>
 </ul>
 <ul class="typelistcap">
 <li class="l1"><input name="C2" type="checkbox" onclick="xuan()" /></li>
 <li class="l2">大分类</li>
 <li class="l3">卖家收入</li>
 <li class="l4">推荐佣金</li>
 <li class="l5">担保时间</li>
 <li class="l6">序号</li>
 <li class="l7">编辑时间</li>
 <li class="l8">操作</li>
 </ul>
 <?
 while1("*","yjcode_type where admin=1 order by xh asc");while($row1=mysql_fetch_array($res1)){
 $nu="type1.php?action=update&id=".$row1[id];
 ?>
 <ul class="typelist">
 <li class="l1"><input name="C1" type="checkbox" value="<?=$row1[id]?>" /></li>
 <li class="l2">
 <a href="typelists.php?ty1id=<?=$row1[id]?>"><strong><?=$row1[type1]?></strong></a><? if(empty($row1[iftj])){?> <span class="red">(推荐)</span><? }?>
 </li>
 <li class="l3"><?=returnjgdw($row1[sellbl],"","全局")?></li>
 <li class="l4"><?=returnjgdw($row1[tjmoney],"","全局")?></li>
 <li class="l5"><?=returnjgdw($row1[dbsj],"","全局")?></li>
 <li class="l6"><?=$row1[xh]?></li>
 <li class="l7"><?=$row1[sj]?></li>
 <li class="l8">
 <a href="type2.php?ty1id=<?=$row1[id]?>">子类</a><span></span>
 <a href="<?=$nu?>">编辑</a><span></span><a href="typesxlist.php?typeid=<?=$row1[id]?>">附加选项</a>
 </li>
 </ul>
 <? }?>
 <!--end-->
 
</div>
</div>
<?php include("bottom.php");?>
</body>
</html>