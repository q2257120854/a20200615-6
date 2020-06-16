<?php
include("../../config/conn.php");
include("../../config/function.php");
sesCheck();
$sqluser="select * from yjcode_user where uid='".$_SESSION[SHOPUSER]."'";mysql_query("SET NAMES 'GBK'");$resuser=mysql_query($sqluser);
if(!$rowuser=mysql_fetch_array($resuser)){php_toheader("../reg/");}
$sj=date("Y-m-d H:i:s");
include("../buycheck.php");

if(sqlzhuru($_POST[jvs])=="carpay"){
if($needmoney<=$usermoney){Audit_alert("您的可用余额充足，请用余额直接支付。","../carpay.php?carid=".$carid);}
zwzr();
$bh=time();
$uip=$_SERVER["REMOTE_ADDR"];
$ddbh=time()."|".$rowuser[id];	
$money1=sprintf("%.2f",($needmoney-$usermoney));
intotable("yjcode_dingdang","bh,ddbh,userid,sj,uip,money1,ddzt,alipayzt,bz,ifok,carid","'".$bh."','".$ddbh."',".$rowuser[id].",'".$sj."','".$uip."',".$money1.",'等待买家付款','','财付通',0,'".$caridarr."'");
require_once ("classes/RequestHandler.class.php");
require_once ("buy_tenpay_config.php");
$curDateTime = date("YmdHis");
$strDate = date("Ymd");
$strTime = date("His");
$randNum = rand(1000, 9999);
$strReq = $strTime . $randNum;
$mch_vno = $dingbh;
}

if(sqlzhuru($_POST[R1])=="tenpay"){$nbtv="0";}else{$nbtv=sqlzhuru($_POST[R1]);}
?>
 
<HTML>
<HEAD>
<TITLE>财付通付款通道</TITLE>
</HEAD>
<BODY onLoad="document.directFrm.submit();">


<form action='buy_tenpay.php' method='post' name='directFrm'>
<input type="hidden" value="1" name="trade_mode" > <!--即时到帐，交易方式-->
<input type="hidden" name="order_no" value="<?=$ddbh?>" > <!--订单编号-->
<input name="product_name" type="hidden" value="<?=webname?>收银台结算" > <!--付款项目-->
<input name="remarkexplain" type="hidden" value="无" > <!--备注-->
<input type="hidden" name="order_price" value="<?=$money1?>"> <!--付款金额-->
<input type="hidden" name="bank_type_value" value="<?=$nbtv?>"  id="bank_type_value">
</form>


</body>
</html>
