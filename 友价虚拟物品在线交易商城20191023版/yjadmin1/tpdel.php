<?
include("../config/conn.php");
include("../config/function.php");
AdminSes_audit();
while1("*","yjcode_tp where id=".$_GET[id]);if($row1=mysql_fetch_array($res1)){
 if(!empty($row1[tp])){
  delFile("../".str_replace(".","-1.",$row1[tp]));
  delFile("../".$row1[tp]);
 }
 deletetable("yjcode_tp where id=".$_GET[id]);
}
?>
