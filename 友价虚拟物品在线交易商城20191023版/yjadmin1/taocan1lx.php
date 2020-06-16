<?php
include("../config/conn.php");
include("../config/function.php");
AdminSes_audit();
$sj=date("Y-m-d H:i:s");
$bh=$_GET[bh];
$ty1id=$_GET[ty1id];
while0("*","yjcode_pro where bh='".$bh."'");if(!$row=mysql_fetch_array($res)){php_toheader("productlist.php");}

if(!strstr($adminqx,",0,") && !strstr($adminqx,",0101,")){Audit_alert("È¨ÏÞ²»¹»","default.php");}
while1("*","yjcode_taocan where id=".$ty1id);if(!$row1=mysql_fetch_array($res1)){php_toheader("productlist.php");}
$nxh=returnxh("yjcode_taocan"," and admin=2 and tit='".$row1[tit]."' and probh='".$bh."'");
intotable("yjcode_taocan","tit,xh,admin,probh,userid,zt","'".$row1[tit]."',".$nxh.",2,'".$bh."',".$row[userid].",99");
$id=mysql_insert_id();
php_toheader("taocan1.php?ty1id=".$_GET[ty1id]."&bh=".$bh."&id=".$id);
?>
