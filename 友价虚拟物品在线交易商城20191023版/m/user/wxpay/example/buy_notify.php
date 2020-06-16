<?
include("../../../../config/conn.php");
include("../../../../config/function.php");
$wxpay=preg_split("/,/",$rowcontrol[wxpay]);
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

$xmlObj = simplexml_load_string(file_get_contents("php://input"));
//$xmlObj = simplexml_load_string($GLOBALS['HTTP_RAW_POST_DATA']); //解析回调数据  
$appid = $xmlObj->appid;//微信appid
$mch_id = $xmlObj->mch_id;  //商户号
$nonce_str = $xmlObj->nonce_str;//随机字符串
$sign = $xmlObj->sign;//签名
$result_code = $xmlObj->result_code;//业务结果
$openid = $xmlObj->openid;//用户标识
$is_subscribe = $xmlObj->is_subscribe;//是否关注公众帐号
$trace_type = $xmlObj->trade_type;//交易类型，JSAPI,NATIVE,APP
$bank_type = $xmlObj->bank_type;//付款银行，银行类型采用字符串类型的银行标识。
$total_fee = $xmlObj->total_fee;//订单总金额，单位为分
$fee_type = $xmlObj->fee_type;//货币类型，符合ISO4217的标准三位字母代码，默认为人民币：CNY。
$transaction_id = $xmlObj->transaction_id;//微信支付订单号
$out_trade_no = $xmlObj->out_trade_no;//商户订单号
$attach = $xmlObj->attach;//商家数据包，原样返回
$time_end = $xmlObj->time_end;//支付完成时间
$cash_fee = $xmlObj->cash_fee;
$return_code = $xmlObj->return_code;
if(!empty($_SESSION["SHOPUSER"])){
php_toheader("../../wxresult.php?a=order");
}

    if($return_code =="SUCCESS"){
//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
//进行签名验证B
$signA ="appid=$appid&mch_id=$mch_id&nonce_str=$nonce_str&transaction_id=$transaction_id";
$strSignTmp = $signA."&key=".$wxpay[2]; //拼接字符串  注意顺序微信有个测试网址 顺序按照他的来 直接点下面的校正测试 包括下面XML  是否正确
$sign = strtoupper(MD5($strSignTmp)); // MD5 后转换成大写
$post_data = "<xml>
                        <appid>$appid</appid>
                        <mch_id>$mch_id</mch_id>
                        <nonce_str>$nonce_str</nonce_str>
                        <transaction_id>$transaction_id</transaction_id>
                        <sign>$sign</sign>
                    </xml>";//拼接成XML 格式
$url = "https://api.mch.weixin.qq.com/pay/orderquery";//微信传参地址
$dataxml = curl_post_https($url,$post_data); //后台POST微信传参地址  同时取得微信返回的参数    POST 方法我写下面了
$objectxml = (array)simplexml_load_string($dataxml, 'SimpleXMLElement', LIBXML_NOCDATA); //将微信返回的XML 转换成数组
//进行签名验证E
if($objectxml["trade_state"]=="SUCCESS"){
 //自己逻辑代码B
 $sql="select * from yjcode_dingdang where ddbh='".$out_trade_no."' and ifok=0";mysql_query("SET NAMES 'gbk'");$res=mysql_query($sql);
 if($row=mysql_fetch_array($res)){
  if(1==$row[ifok]){echo "success";exit;}
  $sj=date("Y-m-d H:i:s");
  $uip=$_SERVER["REMOTE_ADDR"];
  updatetable("yjcode_dingdang","sj='".$sj."',uip='".$uip."',alipayzt='TRADE_SUCCESS',ddzt='交易成功',ifok=1 where id=".$row[id]);
  $money1=$row[money1];
  PointIntoM($row[userid],"微信充值".$money1."元",$money1,4,$transaction_id);
  PointUpdateM($row[userid],$money1);
  if(!empty($row[sxf])){
  $sxf=$row[sxf]*(-1);
  PointIntoM($row[userid],"支付接口手续费",$sxf,0,$transaction_id);
  PointUpdateM($row[userid],$sxf);
  }
  if(!empty($row[carid])){
  $caridarr=$row[carid];
  include("../../../../user/buy.php"); 
  }
  echo "success";exit;
 }
 //自己逻辑代码E
}
            echo success;     
         }


?>