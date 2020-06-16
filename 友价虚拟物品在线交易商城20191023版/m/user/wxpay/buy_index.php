<?
include("../../../config/conn.php");
include("../../../config/function.php");
function curl_post_https($url,$data){ // 模拟提交数据函数
    $curl = curl_init(); // 启动一个CURL会话
    curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1); // 从证书中检查SSL加密算法是否存在
    curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
    curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
    curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
    curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
    curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
    $tmpInfo = curl_exec($curl); // 执行操作
    if (curl_errno($curl)) {
        echo 'Errno'.curl_error($curl);//捕抓异常
    }
    curl_close($curl); // 关闭CURL会话
    return $tmpInfo; // 返回数据，json格式
}

function getIp(){    
    $ip = '';    
    if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){        
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];    
    }elseif(isset($_SERVER['HTTP_CLIENT_IP'])){        
        $ip = $_SERVER['HTTP_CLIENT_IP'];    
    }else{        
        $ip = $_SERVER['REMOTE_ADDR'];    
    }
    $ip_arr = explode(',', $ip);
    return $ip_arr[0];
 }
 
 
 
$sqluser="select * from yjcode_user where uid='".$_SESSION[SHOPUSER]."'";mysql_query("SET NAMES 'GBK'");$resuser=mysql_query($sqluser);
if(!$rowuser=mysql_fetch_array($resuser)){php_toheader(weburl."m/reg/");}
$userid=$rowuser[id];
$sj=date("Y-m-d H:i:s");
include("../../../user/buycheck.php");

if(sqlzhuru($_POST[jvs])=="carpay"){
if($needmoney<=$usermoney){Audit_alert("您的可用余额充足，请用余额直接支付。",weburl."m/user/carpay.php?carid=".$carid);}
zwzr();
$bh=time();
$uip=getIp();
$ddbh=time().$userid.rnd_num(99999);
$money1=sprintf("%.2f",$needmoney-$usermoney);
$money=$money1*100;
intotable("yjcode_dingdang","bh,ddbh,userid,sj,uip,money1,ddzt,alipayzt,bz,ifok,carid,sxf","'".$bh."','".$ddbh."',".$rowuser[id].",'".$sj."','".$uip."',".$money1.",'wait','','wx-h5',0,'".$caridarr."',".$sxf."");
}


$wxpay=preg_split("/,/",$rowcontrol[wxpay]);
$userip =$uip; //获得用户设备IP 自己网上百度去
$appid = $wxpay[0];//微信给的
$mch_id = $wxpay[1];//微信官方的
$key = $wxpay[2];//自己设置的微信商家key
$out_trade_no = $ddbh;//平台内部订单号
$nonce_str=MD5($out_trade_no);//随机字符串
$body = "weixin";//内容
$total_fee = $money; //金额
$spbill_create_ip = $userip; //IP
$notify_url = weburl."m/user/wxpay/example/buy_notify.php"; //回调地址
$trade_type = 'MWEB';//交易类型 具体看API 里面有详细介绍
$scene_info ='{"h5_info":{"type":"Wap","wap_url":"'.weburl.'","wap_name":"支付"}}';//场景信息 必要参数
$signA ="appid=$appid&body=$body&mch_id=$mch_id&nonce_str=$nonce_str&notify_url=$notify_url&out_trade_no=$out_trade_no&scene_info=$scene_info&spbill_create_ip=$spbill_create_ip&total_fee=$total_fee&trade_type=$trade_type";
$strSignTmp = $signA."&key=$key"; //拼接字符串  注意顺序微信有个测试网址 顺序按照他的来 直接点下面的校正测试 包括下面XML  是否正确
$sign = strtoupper(MD5($strSignTmp)); // MD5 后转换成大写
$post_data = "<xml>
                        <appid>$appid</appid>
                        <body>$body</body>
                        <mch_id>$mch_id</mch_id>
                        <nonce_str>$nonce_str</nonce_str>
                        <notify_url>$notify_url</notify_url>
                        <out_trade_no>$out_trade_no</out_trade_no>
                        <scene_info>$scene_info</scene_info>
                        <spbill_create_ip>$spbill_create_ip</spbill_create_ip>
                        <total_fee>$total_fee</total_fee>
                        <trade_type>$trade_type</trade_type>
                        <sign>$sign</sign>
                    </xml>";//拼接成XML 格式
$url = "https://api.mch.weixin.qq.com/pay/unifiedorder";//微信传参地址
$dataxml = curl_post_https($url,$post_data); //后台POST微信传参地址  同时取得微信返回的参数    POST 方法我写下面了
$objectxml = (array)simplexml_load_string($dataxml, 'SimpleXMLElement', LIBXML_NOCDATA); //将微信返回的XML 转换成数组
$a1=preg_split("/prepay_id=/",$objectxml["mweb_url"]);
$a2=preg_split("/&/",$a1[1]);
$b1=preg_split("/package=/",$objectxml["mweb_url"]);

php_toheader("https://wx.tenpay.com/cgi-bin/mmpayweb-bin/checkmweb?prepay_id=".$a2[0]."&package=".$b1[1]."&redirect_url=".urlencode($notify_url));
?>