<?
include("../config/conn.php");
include("../config/function.php");
AdminSes_audit();

if(!strstr($adminqx,",0,") && !strstr($adminqx,",0301,")){Audit_alert("È¨ÏÞ²»¹»","default.php");}
$sj=date("Y-m-d H:i:s");
$bh=time();
$nxh=returnxh("yjcode_kuaidi"," and zt<>99");
deletetable("yjcode_kuaidi where zt=99");
intotable("yjcode_kuaidi","xh,sj,zt,bh","".$nxh.",'".$sj."',99,'".$bh."'");

php_toheader("kuaidi.php?bh=".$bh);
?>
