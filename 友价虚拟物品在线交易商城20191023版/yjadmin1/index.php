<?php
include("../config/conn.php");
include("../config/function.php");
if($_SESSION["SHOPADMIN"]!="" && $_SESSION["SHOPADMINPWD"]!=""){php_toheader("default.php");}
//函数开始
if($_GET[a]=="login"){
 if(strtolower($_SESSION["authnum_session"])!=strtolower(sqlzhuru($_POST[t3]))){Audit_alert("验证码有误！","index.php");}
 zwzr();
 while0("*","yjcode_admin where adminuid='".sqlzhuru($_POST[t1])."' and adminpwd='".sha1(sqlzhuru($_POST[t2]))."'");if($row=mysql_fetch_array($res)){
 $sj=date("Y-m-d H:i:s");
 $uip=$_SERVER["REMOTE_ADDR"];
 intotable("yjcode_loginlog","admin,userid,sj,uip","2,".$row[id].",'".$sj."','".$uip."'");
 $_SESSION["SHOPADMIN"]=sqlzhuru($_POST[t1]);
 $_SESSION["SHOPADMINPWD"]=$row[adminpwd];
 php_toheader("default.php");
 }else{
 Audit_alert("身份验证有误，返回重试！","index.php");
 }
}
//函数结束
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><?=webname?>管理员系统</title>
<link href="css/basic.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script language="javascript" src="js/basic.js"></script>
<script language="javascript" src="js/layer.js"></script>
<script language="javascript">
function login(){
if((document.f1.t1.value).replace(/\s/,"")==""){alert("请输入登录帐号!");document.f1.t1.focus();return false;}	
if((document.f1.t2.value).replace(/\s/,"")==""){alert("请输入登录密码!");document.f1.t2.focus();return false;}	
if((document.f1.t3.value).replace(/\s/,"")==""){alert("请输入验证码 !");document.f1.t3.focus();return false;}	
f1.action="index.php?a=login";
}
</script>
</head>
<body>
<div class="main">
 <div class="lmain">
  <form name="f1" method="post" onsubmit="return login()">
  <ul class="u1">
  <li class="l1">输入您的登录信息</li>
  <li class="l2">登录帐号：</li>
  <li class="l3"><input class="inp1" type="text" onblur="this.className='inp1';" onfocus="this.className='inp1 inp2';" name="t1" /></li>
  <li class="l2">管理密码：</li>
  <li class="l3"><input class="inp1" type="password" onblur="this.className='inp1';" onfocus="this.className='inp1 inp2';" name="t2" /></li>
  <li class="l2">验 证 码：</li>
  <li class="l31">
  <input class="inp1" type="text" onblur="this.className='inp1';" onfocus="this.className='inp1 inp2';" name="t3" />
  <img src="../config/getYZM.php" onclick="this.src='../config/getYZM.php'" width="88" />
  </li>
  <li class="l5"><input type="image" src="img/loginbtn.gif" width="101" height="32" /></li>
  <li class="l4"></li>
  </ul>
  </form>
  <ul class="u2">
  <li class="l1"><img src="img/close.gif" width="19" height="19" style="cursor:pointer;" onclick="javascript:window.close();" /></li>
  <li class="l2"><a href="../" target="_blank"><?=webname?></a><br><?=$rowcontrol[webtj]?></li>
  <li class="l3"></li>
  </ul>
 </div>
</div>
</body>
</html>