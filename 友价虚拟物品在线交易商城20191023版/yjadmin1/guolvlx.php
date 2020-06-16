<?
include("../config/conn.php");
include("../config/function.php");
AdminSes_audit();

if(!strstr($adminqx,",0,") && !strstr($adminqx,",0701,")){Audit_alert("È¨ÏÞ²»¹»","default.php");}
$sj=date("Y-m-d H:i:s");
$admin=intval($_GET[admin]);
if(empty($admin)){$admin=1;}
deletetable("yjcode_guolv where zt=99");
$bh=returnbh();
intotable("yjcode_guolv","bh,admin,sj,zt","'".$bh."',".$admin.",'".$sj."',99");
php_toheader("guolv.php?bh=".$bh);
?>
