<?
include("../config/conn.php");
include("../config/function.php");
if(empty($_SESSION["SHOPUSER"])){echo "ok";exit;}
while1("uid,email,ifemail","yjcode_user where uid='".$_SESSION[SHOPUSER]."' and ifemail=1");if(!$row1=mysql_fetch_array($res1)){echo "ok";exit;}

require("../config/mailphp/sendmail.php");
$yz=MakePass(6);
$str="邮箱解除绑定，验证码：<font color='red' style='font-size:18px;'>".$yz."</font>,您正在进行邮箱解除绑定操作，如果不是本人操作，请忽略此信息。【".webname."】<hr>该邮件为系统发出，请勿回复";
yjsendmail("邮箱解除绑定【".webname."】",$row1["email"],$str);

updatetable("yjcode_user","bdemail='".$yz."' where uid='".$_SESSION[SHOPUSER]."'");echo "ok";exit;

?>