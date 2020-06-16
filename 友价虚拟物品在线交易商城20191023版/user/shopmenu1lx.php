<?
include("../config/conn.php");
include("../config/function.php");
sesCheck();

$userid=returnuserid($_SESSION[SHOPUSER]);
$sj=date("Y-m-d H:i:s");
$bh=time()."m".$userid;
deletetable("yjcode_shopmenu where userid=".$userid." and zt=99");
$nxh=returnxh("yjcode_shopmenu"," and userid=".$userid." and admin=1 and zt=0");
intotable("yjcode_shopmenu","bh,userid,aurl,targ,admin,xh,sj,zt","'".$bh."',".$userid.",'http://',1,1,".$nxh.",'".$sj."',99");
php_toheader("shopmenu1.php?bh=".$bh);
?>
