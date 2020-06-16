<?
include("../config/conn.php");
include("../config/function.php");
AdminSes_audit();

if(!strstr($adminqx,",0,") && !strstr($adminqx,",0101,")){Audit_alert("È¨ÏÞ²»¹»","default.php");}
$bh=$_GET[bh];
while0("*","yjcode_pro where bh='".$bh."'");if(!$row=mysql_fetch_array($res)){php_toheader("productlist.php");}
deletetable("yjcode_provideo where probh='".$bh."' and zt=99");

$mbh=time()."v".$row[userid];
$sj=date("Y-m-d H:i:s");
intotable("yjcode_provideo","userid,probh,sj,djl,bh,iftj,zt","".$row[userid].",'".$bh."','".$sj."',1,'".$mbh."',0,99");

php_toheader("provideo.php?mybh=".$mbh."&bh=".$bh);
?>
