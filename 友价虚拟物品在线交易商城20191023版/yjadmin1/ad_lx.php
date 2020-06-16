<?
include("../config/conn.php");
include("../config/function.php");
AdminSes_audit();

if(!strstr($adminqx,",0,") && !strstr($adminqx,",0601,")){Audit_alert("È¨ÏÞ²»¹»","default.php");}
$sj=date("Y-m-d H:i:s");
$mbh=returnbh();
$adbh=$_GET[bh];
$nxh=returnxh("yjcode_ad"," and adbh='".$adbh."' and zt<>99");
intotable("yjcode_ad","bh,adbh,sj,xh,zt,aw,ah","'".$mbh."','".$adbh."','".$sj."',".$nxh.",99,0,0");
php_toheader("ad.php?bh=".$mbh."&sm=".urlencode($_GET[sm])."&must=".$_GET[must]);
?>
