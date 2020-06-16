<?
include("../../config/conn.php");
include("../../config/function.php");
sesCheck_m();
$userid=returnuserid($_SESSION["SHOPUSER"]);
while0("id,userid,orderbh,ddzt","yjcode_order where userid=".$userid." and (ddzt='wait' or ddzt='db' or ddzt='suc') order by id desc");if($row=mysql_fetch_array($res)){php_toheader("orderview.php?orderbh=".$row[orderbh]);}else{php_toheader("order.php");}
?>
