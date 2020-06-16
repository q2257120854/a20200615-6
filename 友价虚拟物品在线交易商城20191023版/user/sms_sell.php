<?
include("../config/conn.php");
include("../config/function.php");
sesCheck();
$userid=returnuserid($_SESSION["SHOPUSER"]);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>用户管理面板 - <?=webname?></title>
<? include("cssjs.html");?>
</head>
<body>
<div class="smsmain">
 <span class="s1">您有订单数据正在同步中</span>
 <span id="s2">0%</span>
 <span class="s3">(请不要刷新或关闭页面)</span>
</div>
<? $i=1;while1("*","yjcode_smsmail where userid=".$userid." and tyid=1 order by id asc");while($row1=mysql_fetch_array($res1)){?>
<span id="smsid<?=$i?>" style="display:none"><?=$row1[id]?></span>
<? $i++;}?>
</body>

<script language="javascript">
var nowsms=1; //当前执行的顺序号
var allsms; //最大的SMS顺序号

allsms=<?=$i-1?>;
if(allsms<=0){
timeset();
}else{
userChecksms();
}


//SMSMAIL系统
function timeset(){
//parent.location.href="order.php";
parent.layer.closeAll();
}


function userChecksms(){
 url1 = "sms_sell_chk.php";
 $.get(url1,{id:document.getElementById("smsid"+nowsms).innerHTML},function(result){
 if(result!=""){
  a=parseInt(nowsms/allsms*100);
  document.getElementById("s2").innerHTML=a+"%";
  if(allsms>nowsms){nowsms=nowsms+1;setTimeout("userChecksms()",4000);}else{timeset();}
 }
 });
}

</script>

</html>