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
<title><?=webname?>管理系统</title>
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
 <a class="a1" href="userdjlist.php">会员等级</a>
 </div>
 <div class="rights">
 <strong>提示：</strong><br>
 <span class="red">排序第一位的等级便是用户注册后默认的等级</span>
 </div>

 <!--B-->
 <ul class="ksedi">
 <li class="l2">
 <a href="javascript:checkDEL(36,'yjcode_userdj')" class="a2">删除</a>
 <a href="userdjlx.php" class="a1">新增等级</a>
 </li>
 </ul>
 <ul class="qjlistcap">
 <li class="l1"><input name="C2" type="checkbox" onclick="xuan()" /></li>
 <li class="l2">等级信息</li>
 <li class="l3">等级费用</li>
 <li class="l4">排序</li>
 <li class="l5">最后更新</li>
 </ul>
 <?
 while0("*","yjcode_userdj where zt=0 order by xh asc");while($row=mysql_fetch_array($res)){
 $aurl="userdj.php?bh=".$row[bh];
 ?>
 <ul class="qjlist2">
 <li class="l1"><input name="C1" type="checkbox" value="<?=$row[bh]?>" /></li>
 <li class="l2" onclick="gourl('<?=$aurl?>')"><strong><?=$row[name1]?></strong> [<?=$row[zhekou]?>折]</li>
 <li class="l3"><?=$row[money1]?>元/<? if(empty($row[jgdw])){echo "月";}else{echo "年";}?></li>
 <li class="l4"><?=$row[xh]?></li>
 <li class="l51"><?=$row[sj]?></li>
 </ul>
 <? }?>
 <!--E-->
 
</div>
</div>
<?php include("bottom.php");?>
</body>
</html>