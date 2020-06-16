<?
header('Content-type: text/html; charset=gbk');
include("../../config/conn.php");
include("../../config/function.php");
$userid=returnuserid($_SESSION[SHOPUSER]);
$id=intval($_GET[id]);
if(empty($id)){echo "err";exit;}
deletetable("yjcode_shopfav where id=".$id." and userid=".$userid);echo "ok";exit;
?>
