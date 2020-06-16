<?
header('Content-type: text/html; charset=gbk');
include("../../config/conn.php");
include("../../config/function.php");
$bzv=iconv('utf-8', 'gbk',sqlzhuru($_POST[bzv]));
$cid=intval($_POST[cid]);
if(empty($cid)){echo "err";exit;}
$userid=returnuserid($_SESSION[SHOPUSER]);
updatetable("yjcode_car","bz='".$bzv."' where id=".$cid." and userid=".$userid);echo "ok";exit;
?>
