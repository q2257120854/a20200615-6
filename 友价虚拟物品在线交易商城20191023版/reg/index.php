<?
include("../config/conn.php");
include("../config/function.php");
if($_SESSION["SHOPUSER"]!=""){php_toheader("../user/");}

//登录验证开始
if($_GET[action]=="login" && sqlzhuru($_POST[jvs])=="login"){
 zwzr();
 include("../tem/uc/login.php");
 $uid=sqlzhuru($_POST[t1]);$pwd=sqlzhuru($_POST[t2]);
 include("login_tem.php");
 php_toheader(returnjgdw($_SESSION["tzURL"],"","../user/"));

}elseif($_GET[action]=="mot" && sqlzhuru($_POST[jvs])=="mot"){
 zwzr();
 $mot=sqlzhuru($_POST[mot]);
 while0("*","yjcode_yzm where tit='".$mot."' and yzm='".sqlzhuru($_POST[yzm])."' and admin=2");if(!$row=mysql_fetch_array($res)){Audit_alert("短信验证码输入有误，返回重试","index.php");}
 deletetable("yjcode_yzm where tit='".$mot."'");
 $sj=getsj();
 $uip=getuip();
 while1("*","yjcode_user where mot='".$mot."' and ifmot=1");if($row1=mysql_fetch_array($res1)){
  if(0==$row1[zt]){Audit_alert("您的帐号已被禁用，请联系网站客服处理","./");}
  $uid=$row1[uid];
  $pwd1=$row1[pwd];
  $userid=$row1[id];
 }else{
  $bh=time();
  $uid="mot".$bh.rnd_num(300);
  $pwd="123456";
  $ifmot=1;
  $nc=$mot;
  $email=$uid."@qq.com";
  include("reg_tem.php");
  $pwd1=sha1($pwd);
 }
 intotable("yjcode_loginlog","admin,userid,sj,uip","1,".$userid.",'".$sj."','".$uip."'");
 $_SESSION["SHOPUSER"]=$uid;
 $_SESSION["SHOPUSERPWD"]=$pwd1;
 php_toheader(returnjgdw($_SESSION["tzURL"],"","../user/"));

}
//登录验证结束

?>
<html>
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>会员登录 - <?=webname?></title>
<? include("../tem/cssjs.html");?>
<? if(check_in("https:",weburl)){$nh="https";}else{$nh="http";}?>
<script src="<?=$nh?>://res.wx.qq.com/connect/zh_CN/htmledition/js/wxLogin.js"></script>
<script language="javascript">
var sz;
var xmlHttp = false;
try {
  xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
} catch (e) {
  try {
    xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
  } catch (e2) {
    xmlHttp = false;
  }
}
if (!xmlHttp && typeof XMLHttpRequest != 'undefined') {
  xmlHttp = new XMLHttpRequest();
}


function updatePage() {
  if (xmlHttp.readyState == 4) {
    var response = xmlHttp.responseText;
	response=response.replace(/[\r\n]/g,'');
	mottsv("","");
	if(response=="True"){
		mottsv("该号码在本站未绑定","dts");document.getElementById("fs1").style.display="";document.getElementById("fs2").style.display="none";return false;
	}else if(response=="err1"){
		mottsv("请输入正确的图形验证码","dts");document.getElementById("fs1").style.display="";document.getElementById("fs2").style.display="none";return false;
	}else{
		sz=setInterval("sjzou()",1000);return false;
	}
  }
}

function yzonc(){
 if((document.getElementById("mot").value).replace("/\s/","")==""){mottsv("请输入手机号码","dts");document.getElementById("mot").focus();return false;}
 if((document.getElementById("picyzm").value).replace("/\s/","")==""){mottsv("请输入图形验证码","dts");document.getElementById("picyzm").focus();return false;}
 document.getElementById("sjzouv").innerHTML=120;
 document.getElementById("fs1").style.display="none";
 document.getElementById("fs2").style.display="";
 var url = "regchk.php?mob="+document.getElementById("mot").value+"&tpicyzm="+document.getElementById("picyzm").value;
 xmlHttp.open("post", url, true);
 xmlHttp.onreadystatechange = updatePage;
 xmlHttp.send(null);
}

function sjzou(){
 s=parseInt(document.getElementById("sjzouv").innerHTML);
 if(s<=0){
  clearInterval(sz);
  document.getElementById("sjzouv").innerHTML=120;
  document.getElementById("fs1").style.display="";
  document.getElementById("fs2").style.display="none";
  return false;
 }else{document.getElementById("sjzouv").innerHTML=s-1;}
}

function mottsv(x,y){
 document.getElementById("motts").innerHTML=x;
 document.getElementById("motts").className=y;
}

function mottj(){
if((document.getElementById("mot").value).replace("/\s/","")==""){mottsv("请输入手机号码","dts");document.getElementById("mot").focus();return false;}
if((document.getElementById("picyzm").value).replace("/\s/","")==""){mottsv("请输入图形验证码","dts");document.getElementById("picyzm").focus();return false;}
if((document.getElementById("yzm").value).replace("/\s/","")==""){mottsv("请输入短信验证码","dts");document.getElementById("yzm").focus();return false;}
document.getElementById("tjbtn1").style.display="none";
document.getElementById("tjing1").style.display="";	
f2.action="index.php?action=mot";
}
</script>
</head>
<body>
<? include("../tem/top.html");?>
<? include("../tem/top1.html");?>

<? while1("*","yjcode_ad where adbh='ADO01' and zt=0 order by xh asc");if($row1=mysql_fetch_array($res1)){$a="../".returnjgdw($rowcontrol[addir],"","gg")."/".$row1[bh].".".$row1[jpggif];}?>
<div class="bfb loginbfb" style="background:url(<?=$a?>) center center no-repeat;">
<div class="yjcode">

<div class="loginright fontyh">
 
 <?
 if($rowcontrol[wxlogin]!="" && $rowcontrol[wxlogin]!="," && $rowcontrol[ifmob]=="off"){
 $c=" cap2";
 }elseif(($rowcontrol[wxlogin]=="" || $rowcontrol[wxlogin]==",") && $rowcontrol[ifmob]=="on"){
 $c=" cap2";
 }elseif(($rowcontrol[wxlogin]=="" || $rowcontrol[wxlogin]==",") && $rowcontrol[ifmob]=="off"){
 $c=" ";
 }else{
 $c=" cap3";
 }
 ?>
 <div class="cap<?=$c?>">
 <a class="a1" href="javascript:void(0);" onClick="caponc(1)" id="cap1">常规登录</a>
 <? if($rowcontrol[wxlogin]!="" && $rowcontrol[wxlogin]!=","){?><a class="a2" href="javascript:void(0);" onClick="caponc(3)" id="cap3">微信扫码</a><? }?>
 <? if($rowcontrol[ifmob]=="on"){?><a class="a2" href="javascript:void(0);" onClick="caponc(2)" id="cap2">短信登录</a><? }?>
 </div>
 <div id="loginmod1">
 <form name="f1" method="post" onSubmit="return login()">
 <div id="ts"></div>
 <ul class="u1">
 <li class="l1"><input autocomplete="off" disableautocomplete type="text" class="inp inp1" name="t1"></li>
 <li class="l1"><input autocomplete="off" disableautocomplete type="password" class="inp inp2" name="t2"></li>
 <li class="l2"><input id="tjbtn" type="submit" value="登 录"><div id="tjing" style="display:none;"><img src="../img/ajax_loader.gif" /><br>正在登录，请稍候……</div></li>
 </ul>
 <input type="hidden" value="login" name="jvs" />
 </form>
 </div>
 
  <div id="loginmod3" style="display:none;">
   <div id="wxlogin"></div>
  <? $wxlogin=preg_split("/,/",$rowcontrol[wxlogin]);?>
  <script language="javascript">
  var obj = new WxLogin({
  id:"wxlogin", 
  appid: "<?=$wxlogin[0]?>", 
  scope: "snsapi_login", 
  redirect_uri: "<?=weburl?>reg/wxlogin.php",
  state: "",
  style: "",
  href: ""
  });
  </script>
  </div>
 
 <div id="loginmod2" style="display:none;">
 <form name="f2" method="post" onSubmit="return mottj()">
 <div id="motts"></div>
 <ul class="u1">
 <li class="l1"><input autocomplete="off" disableautocomplete type="text" class="inp inp3" id="mot" name="mot" /></li>
 <li class="l1">
 <input autocomplete="off" disableautocomplete type="text" class="inp inp0 inp4" id="picyzm" name="picyzm" />
 <img src="../config/getYZM.php" height="34" width="106" />
 </li>
 <li class="l1">
 <input autocomplete="off" disableautocomplete type="text" class="inp inp0 inp5" id="yzm" name="yzm" />
 <a href="javascript:void(0);" class="a1" id="fs1" onClick="yzonc()">获取验证码</a>
 <a href="javascript:void(0);" class="a2" id="fs2" style="display:none;"><span id="sjzouv">120</span>秒后重发</a>
 </li>
 <li class="l2">
 <input type="submit" id="tjbtn1" value="登 录"><div id="tjing1" style="display:none;"><img src="../img/ajax_loader.gif" /><br>正在登录，请稍候……</div>
 </li>
 </ul>
 <input type="hidden" value="mot" name="jvs" />
 </form>
 </div>
 
 <div class="d1" id="ksd1">
 <? if(!empty($rowcontrol[qqappid])){?>
 <a href="../config/qq/oauth/index.php" target="_blank">QQ登录</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 <? }?>
 <a href="reg.php">免费注册</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 <a href="getmm.php">忘记密码？</a>
 </div>

</div>

</div>
</div>

<script language="javascript">
<? if($_GET[lx]=="mot"){?>
caponc(2);
<? }?>
</script>

<? include("../tem/bottom.html");?>
</body>
</html>