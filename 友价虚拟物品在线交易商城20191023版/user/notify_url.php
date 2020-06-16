<?php
require("../config/conn.php");
include("../config/function.php");
require_once("alipay.config.php");

$alipay_config['cacert']    = getcwd().'\\cacert.pem';

require_once("lib/alipay_notify.class.php");

//计算得出通知验证结果
$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyNotify();

if($verify_result) {//验证成功

	$out_trade_no = $_POST['out_trade_no'];

	//支付宝交易号

	$trade_no = $_POST['trade_no'];

	//交易状态
	$trade_status = $_POST['trade_status'];
    switch($trade_status){
	  case "WAIT_BUYER_PAY";
	  $nddzt="等待买家付款";
	  break;
	  case "TRADE_FINISHED":
	  case "TRADE_SUCCESS";
	  $nddzt="交易成功"; 
	  break;
      }


$sj=date("Y-m-d H:i:s");
$uip=$_SERVER["REMOTE_ADDR"];
$dingdanbh=preg_split("/\|/",$out_trade_no);
$userid=$dingdanbh[1];

if(empty($trade_no)){echo "success";exit;}
/*
$sql="select ifok,ddbh from yjcode_dingdang where ifok=1 and ddbh='".$out_trade_no."'";mysql_query("SET NAMES 'GBK'");$res=mysql_query($sql);
if($row=mysql_fetch_array($res)){echo "success";exit;}
*/



$sql="select * from yjcode_dingdang where ddbh='".$out_trade_no."' and ifok=0 and userid=".$userid;mysql_query("SET NAMES 'GBK'");$res=mysql_query($sql);
if($row=mysql_fetch_array($res)){
 if(1==$row[ifok]){echo "success";exit;}
 if($trade_status=="TRADE_SUCCESS" || $trade_status=="TRADE_FINISHED"){
 updatetable("yjcode_dingdang","sj='".$sj."',uip='".$uip."',alipayzt='".$trade_status."',ddzt='".$nddzt."',ifok=1,jyh='".$trade_no."' where id=".$row[id]);
 $money1=$row["money1"];
 PointIntoM($userid,"支付宝充值".$money1."元",$money1,3,$trade_no);
 PointUpdateM($userid,$money1);
 if(!empty($row[sxf])){
 $sxf=$row[sxf]*(-1);
 PointIntoM($row[userid],"支付接口手续费",$sxf,0,$trade_no);
 PointUpdateM($row[userid],$sxf);
 }
 updatetable("yjcode_dingdang","ifok=1 where id=".$row1[id]);
 echo "success";exit;
 }
}


}
?>