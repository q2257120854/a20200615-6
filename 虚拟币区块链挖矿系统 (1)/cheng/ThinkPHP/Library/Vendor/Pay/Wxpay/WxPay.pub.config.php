<?php
/**
* 	配置账号信息
*/

class WxPayConf_pub
{
	//=======【基本信息设置】=====================================
	//微信公众号身份的唯一标识。审核通过后，在微信发送的邮件中查看
	const APPID = 'wx70ba88d99c5c6881';
	//受理商ID，身份标识
	const MCHID = '1232864002';
	//商户支付密钥Key。审核通过后，在微信发送的邮件中查看
	const KEY = 'dljfkjdkj7876d786fJDKJFSLKJD8797';
	//JSAPI接口中获取openid，审核后在公众平台开启开发模式后可查看
	const APPSECRET = '4ae34bdc4ba497fac5af700087c2298d';
	const JS_API_CALL_URL = 'http://www.517lyg.com/weixin/index.php/Home/Pay/index/id/';
	
	
	
	const SSLCERT_PATH = '{$path}/cacert/apiclient_cert.pem';
	const SSLKEY_PATH = '{$path}/cacert/apiclient_key.pem';

	const NOTIFY_URL = 'http://www.517lyg.com/woyaochi/index.php/Home/OrderPay/notify';
	const CURL_TIMEOUT = 60;
}

	
?>