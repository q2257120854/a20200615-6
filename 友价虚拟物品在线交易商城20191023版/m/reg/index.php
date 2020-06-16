<?
include("../../config/conn.php");
include("../../config/function.php");
if($_SESSION["SHOPUSER"]!="" && $_SESSION["SHOPUSERPWD"]!=""){php_toheader("../user/");}
if(!empty($_GET[reurl])){$_SESSION["tzURL"]=$_GET[reurl];}

//登录验证开始
if($_GET[action]=="login" && sqlzhuru($_POST[yj])=="yjcode"){
 zwzr();
 $WAPLJ=1;
 include("../../tem/uc/login.php");
 $uid=sqlzhuru($_POST[t1]);$pwd=sqlzhuru($_POST[t2]);
 include("../../reg/login_tem.php");
 php_toheader(returnjgdw($_SESSION["tzURL"],"","../user/"));

}elseif($_GET[action]=="mian"){
 zwzr();
 $uqq=sqlzhuru($_POST[tqq1]);
 if(empty($uqq)){Audit_alert("QQ号码不得为空，返回重试","index.php");}
 $nc="免注册用户";
 $uid="mian".time().rnd_num(300);
 $pwd=MakePassAll(10);
 $email=$uqq."@qq.com";
 $WAPLJ=1;
 include("../../reg/reg_tem.php");
 
 if(!empty($rowcontrol[mailstr]) && $rowcontrol[mailstr]!=",,,"){
 require("../../config/mailphp/sendmail.php");
 $str="注册成功,以下是您的账号密码信息。<br>登录账号：".$uid."<br>登录密码：".$pwd."<br>登录地址：<a hre='".weburl."reg/'>".weburl."reg/"."</a><br>网站名称：".webname."<hr>该邮件为系统自动发出，请勿回复";
 yjsendmail(webname."注册成功",$email,$str,"../");
 }
 
 php_toheader(returnjgdw($_SESSION["tzURL"],"","../user/"));

}
//登录验证结束

?>
<html>
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="viewport" content="initial-scale=1, width=device-width, maximum-scale=1, user-scalable=no" />
<title>会员登录 - 手机版<?=webname?></title>
<? include("../tem/cssjs.html");?>
<script language="javascript">
function login(){
if((document.f1.t1.value).replace(/\s/,"")==""){layerts("输入会员账号/手机号码");return false;}
if((document.f1.t2.value).replace(/\s/,"")==""){layerts("请输入密码");return false;}
layer.open({type: 2,content: '正在验证',shadeClose:false});
f1.action="index.php?action=login";
}

function regtyonc(x){
for(i=0;i<=1;i++){
document.getElementById("regty"+i).className="d1";
document.getElementById("regm"+i).style.display="none";
}
document.getElementById("regty"+x).className="d1 d11";
document.getElementById("regm"+x).style.display="";
}

function maintj(){
if(document.f2.tqq1.value==""){layerts("请输入QQ号码");return false;}	
if(document.f2.tqq1.value!=document.f2.tqq2.value){layerts("两次输入的QQ号码不一致");return false;}	
layer.open({type: 2,content: '正在验证',shadeClose:false});
f2.action="index.php?action=mian";
}

</script>
</head>
<body>
<!--内页头部B-->
<div class="ntop box">
 <div class="d1" onClick="javascript:history.back(-1)"><img src="../img/back-vector.png" height="20" /></div>
 <div class="d2">会员登录</div>
 <div class="d3"></div>
</div>
<!--内页头部E-->

<div class="regty box">
 <div class="d1 d11" onClick="regtyonc(0)" id="regty0">常规方式登录</div>
 <div class="d1" onClick="regtyonc(1)" id="regty1">免登录购买</div>
</div>

<div id="regm0">
<form name="f1" method="post" onSubmit="return login()">
<input type="hidden" value="yjcode" name="yj" />
<div class="reg">

 <div class="inpbox box">
  <div class="d1"><input type="text" name="t1" placeholder="输入会员账号/手机号码" /></div>
 </div>
 
 <div class="inpbox box">
  <div class="d1"><input onFocus="this.type='password';this.select();" type="text" name="t2" placeholder="请输入密码" /></div>
 </div>

 <div class="regbtn box">
  <div class="d1"><input type="submit" class="tjinput" value="登录" /></div>
 </div>
 
</div>
</form>
</div>

<div id="regm1" style="display:none;">
<form name="f2" method="post" onSubmit="return maintj()">
<input type="hidden" value="mian" name="yj" />
<div class="reg">

 <div class="inpbox box">
  <div class="d1"><input type="text" name="tqq1" placeholder="输入您的QQ号码" /></div>
 </div>

 <div class="inpbox box">
  <div class="d1"><input type="text" name="tqq2" placeholder="再次输入您的QQ号码" /></div>
 </div>

 <div class="regbtn box">
  <div class="d1"><input type="submit" class="tjinput" value="登录" /></div>
 </div>
 
</div>
</form>
</div>

<script language="javascript">
regtyonc(<?=intval($rowcontrol[mrbuy])?>);
</script>

<div class="qh">
<a href="../../config/qq/oauth/index.php?tz=wap">QQ登录</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
<? if($rowcontrol[ifmob]=="on"){?>
<a href="index1.php">手机快捷登录</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
<? }?>
<?
$user_agent = $_SERVER['HTTP_USER_AGENT'];
if (strpos($user_agent, 'MicroMessenger') === false) {
}else{$wxpay=preg_split("/,/",$rowcontrol[wxpay]);
if(!empty($wxpay[0])){
?>
<a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid=<?=$wxpay[0]?>&redirect_uri=<?=urlencode(weburl."m/reg/wxlogin.php")?>&response_type=code&scope=snsapi_userinfo&connect_redirect=1#wechat_redirect">微信登录</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
<? }}?>
<a href="reg.php">免费注册会员</a>
</div>

<? include("../tem/moban/".$rowcontrol[wapmb]."/tem/bottom.php");?>
</body>
</html>