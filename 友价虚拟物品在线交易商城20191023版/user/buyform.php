<?
header('Content-type: text/html; charset=gbk');
include("../config/conn.php");
include("../config/function.php");
$bv=iconv('utf-8', 'gbk',sqlzhuru($_POST[bv]));
$cid=intval($_POST[cid]);
if(empty($bv) || empty($cid)){echo "err";exit;}
$userid=returnuserid($_SESSION[SHOPUSER]);
$bvarr=preg_split("/yj99yjcode/",$bv);
$c=preg_split("/c/",$cid);
for($i=0;$i<count($c);$i++){
$d=preg_split("/-/",$c[$i]);
if(!empty($d[0])){
updatetable("yjcode_car","buyform='".$bvarr[$i]."' where id=".$d[0]." and userid=".$userid);echo "ok";exit;
}
}
?>
