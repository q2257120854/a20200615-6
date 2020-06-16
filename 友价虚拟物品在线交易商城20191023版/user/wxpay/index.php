<?
include("../../config/conn.php");
include("../../config/function.php");
$sj=date("Y-m-d H:i:s");
if(empty($_SESSION["SHOPUSER"])){Audit_alert("登录超时!","./","parent.");}

$userid=returnuserid($_SESSION["SHOPUSER"]);
$sj=date("Y-m-d H:i:s");
$bh=time();
$uip=$_SERVER["REMOTE_ADDR"];
$money1=$_GET[m];
$ddbh=time().$userid.rnd_num(1000);	
$sxf=0;
if(!empty($rowcontrol[paysxf])){
$sxf=str_replace("0.00",0,sprintf("%.2f",$money1*$rowcontrol[paysxf]));
}
$money1=$money1+$sxf;
intotable("yjcode_dingdang","bh,ddbh,userid,sj,uip,money1,ddzt,alipayzt,bz,ifok,sxf","'".$bh."','".$ddbh."',".$userid.",'".$sj."','".$uip."',".$money1.",'等待买家付款','','微信支付',0,".$sxf."");
php_toheader("example/native.php?ddbh=".$ddbh."&ifwap=".$_GET[ifwap]);
?>
