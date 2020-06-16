<?php
include("../../config/conn.php");
include("../../config/function.php");
sesCheck();
$lj=weburl;
$tz="wxcarpay.php";
if($_GET[m]=="yes"){
 $lj=weburl."m/";
 $tz="wxcarpay_m.php";
}
$sqluser="select * from yjcode_user where uid='".$_SESSION[SHOPUSER]."'";mysql_query("SET NAMES 'GBK'");$resuser=mysql_query($sqluser);
if(!$rowuser=mysql_fetch_array($resuser)){php_toheader($lj."user/reg/");}
$sj=date("Y-m-d H:i:s");
include("../buycheck.php");

if(sqlzhuru($_POST[jvs])=="carpay"){
if($needmoney<=$usermoney){Audit_alert("您的可用余额充足，请用余额直接支付。",$lj."user/carpay.php?carid=".$carid);}
zwzr();
$bh=time();
$uip=$_SERVER["REMOTE_ADDR"];
$ddbh=time()."|".$rowuser[id];	
$money1=($needmoney*10-$usermoney*10)/10;
intotable("yjcode_dingdang","bh,ddbh,userid,sj,uip,money1,ddzt,alipayzt,bz,ifok,carid,sxf","'".$bh."','".$ddbh."',".$rowuser[id].",'".$sj."','".$uip."',".$money1.",'等待买家付款','','微信支付',0,'".$caridarr."',".$sxf."");
}
//php_toheader("example/buy_native.php?ddbh=".$ddbh);
php_toheader("../".$tz."?ddbh=".$ddbh);
?>