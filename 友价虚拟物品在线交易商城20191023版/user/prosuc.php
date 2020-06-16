<?
include("../config/conn.php");
include("../config/function.php");
sesCheck();
$bh=$_GET[bh];
$id=$_GET[id];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>用户管理面板 - <?=webname?></title>
<? include("cssjs.html");?>
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
 
 <ul class="wz">
 <li class="l1 l2"><a href="javascript:void(0);">操作提示</a></li>
 </ul>

 <div class="czts">
 <strong class="feng">恭喜您，编辑成功！</strong><br>
 <a href="productlist.php">返回列表</a> | <a href="productlx.php">发布新商品</a> | <a href="product.php?bh=<?=$bh?>">返回编辑</a> | <a href="../product/view<?=$id?>.html" target="_blank">预览刚发布的商品</a>
 </div>
 
 </div>
 <!--白E-->

</div> 
<!--RE-->

</div>

<div class="clear clear15"></div>
<? include("../tem/bottom.html");?>
</body>
</html>