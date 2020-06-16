<?
include("../../config/conn.php");
include("../../config/function.php");
sesCheck_m();

$sqluser="select * from yjcode_user where uid='".$_SESSION[SHOPUSER]."' and ifemail=1";mysql_query("SET NAMES 'GBK'");$resuser=mysql_query($sqluser);
if(!$rowuser=mysql_fetch_array($resuser)){Audit_alert("您未绑定邮箱，请先进行绑定","emailbd.php");}

if(sqlzhuru($_POST[jvs])=="zf"){
 zwzr();
 if(empty($_POST[t1])){Audit_alert("验证码有误！","zfmm.php");}
 if(panduan("uid,getpwd","yjcode_user where getpwd='".sqlzhuru($_POST[t1])."' and uid='".$_SESSION[SHOPUSER]."'")==0){Audit_alert("验证码有误！","zfmm.php");}
 $zfmm=sha1(sqlzhuru($_POST[tzfmm]));
 updatetable("yjcode_user","zfmm='".$zfmm."',getpwd='' where uid='".$_SESSION[SHOPUSER]."'");
 php_toheader("../tishi/index.php?admin=2"); 

}


?>
<html>
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
<title>会员中心 <?=webname?></title>
<link rel="stylesheet" href="../css/basic.css">
<link rel="stylesheet" href="index.css">
<script src="../js/jquery-1.9.1.min.js" type="text/javascript"></script>
<script language="javascript" src="../js/basic.js"></script>
<script language="javascript" src="../js/layer.js"></script>
<script language="javascript" src="index.js"></script>
<script language="javascript">
function tj(){
 if((document.f1.tzfmm.value).replace("/\s/","")==""){alert("请输入新的安全码");document.f1.tzfmm.focus();return false;}
 if((document.f1.t1.value).replace("/\s/","")==""){alert("请输入验证码");document.f1.t1.focus();return false;}
 layer.open({type: 2,content: '正在提交',shadeClose:false});
 f1.action="zfmm.php";
}


//发送开始
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
    response = xmlHttp.responseText;
	response=response.replace(/[\r\n]/g,'');
	if(response=="err"){clearInterval(sz);document.getElementById("sjzouv").innerHTML=120;document.getElementById("fsid1").style.display="none";document.getElementById("fsid2").style.display="";alert("请先绑定邮箱");return false;}
   else{sz=setInterval("sjzou()",1000);return false;}
  }
}


function yzonc(){
 document.getElementById("sjzouv").innerHTML=120;
 document.getElementById("fsid1").style.display=""; 
 document.getElementById("fsid2").style.display="none"; 
 var url = "../../user/mobtx.php";
 xmlHttp.open("post", url, true);
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

</script>

</head>
<body>
<? include("top.php");?>

<div class="boxcap box">
 <div class="d1"><a href="../">用户中心</a> - 支付密码</div>
</div>

 <form name="f1" method="post" onSubmit="return tj()">
 <input type="hidden" value="zf" name="jvs" />
<div class="uk box">
 <div class="d1">新 密 码<span class="s1"></span></div>
 <div class="d2"><input type="password" name="tzfmm" class="inp" placeholder="请输入新支付密码" /></div>
</div>
<div class="uk box">
 <div class="d1">验 证 码<span class="s1"></span></div>
 <div class="d2"><input type="password" name="t1" class="inp" placeholder="请输入邮箱验证码" /></div>
</div>
 <div class="tishi box"><div class="d1">您当前绑定的邮箱是<?=$rowuser[email]?>，【<a href="emailbd.php" class="feng">修改邮箱</a>】</div></div>
 <div class="tishi box" id="fsid1" style="display:none;"><div class="d1">发送中……(<span id="sjzouv" class="red">120</span>秒)</div></div>
 <div class="tishi box" id="fsid2"><div class="d1"><strong>[<a href="#" onClick="javascript:yzonc();" class="red">发送验证码</a>]</strong></div></div>
 
<div class="fbbtn box">
 <div class="d1"><? tjbtnr_m("提交")?></div>
</div>
 </form>

<? include("bottom.php");?>
</body>
</html>