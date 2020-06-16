<?
include("config/conn.php");
include("config/function.php");
$mb=$rowcontrol[nowmb];
if(empty($mb)){$mb="default";}
echo htmlget(weburl."tem/moban/".$mb."/indextemplate.php");
?>