<?php
include("../../../config/conn.php");
include("../../../config/function.php");





$lib_path	= dirname(__FILE__)."/";
require_once $lib_path."WxPay.Config.php";
require_once $lib_path."WxPay.Api.php";
require_once $lib_path."WxPay.Notify.php";
require_once $lib_path."WxPay.JsApiPay.php";
require_once $lib_path."log.php";



class PayNotifyCallBack extends WxPayNotify
{
	public  $data;
	//查询订单
	public function Queryorder($transaction_id)
	{
		$input = new WxPayOrderQuery();
		$input->SetTransaction_id($transaction_id);
		$result = WxPayApi::orderQuery($input);
		Log::DEBUG("query:" . json_encode($result));
		if(array_key_exists("return_code", $result)
			&& array_key_exists("result_code", $result)
			&& $result["return_code"] == "SUCCESS"
			&& $result["result_code"] == "SUCCESS")
		{
			
			
			return true;
		}
		return false;
	}
	
	//重写回调处理函数
	public function NotifyProcess($data, &$msg)
	{
		Log::DEBUG("call back:" . json_encode($data));
		
		$this->data = $data;
		$notfiyOutput = array();
		
		if(!array_key_exists("transaction_id", $data)){
			$msg = "输入参数不正确";
			return false;
		}
		//查询订单，判断订单真实性
		if(!$this->Queryorder($data["transaction_id"])){
			$msg = "订单查询失败";
			return false;
		}

		return true;
	}
}



require_once "wxconfig.php";


WxPayConfig::set_appid( $payment['wxpay_jspay_appid'] );
WxPayConfig::set_appsecret( $payment['wxpay_jspay_appsecret']);	

WxPayConfig::set_mchid( $payment['wxpay_jspay_mchid'] );
WxPayConfig::set_key( $payment['wxpay_jspay_key'] );






		$logHandler= new CLogFileHandler($lib_path."logs/".date('Y-m-d').'.log');
		$log = Log::Init($logHandler, 15);
		
		Log::DEBUG("begin notify");
		$notify = new PayNotifyCallBack( );
		$notify->Handle(true);
		
		$data = $notify->data;
		
		//判断签名
			if ($data['result_code'] == 'SUCCESS') {
				
					$transaction_id = $data['transaction_id'];
				 // 获取log_id
                    $out_trade_no	= $data['out_trade_no'];

						
					$sj=date("Y-m-d H:i:s");
					$uip=$_SERVER["REMOTE_ADDR"];
					$sql="select * from yjcode_dingdang where wxddbh='".$data['out_trade_no']."' and ifok=0";mysql_query("SET NAMES 'GBK'");$res=mysql_query($sql);
					if($row=mysql_fetch_array($res)){
						updatetable("yjcode_dingdang","sj='".$sj."',uip='".$uip."',alipayzt='TRADE_SUCCESS',ddzt='交易成功',ifok=1 where wxddbh='".$data['out_trade_no']."'");
						$money1=$row["money1"];
						PointIntoM($row[userid],"微信手机付款".$money1."元",$money1);
						PointUpdateM($row[userid],$money1);
						$caridarr=$row[carid];
						include("../../../user/buy.php"); 
					}	
	
					
					exit();
			}else{
				 //echo 'fail';
				exit();
			}


?>