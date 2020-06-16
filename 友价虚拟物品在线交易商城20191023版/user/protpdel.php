<?
include("../config/conn.php");
include("../config/function.php");
$userid=returnuserid($_SESSION[SHOPUSER]);
$id=intval($_GET[id]);
if(!is_numeric($id)){exit;}
while1("*","yjcode_tp where userid=".$userid." and id=".$id);if($row1=mysql_fetch_array($res1)){
 if(!empty($row1[tp])){
  delFile("../".str_replace(".","-1.",$row1[tp]));
  delFile("../".str_replace(".","-2.",$row1[tp]));
  delFile("../".$row1[tp]);
 }
 deletetable("yjcode_tp where id=".$id);
}
?>
