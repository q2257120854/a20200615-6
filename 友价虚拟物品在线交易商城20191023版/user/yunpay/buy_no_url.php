<?php
/* *
 * 功能：服务器异步通知页面
 */
include("../../config/conn.php");
include("../../config/function.php");


require_once("yun.config.php");
require_once("lib/yun_md5.function.php");

//计算得出通知验证结果
$yunNotify = md5Verify($_REQUEST['i1'],$_REQUEST['i2'],$_REQUEST['i3'],$yun_config['key'],$yun_config['partner']);

if($yunNotify) {//验证成功
	/////////////////////////////////////////////////////////
	
	//商户订单号

	$out_trade_no = $_REQUEST['i2'];

	//云支付交易号

	$trade_no = $_REQUEST['i4'];

	//价格
	$yunprice=$_REQUEST['i1'];

$sj=date("Y-m-d H:i:s");
$uip=$_SERVER["REMOTE_ADDR"];
while1("*","yjcode_dingdang where ddbh='".$out_trade_no."' and ddzt='wait'");if($row1=mysql_fetch_array($res1)){
 updatetable("yjcode_dingdang","sj='".$sj."',uip='".$uip."',alipayzt='TRADE_SUCCESS',ddzt='suc' where id=".$row1[id]);
 $money1=$row1["money1"];
 PointIntoM($row1[userid],"云支付充值".$money1."元",$money1);
 PointUpdateM($row1[userid],$money1);
 $buyuserid=$row1[userid];
 $bharr=$row1[probh];
 $numarr=$row1[pronum];
 $tcidarr=$row1[tcid];
 $buyformarr=$row1[buyform];
 $shdzarr=$row1[shdz];
 include("../buy.php"); 
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