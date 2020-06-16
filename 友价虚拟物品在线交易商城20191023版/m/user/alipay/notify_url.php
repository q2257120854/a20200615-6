<?php
require("../../../config/conn.php");
include("../../../config/function.php");

require_once("aliconfig.php");
require_once 'wappay/service/AlipayTradeService.php';


$arr=$_POST;
$alipaySevice = new AlipayTradeService($config); 
$alipaySevice->writeLog(var_export($_POST,true));
$result = $alipaySevice->check($arr);

/* 实际验证过程建议商户添加以下校验。
1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），
3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）
4、验证app_id是否为该商户本身。
*/
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


    if($_POST['trade_status'] == 'TRADE_FINISHED' || $_POST['trade_status'] == 'TRADE_SUCCESS') {


$dingdanbh=preg_split("/\|/",$out_trade_no);
$userid=$dingdanbh[1];
$sql="select * from yjcode_dingdang where ddbh='".$out_trade_no."' and ifok=0 and userid=".$userid;mysql_query("SET NAMES 'GBK'");$res=mysql_query($sql);
if($row=mysql_fetch_array($res)){
 if(1==$row[ifok]){echo "success";exit;}
 updatetable("yjcode_dingdang","sj='".getsj()."',uip='".getuip()."',alipayzt='".$trade_status."',ddzt='suc',ifok=1,jyh='".$trade_no."' where id=".$row[id]);
 $money1=$row["money1"];
 PointIntoM($userid,"支付宝充值".$money1."元",$money1,3,$trade_no);
 PointUpdateM($userid,$money1);
 if(!empty($row[sxf])){
 $sxf=$row[sxf]*(-1);
 PointIntoM($row[userid],"支付接口手续费",$sxf,0,$trade_no);
 PointUpdateM($row[userid],$sxf);
 }
 updatetable("yjcode_dingdang","ifok=1 where id=".$row1[id]);
 $caridarr=$row[carid];
 if(!empty($caridarr)){
 include("../../../user/buy.php");
 }
 echo "success";exit;
}




    }
	//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
        
	echo "success";		//请不要修改或删除
		
}else {
    //验证失败
    echo "fail";	//请不要修改或删除

}

?>

