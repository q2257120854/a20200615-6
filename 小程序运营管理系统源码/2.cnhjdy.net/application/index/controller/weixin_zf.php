<?php
        
    // define("ROOT_PATH",IA_ROOT.'/addons/sudu8_page/');
    namespace app\index\controller;
    use think\Controller;
    use think\Db;
    use think\Request;
    use think\Session;
    use think\View;
    header('Content-type:text/html; Charset=utf-8');

    class WxpayService extends Controller
    {
        protected $mchid;
        protected $appid;
        protected $appKey;
        protected $apiKey;
        protected $uniacid;
        public $data = null;

        
        public function __construct($mchid, $appid, $appKey,$key)
        {
            $this->mchid = $mchid;
            $this->appid = $appid;
            $this->appKey = $appKey;
            $this->apiKey = $key;
        }



        /**
         * 拼接签名字符串
         * @param array $urlObj
         * @return 返回已经拼接好的字符串
         */
        private function ToUrlParams($urlObj)
        {
            $buff = "";
            foreach ($urlObj as $k => $v)
            {
                if($k != "sign") $buff .= $k . "=" . $v . "&";
            }
            $buff = trim($buff, "&");
            return $buff;
        }

        /**
         * 企业付款
         * @param string $openid 调用【网页授权获取用户信息】接口获取到用户在该公众号下的Openid
         * @param float $totalFee 收款总费用 单位元
         * @param string $outTradeNo 唯一的订单号
         * @param string $orderName 订单名称
         * @param string $notifyUrl 支付结果通知url 不要有问号
         * @param string $timestamp 支付时间
         * @return string
         */
        public function createJsBizPackage($openid, $totalFee, $outTradeNo,$trueName,$uniacid)
        {   
            $ip = $_SERVER['SERVER_ADDR'];
            $config = array(
                'mch_id' => $this->mchid,
                'appid' => $this->appid,
                'key' => $this->apiKey,
            );
            $unified = array(
                'mch_appid' => $config['appid'],
                'mchid' => $config['mch_id'],
                'nonce_str' => self::createNonceStr(),
                'openid' => $openid,
                'check_name'=>'NO_CHECK',        //校验用户姓名选项。NO_CHECK：不校验真实姓名，FORCE_CHECK：强校验真实姓名
                're_user_name'=>$trueName,                 //收款用户真实姓名（不支持给非实名用户打款）
                'partner_trade_no' => $outTradeNo,
                'spbill_create_ip' => $ip,
                'amount' => intval($totalFee * 100),       //单位 转为分
                'desc'=>'付款',            //企业付款操作说明信息
            );

            $unified['sign'] = self::getSign($unified, $config['key']);


            $responseXml = $this->curlPost('https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers', self::arrayToXml($unified),$uniacid);

            $unifiedOrder = simplexml_load_string($responseXml, 'SimpleXMLElement', LIBXML_NOCDATA);
            if ($unifiedOrder === false) {
                die('parse xml error');
            }
            if ($unifiedOrder->return_code != 'SUCCESS') {
                die($unifiedOrder->return_msg);
            }
            if ($unifiedOrder->result_code != 'SUCCESS') {
                die($unifiedOrder->err_code);
            }
            return true;
        }

        public static function curlGet($url = '', $options = array())
        {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            if (!empty($options)) {
                curl_setopt_array($ch, $options);
            }
            //https请求 不验证证书和host
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            $data = curl_exec($ch);
            curl_close($ch);
            return $data;
        }

        public function curlPost($url = '', $postData = '', $uniacid, $options = array())
        {   
            // var_dump($url);
            // var_dump($postData);
            // var_dump($uniacid);
            // var_dump($options);
            // die();

            if (is_array($postData)) {
                $postData = http_build_query($postData);
            }
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30); //设置cURL允许执行的最长秒数
            if (!empty($options)) {
                curl_setopt_array($ch, $options);
            }
            //https请求 不验证证书和host
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

            //第一种方法，cert 与 key 分别属于两个.pem文件
            //默认格式为PEM，可以注释
            curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
            curl_setopt($ch,CURLOPT_SSLCERT,ROOT_PATH.'Cert/'.$uniacid.'/apiclient_cert.pem');
            //默认格式为PEM，可以注释
            curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
            curl_setopt($ch,CURLOPT_SSLKEY,ROOT_PATH.'Cert/'.$uniacid.'/apiclient_key.pem');
            //第二种方式，两个文件合成一个.pem文件
            //curl_setopt($ch,CURLOPT_SSLCERT,getcwd().'/all.pem');

            // var_dump($ch);
            // die();
            
            $data = curl_exec($ch);
            curl_close($ch);

            return $data;
        }

        public static function createNonceStr($length = 16)
        {
            $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            $str = '';
            for ($i = 0; $i < $length; $i++) {
                $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
            }
            return $str;
        }

        public static function arrayToXml($arr)
        {
            $xml = "<xml>";
            foreach ($arr as $key => $val) {
                if (is_numeric($val)) {
                    $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
                } else
                    $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
            }
            $xml .= "</xml>";
            return $xml;
        }

        public static function getSign($params, $key)
        {
            ksort($params, SORT_STRING);
            $unSignParaString = self::formatQueryParaMap($params, false);
            $signStr = strtoupper(md5($unSignParaString . "&key=" . $key));
            return $signStr;
        }

        protected static function formatQueryParaMap($paraMap, $urlEncode = false)
        {
            $buff = "";
            ksort($paraMap);
            foreach ($paraMap as $k => $v) {
                if (null != $v && "null" != $v) {
                    if ($urlEncode) {
                        $v = urlencode($v);
                    }
                    $buff .= $k . "=" . $v . "&";
                }
            }
            $reqPar = '';
            if (strlen($buff) > 0) {
                $reqPar = substr($buff, 0, strlen($buff) - 1);
            }
            return $reqPar;
        }


    }
