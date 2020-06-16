<?
include("../../config/conn.php");
include("../../config/function.php");
sesCheck_m();

$sqluser="select * from yjcode_user where uid='".$_SESSION[SHOPUSER]."'";mysql_query("SET NAMES 'GBK'");$resuser=mysql_query($sqluser);
$rowuser=mysql_fetch_array($resuser);
if(empty($rowuser[txyh]) || empty($rowuser[txname]) || empty($rowuser[txzh])){Audit_alert("您未设置收款帐号，请先设置","txsz.php");}

if(sqlzhuru($_POST[jvs])=="tixian"){
 zwzr();
 $sj=date("Y-m-d H:i:s");
 $uip=$_SERVER["REMOTE_ADDR"];
 $money1=sqlzhuru($_POST[t1]);
 $m=(float)$money1;
 if($m>$rowuser[money1] || $m<=0){Audit_alert("提现金额不正确，提现失败","tixian.php");}
 if($m<$rowcontrol[txdi]){Audit_alert("低于最低提现额，提现失败","tixian.php");}
 $bh=time()."tx".$rowuser[id];
 intotable("yjcode_tixian","bh,userid,money1,sj,uip,txyh,txname,txzh,txkhh,zt,sm","'".$bh."',".$rowuser[id].",".$m.",'".$sj."','".$uip."','".$rowuser[txyh]."','".$rowuser[txname]."','".$rowuser[txzh]."','".$rowuser[txkhh]."',4,''");
  PointUpdateM($rowuser[id],$m*(-1));
  PointIntoM($rowuser[id],"提现申请",$m*(-1));
  php_toheader("../tishi/index.php?admin=999&b=../user/");
}

?>
<html>
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
<title>会员中心 <?=webname?></title>
<? include("../tem/cssjs.html");?>
<link href="css/buy.css" rel="stylesheet" type="text/css" />
<script language="javascript">
function tj(){
if((document.f1.t1.value).replace(/\s/,"")=="" || isNaN(document.f1.t1.value)){layerts("请输入有效的提现金额");return false;}	
if(parseFloat(document.f1.t1.value)<<?=$rowcontrol[txdi]?>){layerts("单次提现不得低于<?=$rowcontrol[txdi]?>元");return false;}	
if(confirm("确定要提现吗？")){layer.open({type: 2,content: '正在提交',shadeClose:false});f1.action="tixian.php";}else{return false;}
}
</script>
</head>
<body>
<? include("topuser.php");?>

<div class="bfbtop1 box">
 <div class="d1" onClick="gourl('index.php')"><img src="img/topleft.png" height="21" /></div>
 <div class="d2">进行提现</div>
 <div class="d4" onClick="gourl('tixianlog.php')">记录</div>
</div>

 <form name="f1" method="post" onSubmit="return tj()">
 <input type="hidden" value="tixian" name="jvs" />
 <div class="uk box">
  <div class="d1">可用余额<span class="s1"></span></div>
  <div class="d21 feng"><?=sprintf("%.2f",$rowuser[money1])?>元</div>
 </div>
 <div class="uk box">
  <div class="d1">提现类型<span class="s1"></span></div>
  <div class="d21"><?=$rowuser[txyh]?></div>
  <div class="d3"><img src="../img/rightjian.png" height="13" /></div>
 </div>
 <div class="uk box">
  <div class="d1">卡/账 户<span class="s1"></span></div>
  <div class="d21"><?=$rowuser[txzh]?></div>
  <div class="d3"><img src="../img/rightjian.png" height="13" /></div>
 </div>
 <? if($rowuser[txyh]!="支付宝" && $rowuser[txyh]!="财付通"){?>
 <div class="uk box" onClick="gourl('txsz.php')">
  <div class="d1">开 户 行<span class="s1"></span></div>
  <div class="d21"><?=$rowuser[txkhh]?></div>
  <div class="d3"><img src="../img/rightjian.png" height="13" /></div>
 </div>
 <? }?>
 <div class="uk box" onClick="gourl('txsz.php')">
  <div class="d1">收 款 人<span class="s1"></span></div>
  <div class="d21"><?=$rowuser[txname]?></div>
  <div class="d3"><img src="../img/rightjian.png" height="13" /></div>
 </div>
 <div class="uk box">
  <div class="d1">提现金额<span class="s1"></span></div>
  <div class="d2"><input type="text" class="inp" placeholder="请输入提现金额" name="t1" /> </div>
 </div>

 <div class="fbbtn box">
 <div class="d1"><? tjbtnr_m("提交申请")?></div>
 </div>

 </form>

 <div class="tishi box">
  <div class="d1">
  <? if(!empty($rowcontrol[txfl])){?>提现需扣除<?=$rowcontrol[txfl]*100?>%的手续费,<? }?>单次提现不低于<?=$rowcontrol[txdi]?>元<br>
  </div>
 </div>

</body>
</html>