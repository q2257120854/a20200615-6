<?
include("../config/conn.php");
include("../config/function.php");

if(sqlzhuru($_POST[jvs])=="getpwd"){
 zwzr();
 $uid=sqlzhuru($_POST[t0]);
 $m=sqlzhuru($_POST[t1]);
 if(strtolower($_SESSION["authnum_session"])!=strtolower(sqlzhuru($_POST[t2]))){Audit_alert("验证码有误！","getpasswd.php");}
 while0("id,uid,email","yjcode_user where email='".$m."' and uid='".$uid."'");if(!$row=mysql_fetch_array($res)){Audit_alert("帐号与邮箱不匹配！","getpasswd.php");}

 //SMSMAIL入库
 if(!empty($rowcontrol[mailstr]) && $rowcontrol[mailstr]!=",,,"){
  $rnd=MakePass(6);
  updatetable("yjcode_user","getpwd='".$rnd."' where id=".$row[id]);
  $str=weburl."reg/repwd.php?id=".$row[id]."&chk=".sha1($row[id].weburl)."&tmp=".$rnd;
  $txt="尊敬的用户您好：<br><br>您在".webname."(".weburl.")请求发送密码重设邮件！(如果不是您本人操作，请不用理会该邮件)<br><br>请点击如下链接进行密码重设（如果不能点击，请复制到网址栏打开）<br><br><a href=\"".$str."\">".$str."</a><br><hr><br><br>重设密码后请牢记您的新密码！<br><br>感谢您使用".webname."!";
  require("../config/mailphp/sendmail.php");
  yjsendmail("找回密码【".webname."】",$m,$txt);
  php_toheader("getpasswd.php?t=suc&m=".$m);
 }else{Audit_alert("网站没有启动邮箱投递功能，请联系客服处理","getpasswd.php");}
 //SMSMAIL入库
 
 exit;
}
?>
<html>
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>找回密码 - <?=webname?></title>
<? include("../tem/cssjs.html");?>
</head>
<body>
<? include("../tem/top.html");?>
<? include("../tem/top1.html");?>

<div class="yjcode">

 <div class="getpassword">
  <ul class="u1">
  <li class="l1">通过邮箱找回密码</li>
  <li class="l2"><a href="getmm.php" class="feng">选择其他方式找回</a></li>
  </ul>
 </div>
 
 <div class="getpwdmain">
  <? if($_GET[t]=="suc"){?><div class="sucts">您好，已向您的邮箱<?=$_GET[m]?>发送一封找回密码的邮件，请登录邮箱查看</div><? }?>
  <form name="f1" method="post" onSubmit="return getpwdtj()">
  
  <ul class="u1">
  <li class="l1">登录帐号：</li>
  <li class="l2"><input name="t0" class="inp" type="text" style="width:204px;" /></li>
  <li class="l3">
  <span id="ts1">请输入登录帐号</span>
  </li>
  </ul>
  
  <ul class="u1">
  <li class="l1">Email邮箱：</li>
  <li class="l2"><input name="t1" class="inp" type="text" style="width:204px;" /></li>
  <li class="l3">
  <span id="ts1">请输入邮箱</span>
  </li>
  </ul>
    
  <ul class="u1">
  <li class="l1">验证码：</li>
  <li class="l4"><input name="t2" class="inp" type="text" style="width:94px;" /></li>
  <li class="l5"><img src="../config/getYZM.php" width="88" height="28" /></li>
  <li class="l3">
  <span id="ts6">验证码不区分大小写</span>
  </li>
  </ul>
  
  <ul class="u1">
  <li class="l1"></li>
  <li class="l2"><? tjbtnr("下一步");?></li>
  <li class="l3"></li>
  </ul>
  
  <input type="hidden" value="getpwd" name="jvs" />
  </form>
 </div>

</div>

<? include("../tem/bottom.html");?>
</body>
</html>