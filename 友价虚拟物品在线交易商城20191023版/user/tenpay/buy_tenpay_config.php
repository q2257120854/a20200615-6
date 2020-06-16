<?php
require("../../config/conn.php");

$spname=webname."收银台结算";
$partner = $rowcontrol[tenpay1];                                  	//财付通商户号
$key = $rowcontrol[tenpay2];											//财付通密钥

$return_url = weburl."user/paylog.php";			//显示支付结果页面,*替换成payReturnUrl.php所在路径
$notify_url = weburl."user/tenpay/buy_payNotifyUrl.php";			//支付完成后的回调处理页面,*替换成payNotifyUrl.php所在路径
?>