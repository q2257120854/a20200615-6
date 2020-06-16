<?
include("../config/conn.php");
include("../config/function.php");
$uid=$_GET["uid"];
if(empty($uid)){echo "True";exit;}
if(panduan("*","yjcode_user where uid='".$uid."'")==1){echo "True";}else{
 include("../tem/uc/usercheck.php");
 echo "False";exit;
}
?>