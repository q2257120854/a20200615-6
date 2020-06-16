<?php
include("../config/conn.php");
include("../config/function.php");
AdminSes_audit();
$sj=date("Y-m-d H:i:s");
$bh=$_GET[bh];
while0("*","yjcode_pro where bh='".$bh."'");if(!$row=mysql_fetch_array($res)){php_toheader("productlist.php");}

if(!strstr($adminqx,",0,") && !strstr($adminqx,",0101,")){Audit_alert("È¨ÏÞ²»¹»","default.php");}
$nxh=returnxh("yjcode_taocan"," and admin is null and probh='".$bh."' and zt<>99");
intotable("yjcode_taocan","xh,probh,userid,zt","".$nxh.",'".$bh."',".$row[userid].",99");
$id=mysql_insert_id();
php_toheader("taocan.php?bh=".$bh."&id=".$id);

?>
