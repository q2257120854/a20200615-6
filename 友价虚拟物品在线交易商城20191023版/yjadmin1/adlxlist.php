<?php
include("../config/conn.php");
include("../config/function.php");
AdminSes_audit();
$ses=" where zt=0";
$page=$_GET["page"];if($page==""){$page=1;}else{$page=intval($_GET["page"]);}
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
 <a class="a1" href="adlxlist.php">自助广告</a>
 </div>
 <div class="rights">
 <strong>提示：</strong><br>
 <span class="red">自助广告系统出售后，是免审核的，因此请做好利弊权衡</span>
 </div>

 <!--B-->
 <ul class="ksedi">
 <li class="l2">
 <a href="javascript:checkDEL(32,'yjcode_adlx')" class="a2">删除</a>
 <a href="adlxlx.php" class="a1">新增信息</a>
 </li>
 </ul>
 <ul class="qjlistcap">
 <li class="l1"><input name="C2" type="checkbox" onclick="xuan()" /></li>
 <li class="l2">广告说明</li>
 <li class="l3">广告编号</li>
 <li class="l4">付费类型</li>
 <li class="l5">最后更新</li>
 </ul>
 <?
 pagef($ses,20,"yjcode_adlx","order by sj desc");while($row=mysql_fetch_array($res)){
 $aurl="adlx.php?bh=".$row[bh];
 if($row[fflx]==1){$fflx="<span class='feng'>固定位置</span>";}else{$fflx="<span class='green'>根据位置变动</span>";}
 ?>
 <ul class="qjlist2">
 <li class="l1"><input name="C1" type="checkbox" value="<?=$row[bh]?>" /></li>
 <li class="l2"><a href="<?=$aurl?>"><?=$row[tit]?></a></li>
 <li class="l3"><?=$row[adbh]?></li>
 <li class="l4"><?=$fflx?></li>
 <li class="l51"><?=$row[sj]?></li>
 </ul>
 <? }?>
 <?
 $nowurl="adlxlist.php";
 $nowwd="";
 include("page.php");
 ?>
 <!--E-->
 
</div>
</div>
<?php include("bottom.php");?>
</body>
</html>