<?php
require("../../config/conn.php");
$yunpay=preg_split("/,/",$rowcontrol[yunpay]);
//合作身份者id
$yun_config['partner']		= $yunpay[0];

//安全检验码
$yun_config['key']			= $yunpay[1];

//云会员账户（邮箱）
$seller_email = $yunpay[2];

//↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑

?>