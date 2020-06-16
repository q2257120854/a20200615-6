<?
include("../../config/conn.php");
include("../../config/function.php");
sesCheck_m();
$sqluser="select * from yjcode_user where uid='".$_SESSION[SHOPUSER]."'";mysql_query("SET NAMES 'GBK'");$resuser=mysql_query($sqluser);
if(!$rowuser=mysql_fetch_array($resuser)){php_toheader("../reg/");}

if(sqlzhuru($_POST[yjcode])=="jfbank"){
 zwzr();
 $fs=intval($_GET[fsv]);
 if($fs==1){ //积分换人民币
  $tnum=intval($_POST[t1]);
  if($tnum<=0){Audit_alert("兑换数值无效！","jfbank.php");}
  if($tnum>$rowuser[jf]){Audit_alert("兑换值超过您的可用积分！","jfbank.php");}
  $m=sprintf("%.2f",$tnum/$rowcontrol[jfmoney]);
  PointIntoM($rowuser[id],"积分兑换金钱",$m);PointUpdateM($rowuser[id],$m);
  PointInto($rowuser[id],"积分兑换金钱",$tnum*(-1));PointUpdate($rowuser[id],$tnum*(-1));
 }elseif($fs==2){ //人民币换积分
  $tnum=intval($_POST[t2]);
  if($tnum<=0){Audit_alert("兑换数值无效！","jfbank.php");}
  if($tnum>$rowuser[money1]){Audit_alert("兑换值超过您的可用余额！","jfbank.php");}
  $jf=sprintf("%.2f",$tnum*$rowcontrol[jfmoney]);
  PointIntoM($rowuser[id],"积分兑换金钱",$tnum*(-1));PointUpdateM($rowuser[id],$tnum*(-1));
  PointInto($rowuser[id],"积分兑换金钱",$jf);PointUpdate($rowuser[id],$jf);
 }
 
 php_toheader("../tishi/index.php?admin=999&b=../user/jfbank.php"); 
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
var fs=1;
function tj(){
 if(fs==1){zhi=document.f1.t1.value;}
 else if(fs==2){zhi=document.f1.t2.value;}
 if(zhi=="" || isNaN(zhi)){layerts('请输入有效的兑换数量');return false;}
 if(!confirm("确认要进行兑换吗？")){return false;}	
 layer.open({type: 2,content: '正在提交',shadeClose:false});
 f1.action="jfbank.php?fsv="+fs;
}

function jfxs(){
fs=parseInt(document.f1.d1.value);
document.getElementById("uk1").style.display="none";
document.getElementById("uk2").style.display="none";
document.getElementById("uk"+fs).style.display="";
}

</script>
</head>
<body>
<? include("topuser.php");?>

<div class="bfbtop1 box">
 <div class="d1" onClick="gourl('shezhi.php')"><img src="img/topleft.png" height="21" /></div>
 <div class="d2">积分银行</div>
 <div class="d3"></div>
</div>

<form name="f1" method="post" onSubmit="return tj()">
<input type="hidden" value="jfbank" name="yjcode" />
<div class="uk box">
 <div class="d1">兑换方式<span class="s1"></span></div>
 <div class="d2">
 <select name="d1" onChange="jfxs()" style="font-size:13px;">
 <option value="1">积分换人民币</option>
 <option value="2">人民币换积分</option>
 </select>
 </div>
 <div class="d3"><img src="../img/rightjian.png" height="13" /></div>
</div>

<div id="uk1">
 <div class="uk box">
  <div class="d1">可用积分<span class="s1"></span></div>
  <div class="d21"><strong class="red"><?=$rowuser[jf]?></strong>分</div>
 </div>
 <div class="uk box">
  <div class="d1">可用余额<span class="s1"></span></div>
  <div class="d21"><strong class="red"><?=sprintf("%.2f",$rowuser[money1])?></strong>元</div>
 </div>
 <div class="uk box">
  <div class="d1">兑换比例<span class="s1"></span></div>
  <div class="d21"><?=$rowcontrol[jfmoney]?>分=1元人民币</div>
 </div>
 <div class="uk box">
  <div class="d1">兑换积分<span class="s1"></span></div>
  <div class="d2"><input type="text" name="t1" class="inp" placeholder="请输入您的积分" /></div>
 </div>
</div>

<div id="uk2" style="display:none;">
 <div class="uk box">
  <div class="d1">可用余额<span class="s1"></span></div>
  <div class="d21"><strong class="red"><?=sprintf("%.2f",$rowuser[money1])?></strong>元</div>
 </div>
 <div class="uk box">
  <div class="d1">可用积分<span class="s1"></span></div>
  <div class="d21"><strong class="red"><?=$rowuser[jf]?></strong>分</div>
 </div>
 <div class="uk box">
  <div class="d1">兑换比例<span class="s1"></span></div>
  <div class="d21">1元人民币=<?=$rowcontrol[jfmoney]?>分</div>
 </div>
 <div class="uk box">
  <div class="d1">人 民 币<span class="s1"></span></div>
  <div class="d2"><input type="text" name="t2" class="inp" placeholder="请输入人民币数量" /></div>
 </div>
</div>


<div class="fbbtn box">
 <div class="d1"><? tjbtnr_m("保存")?></div>
</div>

</form>

<? include("bottom.php");?>
<script language="javascript">
bottomjd(4);
</script>
</body>
</html>