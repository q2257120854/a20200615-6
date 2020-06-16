<?php
include("../config/conn.php");
include("../config/function.php");
AdminSes_audit();
$ses=" where id>0";
if($_GET[st1]!=""){$userid=returnuserid($_GET[st1]);$ses=$ses." and userid=".$userid;}
if($_GET[zt]!=""){$ses=$ses." and zt=".$_GET[zt];}
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
location.href="baomoneylist.php?st1="+document.getElementById("st1").value;	
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
 <? $leftid=3;include("menu_user.php");?>

<div class="right">
 
 <div class="bqu1">
 <a class="a1" href="baomoneylist.php">保证金管理</a>
 </div>
 <!--B-->
 <ul class="ksedi">
 <li class="l2">
 <a href="javascript:checkDEL(39,'yjcode_baomoneyrecord')" class="a2">删除</a>
 </li>
 </ul>
 <ul class="psel">
 <li class="l1">会员帐号：</li><li class="l2"><input value="<?=$_GET[st1]?>" type="text" id="st1" size="15" /></li>
 <li class="l3"><a href="javascript:ser()" class="a2">搜索</a></li>
 </ul>
 <ul class="mlistcap">
 <li class="l1"><input name="C2" type="checkbox" onclick="xuan()" /></li>
 <li class="l2">说明</li>
 <li class="l3">保证金</li>
 <li class="l4">操作IP</li>
 <li class="l5">操作时间</li>
 <li class="l6">会员</li>
 </ul>
 <? pagef($ses,20,"yjcode_baomoneyrecord","order by sj desc");while($row=mysql_fetch_array($res)){$au="baomoney.php?id=".$row[id];?>
 <ul class="mlist">
 <li class="l1"><? if(1<>$row[zt]){?><input name="C1" type="checkbox" value="<?=$row[id]?>" /><? }?></li>
 <li class="l2"><a href="<?=$au?>"><?=$row[tit]?></a> [<?=returnztv($row[zt])?>]</li>
 <li class="l3"><? if($row[moneynum]>0){?><span class="blue"><?=$row[moneynum]?></span><? }else{?><span class="red"><?=$row[moneynum]?></span><? }?></li>
 <li class="l4"><?=$row[sj]?></li>
 <li class="l5"><a href="http://www.baidu.com/s?wd=<?=$row[uip]?>" target="_blank"><?=$row[uip]?></a></li>
 <li class="l6"><?=returnuser($row[userid])?></li>
 </ul>
 <? }?>
 <?
 $nowurl="baomoneylist.php";
 $nowwd="st1=".$_GET[st1]."&zt=".$_GET[zt];
 include("page.php");
 ?>
 <!--E-->
 
</div>
</div>
<?php include("bottom.php");?>
</body>
</html>