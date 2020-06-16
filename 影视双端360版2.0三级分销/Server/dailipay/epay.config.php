<?php
/* *
 * 配置文件
 */
$databases = include_once("../Application/Common/Conf/config.php");
$link = mysqli_connect(
    $databases['DB_HOST'], 
    $databases['DB_USER'],   
   $databases['DB_PWD'],
   $databases['DB_NAME']);   
   $sql="select * from bc_config where id =1 ";
   $result=mysqli_query($link,$sql);
 while ($row = mysqli_fetch_assoc($result))
  { 
	$shanghu = $row; 
  }
$alipay_config['partner']		= $shanghu ['payh'];//商户id
$alipay_config['key']			=$shanghu ['payk'];///商户key
$alipay_config['sign_type']    = strtoupper('MD5');
$alipay_config['input_charset']= strtolower('utf-8');
$alipay_config['transport']    = $shanghu ['payt'];;
$alipay_config['apiurl']    =  $shanghu ['payu']; //网关无需改动
?>