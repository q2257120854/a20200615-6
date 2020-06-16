<?
include("../config/conn.php");
include("../config/function.php");
sesCheck();
$ifpays=0;

if(sqlzhuru($_POST[jvs])=="pay" && sqlzhuru($_POST[R1])=="alipay"){
zwzr();
$sj=date("Y-m-d H:i:s");
$userid=returnuserid($_SESSION["SHOPUSER"]);
$bh=time()."pay".$userid;
$uip=$_SERVER["REMOTE_ADDR"];
$allname=webname."预存款充值";
$ddbh=time()."|".$userid;	
$money1=sqlzhuru($_POST[t1]);
$sxf=0;
if(!empty($rowcontrol[paysxf])){
$sxf=str_replace("0.00",0,sprintf("%.2f",$money1*$rowcontrol[paysxf]));
}
$money1=$money1+$sxf;
intotable("yjcode_dingdang","bh,ddbh,userid,sj,uip,money1,ddzt,alipayzt,bz,ifok,sxf","'".$bh."','".$ddbh."',".$userid.",'".$sj."','".$uip."',".$money1.",'等待买家付款','','',0,".$sxf."");


require_once("alipay.config.php");
$payment_type = "1";
$notify_url = weburl."user/notify_url.php"; //服务器异步通知页面路径
if($_GET[ifwap]=="yes"){$ifm="m/";}
$return_url = weburl.$ifm."user/paylog.php";//页面跳转同步通知页面路径
$seller_email = $rowcontrol[seller_email];//卖家支付宝帐户
$out_trade_no = $ddbh;//商户订单号
$subject = webname."预存款充值";//订单名称
$body =  webname."预存款充值";
$show_url = weburl;//商品展示地址

include("alipay.php");exit;

}elseif(sqlzhuru($_POST[jvs])=="pay" && sqlzhuru($_POST[R1])=="aliewm"){
zwzr();
$money1=sqlzhuru($_POST[t1]);
php_toheader("alipay_ewm.php?money1=".$money1);

}elseif(sqlzhuru($_POST[jvs])=="pay" && sqlzhuru($_POST[R1])=="wxewm"){
zwzr();
$money1=sqlzhuru($_POST[t1]);
php_toheader("wxpay_ewm.php?money1=".$money1);

}elseif(sqlzhuru($_POST[yjcode])=="km" && $_GET[control]=="km"){
zwzr();
$tk=sqlzhuru($_POST[tk]);
$tm=sqlzhuru($_POST[tm]);
while1("*","yjcode_paykami where ka='".$tk."' and mi='".$tm."' and ifok=0");if(!$row1=mysql_fetch_array($res1)){Audit_alert("充值失败，卡号或密码不匹配","pay.php");}
$sj=date("Y-m-d H:i:s");
$userid=returnuserid($_SESSION["SHOPUSER"]);
PointIntoM($userid,"卡密直充".$row1[money1]."元",$row1[money1]);
PointUpdateM($userid,$row1[money1]);
updatetable("yjcode_paykami","userid=".$userid.",usesj='".$sj."',ifok=1 where id=".$row1[id]);
php_toheader("paylog.php");

}

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
function tj(){
t1v=document.f1.t1.value;
if(t1v.replace(/\s/,"")=="" || isNaN(t1v)){layer.alert('请输入充值金额', {icon:5});return false;}
r=document.getElementsByName("R1");
rv="";
for(i=0;i<r.length;i++){if(r[i].checked==true){rv=r[i].value;}}
if(rv==""){layer.alert('请选择支付方式', {icon:5});return false;}
if(rv=="alipay"){f1.action="pay.php";}
else if(rv=="aliewm"){f1.action="pay.php";}
else if(rv=="wxewm"){f1.action="pay.php";}
else if(rv=="ips"){f1.action="ips/OrderPay.php";}
else if(rv=="wxpay"){

document.getElementById("wxpay_f").src="wxpay/index.php?m="+t1v;
tangopen();
return false;
}
else if(rv=="otherpay"){f1.action="otherpay/otherpay.php";}
else if(rv=="yunpay"){f1.action="yunpay/yunpay.php";}
else if(rv=="bank"){f1.action="bank/Send.php";}
}

function tangopen(){
layer.open({
  type:1,
  title: false,
  closeBtn: 0,
  area: '369px',
  skin: 'layui-layer-nobg', //没有背景色
  shadeClose: false,
  content: $('#wxpay_t')
});
}

function payover(x){
 for(i=1;i<=2;i++){
 document.getElementById("rcap"+i).className="l1";
 document.getElementById("paymain"+i).style.display="none";
 }
 document.getElementById("rcap"+x).className="l1 l2";
 document.getElementById("paymain"+x).style.display="";
}

function tj1(){
tkv=document.f2.tk.value;
tmv=document.f2.tm.value;
if(tkv.replace(/\s/,"")==""){layer.alert('请输入充值卡号', {icon:5});return false;}
if(tmv.replace(/\s/,"")==""){layer.alert('请输入充值密码', {icon:5});return false;}
layer.msg('正在验证', {icon: 16  ,time: 0,shade :0.25});
f2.action="pay.php?control=km";
}

</script>
</head>
<body>
<? include("../tem/top.html");?>
<? include("top.php");?>

<div id="wxpay_t" style="display:none;">
<iframe name="wxpay_f" id="wxpay_f" marginwidth="1" marginheight="1" frameborder="0" height="100%" width="100%" border="0" src=""></iframe>
</div>

<div class="yjcode">

<? include("left.php");?>

<!--RB-->
<div class="userright">
 
 <ul class="wz">
 <li class="l1 l2" id="rcap1" onmouseover="payover(1)"><a href="javascript:void(0);">在线充值</a></li>
 <li class="l1" id="rcap2" onmouseover="payover(2)"><a href="javascript:void(0);">卡密支付</a></li>
 </ul>

 <!--白B-->
 <div class="rkuang">
 
 <ul class="uk">
 <li class="l1">您的当前余额：</li>
 <li class="l21 feng"><?=sprintf("%.2f",$rowuser[money1])?>元</li>
 </ul>

 <!--在线充值B-->
 <div id="paymain1">
 <form name="f1" method="post" onSubmit="return tj()" target="_blank">
 <input type="hidden" value="pay" name="jvs" />
 <ul class="uk">
 <li class="l1">充值金额：</li>
 <li class="l2">
 <input name="t1" autocomplete="off" disableautocomplete value="<?=$_GET[m]?>" style="width:105px;" class="inp" type="text" />
 <? if(!empty($rowcontrol[paysxf])){?><span class="fd">需要支付<strong style="color:#ff0000;"><?=$rowcontrol[paysxf]*100?>%</strong>的手续费</span><? }?>
 </li>
 <li class="l3"><? tjbtnr("立即充值")?></li>
 </ul>

 <ul class="czpay1">
 <li class="l1">选择支付方式：</li>
 
 <? if(empty($rowcontrol[zftype]) && !empty($rowcontrol[partner]) && !empty($rowcontrol[security_code]) && !empty($rowcontrol[seller_email])){?>
 <li class="l2">
 <input name="R1" id="alipay" type="radio" value="alipay"<? if($ifpays==0){?> checked="checked"<? $ifpays=1;}?> /><img onClick="xz('alipay')" src="img/pay/alipay.gif" />
 </li>
 <? }elseif(3==$rowcontrol[zftype]){?>
 <li class="l2">
 <input name="R1" id="aliewm" type="radio" value="aliewm"<? if($ifpays==0){?> checked="checked"<? $ifpays=1;}?> /><img onClick="xz('aliewm')" src="img/pay/alipay.gif" />
 </li>
 <? }?>

 <? if(!empty($rowcontrol[ipsshh]) && !empty($rowcontrol[ipszs])){?>
 <li class="l2">
 <input name="R1" id="ips" type="radio" value="ips"<? if($ifpays==0){?> checked="checked"<? $ifpays=1;}?> /><img src="img/pay/ips.gif" onClick="xz('ips')" />
 </li>
 <? }?>

 <? if(!empty($rowcontrol[bankbh]) && !empty($rowcontrol[bankkey])){?>
 <li class="l2">
 <input name="R1" id="bank" type="radio" value="bank"<? if($ifpays==0){?> checked="checked"<? $ifpays=1;}?> /><img src="img/pay/bank.gif" onClick="xz('bank')" />
 </li>
 <? }?>

 <? if(empty($rowcontrol[wxpayfs]) && !empty($rowcontrol[wxpay]) && $rowcontrol[wxpay]!=",,,"){?>
 <li class="l2">
 <input name="R1" id="wxpay" type="radio" value="wxpay"<? if($ifpays==0){?> checked="checked"<? $ifpays=1;}?> /><img src="img/pay/wxpay.gif" onClick="xz('wxpay')" />
 </li>
 <? }elseif($rowcontrol[wxpayfs]==1){?>
 <li class="l2">
 <input name="R1" id="wxewm" type="radio" value="wxewm"<? if($ifpays==0){?> checked="checked"<? $ifpays=1;}?> /><img src="img/pay/wxpay.gif" onClick="xz('wxewm')" />
 </li>
 <? }?>

 <? if(!empty($rowcontrol[yunpay]) && $rowcontrol[yunpay]!=",,"){?>
 <li class="l2">
 <input name="R1" id="yunpay" type="radio" value="yunpay"<? if($ifpays==0){?> checked="checked"<? $ifpays=1;}?> /><img src="img/pay/yunpay.png" width="150" height="50" onClick="xz('yunpay')" />
 </li>
 <? }?>

 <? if(!empty($rowcontrol[otherpay])){$a=preg_split("/,/",$rowcontrol[otherpay]);?>
 <li class="l2">
 <input name="R1" id="otherpay" type="radio" value="otherpay"<? if($ifpays==0){?> checked="checked"<? $ifpays=1;}?> /><img src="img/pay/otherpay.jpg" width="150" height="50" onClick="xz('otherpay')" />
 </li>
 <? }?>
 
 </ul>
  
 </form>
 </div>
 <!--在线充值E-->
 
 <!--卡密B-->
 <form name="f2" method="post" onsubmit="return tj1()">
 <input type="hidden" value="km" name="yjcode" />
 <div id="paymain2" style="display:none;">
 <ul class="uk uk0">
 <li class="l1">充值卡号：</li>
 <li class="l2"><input type="text" class="inp" name="tk" style="width:300px;" autocomplete="off" disableautocomplete /></li>
 <li class="l1">充值密码：</li>
 <li class="l2"><input type="text" class="inp" name="tm" style="width:300px;" autocomplete="off" disableautocomplete /></li>
 <li class="l3"><input type="submit" class="btn1" onmouseover="this.className='btn1 btn2';" onmouseout="this.className='btn1';" value="立即充值" /></li>
 </ul>
 <div class="paytsad"><? adread("ADUSER1","898",0);?></div>
 </div>
 </form>
 <!--卡密E-->
 
 
 <div class="clear clear10"></div>
 </div>
 <!--白E-->

</div> 
<!--RE-->

</div>

<div class="clear clear15"></div>
<? include("../tem/bottom.html");?>
</body>
</html>