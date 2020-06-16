<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
	<title>支付跳转中...</title>
</head>
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
updatetable("yjcode_user","uqq='".sqlzhuru($_POST[tuqq])."' where uid='".$_SESSION[SHOPUSER]."'");
$bh=time();
$uip=$_SERVER["REMOTE_ADDR"];
$ddbh=time()."|".$rowuser[id];	
$money1=($needmoney*10-$usermoney*10)/10;
$buyformarr=sqlzhuru($_POST[buyformv]);
$shdzarr=sqlzhuru($_POST[shdzv]);
intotable("yjcode_dingdang","bh,ddbh,userid,sj,uip,money1,ddzt,alipayzt,bz,ifok,probh,pronum,tcid,buyform,shdz","'".$bh."','".$ddbh."',".$rowuser[id].",'".$sj."','".$uip."',".$money1.",'wait','','otherpay',0,'".$bharr."','".$numarr."','".$tcidarr."','".$buyformarr."','".$shdzarr."'");
}
require_once("epay.config.php");
require_once("lib/epay_submit.class.php");

		

/**************************请求参数**************************/
		
		//商户订单号
        $out_trade_no =$ddbh;//商户网站订单系统中唯一订单号，必填

        //订单名称
        $subject = 'recharge-'.time();

        //付款金额
        $total_fee = $money1;//必填 需为整数
		
		
		//服务器异步通知页面路径
        $notify_url = weburl."user/otherpay/buy_no_url.php";
        //需http://格式的完整路径，不能加?id=123这类自定义参数

        //页面跳转同步通知页面路径
        $return_url = weburl."user/sms_sell.php";
        //需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/


/************************************************************/

//构造要请求的参数数组，无需改动
$parameter = array(
		"pid" => trim($alipay_config['partner']),
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