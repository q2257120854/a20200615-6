//这里是友价商城系统全局JS，
//不受模板影响，
//就是任何模板都可以或可能调用的一些通用样式，写在这里
//www.yj99.cn，请勿修改

//手机版判断
function is_mobile() {
  var regex_match = /(nokia|iphone|android|motorola|^mot-|softbank|foma|docomo|kddi|up.browser|up.link|htc|dopod|blazer|netfront|helio|hosin|huawei|novarra|CoolPad|webos|techfaith|palmsource|blackberry|alcatel|amoi|ktouch|nexian|samsung|^sam-|s[cg]h|^lge|ericsson|philips|sagem|wellcom|bunjalloo|maui|symbian|smartphone|midp|wap|phone|windows ce|iemobile|^spice|^bird|^zte-|longcos|pantech|gionee|^sie-|portalmmm|jigs browser|hiptop|^benq|haier|^lct|operas*mobi|opera*mini|320x320|240x320|176x220)/i;
  var u = navigator.userAgent;
  if (null == u) {
   return true;
  }
  var result = regex_match.exec(u);
  if (null == result) {
   return false
  } else {
   return true
  }
}

//头部登录验证
function userCheckses(){
$.get(document.getElementById("webhttp").innerHTML+"tem/sesCheck.php",{},function(result){
 if(result=="0"){
 document.getElementById("notlogin").style.display="";
 document.getElementById("yeslogin").style.display="none";
 return false;
 }else{
 r=result.split(" ");
 document.getElementById("yeslogin").style.display="";
 document.getElementById("notlogin").style.display="none";
 document.getElementById("yesuid").innerHTML=r[0];
 if(r[1]=="yes"){document.getElementById("dontqd").style.display="";document.getElementById("needqd").style.display="none";}
 else{document.getElementById("dontqd").style.display="none";document.getElementById("needqd").style.display="";}
 return false;
 }
});
}


//弹出QQ联系
function opentangqq(x){
layer.open({
  type: 2,
  shadeClose :true,
  area: ['320px', '170px'],
  title:["QQ联系","text-align:left"],
  skin: 'layui-layer-rim', //加上边框
  content:[document.getElementById("webhttp").innerHTML+'tem/tangqq.php?qq='+x, 'no'] 
});
}

//相加
function addNum(num1,num2){ //避免出现小数点多位的情况
var sq1,sq2,m;
try{sq1=num1.toString().split(".")[1].length;} catch(e){sq1=0;}
try{sq2=num2.toString().split(".")[1].length;} catch(e){sq2=0;}
m=Math.pow(10,Math.max(sq1,sq2));
return ( num1 * m + num2 * m ) / m;
}

//相乘
function accMul(arg1,arg2){
 var m=0,s1=arg1.toString(),s2=arg2.toString();
 try{m+=s1.split(".")[1].length}catch(e){}
 try{m+=s2.split(".")[1].length}catch(e){}
 return Number(s1.replace(".",""))*Number(s2.replace(".",""))/Math.pow(10,m);
}

//提交
function tjwait(){
document.getElementById("tjbtn").style.display="none";
document.getElementById("tjing").style.display="";	
}

//邮箱判断
function isEmail(str){//判断邮箱
var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/;
return reg.test(str);
}

//回到顶部
function gotoTop(acceleration,stime){acceleration=acceleration||0.1;stime=stime||10;var x1=0;var y1=0;var x2=0;var y2=0;var x3=0;var y3=0;if(document.documentElement){x1=document.documentElement.scrollLeft||0;y1=document.documentElement.scrollTop||0;}
if(document.body){x2=document.body.scrollLeft||0;y2=document.body.scrollTop||0;}
var x3=window.scrollX||0;var y3=window.scrollY||0;var x=Math.max(x1,Math.max(x2,x3));var y=Math.max(y1,Math.max(y2,y3));var speeding=1+ acceleration;window.scrollTo(Math.floor(x/speeding),Math.floor(y/speeding));if(x>0||y>0){var run="gotoTop("+ acceleration+", "+ stime+")";window.setTimeout(run,stime);}}

//对象DIS
function objdis(x,y){
 if(0==x){document.getElementById(y).style.display="none";}	
 else if(1==x){document.getElementById(y).style.display="";}	
}

//跳转
function gourl(x){
 location.href=x;
}

//全选
function xuan(){
 c2=document.getElementsByName("C2");
 c=document.getElementsByName("C1");
 if(c2[0].checked){
 for(i=0;i<c.length;i++){
 c[i].checked="checked";
 }
 }else{
 for(i=0;i<c.length;i++){
 c[i].checked=false;
 }
 }
}
function xuan1(){
 c21=document.getElementsByName("C21");
 c11=document.getElementsByName("C11");
 if(c21[0].checked){
 for(i=0;i<c11.length;i++){
 c11[i].checked="checked";
 }
 }else{
 for(i=0;i<c11.length;i++){
 c11[i].checked=false;
 }
 }
}

function textinto(x,y){
document.getElementById(x).value=y;	
}


//弹出登录窗口
function tclogin(){
layer.open({
  type: 2,
  area: ['650px', '425px'],
  title:false,
  skin: 'layui-layer-rim', //加上边框
  content:['../tem/openw.php', 'no'] 
});
}

//弹出举报窗口
function jbtang(x,y){
layer.open({
  type: 2,
  area: ['650px', '495px'],
  title:["举报窗口","text-align:left"],
  skin: 'layui-layer-rim', //加上边框
  content:['../tem/jubao.php?admin='+x+"&id="+y, 'no'] 
});
}
