<?
include("../../../config/conn.php");
include("../../../config/function.php");
$ddbh=$_GET[ddbh];
if(panduan("ddbh,ifok","yjcode_dingdang where ddbh='".$ddbh."' and ifok=1")==1){echo "ok";exit;}else{echo "err";exit;}
?>