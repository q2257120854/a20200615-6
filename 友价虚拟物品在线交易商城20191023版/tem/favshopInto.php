<?
include("../config/conn.php");
include("../config/function.php");
$id=$_GET[id];
if(empty($_SESSION["SHOPUSER"])){echo "err1";exit;}
$userid=returnuserid($_SESSION["SHOPUSER"]);
if($userid==$id){echo "err2";exit;}
if(panduan("shopid,userid","yjcode_shopfav where shopid=".$id." and userid=".$userid)==1){echo "ok";exit;}
$sj=date("Y-m-d H:i:s");
intotable("yjcode_shopfav","shopid,userid,sj","".$id.",".$userid.",'".$sj."'");
echo "ok";exit;
?>
