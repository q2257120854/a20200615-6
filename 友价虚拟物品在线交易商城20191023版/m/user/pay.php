<?
include("../../config/conn.php");
include("../../config/function.php");
sesCheck_m();
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
<title>会员中心 <?=webname?></title>
<? include("../tem/cssjs.html");?>
<link href="css/buy.css" rel="stylesheet" type="text/css" />
</head>
<body>
<? include("topuser.php");?>

<div class="bfbtop1 box">
 <div class="d1" onClick="gourl('order.php')"><img src="img/topleft.png" height="21" /></div>
 <div class="d2">在线充值</div>
 <div class="d3"></div>
</div>


<form name="f1" method="post" onSubmit="return tj()">
<input type="hidden" value="pay" name="jvs" />

<div class="uk box">
 <div class="d1">充值金额</div>
 <div class="d2"><input type="text" name="t1" class="inp" style="font-weight:700;color:#ff6600;" value="<?=returnjgdw($_GET[m],"",100)?>" /></div>
</div>

<div class="pay box">
 <div class="paym">
 
 <ul class="pay1">

 <? if(empty($rowcontrol[zftype]) && !empty($rowcontrol[partner]) && !empty($rowcontrol[security_code]) && !empty($rowcontrol[seller_email])){?>
 <li class="l2"><input name="R1" id="alipay" type="radio" value="alipay" /><img onClick="xz('alipay')" src="../../user/img/pay/alipay.gif" /></li>
 <? }?>

 <? if(!empty($rowcontrol[ipsshh]) && !empty($rowcontrol[ipszs])){?>
 <li class="l2"><input name="R1" id="ips" type="radio" value="ips" /><img src="../../user/img/pay/ips.gif" onClick="xz('ips')" /></li>
 <? }?>

 <? if(!empty($rowcontrol[bankbh]) && !empty($rowcontrol[bankkey])){?>
 <li class="l2"><input name="R1" id="bank" type="radio" value="bank" /><img src="../../user/img/pay/bank.gif" onClick="xz('bank')" /></li>
 <? }?>

 <? if(empty($rowcontrol[wxpayfs]) && !empty($rowcontrol[wxpay]) && $rowcontrol[wxpay]!=",,,"){?>
 <li class="l2"><input name="R1" id="wxpay" type="radio" value="wxpay" /><img src="../../user/img/pay/wxpay.gif" onClick="xz('wxpay')" /></li>
 <? }?>

 <? if(!empty($rowcontrol[yunpay]) && $rowcontrol[yunpay]!=",,"){?>
 <li class="l2"><input name="R1" id="yunpay" type="radio" value="yunpay" /><img src="../../user/img/pay/yunpay.png" onClick="xz('yunpay')" /></li>
 <? }?>

 <? if(!empty($rowcontrol[otherpay])){$a=preg_split("/,/",$rowcontrol[otherpay]);?>
 <li class="l2"><input name="R1" id="otherpay" type="radio" value="otherpay" /><img src="../../user/img/pay/otherpay.jpg" onClick="xz('otherpay')" /></li>
 <? }?>
   
 </ul>
  
 </div>
</div>

<div class="carbtn">
 <div id="tjbtn"><input type="submit" class="tjinput" value="立即充值" /></div>
 <div class="tjing" id="tjing" style="display:none;">
 <img style="margin:0 0 6px 0;" src="../img/ajax_loader.gif" width="208" height="13" /><br />正在处理数据，请不要刷新页面，也不要关闭页面 ^_^
 </div>
</div>

</form>

<script language="javascript">
function xz(x){
document.getElementById(x).checked=true;	
}

function tj(){
 t1v=document.f1.t1.value;
 if(t1v.replace(/\s/,"")=="" || isNaN(t1v)){layerts("请输入充值金额");return false;}
 r=document.getElementsByName("R1");
 rv="";
 for(i=0;i<r.length;i++){if(r[i].checked==true){rv=r[i].value;}}
 if(rv==""){layerts("请选择支付方式");return false;}

 ua = window.navigator.userAgent.toLowerCase();
 if(rv=="alipay" || rv==""){
  if(ua.match(/MicroMessenger/i) == 'micromessenger'){
  fu="wxalipay.php?admin=2&uid=<?=$rowuser[id]?>&upwd=<?=$rowuser[pwd]?>&m="+t1v;
  }else{
  <? if(empty($rowcontrol[alipaywap]) || $rowcontrol[alipaywap]==",,"){?>
  fu="../../user/pay.php?ifwap=yes";
  <? }else{?>
  fu="alipay/wappay/pay.php";
  <? }?>
  }
 }else if(rv=="ips"){fu="../../user/ips/OrderPay.php?ifwap=yes";}
 else if(rv=="bank"){fu="../../user/bank/Send.php?ifwap=yes";}
 else if(rv=="wxpay"){
  if(ua.match(/MicroMessenger/i) == 'micromessenger'){
  fu="wxpay1/pay.php?m="+document.f1.t1.value;
  }else{
  fu="wxpay/index.php?m="+t1v;
  }
 }
 else if(rv=="otherpay"){f1.action="../../user/otherpay/otherpay.php?ifwap=yes";}
 tjwait();
 f1.action=fu;
}
</script>

<? include("bottom.php");?>
<script language="javascript">
bottomjd(4);
</script>

</body>
</html>