<?
include("../config/conn.php");
include("../config/function.php");
AdminSes_audit();

if(!strstr($adminqx,",0,") && !strstr($adminqx,",0301,")){Audit_alert("È¨ÏÞ²»¹»","default.php");}
$sj=date("Y-m-d H:i:s");
$bh=time()."a".rnd_num(100);
intotable("yjcode_adlx","bh,maxnum,adw,adh,fflx,admin,sj,zt","'".$bh."',0,0,0,1,1,'".$sj."',99");

php_toheader("adlx.php?bh=".$bh);
?>
