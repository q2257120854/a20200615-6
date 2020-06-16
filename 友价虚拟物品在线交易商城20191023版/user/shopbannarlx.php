<?
include("../config/conn.php");
include("../config/function.php");
sesCheck();

$userid=returnuserid($_SESSION[SHOPUSER]);
$sj=date("Y-m-d H:i:s");
$bh=time()."b".$userid;
deletetable("yjcode_shopbannar where userid=".$userid." and zt=99");
$nxh=returnxh("yjcode_shopbannar"," and userid=".$userid." and zt=0");
intotable("yjcode_shopbannar","bh,userid,aurl,targ,xh,sj,zt","'".$bh."',".$userid.",'http://',1,".$nxh.",'".$sj."',99");
php_toheader("shopbannar.php?bh=".$bh);
?>
