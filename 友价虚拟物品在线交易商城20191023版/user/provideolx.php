<?
include("../config/conn.php");
include("../config/function.php");
sesCheck();

$userid=returnuserid($_SESSION[SHOPUSER]);
$bh=$_GET[bh];
while0("*","yjcode_pro where bh='".$bh."' and userid=".$userid."");if(!$row=mysql_fetch_array($res)){php_toheader("productlist.php");}
deletetable("yjcode_provideo where probh='".$bh."' and zt=99 and userid=".$userid."");

$mbh=time()."v".$row[userid];
$sj=date("Y-m-d H:i:s");
intotable("yjcode_provideo","userid,probh,sj,djl,bh,iftj,zt","".$row[userid].",'".$bh."','".$sj."',1,'".$mbh."',0,99");

php_toheader("provideo.php?mybh=".$mbh."&bh=".$bh);
?>
