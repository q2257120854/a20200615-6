<?php
namespace Home\Controller;
use Think\Controller;
class Alipay2019Controller extends Controller {
	    private $app_id;
	    private $merchant_private_key;
	    private $alipay_public_key;
		private $signtype;
      //在类初始化方法中，引入相关类库    
       public function _initialize() {
         Vendor('Aliplay2019.aop.AopClient');
        Vendor('Aliplay2019.aop.request.AlipayTradePagePayRequest');
		$config = M('config') -> select();
		if(!is_array($config)){
			die('请先在后台设置好各参数');
		}
		foreach($config as $v){
			$key = '_'.$v['name'];
			$this -> $key = unserialize($v['value']);
			$_CFG[$v['name']] = $this -> $key;
		}
		$GLOBALS['_CFG'] = $_CFG;
		$config=$GLOBALS['_CFG']['alipay2019'];
		$this->app_id= $config['app_id'];
		$this->signtype="RSA2";
 
		$this->merchant_private_key= str_replace(array("\r\n", "\r", "\n"), "", $config['merchant_private_key']);
	    $this->alipay_public_key= str_replace(array("\r\n", "\r", "\n"), "", $config['alipay_public_key']);
    }
   private function check($arr){
	 
		$aop = new \AopClient();
		$aop->alipayrsaPublicKey =   $this->alipay_public_key;
		$result = $aop->rsaCheckV1($arr, $this->alipay_public_key, $this->signtype);
		return $result;
	}
	//支付宝支付
	public function dopay(){
		header("Content-type:text/html;charset=utf-8");
		 $sn = I('sn');
		       $order = M('charge')->where(array('sn'=>$sn))->find();
			   if(!$order || empty($order)){
				   exit('error!');
			   }
	 		
		//print_r($Aliconfig);exit;
		//http://127.0.0.5/index.php?m=&c=Mh&a=payAli
		 //商户订单号，商户网站订单系统中唯一订单号，必填
        $out_trade_no = $sn;
        //订单名称，必填
        $proName ='充值';
        //付款金额，必填
        $total_amount =  $order['money'];//trim($_POST['WIDtotal_amount']);
        //商品描述，可空
        $body = '充值';//trim($_POST['WIDbody']);
      
        //请求
        $c = new \AopClient();
         $return_url="http://".$_SERVER['HTTP_HOST'].__ROOT__."/index.php?m=&c=Mh&a=my";
		 $notify_url="http://".$_SERVER['HTTP_HOST'].__ROOT__."/third/alipay2019Notify.php";
        $c->gatewayUrl = "https://openapi.alipay.com/gateway.do";
        $c->appId =$this->app_id;
        $c->rsaPrivateKey = $this->merchant_private_key;
        $c->format = "json";
        $c->charset= "UTF-8";
        $c->signType=$this->signtype;
        $c->alipayrsaPublicKey =$this->alipay_public_key;
        $request = new \AlipayTradePagePayRequest();
        $request->setReturnUrl($return_url);
        $request->setNotifyUrl($notify_url);
        $request->setBizContent("{" .
            "    \"product_code\":\"FAST_INSTANT_TRADE_PAY\"," .
            "    \"subject\":\"$proName\"," .
            "    \"out_trade_no\":\"$out_trade_no\"," .
            "    \"total_amount\":$total_amount," .
            "    \"body\":\"$body\"" .
            "  }");
			//print_r($request);exit;
        $result = $c->pageExecute ($request);
        
        //输出
        echo $result;
	}
	
    
 
	
	/******************************
		服务器异步通知页面方
	*******************************/
    public function notifyurl(){
		$result = $this->check($_POST);
		if($result) {//验证成功
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				//请在这里加上商户的业务逻辑程序代

				
				//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
				
				//获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
				
				//商户订单号

				$out_trade_no = $_POST['out_trade_no'];

				//支付宝交易号

				$trade_no = $_POST['trade_no'];

				//交易状态
				$trade_status = $_POST['trade_status'];


				if($_POST['trade_status'] == 'TRADE_FINISHED') {

					//判断该笔订单是否在商户网站中已经做过处理
						//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
						//请务必判断请求时的total_amount与通知时获取的total_fee为一致的
						//如果有做过处理，不执行商户的业务程序
							
					//注意：
					//退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知
				}
				else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
					//判断该笔订单是否在商户网站中已经做过处理
						//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
						//请务必判断请求时的total_amount与通知时获取的total_fee为一致的
						//如果有做过处理，不执行商户的业务程序			
					//注意：
					//付款完成后，支付宝系统发送该交易状态通知
					   $charge =  M('charge')->where(array('sn'=>$out_trade_no))->find();
			  if($charge['status'] == 1){
				$money = $charge['money'];//金额 
				   $orderid = $out_trade_no;
		           $paysapi_id= $trade_no;
				$Dbresult = M('charge')->where(array('sn'=>$orderid))->save(array(
					'pay_time' => time(),
					'remark' => $orderid,
					'paysn'=>$paysapi_id,
					'status' => 2,
				));	
				if($Dbresult){
					$mid=$charge['mid'];
					//计算按比例扣除订单
					$m = M('member')->where(array('id'=>$mid))->find();
					$j =$member['deductions_e'];
					$i = M('charge')->where(array('mid'=>$charge['mid'],'status'=>2))->count();
					if($i%$j== 0){
						//扣除单子
						M('charge')->where(array('sn'=>$sn))->save(array('is_status' => 2));
						//扣除分层
						M('member_separate')->where(array('sn'=>$sn))->save(array('is_status'=>2));
					}
					//如果是VIP包年
					if($charge['isvip'] == 1){
						$s_time = time();
						$e_time = strtotime("+1 year");	
						//是VIP 增加一年期限
						$user = M('user')->find(intval($charge['user_id']));
						if($user['vip'] == 1){
							$e_time = strtotime("+1 year",$user['vip_e_time']);
						}
						$vipsb = $this->_site['vipsb'];
					if($vipsb!=0){
						M('user')->where(array('id'=>$this->user['id']))->setInc('money',$vipsb);
					}
						M('user')->where(array('id'=>$user['id']))->save(array(
							"vip"=>1,
							"vip_s_time"=>$s_time,
							"vip_e_time"=>$e_time,
						));
					}
                  //如果是VIP包月
					if($charge['isvip'] == 2){
						$s_time = time();
						$e_time = strtotime("+1 month");	
						//是VIP 增加一月期限
						$user = M('user')->find(intval($charge['user_id']));
						if($user['vip'] == 1){
							$e_time = strtotime("+1 month",$user['vip_e_time']);
						}
						$vipsb = $this->_site['vipsb'];
					if($vipsb!=0){
						M('user')->where(array('id'=>$this->user['id']))->setInc('money',$vipsb);
					}
						M('user')->where(array('id'=>$user['id']))->save(array(
							"vip"=>1,
							"vip_s_time"=>$s_time,
							"vip_e_time"=>$e_time,
						));
					}
                    //如果是VIP包季
					if($charge['isvip'] == 3){
						$s_time = time();
						$e_time = strtotime("+3 month");	
						//是VIP 增加一季度期限
						$user = M('user')->find(intval($charge['user_id']));
						if($user['vip'] == 1){
							$e_time = strtotime("+3 month",$user['vip_e_time']);
						}
						$vipsb = $this->_site['vipsb'];
					if($vipsb!=0){
						M('user')->where(array('id'=>$this->user['id']))->setInc('money',$vipsb);
					}
						M('user')->where(array('id'=>$user['id']))->save(array(
							"vip"=>1,
							"vip_s_time"=>$s_time,
							"vip_e_time"=>$e_time,
						));
					}
                  else{
						$user_id = $charge['user_id'];
						$user_info = M('user')->where(array('id'=>$user_id))->find();
						$send = 0;
						
						foreach($this->_charge as $v){
							if($money == $v['money']){
								$send = $v['send'];
								break;
							}
						}
						$money = $money*$this->_site['rate'];
						$money = $money + $send;
						M('user')->where(array('id'=>$charge['user_id']))->setInc('money',$money);
						flog($charge['user_id'], "money", $money, 1);
					}
					
					
					//更新第三方用户信息
					if($charge['mid']){
						$member = M('member')->where(array('id'=>$charge['mid']))->find();
					}
					if($member){
						//更新分成状态
						M('member_separate')->where(array('cid'=>$charge['id']))->save(array('status'=>2,'pay_time'=>NOW_TIME));
						//添加分成佣金到代理账户
						$msep = M('member_separate')->where(array('cid'=>$charge['id']))->find();
						M('member')->where(array('id'=>$msep['mid']))->save(array(
							'money' => array('exp', 'money+'.$msep['money']),
						));	
					}

					//分成到用户佣金
					$logs = M('separate_log')->where(array('order_id'=>$charge['id']))->select();
					if($logs){
						foreach((array)$logs as $v){
							M('user') -> where('id='.$v['user_id']) -> save(array(
								'rmb' => array('exp', 'rmb+'.$v['money']),
							));
							M('separate_log')->where(array('id'=>$v['id']))->save(array('status'=>4));
							flog($v['user_id'], 'money', $v['money'],3);
						}
					}
					
					//新增如果有文案推广，增加文案推广的充值金额
					if($charge['chapid']>0){
						M('chapter')->where(array('id'=>$charge['chapid']))->save(array(
							'charge' => array('exp', 'charge+'.$charge['money']),
						));
					}					
			 
				}
			    }
					    
				}
				//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
					
				echo "success";		//请不要修改或删除
					
			}else {
				//验证失败
				echo "fail";	//请不要修改或删除

			} 
    }
	
  
	
}?>