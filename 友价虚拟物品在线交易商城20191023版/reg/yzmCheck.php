<?
session_start();
$yzm=$_POST["yzm"];
if(empty($yzm)){echo "True";exit;}
if(strtolower($_SESSION["authnum_session"])!=strtolower($yzm)){echo "True";exit;}
echo "False";
?>