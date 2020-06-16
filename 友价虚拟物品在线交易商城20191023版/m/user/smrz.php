<?
include("../../config/conn.php");
include("../../config/function.php");
sesCheck_m();

$sqluser="select * from yjcode_user where uid='".$_SESSION[SHOPUSER]."'";mysql_query("SET NAMES 'GBK'");$resuser=mysql_query($sqluser);
if(!$rowuser=mysql_fetch_array($resuser)){php_toheader("../reg/");}
$sfz1="../../upload/".$rowuser[id]."/".strgb2312($rowuser[sfz],0,15)."-1.jpg";
$sfz2="../../upload/".$rowuser[id]."/".strgb2312($rowuser[sfz],0,15)."-2.jpg";
$sfz3="../../upload/".$rowuser[id]."/".strgb2312($rowuser[sfz],0,15)."-3.jpg";
?>
<html>
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
<title>会员中心 <?=webname?></title>
<? include("../tem/cssjs.html");?>
<link href="css/buy.css" rel="stylesheet" type="text/css" />
</head>
<body>
<? include("topuser.php");?>

<div class="bfbtop1 box">
 <div class="d1" onClick="javascript:window.history.go(-1);"><img src="img/topleft.png" height="21" /></div>
 <div class="d2">实名认证</div>
 <div class="d3"></div>
</div>

<div class="uk box"><div class="d1">认证状态<span class="s1"></span></div><div class="d21"><? 
if(0==$rowuser[sfzrz]){echo "<strong class='blue'>已提交资料，正在审核认证，请耐心等待</strong>";}
elseif(1==$rowuser[sfzrz]){echo "<strong class='green'>已经通过实名认证</strong>";}
elseif(2==$rowuser[sfzrz]){echo "<strong class='red'>认证被拒，原因：".$rowuser[sfzrzsm]."</strong>";}
elseif(3==$rowuser[sfzrz]){echo "<strong>未提交认证资料</strong>";}
?></div></div>
<div class="uk box"><div class="d1">真实姓名<span class="s1"></span></div><div class="d21"><?=$rowuser[uname]?></div></div>
<div class="uk box"><div class="d1">身份证号<span class="s1"></span></div><div class="d21"><?=$rowuser[sfz]?></div></div>

<? if(2==$rowuser[sfzrz] || 3==$rowuser[sfzrz]){?>
<form name="f1" action="smrz1.php">
<div class="fbbtn box">
 <div class="d1"><? tjbtnr_m("开始认证")?></div>
</div>
</form>
<? }?>

<? if(is_file($sfz1)){?>
<div class="listcap box"><div class="d2">身份证正面：</div></div>
<div class="tishi box">
<div class="d1"><a href="<?=$sfz1?>" target="_blank"><img border="0" src="<?=$sfz1?>" width="170" height="100" /></a></div>
</div>
<? }?>

<? if(is_file($sfz2)){?>
<div class="listcap box"><div class="d2">身份证反面：</div></div>
<div class="tishi box">
<div class="d1"><a href="<?=$sfz2?>" target="_blank"><img border="0" src="<?=$sfz2?>" width="170" height="100" /></a></div>
</div>
<? }?>

<? if(is_file($sfz3)){?>
<div class="listcap box"><div class="d2">手持身份证照片：</div></div>
<div class="tishi box">
<div class="d1"><a href="<?=$sfz3?>" target="_blank"><img border="0" src="<?=$sfz3?>" width="170" height="100" /></a></div>
</div>
<? }?>


<? include("bottom.php");?>
<script language="javascript">
bottomjd(4);
</script>
</body>
</html>