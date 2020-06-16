<?
include("../../config/conn.php");
include("../../config/function.php");
sesCheck_m();

if(sqlzhuru($_POST[jvs])=="inf"){
 zwzr();
 $nc=sqlzhuru($_POST[tnc]);
 if(empty($nc)){Audit_alert("请输入昵称","inf.php");}
 updatetable("yjcode_user","uqq='".sqlzhuru($_POST[tuqq])."',weixin='".sqlzhuru($_POST[tweixin])."' where uid='".$_SESSION[SHOPUSER]."'");
 if(panduan("uid,nc","yjcode_user where uid<>'".$_SESSION[SHOPUSER]."' and nc='".$nc."'")){Audit_alert("该昵称已被其他用户使用","inf.php");}
 updatetable("yjcode_user","nc='".$nc."' where uid='".$_SESSION[SHOPUSER]."'");
 php_toheader("../tishi/index.php?admin=3"); 
}

$sqluser="select * from yjcode_user where uid='".$_SESSION[SHOPUSER]."'";mysql_query("SET NAMES 'GBK'");$resuser=mysql_query($sqluser);
if(!$rowuser=mysql_fetch_array($resuser)){php_toheader("../reg/");}

?>
<html>
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
<title>会员中心 <?=webname?></title>
<? include("../tem/cssjs.html");?>
<link href="css/buy.css" rel="stylesheet" type="text/css" />
<script language="javascript">
function tj(){
 if((document.f1.tnc.value).replace("/\s/","")==""){layerts("请输入昵称");return false;}
 layer.open({type: 2,content: '正在提交',shadeClose:false});
 f1.action="inf.php";
}
</script>
</head>
<body>
<? include("topuser.php");?>

<div class="bfbtop1 box">
 <div class="d1" onClick="gourl('shezhi.php')"><img src="img/topleft.png" height="21" /></div>
 <div class="d2">基本资料</div>
 <div class="d3"></div>
</div>

<form name="f1" method="post" onSubmit="return tj()">
<input type="hidden" value="inf" name="jvs" />
<div class="uk box">
 <div class="d1">您的昵称<span class="s1"></span></div>
 <div class="d2"><input type="text" name="tnc" value="<?=$rowuser[nc]?>" class="inp" placeholder="请输入您的昵称" /></div>
</div>
<div class="uk box">
 <div class="d1">QQ号码<span class="s1"></span></div>
 <div class="d2"><input type="text" name="tuqq" value="<?=$rowuser[uqq]?>" class="inp" placeholder="请输入您的常用QQ号码" /></div>
</div>
<div class="uk box">
 <div class="d1">微信号码<span class="s1"></span></div>
 <div class="d2"><input type="text" name="tweixin" value="<?=$rowuser[weixin]?>" class="inp" placeholder="请输入您的微信号码" /></div>
</div>

<div class="fbbtn box">
 <div class="d1"><? tjbtnr_m("保存")?></div>
</div>

</form>

</body>
</html>