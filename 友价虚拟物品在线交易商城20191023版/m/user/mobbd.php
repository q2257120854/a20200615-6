<?
include("../../config/conn.php");
include("../../config/function.php");
sesCheck_m();

$qzmotweb=1;

if($_GET[control]=="bd"){
 zwzr();
 if(panduan("uid,mot,ifmot","yjcode_user where mot='".$_GET[mob]."' and ifmot=1")==1){Audit_alert("绑定失败，该号码已经被绑定过","mobbd.php");}
 if(empty($_GET[yz])){Audit_alert("验证码有误！","mobbd.php");}
 if(panduan("uid,mot,ifmot,bdmot","yjcode_user where mot='".$_GET[mob]."' and bdmot='".$_GET[yz]."' and uid='".$_SESSION[SHOPUSER]."'")==0){
 Audit_alert("验证码输入有误，请重新绑定","mobbd.php");
 }
 updatetable("yjcode_user","mot='".$_GET[mob]."',ifmot=1,bdmot='' where uid='".$_SESSION[SHOPUSER]."'");
 php_toheader("mobbd.php?t=suc"); 

}elseif($_GET[control]=="delbd"){
 if(panduan("uid,bdmot","yjcode_user where bdmot='".$_GET[yz]."' and uid='".$_SESSION[SHOPUSER]."'")==0){
 Audit_alert("验证码输入有误，请重新提交","mobbd.php");
 }
 $sqluser="select id,mot from yjcode_user where uid='".$_SESSION[SHOPUSER]."'";mysql_query("SET NAMES 'GBK'");$resuser=mysql_query($sqluser);
 $rowuser=mysql_fetch_array($resuser);
 updatetable("yjcode_user","jbmot='".$rowuser[mot]."',mot='',ifmot=0,bdmot='' where id=".$rowuser[id]);
 php_toheader("mobbd.php"); 

}


$sqluser="select uid,mot,ifmot from yjcode_user where uid='".$_SESSION[SHOPUSER]."'";mysql_query("SET NAMES 'GBK'");$resuser=mysql_query($sqluser);
if(!$rowuser=mysql_fetch_array($resuser)){php_toheader("un.php");}

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
//绑定开始
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
	if(response=="True"){alert("该号码已经被绑定，请更换");document.getElementById("uk1").style.display="";document.getElementById("uk2").style.display="none";return false;	}
	else if(response=="err1"){alert("图形验证码不正确");location.reload();return false;}
	else{sz=setInterval("sjzou()",1000);return false;}
  }
}

function yzonc(){
 if((document.getElementById("t1").value).replace("/\s/","")==""){alert("请输入手机号码");document.getElementById("t1").focus();return false;}
 if((document.getElementById("tyzm").value).replace("/\s/","")==""){alert("请输入验证码");document.getElementById("tyzm").focus();return false;}
 document.getElementById("sjzouv").innerHTML=120;
 document.getElementById("uk1").style.display="none";
 document.getElementById("uk2").style.display="";
 document.getElementById("fsid1").style.display=""; 
 document.getElementById("fsid2").style.display="none"; 
 var url = "../../user/mobchk.php?mob="+document.getElementById("t1").value+"&yzm="+document.getElementById("tyzm").value;
 xmlHttp.open("get", url, true);
 xmlHttp.onreadystatechange = updatePage;
 xmlHttp.send(null);
}

function sjzou(){
 s=parseInt(document.getElementById("sjzouv").innerHTML);
 if(s<=0){
  clearInterval(sz);
  document.getElementById("fsid1").style.display="none"; 
  document.getElementById("fsid2").style.display=""; 
  return false;
 }else{document.getElementById("sjzouv").innerHTML=s-1;}
}

function bd(){
 if((document.getElementById("t2").value).replace("/\s/","")==""){alert("请输入验证码");document.getElementById("t2").focus();return false;}
 location.href="mobbd.php?control=bd&yz="+document.getElementById("t2").value+"&mob="+document.getElementById("t1").value;
}

//解绑开始
var delsz;
var delxmlHttp = false;
try {
  delxmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
} catch (e) {
  try {
    delxmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
  } catch (e2) {
    delxmlHttp = false;
  }
}
if (!delxmlHttp && typeof XMLHttpRequest != 'undefined') {
  delxmlHttp = new XMLHttpRequest();
}


function delupdatePage() {
  if (delxmlHttp.readyState == 4) {
    response = delxmlHttp.responseText;
	response=response.replace(/[\r\n]/g,'');
	if(response=="err1"){alert("图形验证码不正确");location.reload();return false;}
	delsz=setInterval("delsjzou()",1000);
  }
}

function delbd(){
 if((document.getElementById("tyzm").value).replace("/\s/","")==""){alert("请输入验证码");document.getElementById("tyzm").focus();return false;}
 if(!confirm("确定要解除该手机号码的绑定吗？")){return false;}
 document.getElementById("delsjzouv").innerHTML=120;
 document.getElementById("uk3").style.display="none";
 document.getElementById("uk4").style.display="";
 document.getElementById("fsid3").style.display=""; 
 document.getElementById("fsid4").style.display="none"; 
 var url = "../../user/mobchkdel.php?yzm="+document.getElementById("tyzm").value;
 delxmlHttp.open("post", url, true);
 delxmlHttp.onreadystatechange = delupdatePage;
 delxmlHttp.send(null);
}

function delsjzou(){
 s=parseInt(document.getElementById("delsjzouv").innerHTML);
 if(s<=0){
  clearInterval(delsz);
  document.getElementById("fsid3").style.display="none"; 
  document.getElementById("fsid4").style.display=""; 
  return false;
 }else{document.getElementById("delsjzouv").innerHTML=s-1;}
}

function deltj(){
 if((document.getElementById("t4").value).replace("/\s/","")==""){alert("请输入验证码");document.getElementById("t4").focus();return false;}
 location.href="mobbd.php?control=delbd&yz="+document.getElementById("t4").value;
}

</script>

</head>
<body>
<? include("topuser.php");?>

<div class="bfbtop1 box">
 <div class="d1" onClick="javascript:window.history.go(-1);"><img src="img/topleft.png" height="21" /></div>
 <div class="d2">手机绑定</div>
 <div class="d3"></div>
</div>

 <? if(1==$rowuser[ifmot]){?>
 <div id="uk3">
  <div class="tishi box blue"><div class="d1">已绑定手机：<strong><?=$rowuser["mot"]?></strong></div></div>
  <div class="uk box">
   <div class="d1">验 证 码<span class="s1"></span></div>
   <div class="d2"><input type="text" name="tyzm" id="tyzm" class="inp" placeholder="请输入图形验证码" /></div>
   <div class="d2" style="margin-top:5px;"><img src="../../config/getYZM.php" width="88" /></div>
  </div>
  <div class="fbbtn box">
   <div class="d1"><input type="button" class="tjinput" onClick="delbd()" value="解除手机绑定" /></div>
  </div>
 </div>

 <div id="uk4" style="display:none;">
  <div class="tishi box blue"><div class="d1">如果您的原手机号码已经丢失，请联系网站客服处理。</div></div>
  <div class="uk box">
   <div class="d1">验 证 码<span class="s1"></span></div>
   <div class="d2"><input class="inp" type="text" name="t4" id="t4" placeholder="请输入验证码" /></div>
  </div>
  <div class="tishi box" id="fsid3"><div class="d1">请查看<?=$rowuser[mot]?>手机短信,发送中……(<span id="delsjzouv" class="red">120</span>秒后重发)</div></div>
  <div class="tishi box" id="fsid4" style="display:none;"><div class="d1">[<a href="#" onClick="javascript:delbd();">重新发送</a>]</div></div>
  <div class="fbbtn box">
   <div class="d1"><input type="button" class="tjinput" onClick="deltj()" value="下一步" /></div>
  </div>
 </div>
 
 <? }else{?>
 <div id="uk1">
  <div class="uk box">
   <div class="d1">手机号码<span class="s1"></span></div>
   <div class="d2"><input type="text" class="inp" name="t1" id="t1" value="<?=$rowuser[mot]?>" placeholder="请输入手机号码" /></div>
  </div>
  <div class="uk box">
   <div class="d1">验 证 码<span class="s1"></span></div>
   <div class="d2"><input type="text" name="tyzm" id="tyzm" class="inp" placeholder="请输入图形验证码" /></div>
   <div class="d2" style="margin-top:5px;"><img src="../../config/getYZM.php" width="88" /></div>
  </div>
  <div class="fbbtn box">
   <div class="d1"><input type="button" class="tjinput" onClick="yzonc()" value="下一步" /></div>
  </div>
 </div>

 <div id="uk2" style="display:none;">
  <div class="uk box">
   <div class="d1">验 证 码<span class="s1"></span></div>
   <div class="d2"><input type="text" name="t2" id="t2" class="inp" placeholder="请输入验证码" /></div>
  </div>
  <div class="tishi box" id="fsid1"><div class="d1">发送中……(<span id="sjzouv" class="red">120</span>秒后重发)</div></div>
  <div class="tishi box" id="fsid2" style="display:none;"><div class="d1">[<a href="#" onClick="javascript:yzonc();">重新发送</a>]</div></div>
  <div class="fbbtn box">
   <div class="d1"><input type="button" class="tjinput" onClick="bd()" value="绑定手机" /></div>
  </div>
 </div>
 
 <? }?>
 
 <div class="tishi box"><div class="d1">友情提示：由于安全软件的设置，短信有可能被手机安全软件拦截，如果没收到短信，请查看拦截设置。</div></div>

<? include("bottom.php");?>
<script language="javascript">
bottomjd(4);
</script>
</body>
</html>