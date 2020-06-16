<?
include("../config/conn.php");
include("../config/function.php");
AdminSes_audit();

if(!strstr($adminqx,",0,") && !strstr($adminqx,",0301,")){Audit_alert("È¨ÏÞ²»¹»","default.php");}
$sj=date("Y-m-d H:i:s");
$bh=time()."d".rnd_num(100);
$xh=returnxh("yjcode_userdj"," and zt=0");
intotable("yjcode_userdj","bh,xh,sj,zt","'".$bh."',".$xh.",'".$sj."',99");
php_toheader("userdj.php?bh=".$bh);
?>
