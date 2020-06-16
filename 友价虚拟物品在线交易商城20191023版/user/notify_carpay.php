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




	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//请在这里加上商户的业务逻辑程序代

	
	//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
	
    //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
	
	//商户订单号

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
	  case "WAIT_SELLER_SEND_GOODS":
	  case "WAIT_BUYER_CONFIRM_GOODS":
	  case "TRADE_SUCCESS";
	  $nddzt="交易成功"; 
	  break;
      }


$sj=date("Y-m-d H:i:s");
$uip=$_SERVER["REMOTE_ADDR"];
$dingdanbh=preg_split("/\|/",$out_trade_no);

if(empty($trade_no)){echo "success";exit;}
$sql="select ifok,jyh from yjcode_dingdang where ifok=1 and jyh='".$trade_no."'";mysql_query("SET NAMES 'GBK'");$res=mysql_query($sql);
if($row=mysql_fetch_array($res)){echo "success";exit;}

while1("*","yjcode_dingdang where ddbh='".$out_trade_no."' and ifok=0 and userid=".$dingdanbh[1]);if($row1=mysql_fetch_array($res1)){
 if($trade_status=="TRADE_SUCCESS" || $trade_status=="TRADE_FINISHED"){
  updatetable("yjcode_dingdang","sj='".$sj."',uip='".$uip."',alipayzt='".$trade_status."',ddzt='".$nddzt."',ifok=1,jyh='".$trade_no."' where id=".$row1[id]);
  $money1=$row1["money1"];
  PointIntoM($row1[userid],"支付宝充值".$money1."元",$money1,3,$trade_no);
  PointUpdateM($row1[userid],$money1);
  if(!empty($row1[sxf])){
  $sxf=$row1[sxf]*(-1);
  PointIntoM($row1[userid],"支付接口手续费",$sxf,0,$trade_no);
  PointUpdateM($row1[userid],$sxf);
  }
  $caridarr=$row1[carid];
  include("buy.php"); 
  echo "success";exit;
 }
}
  
}
?>