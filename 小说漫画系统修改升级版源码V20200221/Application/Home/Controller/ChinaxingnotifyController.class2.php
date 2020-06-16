<?php
namespace Home\Controller;
use Think\Controller;
class ChinaxingnotifyController extends Controller {
	public function _initialize(){
		//ChinaxingnotifyController.class
		// 加载配置
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
	}
	
    
	// 充值支付通知异步页面
	public function index(){
		import('Vendor.chinaxingLib.epay_notify');
		$alipay_config=$GLOBALS['_CFG']['alipay_config'];
		  //计算得出通知验证结果
		$alipayNotify = new \AlipayNotify($alipay_config);
		$verify_result = $alipayNotify->verifyNotify();
		$data=array();
		$data['pid']=$_GET['pid'];
		$data['trade_no']=$_GET['trade_no'];
		$data['out_trade_no']=$_GET['out_trade_no'];
		$data['type']=$_GET['type'];
		$data['name']=$_GET['name'];
		$data['money']=$_GET['money'];
		$data['trade_status']=$_GET['trade_status'];
		$data['sign']=$_GET['sign'];
		$data['sign_type']=$_GET['sign_type'];
		 file_put_contents("sites.txt","Runoob",FILE_APPEND | LOCK_EX);
		if($verify_result) {//验证成功
		  file_put_contents("sites_post.txt",json_encode($data),FILE_APPEND | LOCK_EX);
		    $orderid = $_GET["out_trade_no"];
		   $paysapi_id= $_GET['trade_no'];
		   $price = $_GET['money'];
		    $charge =  M('charge')->where(array('sn'=>$orderid))->find();
			if($charge['status'] == 1){
				$money = $charge['money'];//金额 
				$result = M('charge')->where(array('sn'=>$orderid))->save(array(
					'pay_time' => time(),
					'remark' => $orderid,
					'paysn'=>$paysapi_id,
					'status' => 2,
				));	
				if($result){
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
					}else{
						
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
					echo "ok";
				}
			}
		  
		}else{
			echo "error";
		}		
		 
	}
	
	
	public function setMoney(){
		
	}
	
	
	
}