<?
header('Content-type: text/html; charset=gbk');
include("../../config/conn.php");
include("../../config/function.php");
$userid=returnuserid($_SESSION[SHOPUSER]);
$ty=$_GET[ty];
if($ty=="one"){
 $id=intval($_GET[id]);
 if(empty($id)){echo "err";exit;}
 deletetable("yjcode_car where id=".$id." and userid=".$userid);echo "ok";exit;
}elseif($ty=="all"){
 deletetable("yjcode_car where userid=".$userid);echo "ok";exit;
}
?>
