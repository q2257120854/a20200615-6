<?php
include("../config/conn.php");
include("../config/function.php");
AdminSes_audit();
$ses=" where id>0";
if($_GET[zt]!=""){$ses=$ses." and zt=".$_GET[zt];}
if($_GET[st1]!=""){$userid=returnuserid($_GET[st1]);$ses=$ses." and userid=".$userid;}
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
<script language="javascript">
function ser(){
location.href="txlist.php?st1="+document.getElementById("st1").value+"&zt="+document.getElementById("zt").value;	
}
</script>
</head>
<body>
<? include("top.php");?>
<script language="javascript">
document.getElementById("menu2").className="a1";
</script>
<? if(!strstr($adminqx,",0,") && !strstr($adminqx,",0702,")){echo "<div class='noneqx'>无权限</div>";exit;}?>

<div class="yjcode">
 <? $leftid=5;include("menu_user.php");?>

<div class="right">
 <div class="rights">
 <strong>提示：</strong><br>
 <span class="red">等待受理的提现申请无法删除，如要删除，请先将提现状态设为非等待受理</span>
 </div>
 <div class="bqu1">
 <a class="a1" href="txlist.php">会员提现</a>
 </div>
 <!--B-->
 <ul class="psel">
 <li class="l1">会员帐号：</li><li class="l2"><input value="<?=$_GET[st1]?>" type="text" id="st1" size="15" /></li>
 <li class="l1">审核状态：</li>
 <li class="l2">
 <select id="zt">
 <option value="">==不限==</option>
 <option value="1"<? if(1==$_GET[zt]){?> selected="selected"<? }?>>提现成功</option>
 <option value="2"<? if(2==$_GET[zt]){?> selected="selected"<? }?>>用户撤销提现</option>
 <option value="3"<? if(3==$_GET[zt]){?> selected="selected"<? }?>>提现失败</option>
 <option value="4"<? if(4==$_GET[zt]){?> selected="selected"<? }?>>等待受理</option>
 </select>
 </li>
 <li class="l3"><a href="javascript:ser()" class="a2">搜索</a></li>
 </ul>
 <ul class="ksedi">
 <li class="l2">
 <a href="javascript:checkDEL(10,'yjcode_tixian')" class="a2">删除</a>
 </li>
 </ul>
 <ul class="mlistcap">
 <li class="l1"><input name="C2" type="checkbox" onclick="xuan()" /></li>
 <li class="l2">状态</li>
 <li class="l6">提现会员</li>
 <li class="l3">提现银行</li>
 <li class="l4">提现金额</li>
 <li class="l5">提现时间</li>
 </ul>
 <?
 pagef($ses,20,"yjcode_tixian","order by sj desc");while($row=mysql_fetch_array($res)){
 $au="tx.php?id=".$row[id];
 ?>
 <ul class="mlist">
 <li class="l1"><input name="C1" type="checkbox" value="<?=$row[id]?>" /></li>
 <li class="l2"><a href="<?=$au?>"><?=returntxzt($row[zt],$row[sm])?></a></li>
 <li class="l6"><?=returnuser($row[userid])?></li>
 <li class="l3"><?=$row[txyh]?></li>
 <li class="l4"><?=$row[money1]?></li>
 <li class="l5"><?=$row[sj]?></li>
 </ul>
 <? }?>
 <?
 $nowurl="txlist.php";
 $nowwd="zt=".$_GET[zt]."&st1=".$_GET[st1];
 include("page.php");
 ?>
 <!--E-->
 
</div>
</div>
<?php include("bottom.php");?>
</body>
</html>