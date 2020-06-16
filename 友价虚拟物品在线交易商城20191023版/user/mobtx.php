<?
include("../config/conn.php");
include("../config/function.php");
while1("uid,email,ifemail","yjcode_user where uid='".$_SESSION[SHOPUSER]."'");$row1=mysql_fetch_array($res1);
if(empty($row1[email]) || $row1[ifemail]==0){echo "err";exit;}

require("../config/mailphp/sendmail.php");
$yz=MakePass(6);
$str="验证码：<font color='red' style='font-size:18px;'>".$yz."</font>,如果不是本人操作，请忽略此信息。【".webname."】<hr>该邮件为系统发出，请勿回复";
yjsendmail("安全码修改【".webname."】",$row1[email],$str);
updatetable("yjcode_user","getpwd='".$yz."' where uid='".$_SESSION[SHOPUSER]."'");
?>