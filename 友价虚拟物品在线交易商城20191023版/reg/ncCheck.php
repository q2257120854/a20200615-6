<?
include("../config/conn.php");
include("../config/function.php");
$nc=$_GET["nc"];
if(empty($nc)){echo "True";exit;}
if(panduan("*","yjcode_user where nc='".$nc."'")==1){echo "True";}else{echo "False";exit;}
?>