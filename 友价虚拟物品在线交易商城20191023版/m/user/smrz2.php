<?
include("../../config/conn.php");
include("../../config/function.php");
sesCheck_m();
$sqluser="select * from yjcode_user where uid='".$_SESSION[SHOPUSER]."'";mysql_query("SET NAMES 'GBK'");$resuser=mysql_query($sqluser);
$rowuser=mysql_fetch_array($resuser);if($rowuser[sfzrz]!=2 && $rowuser[sfzrz]!=3){php_toheader("smrz.php"); }

if($_POST[jvs]=="smrz"){
 zwzr();
 if(panduan("uid,sfzrz","yjcode_user where uid='".$_SESSION[SHOPUSER]."' and (sfzrz=2 or sfzrz=3)")==0){Audit_alert("错误的请求！","smrz.php");}
 updatetable("yjcode_user","sfzrz=0 where id=".$rowuser[id]);
 php_toheader("smrz.php?t=suc"); 
}

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
 if(!confirm("确定要提交认证吗？")){return false;}
 layer.open({type: 2,content: '正在提交',shadeClose:false});
 f1.action="smrz2.php";
}
</script>
</head>
<body>
<? include("topuser.php");?>

<div class="bfbtop1 box">
 <div class="d1" onClick="javascript:window.history.go(-1);"><img src="img/topleft.png" height="21" /></div>
 <div class="d2">实名认证</div>
 <div class="d3"></div>
</div>

<div class="tishi box">
<div class="d1">
认证步骤：<br>
一、填写真实姓名和身份证号码<br>
<strong class="blue">二、上传身份证和手持身份证照片</strong><br>
</div>
</div>

<form name="f1" method="post" onSubmit="return tj()" enctype="multipart/form-data">
<input type="hidden" value="smrz" name="jvs" />

<div class="uk box">
 <div class="d1">证件正面<span class="s1"></span></div>
 <div class="d2"><iframe style="float:left;" src="tpupload.php?admin=7" width="103" scrolling="no" height="113" frameborder="0"></iframe></div>
</div>

<div class="uk box">
 <div class="d1">证件反面<span class="s1"></span></div>
 <div class="d2"><iframe style="float:left;" src="tpupload.php?admin=8" width="103" scrolling="no" height="113" frameborder="0"></iframe></div>
</div>

<div class="uk box">
 <div class="d1">手持照片<span class="s1"></span></div>
 <div class="d2"><iframe style="float:left;" src="tpupload.php?admin=9" width="103" scrolling="no" height="113" frameborder="0"></iframe></div>
</div>

<div class="fbbtn box">
 <div class="d1"><? tjbtnr_m("提交认证")?></div>
</div>

</form>

<? include("bottom.php");?>
</body>
</html>