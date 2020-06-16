<?
session_start();
$yzm=$_POST["yzm"];
if(empty($yzm)){echo "True";exit;}
if(strtolower($_SESSION["REGMOTYZ"])!=strtolower($yzm)){echo "True";exit;}
echo "False";
?>