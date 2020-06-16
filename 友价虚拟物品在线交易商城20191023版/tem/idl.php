<?
header("Content-Type:text/html;charset=GB2312");
session_start();
include("../config/conn.php");
include("../config/function.php");
$t1=$_GET[t1];
$t2=$_GET[t2];
if(empty($t1) && empty($t2)){
 if(empty($_SESSION[SHOPUSER])){echo "err2";exit;}
 $ses="uid='".$_SESSION[SHOPUSER]."'";
}else{
 $ses="uid='".$t1."' and pwd='".sha1($t2)."'";
}
while1("*","yjcode_user where ".$ses);if(!$row1=mysql_fetch_array($res1)){echo "err1";exit;}
$_SESSION[SHOPUSER]=$row1[uid];
$_SESSION["SHOPUSERPWD"]=$row1[pwd];
$money1=$row1[money1]; //可用金额
$jf=$row1[jf]; //可用积分
$djmoney=$row1[djmoney]; //冻结金额
$moneya=$money1+$djmoney;
// 1账号2总额3冻结金额4可用余额5积分6头像
$tx="../upload/".$row1[id]."/user.jpg";if(!is_file($tx)){$tx="../user/img/nonetx.gif";}
echo "ok|".$row1[uid]."|".sprintf("%.2f",$moneya)."|".sprintf("%.2f",$djmoney)."|".sprintf("%.2f",$money1)."|".$jf."|".$tx;
?>