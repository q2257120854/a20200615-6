<?
include("../../config/conn.php");
include("../../config/function.php");
if($_SESSION["SHOPUSER"]!=""){php_toheader("../user/");}

//写入数据库开始
if($_GET[action]=="zh"){
 zwzr();
 $sj=date("Y-m-d H:i:s");
 $uip=$_SERVER["REMOTE_ADDR"];
 $WAPLJ=1;
 include("../../tem/uc/reg.php");
 $uid=sqlzhuru(trim($_POST[t1]));
 $pwd=sqlzhuru($_POST[t2]);
 $nc=$uid;
 $email=$uid."@qq.com";
 include("../../reg/reg_tem.php");
 include("../../tem/uc/reg1.php");
 php_toheader(returnjgdw($_SESSION["tzURL"],"","../user/"));

}elseif($_GET[action]=="mot"){
 zwzr();
 $WAPLJ=1;
 $mot=sqlzhuru($_POST[tmot]);
 $ifmot=1;
 if(panduan("*","yjcode_yzm where tit='".$mot."' and yzm='".sqlzhuru($_POST[tyzm])."' and admin=1")==0){Audit_alert("验证码不正确","reg.php");}
 if(panduan("mot,ifmot","yjcode_user where (mot='".$mot."' and ifmot=1) or uid='".$mot."'")==1){Audit_alert("该手机号码已被使用","reg.php");}
 $sj=date("Y-m-d H:i:s");
 $uip=$_SERVER["REMOTE_ADDR"];
 $uid=$mot;
 $pwd=sqlzhuru($_POST[tpwd]);
 $nc=$mot;
 $WAPLJ=1;
 include("../../tem/uc/reg.php");
 $email=$uid."@qq.com";
 include("../../reg/reg_tem.php");
 include("../../tem/uc/reg1.php");
 deletetable("yjcode_yzm where tit='".$mot."' and admin=1");
 php_toheader(returnjgdw($_SESSION["tzURL"],"","../user/"));

}
//写入数据库结束

?>
<!DOCTYPE html>
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="viewport" content="initial-scale=1, width=device-width, maximum-scale=1, user-scalable=no" />
<title>会员注册 - 手机版<?=webname?></title>
<? include("../tem/cssjs.html");?>
<script language="javascript">
function reg1(){
if((document.f1.t1.value).replace(/\s/,"")==""){layerts("请输入会员账号");return false;}
if((document.f1.t2.value).replace(/\s/,"")==""){layerts("请设置密码");return false;}
if(document.f1.t2.value!=document.f1.t3.value){layerts("两次输入密码不一致");return false;}
layer.open({type: 2,content: '正在注册',shadeClose:false});
f1.action="reg.php?action=zh";
}

function reg(){
mobile=document.getElementById("tmot").value;
var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(16[0-9]{1})|(17[0-9]{1})|(18[0-9]{1})|(19[0-9]{1}))+\d{8})$/; 
if(!myreg.test(mobile)){layerts("手机号码格式有误");return false;}
if(mobile.replace(/\s/,"")==""){layerts("手机号码格式有误");return false;}
if((document.f2.tyzm.value).replace(/\s/,"")==""){layerts("请输入收到的验证码");return false;}
if((document.f2.tpwd.value).replace(/\s/,"")==""){layerts("请设置密码");return false;}
layer.open({type: 2,content: '正在注册',shadeClose:false});
f2.action="reg.php?action=mot";
}
//发送开始
var sz;
function yzonc(){
 objhtml("sjzouv",60);
 objdis("fsid1","none");objdis("fsid2","");
 sz=setInterval("sjzou()",1000);
 $.get("motregchk.php",{mob:document.getElementById("tmot").value},function(result){
  if(result=="True"){huifu();layerts("手机号码已被注册，请更换");}
  else if(result=="err1"){huifu();layerts("手机号码格式错误");}
 });
}
function sjzou(){
 miao=parseInt(document.getElementById("sjzouv").innerHTML);
 if(miao<=0){huifu();}else{document.getElementById("sjzouv").innerHTML=miao-1;}
}
function objdis(x,y){
document.getElementById(x).style.display=y;
}
function objhtml(x,y){
document.getElementById(x).innerHTML=y;
}
function huifu(){
clearInterval(sz);objdis("fsid1","");objdis("fsid2","none");objhtml("sjzouv",60);
}
function regtyonc(x){
for(i=1;i<=2;i++){
document.getElementById("regty"+i).className="d1";
document.getElementById("regm"+i).style.display="none";
}
document.getElementById("regty"+x).className="d1 d11";
document.getElementById("regm"+x).style.display="";
}
</script>
</head>
<body>

<!--内页头部B-->
<div class="ntop box">
 <div class="d1" onClick="javascript:history.back(-1)"><img src="../img/back-vector.png" height="20" /></div>
 <div class="d2">注册账号</div>
 <div class="d3"></div>
</div>
<!--内页头部E-->


<div class="regty box">
 <div class="d1 d11" onClick="regtyonc(1)" id="regty1">常规方式注册</div>
 <div class="d1" onClick="regtyonc(2)" id="regty2">手机短信注册</div>
</div>

<div class="reg" id="regm1">
<form name="f1" method="post" onSubmit="return reg1()">

 <div class="inpbox box">
  <div class="d1"><input type="text" value="" placeholder="请输入注册账号" name="t1" /></div>
 </div>

 <div class="inpbox box">
  <div class="d1"><input type="text" onFocus="this.type='password';this.select();" placeholder="请设置密码" name="t2" /></div>
 </div>

 <div class="inpbox box">
  <div class="d1"><input type="text" onFocus="this.type='password';this.select();" placeholder="请再次输入密码" name="t3" /></div>
 </div>

 <div class="regbtn box">
  <div class="d1"><input type="submit" class="tjinput" value="提交注册" /></div>
 </div>
 
</form>
</div>

<div class="reg" id="regm2" style="display:none;">
<form name="f2" method="post" onSubmit="return reg()">

 <div class="inpbox box">
  <div class="d1"><input type="text" id="tmot" placeholder="输入手机号" name="tmot" /></div>
  <div class="d2">
   <div id="fsid1" onClick="javascript:yzonc();">发送验证码</div>
   <div id="fsid2" style="display:none;">(<span id="sjzouv">60</span>)重新获取</div>
  </div>
 </div>

 <div class="inpbox box">
  <div class="d1"><input type="text" value="" placeholder="请输入短信验证码" name="tyzm" id="tyzm" /></div>
 </div>
 
 <div class="inpbox box">
  <div class="d1"><input type="text" onFocus="this.type='password';this.select();" placeholder="请设置密码" name="tpwd" id="tpwd" /></div>
 </div>

 <div class="regbtn box">
  <div class="d1"><input type="submit" class="tjinput" value="提交注册" /></div>
 </div>

</form>
</div>

<div class="qh">
<? if($rowcontrol[ifmob]=="on"){?><a href="index1.php">手机快捷登录</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;<? }?>
<a href="index.php">账号密码登录</a>
</div>

<? include("../tem/moban/".$rowcontrol[wapmb]."/tem/bottom.php");?>
</body>
</html>
