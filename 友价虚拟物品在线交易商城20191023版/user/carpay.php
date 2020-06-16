<?
include("../config/conn.php");
include("../config/function.php");
sesCheck();
$sqluser="select * from yjcode_user where uid='".$_SESSION[SHOPUSER]."'";mysql_query("SET NAMES 'GBK'");$resuser=mysql_query($sqluser);
if(!$rowuser=mysql_fetch_array($resuser)){php_toheader("../reg/");}
$sj=date("Y-m-d H:i:s");
include("buycheck.php");

//B
if(sqlzhuru($_POST[jvs])=="carpay" && sqlzhuru($_POST[R1])=="alipay"){
if($needmoney<=$usermoney){Audit_alert("您的可用余额充足，请用余额直接支付。","carpay.php?carid=".$carid);}
zwzr();
$bh=time();
$uip=$_SERVER["REMOTE_ADDR"];
$ddbh=time()."|".$rowuser[id];	
$money1=sprintf("%.2f",$needmoney-$usermoney);
intotable("yjcode_dingdang","bh,ddbh,userid,sj,uip,money1,ddzt,alipayzt,bz,ifok,carid,sxf","'".$bh."','".$ddbh."',".$rowuser[id].",'".$sj."','".$uip."',".$money1.",'等待买家付款','','',0,'".$caridarr."',".$sxf."");

require_once("alipay.config.php");
$payment_type = "1";
$notify_url = weburl."user/notify_carpay.php"; //服务器异步通知页面路径
$return_url = weburl."user/ordertz.php";//页面跳转同步通知页面路径
$seller_email = $rowcontrol[seller_email];//卖家支付宝帐户
$out_trade_no = $ddbh;//商户订单号
$subject = "【".webname."】 ".$zfbordertit;//订单名称
$body =  webname."收银台结算";
$show_url = weburl;//商品展示地址

//开始即时到帐
if(0==$rowcontrol[zftype]){ 
$alipay_config['cacert']    = getcwd().'\\cacert.pem';
require_once("lib/alipay_submit.class.php");
$total_fee = $money1;//付款金额
$anti_phishing_key = "";//防钓鱼时间戳
$exter_invoke_ip = "";//客户端的IP地址
$parameter = array(
		"service" => "create_direct_pay_by_user",
		"partner" => trim($alipay_config['partner']),
		"payment_type"	=> $payment_type,
		"notify_url"	=> $notify_url,
		"return_url"	=> $return_url,
		"seller_email"	=> $seller_email,
		"out_trade_no"	=> $out_trade_no,
		"subject"	=> $subject,
		"total_fee"	=> $total_fee,
		"body"	=> $body,
		"show_url"	=> $show_url,
		"anti_phishing_key"	=> $anti_phishing_key,
		"exter_invoke_ip"	=> $exter_invoke_ip,
		"_input_charset"	=> trim(strtolower($alipay_config['input_charset'])));
//结束即时到帐

}

//建立请求
$alipaySubmit = new AlipaySubmit($alipay_config);
$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "正在跳转，请稍候");
echo $html_text;exit;


}elseif(sqlzhuru($_POST[jvs])=="carmypay"){//余额支付
 if($needmoney>$usermoney){Audit_alert("您的可用余额不足，返回重试。","carpay.php?carid=".$carid);}
 zwzr();
 include("buy.php");
 php_toheader("ordertz.php");

}
//E
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>用户管理面板 - <?=webname?></title>
<? include("cssjs.html");?>
<link href="css/pay.css" rel="stylesheet" type="text/css" />
<script language="javascript">
function xz(x){
document.getElementById(x).checked=true;	
}

function carpaytj(x){
 r=document.getElementsByName("R1");
 rv="";
 for(i=0;i<r.length;i++){
 if(r[i].checked==true){rv=r[i].value;}
 }
 <? if($usermoney<$needmoney){?>if(rv==""){alert("请选择支付方式");return false;}<? }?>
 tjwait();
 if(rv=="alipay" || rv==""){fu="carpay.php?carid="+x;}
 else if(rv=="bank"){fu="bank/buy_Send.php?carid="+x;}
 else if(rv=="wxpay"){f1.action="wxpay/buy_index.php?carid="+x;}
 else if(rv=="otherpay"){f1.action="otherpay/buy_otherpay.php?carid="+x;}
 f1.action=fu;
 tangopen();
}


function tangopen(){
layer.open({
  type:1,
  title: false,
  closeBtn: 0,
  area: '331px',
  skin: 'layui-layer-nobg', //没有背景色
  shadeClose: false,
  content: $('#tang')
});
}
</script>
</head>
<body>
<? include("../tem/top.html");?>
<? include("top.php");?>
<div class="yjcode">

<? include("left.php");?>

<!--RB-->
<div class="userright">
 
 <? include("rcap11.php");?>
 <script language="javascript">
 document.getElementById("rcap1").className="l1 l2";
 </script>

 <!--白B-->
 <div class="rkuang">
 
 <div class="carpay">
  <form name="f1" method="post"<? if($usermoney<$needmoney){?> target="_blank"<? }?> onSubmit="return carpaytj('<?=$carid?>')">
  <div class="pay">
  
  <ul class="pu1">
  <li class="l1">结算费用 <strong><?=sprintf("%.2f",$needmoney)?></strong> 元<? if(!empty($sxf)){?>(含<?=$sxf?>元手续费)<? }?></li>
  <li class="l2">您的可用余额：<strong><?=sprintf("%.2f",$usermoney)?></strong> 元</li>
  </ul>
  
  <? if($usermoney<$needmoney){?>
  <ul class="pay1">
  <li class="l1">第三方支付平台：</li>
  
  <? if(!empty($rowcontrol[partner]) && !empty($rowcontrol[security_code]) && !empty($rowcontrol[seller_email]) && 3!=$rowcontrol[zftype]){?>
  <li class="l2"><input name="R1" id="alipay" checked="checked" type="radio" value="alipay" /><img onClick="xz('alipay')" src="img/pay/alipay.gif" /></li>
  <? }?>

  <? if(!empty($rowcontrol[ipsshh]) && !empty($rowcontrol[ipszs])){?>
  <li class="l2">
  <input name="R1" id="ips" type="radio" value="ips" /><img src="img/pay/ips.gif" onClick="xz('ips')" />
  </li>
  <? }?>
  
  <? if(!empty($rowcontrol[bankbh]) && !empty($rowcontrol[bankkey])){?>
  <li class="l2">
  <input name="R1" id="bank" type="radio" value="bank" /><img src="img/pay/bank.gif" onClick="xz('bank')" />
  </li>
  <? }?>

  <? if(!empty($rowcontrol[wxpay]) && $rowcontrol[wxpay]!=",,," && $rowcontrol[wxpayfs]!=1){?>
  <li class="l2">
  <input name="R1" id="wxpay" type="radio" value="wxpay" /><img src="img/pay/wxpay.gif" onClick="xz('wxpay')" />
  </li>
  <? }?>
  
  <? if(!empty($rowcontrol[otherpay])){$a=preg_split("/,/",$rowcontrol[otherpay]);?>
  <li class="l2">
  <input name="R1" id="otherpay" type="radio" value="otherpay" /><img src="img/pay/otherpay.jpg" width="150" height="50" onClick="xz('otherpay')" />
  </li>
  <? }?>

  <? if(!empty($rowcontrol[yunpay]) && $rowcontrol[yunpay]!=",,"){?>
  <li class="l2">
  <input name="R1" id="yunpay" type="radio" value="yunpay" /><img src="img/pay/yunpay.png" width="150" height="50" onClick="xz('yunpay')" />
  </li>
  <? }?>

  </ul>
  <? }?>
  
  <div id="tang" style="display:none;">
  <ul class="pay4">
  <li class="l1">请在支付页面完成付款!</li>
  <li class="l2">付款完成前请不要关闭此窗口。付款完成后请根据情况点击以下按钮。</li>
  <li class="l3">
  <a href="ordertz.php" class="a1">完成付款</a>
  <a href="javascript:void(0);" class="a2" onClick="javascript:alert('付款遇到问题？请联系客服');location.href='carpay.php?carid=<?=$carid?>';return false;">付款遇到问题</a>
  </li>
  </ul>
  </div>
  
  <div class="carbtn">
   <div id="tjbtn"><input type="submit" value="确认付款" /></div>
   <div class="tjing" id="tjing" style="display:none;">
   <img style="margin:0 0 6px 0;" src="../img/ajax_loader.gif" width="208" height="13" /><br />正在处理数据，请不要刷新页面，也不要关闭页面 ^_^
   </div>
  </div>
  <input type="hidden" value="<? if($usermoney<$needmoney){echo "carpay";}else{echo "carmypay";}?>" name="jvs" />
  
  </div>
  </form>
 </div>
 
 </div>
 <!--白E-->

</div> 
<!--RE-->

</div>

<div class="clear clear15"></div>
<? include("../tem/bottom.html");?>
</body>
</html>