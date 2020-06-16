<?php
require("../config/conn.php");
$yunpay=preg_split("/,/",$rowcontrol[yunpay]);
//合作身份者id
$codepay_config['id']		= $yunpay[0];

//安全检验码
$codepay_config['key']			= $yunpay[1];


//↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑

?>