<?
include("../config/conn.php");
include("../config/function.php");
$id=$_GET[id];
$sj=date("Y-m-d H:i:s");
while0("*","yj_domain_pro where zt=1 and jyfs=3 and id=".$id);if(!$row=mysql_fetch_array($res)){php_toheader("../",".parent");}
if(empty($_SESSION[DOMAINUSER])){php_toheader("../",".parent");}
$userid=returnuserid($_SESSION[DOMAINUSER]);
if($userid==$row[userid]){Audit_alert("请勿参与自身域名的询价","view".$id.".html",".parent");}

$sqluser="select * from yj_domain_user where id=".$userid;mysql_query("SET NAMES 'utf8'");$resuser=mysql_query($sqluser);
if(!$rowuser=mysql_fetch_array($resuser)){php_toheader("../",".parent");}

if($_GET[control]=="xun"){
 $uip=$_SERVER['REMOTE_ADDR'];
 intotable("yj_domain_xunjia","probh,selluserid,userid,money1,sj,uip","'".$row[bh]."',".$row[userid].",".$userid.",".sqlzhuru($_POST[t1]).",'".$sj."','".$uip."'");
 php_toheader("xun.php?id=".$id."&t=suc");
}
?>
<html>
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$row[tit]?> - <?=webname?></title>
<link href="../css/basic.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="../js/basic.js"></script>
<style type="text/css">
body{background-color:#fff;}
.xunm{float:left;width:320px;height:170px;border:#F8F8F8 solid 1px;padding:10px;text-align:left;}
.xunm .clo{float:left;width:320px;text-align:right;}
.xunm .clo img{cursor:pointer;}
.xunm .u1{float:left;width:300px;margin:15px 10px 0 10px;}
.xunm .u1 li{float:left;}
.xunm .u1 .l1{width:100px;padding:5px 20px 0 0;height:35px;text-align:right;font-size:14px;}
.xunm .u1 .l2{width:180px;height:40px;}
.xunm .u1 .l2 input{float:left;width:180px;border:#ddd solid 1px;height:30px;font-weight:700;font-size:14px;padding:0 0 0 3px;color:#006FC7;}
.xunm .u1 .lbtn{width:300px;}
.xunm .u1 .lbtn input{float:left;width:300px;height:40px;font-size:14px;background-color:#ff6600;color:#fff;border:0;margin:10px 0 0 0;cursor:pointer;}
.xunm .u1 .lbtn input:hover{background-color:#F76E13;}
.xunm .u1 .l3{width:300px;height:40px;font-size:12px;margin:15px 0 0 0;}
.xunm .ts{float:left;text-align:center;padding:100px 0 0 0;margin:5px 0 0 0;font-size:16px;font-weight:700;background:url(../img/suc.jpg) center top no-repeat;width:320px;}
</style>
<script language="javascript">
function tj(){
v=document.f1.t1.value;
if(v.length == 0 || v.indexOf(" ")>=0 || isNaN(v)){alert("请输入有效价格！");document.f1.t1.focus();return false;}
if(!confirm("确认要提交该预算价格吗？")){return false;}
f1.action="xun.php?id=<?=$id?>&control=xun";
}
function clo(){
parent.tangxun(0);
}
</script>
</head>
<body>
<div class="xunm">
<div class="clo"><img onClick="clo()" src="../img/clo.png" width="15" height="15" /></div>
<? if($_GET[t]=="suc"){?>
<div class="ts"><strong>询价已经发送，请留意您的回复</strong></div>
<? }else{?>
<form name="f1" method="post" onSubmit="return tj()">
<ul class="u1">
<li class="l1">您的预算价位：</li>
<li class="l2"><input type="text" value="" name="t1" /></li>
<li class="lbtn"><input type="submit" value="提交" /></li>
<li class="l3">提示：如果您的预算跟卖家预期接近，系统会邮件提醒您</li>
</ul>
</form>
<? }?>
</div>
</body>
</html>