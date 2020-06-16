<?
include("../config/conn.php");
include("../config/function.php");
sesCheck();
$ddbh=$_GET[ddbh];
?>
<iframe name="wxpay_f" id="wxpay_f" marginwidth="1" marginheight="1" frameborder="0" height="100%" width="100%" border="0" src="wxpay/example/buy_native.php?m=yes&ddbh=<?=$ddbh?>"></iframe>
