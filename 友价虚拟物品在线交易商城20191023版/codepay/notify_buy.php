<?php
//error_reporting(E_ALL & ~ E_NOTICE); //过滤脚本错误

//ini_set("display_errors", "On");  //显示脚本错误提示
//error_reporting(E_ALL | E_STRICT); //开启全部脚本错误提示
/**
 * 功能：码支付服务器异步通知页面 (建议放置外网)
 * 版本：1.0
 * 日期：2016-12-23
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究码支付接口使用，只是提供一个参考。
 *************************业务处理调试说明*************************
 * 1：该页面不建议在本机电脑测试，请到服务器上做测试。请确保外部可以访问该页面。
 * 2：您可以使用我们的软件端中【手动充值】进行调试。
 * 3：该页面调试工具请使用写文本函数logResult，该函数已被默认开启，见codepay_notify_class.php中的函数verifyNotify
 * 4：创建该页面文件时，请留心该页面文件中无任何HTML代码及空格。
 * 5：如果没有收到该页面返回的 ok或者success 信息，码支付会在24小时内按一定的时间策略重发通知
 *************************注意*****************
 *如果您在接口集成过程中遇到问题，可以按照下面的途径来解决
 *1、开发文档中心（https://codepay.fateqq.com/apiword/）
 *2、商户帮助中心（https://codepay.fateqq.com/help/）
 *3、联系客服（https://codepay.fateqq.com/msg.html）
 */




/* *
 * 功能：服务器异步通知页面
 */
include("../config/conn.php");
include("../config/function.php");
require_once("codepay_config.php"); //导入配置文件
require_once("lib/codepay_notify.class.php"); //导入通知类


//计算得出通知验证结果
$codepayNotify = new CodepayNotify($codepay_config);
$verify_result = $codepayNotify->verifyNotify();

if ($verify_result && $_POST['pay_no']) { //验证成功
    $out_trade_no = $_POST['param'];



    $trade_no = $_REQUEST['pay_no'];


    $yunprice=$_POST['price'];


    $sj=date("Y-m-d H:i:s");
    $uip=$_SERVER["REMOTE_ADDR"];
    while1("*","yjcode_dingdang where ddbh='".$out_trade_no."' and ddzt='wait'");if($row1=mysql_fetch_array($res1)){
        updatetable("yjcode_dingdang","sj='".$sj."',uip='".$uip."',alipayzt='TRADE_SUCCESS',ddzt='suc' where id=".$row1[id]);
        $money1=$row1["money1"];
        PointIntoM($row1[userid],$money1,$money1);
        PointUpdateM($row1[userid],$money1);
        $caridarr=$row1[carid];
        $buyuserid=$row1[userid];
        $bharr=$row1[probh];
        $numarr=$row1[pronum];
        $tcidarr=$row1[tcid];
        $buyformarr=$row1[buyform];
        $shdzarr=$row1[shdz];
        include("../user/buy.php");
    }



    echo "success";		//请不要修改或删除


//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

} else {  //验证失败
    echo "fail";
    //调试用，写文本函数记录程序运行情况是否正常
//    logResult("验证失败了");
}

?>