<?
include("../config/conn.php");
include("../config/function.php");
sesCheck();

$userid=returnuserid($_SESSION[SHOPUSER]);
$sj=date("Y-m-d H:i:s");
$bh=time()."p".$userid;
deletetable("yjcode_protype where userid=".$userid." and zt=99");
$nxh=returnxh("yjcode_protype"," and userid=".$userid." and admin=1 and zt=0");
intotable("yjcode_protype","bh,userid,admin,xh,sj,zt","'".$bh."',".$userid.",1,".$nxh.",'".$sj."',99");
php_toheader("protype1.php?bh=".$bh);
?>
