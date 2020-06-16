<?
//获取总运费
include("../config/conn.php");
include("../config/function.php");
$u=$_GET["u"];$s=$_GET["s"];$sl=$_GET["sl"];$p=$_GET["p"];
echo returnyunfei($u,$s,$sl,$p);
?>