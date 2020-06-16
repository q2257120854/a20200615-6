<?
include("../config/conn.php");
include("../config/function.php");
AdminSes_audit();

if(!strstr($adminqx,",0,") && !strstr($adminqx,",0201,")){Audit_alert("È¨ÏÞ²»¹»","default.php");}
$sj=date("Y-m-d H:i:s");
$uip=$_SERVER["REMOTE_ADDR"];
$bh=time()."n".rnd_num(100);
$djl=rnd_num(200);
while1("zze,ly,lyurl","yjcode_news where zt<>99 order by lastsj desc limit 1");$row1=mysql_fetch_array($res1);
intotable("yjcode_news","type1id,type2id,djl,sj,lastsj,uip,bh,ifjc,zze,ly,lyurl,zt,iftp","0,0,".$djl.",'".$sj."','".$sj."','".$uip."','".$bh."',0,'".$row1[zze]."','".$row1[ly]."','".$row1[lyurl]."',99,0");

php_toheader("news.php?bh=".$bh);
?>
