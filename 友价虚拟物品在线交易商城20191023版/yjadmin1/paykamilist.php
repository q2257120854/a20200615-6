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
<link href="css/product.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script language="javascript" src="js/basic.js"></script>
<script language="javascript" src="js/layer.js"></script>
<script language="javascript">
function ser(){
location.href="paykamilist.php?st1="+document.getElementById("st1").value+"&st2="+document.getElementById("st2").value+"&sd1="+document.getElementById("sd1").value;
}
</script>
</head>
<body>
<? include("top.php");?>
<script language="javascript">
document.getElementById("menu3").className="a1";
</script>
<? if(!strstr($adminqx,",0,") && !strstr($adminqx,",0102,")){echo "<div class='noneqx'>无权限</div>";exit;}?>

<div class="yjcode">
 <? $leftid=2;include("menu_product.php");?>

<div class="right">
 
 <div class="bqu1">
 <a class="a1" href="paykamilist.php">卡密列表</a>
 </div>
 <!--B-->
 <ul class="psel">
 <li class="l1">使用情况：</li>
 <li class="l2">
 <select id="sd1">
 <option value="">==不限==</option>
 <option value="0"<? if(0==$_GET[sd1] && $_GET[sd1]!=""){?> selected="selected"<? }?>>未使用</option>
 <option value="1"<? if(1==$_GET[sd1]){?> selected="selected"<? }?>>已使用</option>
 </select>
 </li>
 <li class="l1">卡号：</li><li class="l2"><input value="<?=$_GET[st1]?>" type="text" id="st1" size="15" /></li>
 <li class="l1">密码：</li><li class="l2"><input value="<?=$_GET[st2]?>" type="text" id="st2" size="15" /></li>
 <li class="l3"><a href="javascript:ser()" class="a2">搜索</a></li>
 </ul>
 <ul class="ksedi">
 <li class="l2">
 <a href="javascript:checkDEL(38,'yjcode_paykami')" class="a2">删除</a>
 <a href="paykami.php" class="a1">新增库存</a>
 </li>
 </ul>
 <ul class="paykmcap">
 <li class="l1"><input name="C2" type="checkbox" onclick="xuan()" /></li>
 <li class="l2">卡号</li>
 <li class="l3">密码</li>
 <li class="l4">面值</li>
 <li class="l5">使用情况</li>
 <li class="l6">交易时间</li>
 </ul>
 <?
 $ses=" where id>0";
 if($_GET[st1]!=""){$ses=$ses." and ka like '%".$_GET[st1]."%'";}
 if($_GET[st2]!=""){$ses=$ses." and mi like '%".$_GET[st2]."%'";}
 if($_GET[sd1]!=""){$ses=$ses." and ifok=".$_GET[sd1];}
 $page=$_GET["page"];if($page==""){$page=1;}else{$page=intval($_GET["page"]);}
 pagef($ses,30,"yjcode_paykami","order by id asc");while($row=mysql_fetch_array($res)){
 ?>
 <ul class="paykmlist">
 <li class="l1"><input name="C1" type="checkbox" value="<?=$row[id]?>" /></li>
 <li class="l2"><a href="paykami.php?id=<?=$row[id]?>&action=update"><?=$row[ka]?></a></li>
 <li class="l3"><?=$row[mi]?></li>
 <li class="l4"><?=$row[money1]?>元</li>
 <li class="l5"><? if(1==$row[ifok]){?><span class="red">已使用</span><? }else{?><span class="blue">未使用</span><? }?></li>
 <li class="l6"><?=$row[sj]?></li>
 </ul>
 <? }?>
 <?
 $nowurl="paykamilist.php";
 $nowwd="st1=".$_GET[st1]."&st2=".$_GET[st2]."&sd1=".$_GET[sd1];
 include("page.php");
 ?>
 <!--E-->
 
</div>
</div>
<?php include("bottom.php");?>
</body>
</html>