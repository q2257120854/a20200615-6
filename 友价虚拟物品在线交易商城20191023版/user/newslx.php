<?
include("../config/conn.php");
include("../config/function.php");
sesCheck();

$userid=returnuserid($_SESSION[SHOPUSER]);
$sj=date("Y-m-d H:i:s");
$uip=getuip();

if(!empty($rowcontrol[ipnewsnum])){
 $sj1=dateYMD($sj)." 00:00:00";
 $sj2=dateYMD($sj)." 23:59:59";
 if(returncount("yjcode_news where uip='".$uip."' and sj>'".$sj1."' and sj<'".$sj2."' and userid=".$userid."")>=$rowcontrol[ipnewsnum]){Audit_alert("发稿过于频繁，请明天再来","./");}
}

$bh=time()."n".$userid;
intotable("yjcode_news","type1id,type2id,djl,sj,lastsj,uip,bh,ifjc,zt,iftp,indextop,userid","0,0,0,'".$sj."','".$sj."','".$uip."','".$bh."',0,99,0,0,".$userid."");
php_toheader("news.php?bh=".$bh);
?>
