<?
include("../../config/conn.php");
include("../../config/function.php");
sesCheck_m();

$sqluser="select * from yjcode_user where uid='".$_SESSION[SHOPUSER]."'";mysql_query("SET NAMES 'GBK'");$resuser=mysql_query($sqluser);
$rowuser=mysql_fetch_array($resuser);
if(1==$rowuser[shopzt] || 2==$rowuser[shopzt] || 3==$rowuser[shopzt]){php_toheader("openshop3.php");}
$openbao=returnjgdw($rowcontrol[openbao],"",0);

//入库操作开始
if($_POST[yjcode]=="openshop"){
 zwzr();
 $t1=sha1(sqlzhuru($_POST[t1]));
 if(panduan("uid,pwd","yjcode_user where uid='".$_SESSION[SHOPUSER]."' and pwd='".$t1."'")==0){Audit_alert("登录密码验证失败，返回重试！","openshop2.php");}
 $d=preg_split("/xcf/",$_POST[d1]);
 while1("*","yjcode_openyue where id=".$d[2]);if(!$row1=mysql_fetch_array($res1)){Audit_alert("操作失败，返回重试！","openshop2.php");}
 $m=$row1[money1]+$rowcontrol[openshop]+$openbao;
 if($m>$rowuser[money1]){Audit_alert("您的余额不够，请先充值！","openshop2.php");}

 $sj=date("Y-m-d H:i:s");
 $dqsj=date('Y-m-d H:i:s',strtotime ("+".$row1[yue]." month",strtotime($sj)));
 if($dqsj<$sj){Audit_alert("续费失败，续费到期年限最大为2038年！","openshop2.php");}

 PointUpdateM($rowuser[id],$m*(-1));
 PointIntoM($rowuser[id],"申请开店，缴纳费用(续费".$row1[yue]."月)",$m*(-1));

 updatetable("yjcode_user","openshop=".$m.",openshop1=".$openbao.",shopzt=1,dqsj='".$dqsj."' where uid='".$_SESSION[SHOPUSER]."'");
 php_toheader("openshop3.php");
}
//入库操作结束
?>
<html>
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
<title>会员中心 <?=webname?></title>
<? include("../tem/cssjs.html");?>
<link href="css/sell.css" rel="stylesheet" type="text/css" />
<script language="javascript">
function tj(){
if((document.f1.t1.value).replace(/\s/,"")==""){layerts("请输入登录密码");return false;}	
if(document.f1.d1.value==""){layerts("请选择开店期限");return false;}	
if(!confirm("确定提交吗？")){return false;}
layer.open({type: 2,content: '正在提交',shadeClose:false});
f1.action="openshop2.php";
}
function fycha(){
d=(document.f1.d1.value).split("xcf");
a=addNum(0,d[1]);
b=addNum(a,<?=$rowcontrol[openshop]?>)
c=addNum(b,<?=$openbao?>)
document.getElementById("needmoney").innerHTML=c+"元";
}
</script>
</head>
<body>
<? include("topuser.php");?>

<div class="bfbtop1 box">
 <div class="d1" onClick="gourl('openshop1.php')"><img src="img/topleft.png" height="21" /></div>
 <div class="d2">我要开店</div>
 <div class="d3"></div>
</div>

<? include("kdcap.php");?>
<script language="javascript">
document.getElementById("step2").className="d1 d11";
</script>

<form name="f1" method="post" onSubmit="return tj()">
<input type="hidden" value="openshop" name="yjcode" />
<div class="uk box">
 <div class="d1">审核费用<span class="s1"></span></div>
 <div class="d21"><?=$rowcontrol[openshop]?> 元</div>
</div>
<div class="uk box">
 <div class="d1">保 证 金<span class="s1"></span></div>
 <div class="d21"><?=$openbao?> 元</div>
</div>
<div class="uk box">
 <div class="d1">开店期限<span class="s1"></span></div>
 <div class="d2">
 <select name="d1" onChange="fycha()" style="font-size:13px;">
 <? 
 while1("*","yjcode_openyue order by yue asc");while($row1=mysql_fetch_array($res1)){
 if($row1[yue] % 12==0){$nd=$row1[yue]/12;$nd=$nd."年";}else{$nd=$row1[yue]."个月";}
 ?>
 <option value="<?=$row1[yue]?>xcf<?=$row1[money1]?>xcf<?=$row1[id]?>"><?=$nd?> (费用：<?=$row1[money1]?>元)</option>
 <? }?>
 </select>
 </div>
 <div class="d3"><img src="img/jianright.png" height="13" /></div>
</div>
<div class="uk box">
 <div class="d1">总共费用<span class="s1"></span></div>
 <div class="d21"><span id="needmoney" class="red"></span></div>
</div>
<div class="uk box">
 <div class="d1">可用余额<span class="s1"></span></div>
 <div class="d21"><span class="blue"><?=$rowuser[money1]?>元</span> [<a href="pay.php">点击充值</a>]</div>
</div>
<div class="uk box">
 <div class="d1">登录密码<span class="s1"></span></div>
 <div class="d2"><input type="password" class="inp" placeholder="请输入登录密码" name="t1" /></div>
</div>
<div class="fbbtn box">
 <div class="d1"><? tjbtnr_m("下 一 步")?></div>
</div>

</form>
<script language="javascript">fycha();</script>
</body>
</html>