<?
include("../../config/conn.php");
include("../../config/function.php");
sesCheck_m();
$userid=returnuserid($_SESSION[SHOPUSER]);
while1("id,bh,userid,zt","yjcode_shdz where userid=".$userid." and zt=99");if($row1=mysql_fetch_array($res1)){
$bh=$row1[bh];
}else{
$sj=date("Y-m-d H:i:s");
$bh=time()."s".$userid;
intotable("yjcode_shdz","bh,userid,sj,zt","'".$bh."',".$userid.",'".$sj."',99");
}
php_toheader("shdz.php?bh=".$bh);
?>
