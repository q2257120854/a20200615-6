<?php
include("../config/conn.php");
include("../config/function.php");
AdminSes_audit();
$bh=$_GET[bh];
while0("*","yjcode_pro where bh='".$bh."'");if(!$row=mysql_fetch_array($res)){php_toheader("productlist.php");}

if($_GET[control]=="update"){
 updatetable("yjcode_tp","xh=".$_GET[xh]." where id=".$_GET[id]);
 php_toheader("protp.php?t=suc&bh=".$bh);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><?=webname?>管理系统</title>
<link href="css/default.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="js/basic.js"></script>
<script language="javascript">
function xhonc(x){
location.href="protp.php?id="+x+"&bh=<?=$bh?>&control=update&xh="+document.getElementById("xh"+x).value;
}
</script>
</head>
<body>
<?php include("top.html");?>
<script language="javascript">
document.getElementById("menu3").className="l31";
</script>
<? if(!strstr($adminqx,",0,") && !strstr($adminqx,",0102,")){echo "<div class='noneqx'>无权限</div>";exit;}?>

<div class="adminmain">

<div class="left">
 <div class="lefttop"></div>
 <div class="leftmain">
 <?php include("menu_product.php");?>
 </div>
 <div class="lefttop"></div>
</div>

<div class="right" id="right">
 <ul class="wz">
 <li class="l1">当前位置：后台首页 - <strong>商品图片管理</strong></li><li class="l2"></li>
 </ul>
 <? if($_GET[t]=="suc"){systs("恭喜您，操作成功","protp.php?bh=".$bh);}?>
 <!--B-->
 <div class="listkuan">
 <ul class="typecon1">
 <li class="l1"></li>
 <li class="l2"><?=$row[tit]?></li>
 </ul>
 <ul class="typecap">
 <li class="l1"><input name="C2" type="checkbox" onclick="xuan()" /></li>
 <li class="l2">&nbsp;图片</li>
 <li class="l6">排序</li>
 <li class="l6">图片ID</li>
 <li class="l6">商品编号</li>
 <li class="l6">最后更新</li>
 <li class="l7">操作</li>
 </ul>
 <ul class="typecon">
 <li class="l1">
 <a href="javascript:checkDEL(30,'yjcode_tp')" class="a2">删除</a>
 </li>
 </ul>
 <? while1("*","yjcode_tp where bh='".$bh."' order by xh asc");while($row1=mysql_fetch_array($res1)){$tp="../".str_replace(".","-2.",$row1[tp]);?>
 <ul class="typelist3">
 <li class="l1"><input name="C1" type="checkbox" value="<?=$row1[id]?>" /></li>
 <li class="l2"><img border="0" class="imgtp" src="<?=$tp?>" width="52" height="52" align="left" /></li>
 <li class="l6"><input type="text" value="<?=$row1[xh]?>" id="xh<?=$row1[id]?>" style="width:30px;margin:0 0 8px 0;text-align:center;" /><br><a href="javascript:void(0);" class="blue" onclick="xhonc(<?=$row1[id]?>)">【保存】</a></li>
 <li class="l6"><?=$row1[id]?></li>
 <li class="l6"><?=$row1[bh]?></li>
 <li class="l6"><?=$row1[sj]?></li>
 <li class="l7"><a href="../<?=$row1[tp]?>" target="_blank" class="a1">查看图片</a></li>
 </ul>
 <? }?>
 </div>
 <!--E-->

</div>

</div>

<?php include("bottom.html");?>
</body>
</html>