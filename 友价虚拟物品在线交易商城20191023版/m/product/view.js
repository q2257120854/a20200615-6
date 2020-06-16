function tctang(){
document.getElementById("tbuy").style.display="";
document.getElementById("cgbuy").style.display="none";
$("#taocandiv").animate({height:"400px"});
document.getElementById("zhezhao").style.display="block";
}
function tcclose(){
$("#taocandiv").animate({height:"0px"});
document.getElementById("tbuy").style.display="none";
document.getElementById("cgbuy").style.display="";
document.getElementById("zhezhao").style.display="none";
}

//套餐选择
var taocanid=0;
var taocant="";
var taocanid2=0;
var pretc1id=0;
function taocanonc(a,b,c,d,e,f,g,h){
 document.getElementById("nowkcnum").innerHTML=g;
 taocanid=e;
 taocanid2=0;
 taocant=h;
 document.getElementById("yxztc").innerHTML="已选择："+h;
 if(pretc1id!=0){if(document.getElementById("tc2div"+pretc1id)){document.getElementById("tc2div"+pretc1id).style.display="none";}}
 if(document.getElementById("tc2div"+e)){document.getElementById("tc2div"+e).style.display="";}
 pretc1id=e;
 tc2re(taocanid);
 document.getElementById('nowmoney').innerHTML=c;
 document.getElementById('tcmoney').innerHTML=c;
 document.getElementById("yuanjia").innerHTML="￥"+d+"元";
 for(i=1;i<=b;i++){
 document.getElementById("taocana"+i).className="taocan box";
 }
 document.getElementById("taocana"+a).className="a1";
 document.getElementById("zhekou").innerHTML=f+"折";
}
function taocan2onc(a,b,c,d,e,f,g,h){
 if(taocanid==0){alert("请先选择第一级套餐内容");return false;}
 document.getElementById("nowkcnum").innerHTML=g;
 taocanid2=e;
 document.getElementById("yxztc").innerHTML="已选择："+taocant+","+h;
 tc2re(taocanid);
 document.getElementById("nowmoney").innerHTML=c;
 document.getElementById("tcmoney").innerHTML=c;
 document.getElementById("yuanjia").innerHTML="￥"+d+"元";
 document.getElementById("taocan2a"+taocanid+"_"+a).className="a1";
 document.getElementById("zhekou").innerHTML=f+"折";
}
function tc2re(x){
if(document.getElementById("tc2num"+x)){
a=parseInt(document.getElementById("tc2num"+x).innerHTML);
for(i=1;i<=a;i++){
document.getElementById("taocan2a"+x+"_"+i).className="taocan box";
}
}
}

function shujia(){
 a=parseInt(document.getElementById("buynum").innerHTML);
 if(isNaN(a)){document.getElementById("buynum").innerHTML=1;a=1;}
 if(a<0){document.getElementById("buynum").innerHTML=1;}
 else{
 document.getElementById("buynum").innerHTML=a+1;
 }
 document.getElementById("yxzsl").innerHTML="数量："+document.getElementById("buynum").innerHTML+"件";
}

function shujian(){
 a=parseInt(document.getElementById("buynum").innerHTML);
 if(isNaN(a)){document.getElementById("buynum").innerHTML=1;a=1;}
 if(a<=1){document.getElementById("buynum").innerHTML=1;}
 else{
 document.getElementById("buynum").innerHTML=a-1;
 }
 document.getElementById("yxzsl").innerHTML="数量："+document.getElementById("buynum").innerHTML+"件";
}
