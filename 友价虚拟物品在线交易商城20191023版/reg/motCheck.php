<?
include("../config/conn.php");
include("../config/function.php");
$mot=$_POST["mot"];
if(empty($mot)){echo "True";exit;}
if(panduan("*","yjcode_user where mot='".$mot."' and ifmot=1")==1){echo "True";}else{echo "False";exit;}
?>