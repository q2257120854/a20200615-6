<?php
namespace app\user\controller;
use app\common\controller\HomeBase;
use think\Db;
use think\Request;
use think\Loader;
class Pay extends HomeBase
{
    protected $pay_config;
    protected $config;
    protected function _initialize()
    {
        parent::_initialize();
        $config1 = Db::name('system')->where('name', 'payservice')->value('value');
        $this->config = unserialize($config1);
       
        $this->pay_config['partner'] = $this->config['partner'];
        $this->pay_config['key'] = $this->config['key'];
        // 服务器异步通知页面路径
        $this->pay_config['notify_url'] = 'http://' . $_SERVER['HTTP_HOST'] . getbaseurl() . url('user/pay/notify_url');
        // 页面跳转同步通知页面路径
        $this->pay_config['return_url'] = 'http://' . $_SERVER['HTTP_HOST'] . getbaseurl() . url('user/pay/return_url');
        //签名方式
        $this->pay_config['sign_type'] = strtoupper('MD5');
        //字符编码格式 目前支持 gbk 或 utf-8
        $this->pay_config['input_charset'] = strtolower('utf-8');
        $this->pay_config['transport'] = 'http';
        if($this->config['paytype'] == 1){
            //支付API地址
            $this->pay_config['apiurl'] = $this->config['apiurl'];
            $this->pay_config['sitename'] = $this->config['sitename'];
        }else{
            $this->pay_config['seller_id']	=$this->pay_config['partner'];
            $this->pay_config['cacert']    = getcwd().'\\cacert.pem';
            $this->pay_config['payment_type'] = "1";
            $this->pay_config['service'] = "create_direct_pay_by_user";
            $this->pay_config['anti_phishing_key'] = "";
	    	$this->pay_config['exter_invoke_ip'] = "";
        }
        
        
    }
    public function index()
    {
        $is_thirdpay=0;
        if($this->config['paytype'] == 1) $is_thirdpay=1;
        $this->assign('is_thirdpay', $is_thirdpay);
        $this->assign('config', $this->config);
        return view();
    }
    public function notify_url()
    {
        if($this->config['paytype'] == 1){ 
            $thirdpayNotify = new \thirdpay\Youzinotify($this->pay_config);
        }else{
            $thirdpayNotify = new \alipay\Alipaynotify($this->pay_config);
        }
        
        $verify_result = $thirdpayNotify->verifyNotify();

        if ($verify_result) { //验证成功
            $out_trade_no = $_POST['out_trade_no'];
            //商户交易号
            $trade_no = $_POST['trade_no'];
            //交易状态
            $trade_status = $_POST['trade_status'];
            $map['id'] = $out_trade_no;
            $info = Db::name('orders')->where($map)->find();

            if ($info['status'] != 1) {
                Db::name('orders')->where($map)->update(['trade_no' => $trade_no, 'status' => 1]);
                point_note($info['score'], $info['uid'], 'alipay');
            }
            echo "success";
        } else { //验证失败
            if ($info['errorcode'] != 0) {
                Db::name('orders')->where($map)->update(['trade_no' => $trade_no, 'errorcode' => $_POST['trade_status']]);
            }
            //支付失败
            echo "fail";
        }
    }
    public function return_url()
    {

        //计算得出通知验证结果
        if($this->config['paytype'] == 1){
            $thirdpayNotify = new \thirdpay\Youzinotify($this->pay_config);
        }else{
            $thirdpayNotify = new \alipay\Alipaynotify($this->pay_config);
        }
        // $thirdpayNotify = new ThirdpayNotify($this->pay_config);
        $verify_result = $thirdpayNotify->verifyReturn();
        if ($verify_result) { //验证成功

            //商户订单号
            $out_trade_no = $_GET['out_trade_no'];
            //柚子支付交易号
            $trade_no = $_GET['trade_no'];
            //交易状态
            $trade_status = $_GET['trade_status'];
            $map['id'] = $out_trade_no;
            $info = Db::name('orders')->where($map)->find();
            if ($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
                if ($info['status'] != 1) {
                    Db::name('orders')->where($map)->update(['trade_no' => $trade_no, 'status' => 1]);
                    point_note($info['score'], $info['uid'], 'alipay');
                }
            } else {
                //echo "trade_status=".$_GET['trade_status'];
            }
            $this->success('充值成功', 'user/index/index');
        } else {
            Db::name('orders')->where($map)->update(['trade_no' => $trade_no, 'errorcode' => $_POST['trade_status']]);
            $this->error('充值失败', 'user/index/index');
        }

    }
    public function paysubmit()
    {

        $paydata = $this->request->param();
        //付款金额，必填
        $total_fee = $paydata['price'];
        //支付方式
        $type = $paydata['type'];

        if ($total_fee < $this->config['minnum']) {
            $this->error('充值金额低于最小金额');
        }

        $out_trade_no = generate_password(16) . time();
        $subject = '积分充值';

        //商品描述，可空
        $body = '积分充值';
        $data['uid'] = session('userid');
        $data['id'] = $out_trade_no;
        $data['trade_no'] = 0;
        $data['status'] = 0;
        $data['paytype'] = $this->config['paytype'];
        $data['price'] = $total_fee;
        $data['add_time'] = time();
        $data['errorcode'] = 0;
        $data['score'] = $total_fee * $this->config['scorenum'];
        Db::name('orders')->insert($data);

        

        //建立请求
        
        if($this->config['paytype'] == 1){
            $parameter = array(
                "pid" => $this->pay_config['partner'],
                "type" => $type,
                "notify_url" => $this->pay_config['notify_url'],
                "return_url" => $this->pay_config['return_url'],
                "out_trade_no" => $out_trade_no,
                "name" => $subject,
                "money" => $total_fee,
                "sitename" => $this->pay_config['sitename']
            );
            $thirdpaySubmit = new \thirdpay\Youzisubmit($this->pay_config);
            $html_text = $thirdpaySubmit->buildRequestForm($parameter);
        }else{

            $parameter = array(
				"service"       => $this->pay_config['service'],
				"partner"       => $this->pay_config['partner'],
				"seller_id"  => $this->pay_config['seller_id'],
				"payment_type"	=> $this->pay_config['payment_type'],
				"notify_url"	=> $this->pay_config['notify_url'],
				"return_url"	=> $this->pay_config['return_url'],
				"anti_phishing_key"=>$this->pay_config['anti_phishing_key'],
				"exter_invoke_ip"=>$this->pay_config['exter_invoke_ip'],
				"out_trade_no"	=> $out_trade_no,
				"subject"	=> $subject,
				"total_fee"	=> $total_fee,
				"body"	=> $body,
				"_input_charset"	=> trim(strtolower($this->pay_config['input_charset']))
		);
            $thirdpaySubmit = new \alipay\Alipaysubmit($this->pay_config);
            $html_text = $thirdpaySubmit->buildRequestForm($parameter,"get", "确认");
        }
        $this->success('即将跳转支付界面', $html_text);
    }
}
