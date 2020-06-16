<?
include("../config/conn.php");
include("../config/function.php");
AdminSes_audit();

if(!strstr($adminqx,",0,") && !strstr($adminqx,",0301,")){Audit_alert("È¨ÏÞ²»¹»","default.php");}
$sj=date("Y-m-d H:i:s");
$bh=returnbh();
$nxh=returnxh("yjcode_jubaotype"," and zt<>99");
deletetable("yjcode_jubaotype where zt=99");
intotable("yjcode_jubaotype","bh,sj,xh,admin,zt","'".$bh."','".$sj."',".$nxh.",1,99");
php_toheader("jubaotype.php?bh=".$bh);
?>
