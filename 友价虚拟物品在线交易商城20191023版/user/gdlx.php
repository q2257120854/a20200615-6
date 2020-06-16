<?
include("../config/conn.php");
include("../config/function.php");
sesCheck();
$userid=returnuserid($_SESSION[SHOPUSER]);
$sj=date("Y-m-d H:i:s");
$uip=$_SERVER["REMOTE_ADDR"];
$bh=time()."-".$userid;
intotable("yjcode_gd","bh,userid,sj,uip,zt,gdzt","'".$bh."',".$userid.",'".$sj."','".$uip."',99,1");
php_toheader("gd.php?bh=".$bh); 
?>
