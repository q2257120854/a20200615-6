<?
include("../../../../config/conn.php");
include("../../../../config/function.php");
sesCheck_m();
header("Content-type: text/html; charset=utf-8");
require_once dirname ( __FILE__ ).DIRECTORY_SEPARATOR.'service/AlipayTradeService.php';
require_once dirname ( __FILE__ ).DIRECTORY_SEPARATOR.'buildermodel/AlipayTradeWapPayContentBuilder.php';
require dirname ( __FILE__ ).DIRECTORY_SEPARATOR.'./../aliconfig.php';
	$userid=returnuserid($_SESSION["SHOPUSER"]);
    //商户订单号，商户网站订单系统中唯一订单号，必填
	$ddbh=time()."|".$userid;	
    $out_trade_no = $ddbh;
    //订单名称，必填
    $subject = "充值";
    //付款金额，必填
	$money1=sqlzhuru($_POST[t1]);
    $sxf=0;
    if(!empty($rowcontrol[paysxf])){
    $sxf=str_replace("0.00",0,sprintf("%.2f",$money1*$rowcontrol[paysxf]));
    }
    $money1=$money1+$sxf;
    $total_amount = $money1;
    //商品描述，可空
    $body = "pay";
    intotable("yjcode_dingdang","bh,ddbh,userid,sj,uip,money1,ddzt,alipayzt,bz,ifok,sxf","'".returnbh()."','".$ddbh."',".$userid.",'".getsj()."','".getuip()."',".$money1.",'wait','','alipayH5',0,".$sxf."");


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
