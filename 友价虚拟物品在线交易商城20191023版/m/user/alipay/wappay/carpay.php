<?
include("../../../../config/conn.php");
include("../../../../config/function.php");
sesCheck_m();
header("Content-type: text/html; charset=utf-8");
require_once dirname ( __FILE__ ).DIRECTORY_SEPARATOR.'service/AlipayTradeService.php';
require_once dirname ( __FILE__ ).DIRECTORY_SEPARATOR.'buildermodel/AlipayTradeWapPayContentBuilder.php';
require dirname ( __FILE__ ).DIRECTORY_SEPARATOR.'./../aliconfig.php';


$sqluser="select * from yjcode_user where uid='".$_SESSION[SHOPUSER]."'";mysql_query("SET NAMES 'GBK'");$resuser=mysql_query($sqluser);
if(!$rowuser=mysql_fetch_array($resuser)){php_toheader("../../../reg/");}
$sj=date("Y-m-d H:i:s");
include("../../../../user/buycheck.php");

	$userid=$rowuser[id];
    //商户订单号，商户网站订单系统中唯一订单号，必填
	$ddbh=time()."|".$userid;	
    $out_trade_no = $ddbh;
    //订单名称，必填
    $subject = "充值";
    //付款金额，必填
	$money1=sprintf("%.2f",($needmoney-$usermoney));
    $total_amount = $money1;
    //商品描述，可空
    $body = "pay";
    intotable("yjcode_dingdang","bh,ddbh,userid,sj,uip,money1,ddzt,alipayzt,bz,ifok,carid,sxf","'".returnbh()."','".$ddbh."',".$rowuser[id].",'".getsj()."','".getuip()."',".$money1.",'wait','','',0,'".$caridarr."',".$sxf."");


    //超时时间
    $timeout_express="1m";

    $payRequestBuilder = new AlipayTradeWapPayContentBuilder();
    $payRequestBuilder->setBody($body);
    $payRequestBuilder->setSubject($subject);
    $payRequestBuilder->setOutTradeNo($out_trade_no);
    $payRequestBuilder->setTotalAmount($total_amount);
    $payRequestBuilder->setTimeExpress($timeout_express);

    $payResponse = new AlipayTradeService($config);
    $result=$payResponse->wapPay($payRequestBuilder,$config['return_url'],$config['notify_url']);

    return ;
?>
