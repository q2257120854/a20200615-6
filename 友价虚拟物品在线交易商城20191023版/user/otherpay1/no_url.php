<?php
/* *
 * 功能：服务器异步通知页面
 */
include("../../config/conn.php");
include("../../config/function.php");


require_once("epay.config.php");
require_once("lib/epay_notify.class.php");

//计算得出通知验证结果
$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyNotify();

if($verify_result) {//验证成功
	/////////////////////////////////////////////////////////
	
	//商户订单号

	$out_trade_no = $_GET['out_trade_no'];

	//彩虹易支付交易号

	$trade_no = $_GET['trade_no'];

	//价格
	$money = $_GET['money'];

$sj=date("Y-m-d H:i:s");
$uip=$_SERVER["REMOTE_ADDR"];
while1("*","yjcode_dingdang where ddbh='".$out_trade_no."' and ddzt='wait'");if($row1=mysql_fetch_array($res1)){
 updatetable("yjcode_dingdang","sj='".$sj."',uip='".$uip."',alipayzt='TRADE_SUCCESS',ddzt='suc',ifok=1 where id=".$row1[id]);
 $money1=$row1["money1"];
 PointIntoM($row1[userid],"v支付充值".$money1."元",$money1);
 PointUpdateM($row1[userid],$money1);
}

   
        
	echo "success";		//请不要修改或删除
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
else {
    //验证失败
    echo "fail";//请不要修改或删除

    //调试用，写文本函数记录程序运行情况是否正常
    //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
}
?>