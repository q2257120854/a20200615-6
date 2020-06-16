<?php
$alipay_config['partner']		= $rowcontrol[partner];
$alipay_config['key']			= $rowcontrol[security_code];
$alipay_config['sign_type']    = strtoupper('MD5');
$alipay_config['input_charset']= strtolower('gbk');
$alipay_config['transport']    = 'http';
?>