<?
include("../../config/conn.php");
include("../../config/function.php");

$admin=intval($_GET[admin]);
$sqluser="select * from yjcode_user where uid='".$_SESSION[SHOPUSER]."'";mysql_query("SET NAMES 'GBK'");$resuser=mysql_query($sqluser);
if(!$rowuser=mysql_fetch_array($resuser)){Audit_alert("登录超时","../reg/","parent.");}
$userid=$rowuser[id];

if($admin==6){
$id=$_GET[id];
if(!is_numeric($id)){exit;}
while1("*","yjcode_tp where userid=".$userid." and id=".$id);if($row1=mysql_fetch_array($res1)){
 if(!empty($row1[tp])){
  delFile("../../".str_replace(".","-1.",$row1[tp]));
  delFile("../../".str_replace(".","-2.",$row1[tp]));
  delFile("../../".$row1[tp]);
 }
 deletetable("yjcode_tp where id=".$id);
}

}elseif($admin==7){
$id=$_GET[id];
if(!is_numeric($id)){exit;}
while1("*","yjcode_tp where userid=".$userid." and id=".$id);if($row1=mysql_fetch_array($res1)){
 if(!empty($row1[tp])){
  delFile("../../".str_replace(".","-1.",$row1[tp]));
  delFile("../../".$row1[tp]);
 }
 deletetable("yjcode_tp where id=".$id);
}
	
}
?>
