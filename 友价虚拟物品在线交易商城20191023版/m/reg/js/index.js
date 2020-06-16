//登录开始
function login(){
 if((document.f1.t1.value).replace(/\s/,"")==""){alert("请输入会员名！");document.f1.t1.focus();return false;}
 if((document.f1.t2.value).replace(/\s/,"")==""){alert("请输入密码！");document.f1.t2.focus();return false;}
 tjwait();
 f1.action="index.php?action=login";
}
//登录结束


//注册开始 
var ifuidok=0;
var ifpwd1ok=0;
var ifqqok=0;
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
   if(response=="True"){
   objdis("ts1","");objdis("imgts1","");
   objhtml("ts1","<font color=red>很遗憾，该帐号已存在</font>");
   objhtml("imgts1","<img src='../../img/err.png' />");
   }else if(response=="False"){
   objdis("ts1","none");objdis("imgts1","none");
   ifuidok=1;
   }
  }
}

function userCheck(){
ifuidok=0;
document.getElementById("imgts1").innerHTML="";
t1v =document.f1.t1.value;
re = /^[0-9a-z_]+$/gi;
if(t1v.length<4 || t1v.length>20 || !re.test(t1v)){
 objdis("ts1","");objdis("imgts1","");
 objhtml("ts1","<span class='red'>账号格式有误(4-20位字母、数字或下划线组合)</span>");
 objhtml("imgts1","<img src='../../img/err.png' />");
 return false;
}	
objhtml("ts1","用户名正在检测……");
var url = "../../reg/userCheck.php?uid="+t1v;
xmlHttp.open("get", url, true);
xmlHttp.onreadystatechange = updatePage;
xmlHttp.send(null);
}

function pwd1chk(){
ifpwd1ok=0;
t2v =document.f1.t2.value;
if(t2v.length<6 || t2v.length>20){
objdis("ts2","");objdis("imgts2","");
objhtml("ts2","<span class='red'>6-20个字母、数字、下划线的组合</span>");
objhtml("imgts2","<img src='../../img/err.png' />");
return false;
}else{
objdis("ts2","none");objdis("imgts2","none");ifpwd1ok=1;return false;
}
}

function qqCheck(){
ifqqok=0;
t6v =document.f1.t6.value;
if(t6v.replace(/\s/,"")==""){
objdis("ts6","");objdis("imgts6","");
objhtml("ts6","<span class='red'>请填写正确的联系QQ</span>");
objhtml("imgts6","<img src='../../img/err.png' />");
return false;
}else{objdis("ts6","none");objdis("imgts6","none");ifqqok=1;}
}

function yxCheck(){
ifyxok=0;
t7v =document.f1.t7.value;
if(t7v.replace(/\s/,"")=="" || !isEmail(t7v)){
objdis("ts7","");objdis("imgts7","");
objhtml("ts7","<span class='red'>请填写正确的邮箱</span>");
objhtml("imgts7","<img src='../../img/err.png' />");
return false;
}else{objdis("ts7","none");objdis("imgts7","none");ifyxok=1;}
}

function tj(){
if(0==ifuidok){userCheck();return false;}
if(0==ifpwd1ok){pwd1chk();return false;}
if(0==ifqqok){qqCheck();return false;}
if(0==ifyxok){yxCheck();return false;}
tjwait();
f1.action="reg.php?action=add";
}

function objdis(x,y){
document.getElementById(x).style.display=y;
}
function objhtml(x,y){
document.getElementById(x).innerHTML=y;
}
//注册结束

//邮箱判断
function isEmail(str){//判断邮箱
var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/;
return reg.test(str);
}
