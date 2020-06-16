<?
include("../config/conn.php");
include("../config/function.php");
$id=$_GET[id];
$sj=date("Y-m-d H:i:s");
while0("*","yj_domain_pro where zt=1 and jyfs=2 and id=".$id);if(!$row=mysql_fetch_array($res)){php_toheader("../",".parent");}
$needbao=sprintf("%.2f",$row[money2]*$rowcontrol[paibao]);
$dqmoney=returnjgdw($row[money5],"",$row[money2]);
if(empty($_SESSION[DOMAINUSER])){php_toheader("../",".parent");}
$userid=returnuserid($_SESSION[DOMAINUSER]);
if($userid==$row[userid]){Audit_alert("请勿参与自身域名的竞拍","view".$id.".html",".parent");}

$sqluser="select * from yj_domain_user where id=".$userid;mysql_query("SET NAMES 'utf8'");$resuser=mysql_query($sqluser);
if(!$rowuser=mysql_fetch_array($resuser)){php_toheader("../",".parent");}

//$pzt1 1表示未参与过 2表示已经参与
//$pzt2 1表示冻结保证金余额不足
while1("*","yj_domain_paimai where probh='".$row[bh]."' and userid=".$userid."");if(!$row1=mysql_fetch_array($res1)){
$pzt1=1;
if($needbao>$rowuser[money1]){$pzt2=1;}else{$pzt2=2;}
}else{
$pzt1=2;
}

//处理开始
if($_GET[control]=="pai"){
 $baoj=sqlzhuru($_POST[t1]);
 if($baoj<$row[money3]+$dqmoney){Audit_alert("报价低于最低加价额","pai.php?id=".$id);}	
 
 if($pzt1==1 && $pzt2==2){ //未参与过，余额足够
 $m=$needbao*(-1);
 PointUpdateM($userid,$m);
 PointIntoM($userid,"参与竞拍".$row[tit]."，缴纳保证金",$m,"系统",3);
 updatetable("yj_domain_pro","money5=".$baoj." where id=".$id);
 intotable("yj_domain_paimai","probh,selluserid,userid,sj,baomoney,zt","'".$row[bh]."',".$row[userid].",".$userid.",'".$sj."',".$needbao.",1");
 intotable("yj_domain_paimailog","probh,selluserid,userid,sj,money1","'".$row[bh]."',".$row[userid].",".$userid.",'".$sj."',".$baoj."");
 
 }elseif($pzt1==2){
 updatetable("yj_domain_pro","money5=".$baoj." where id=".$id);
 intotable("yj_domain_paimailog","probh,selluserid,userid,sj,money1","'".$row[bh]."',".$row[userid].",".$userid.",'".$sj."',".$baoj."");
 
 }else{Audit_alert("来源错误，请重试","pai.php?id=".$id);}
  
 php_toheader("pai.php?id=".$id."&t=suc");
  
}
//处理结束
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
.paim{float:left;width:320px;height:270px;border:#F8F8F8 solid 1px;padding:10px;text-align:left;}
.paim .clo{float:left;width:320px;text-align:right;}
.paim .clo img{cursor:pointer;}
.paim .u1{float:left;width:300px;margin:0 10px;}
.paim .u1 li{float:left;}
.paim .u1 .l1{width:100px;padding:5px 20px 0 0;height:35px;text-align:right;font-size:14px;}
.paim .u1 .l21{width:180px;padding:5px 0 0 0;height:35px;font-size:14px;}
.paim .u1 .l2{width:180px;height:40px;}
.paim .u1 .l2 input{float:left;width:180px;border:#ddd solid 1px;height:30px;font-weight:700;font-size:14px;padding:0 0 0 3px;color:#006FC7;}
.paim .u1 .lbtn{width:300px;}
.paim .u1 .lbtn input{float:left;width:300px;height:40px;font-size:14px;background-color:#ff6600;color:#fff;border:0;margin:10px 0 0 0;cursor:pointer;}
.paim .u1 .lbtn input:hover{background-color:#F76E13;}
.paim .ts{float:left;text-align:center;padding:140px 0 0 0;margin:25px 0 0 0;font-size:16px;font-weight:700;background:url(../img/suc.jpg) center top no-repeat;width:320px;}
</style>
<script language="javascript">
function tj(){
v=document.f1.t1.value;
if(v.length == 0 || v.indexOf(" ")>=0 || isNaN(v)){alert("请输入有效报价！");document.f1.t1.focus();return false;}
if(v<<?=$row[money3]+$dqmoney?>){alert("请输入有效报价，不低于<?=$row[money3]+$dqmoney?>元！");document.f1.t1.focus();return false;}
if(!confirm("确认要提交该轮报价吗？")){return false;}
f1.action="pai.php?id=<?=$id?>&control=pai";
}
function clo(){
parent.location.reload();
}
</script>
</head>
<body>
<div class="paim">
<div class="clo"><img onClick="clo()" src="../img/clo.png" width="15" height="15" /></div>
<? if($_GET[t]=="suc"){?>
<div class="ts"><strong>出价成功，请继续关注竞拍结果</strong></div>
<? }else{?>

<form name="f1" method="post" onSubmit="return tj()">
<ul class="u1">
<li class="l1">域名当前出价：</li>
<li class="l21"><?=sprintf("%.2f",$dqmoney)?>元</li>
<li class="l1">最低加价幅度：</li>
<li class="l21"><?=sprintf("%.2f",$row[money3])?>元</li>

<? if($pzt1==1){?>
<li class="l1">需缴纳保证金：</li>
<li class="l21"><?=$needbao?>元</li>
<li class="l1">您的可用余额：</li>
<li class="l21"><?=sprintf("%.2f",$rowuser[money1])?>元</li>

<? if($pzt2==1){?>
<li class="l1">操作提示：</li>
<li class="l21">余额不足，请先【<a href="../user/pay.php" class="red" target="_blank">充值</a>】</li>
<? }?>

<?
}else{
while2("*","yj_domain_paimailog where probh='".$row[bh]."' and userid=".$userid." order by sj desc limit 1");if($row2=mysql_fetch_array($res2)){
$prom=$row2[money1];
$pros=$row2[sj];
}else{
$prom="未曾出价";
$pros="无";
}
?>
<li class="l1">您的上次出价：</li>
<li class="l21"><?=$prom?>元</li>
<li class="l1">上次出价时间：</li>
<li class="l21"><?=$pros?></li>

<? }?>

<? if(($pzt1==1 && $pzt2==2) || $pzt1==2){?>
<li class="l1">输入您的报价：</li>
<li class="l2"><input type="text" value="<?=$row[money3]+$dqmoney?>" name="t1" /></li>
<li class="lbtn"><input type="submit" value="提交报价" /></li>
<? }?>
</ul>
</form>

<? }?>

</div>
</body>
</html>