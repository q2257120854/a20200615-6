<?
include("../config/conn.php");
include("../config/function.php");
$id=intval($_GET[id]);
$_SESSION["tzURL"]=weburl."product/view".$id.".html";
$sqlmb="select * from yjcode_pro where zt<>99 and id=".$id;mysql_query("SET NAMES 'GBK'");$resmb=mysql_query($sqlmb);
if(!$rowmb=mysql_fetch_array($resmb)){php_toheader("../");}
if(empty($rowmb[txtmb])){include("viewmb.php");}
else{include($rowmb[txtmb]."/viewmb.php");}
?>
