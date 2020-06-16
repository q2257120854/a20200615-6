<?
include("../../config/conn.php");
include("../../config/function.php");
sesCheck_m();

//入库操作开始
if($_POST[jvs]=="password"){
 zwzr();
 $pwd=sha1(sqlzhuru($_POST[t1]));
 $pwd1=sha1(sqlzhuru($_POST[t2]));
 $pwd2=sqlzhuru($_POST[t2]);
 $uid=$_SESSION[SHOPUSER];
 if(panduan("*","yjcode_user where uid='".$uid."' and pwd='".$pwd."'")==0){Audit_alert("原密码验证失败，返回重试！","pwd.php");}
 updatetable("yjcode_user","pwd='".$pwd1."' where uid='".$_SESSION[SHOPUSER]."'");
 $WAPLJ=1;
 include("../../tem/uc/pwd.php");
 $_SESSION["SHOPUSERPWD"]=$pwd1;
 php_toheader("../tishi/index.php?admin=1");
}
//入库操作结束

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
 v=document.f1.t1.value;if(v.length == 0 || v.indexOf(" ")>=0){layerts("请输入旧密码");return false;}	
 v=document.f1.t2.value;if(v.length == 0 || v.indexOf(" ")>=0){layerts("请输入新密码");return false;}	
 if(document.f1.t2.value!=document.f1.t3.value){layerts("两次输入的新密码不一致");return false;}	
 layer.open({type: 2,content: '正在提交',shadeClose:false});
 f1.action="pwd.php";
}
</script>
</head>
<body>
<? include("topuser.php");?>

<div class="bfbtop1 box">
 <div class="d1" onClick="gourl('./')"><img src="img/topleft.png" height="21" /></div>
 <div class="d2">修改密码</div>
 <div class="d3"></div>
</div>

<form name="f1" method="post" onSubmit="return tj()">
<input type="hidden" value="password" name="jvs" />
<div class="uk box">
 <div class="d1">原 密 码<span class="s1"></span></div>
 <div class="d2"><input type="password" name="t1" class="inp" placeholder="请输入您的原密码" /></div>
</div>
<div class="uk box">
 <div class="d1">新 密 码<span class="s1"></span></div>
 <div class="d2"><input type="password" name="t2" class="inp" placeholder="请输入您的新密码" /></div>
</div>
<div class="uk box">
 <div class="d1">重复密码<span class="s1"></span></div>
 <div class="d2"><input type="password" name="t3" class="inp" placeholder="请重复您的密码" /></div>
</div>

<div class="fbbtn box">
 <div class="d1"><? tjbtnr_m("修改密码")?></div>
</div>

</form>
</body>
</html>