<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
	<title>支付跳转中...</title>
</head>
<?php
include("../../config/conn.php");
include("../../config/function.php");
$sj=date("Y-m-d H:i:s");
sesCheck();

require_once("epay.config.php");
require_once("lib/epay_submit.class.php");

$userid=returnuserid($_SESSION["SHOPUSER"]);
$sj=date("Y-m-d H:i:s");
$bh=time();
$uip=$_SERVER["REMOTE_ADDR"];
$money1=sqlzhuru($_POST[t1]);
$ddbh=time().$userid.rnd_num(1000);	
intotable("yjcode_dingdang","bh,ddbh,userid,sj,uip,money1,ddzt,alipayzt,bz,ifok","'".$bh."','".$ddbh."',".$userid.",'".$sj."','".$uip."',".$money1.",'wait','','otherpay',0");

		

/**************************请求参数**************************/
		
		//商户订单号
        $out_trade_no =$ddbh;//商户网站订单系统中唯一订单号，必填

        //付款金额
        $total_fee = $money1;//必填 需为整数

		//商品名称
        $subject = 'recharge-'.time();
		
		//服务器异步通知页面路径
        $notify_url = weburl."user/otherpay/no_url.php";
        //需http://格式的完整路径，不能加?id=123这类自定义参数

        //页面跳转同步通知页面路径
        $return_url = weburl."user/paylog.php";
        //需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/
       

/************************************************************/

//构造要请求的参数数组，无需改动
$parameter = array(
		"pid" => trim($alipay_config['partner']),
		"type" => 'qqpay',
		"notify_url"	=> $notify_url,
		"return_url"	=> $return_url,
		"out_trade_no"	=> $out_trade_no,
		"name"	=> $subject,
		"money"	=> $total_fee,
		"sitename"	=> 'youjiashop'
);

//建立请求
$alipaySubmit = new AlipaySubmit($alipay_config);
$html_text = $alipaySubmit->buildRequestForm($parameter,'POST','recharge');
echo $html_text;


?>
</body>
</html>