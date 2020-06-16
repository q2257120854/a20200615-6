function motewmover(){
document.getElementById("motewm").style.display="";
}
function motewmout(){
document.getElementById("motewm").style.display="none";
}

//视频点击
function videodian(x,y){
videofr.location="../video/index.php?id="+x;
for(i=1;i<document.getElementById("videoall").innerHTML;i++){
document.getElementById("videoa"+i).className="";
}
document.getElementById("videoa"+y).className="a1";
}

function djmonc(){
layer.open({
  type:1,
  title: "不同会员等级享受优惠价格说明",
  closeBtn: 1,
  area: '302px',
  skin: 'layui-layer-nobg', //没有背景色
  shadeClose: true,
  content: $('#vipmoney')
});
}

//套餐选择
var taocanid=0;
var taocanid2=0;
var pretc1id=0;
function taocanonc(a,b,c,d,e,f,g,h){
 document.getElementById("utc1").className="utc";
 document.getElementById("nowkcnum").innerHTML=g;
 taocanid=e;
 taocanid2=0;
 if(pretc1id!=0){if(document.getElementById("tc2div"+pretc1id)){document.getElementById("tc2div"+pretc1id).style.display="none";}}
 if(document.getElementById("tc2div"+e)){document.getElementById("tc2div"+e).style.display="";}
 pretc1id=e;
 tc2re(taocanid);
 document.getElementById("nowmoney").innerHTML=c;
 document.getElementById("nowmoneyY").innerHTML=c;
 document.getElementById("yuanjia").innerHTML="￥"+d+"元";
 for(i=1;i<=b;i++){
 document.getElementById("taocana"+i).className="";
 }
 document.getElementById("taocana"+a).className="a1";
 document.getElementById("zhekou").innerHTML=f+"折";
 if(h!=""){document.getElementById("tupiana").innerHTML="<img src='"+h+"' />";}
}
function taocan2onc(a,b,c,d,e,f,g,h){
 if(taocanid==0){alert("请先选择第一级套餐内容");document.getElementById("utc1").className="utc utc1";return false;}
 document.getElementById("tc2div"+taocanid).className="utc";
 document.getElementById("nowkcnum").innerHTML=g;
 taocanid2=e;
 tc2re(taocanid);
 document.getElementById("nowmoney").innerHTML=c;
 document.getElementById("nowmoneyY").innerHTML=c;
 document.getElementById("yuanjia").innerHTML="￥"+d+"元";
 document.getElementById("taocan2a"+taocanid+"_"+a).className="a1";
 document.getElementById("zhekou").innerHTML=f+"折";
 if(h!=""){document.getElementById("tupiana").innerHTML="<img src='"+h+"' />";}
}
function tc2re(x){
if(document.getElementById("tc2num"+x)){
document.getElementById("tc2div"+x).className="utc";
a=parseInt(document.getElementById("tc2num"+x).innerHTML);
for(i=1;i<=a;i++){
document.getElementById("taocan2a"+x+"_"+i).className="";
}
}
}

function shujia(){
 a=parseInt(document.getElementById("tkcnum").value);
 if(isNaN(a)){document.getElementById("tkcnum").value=1;a=1;}
 if(a<0){document.getElementById("tkcnum").value=1;}
 else{
 document.getElementById("tkcnum").value=a+1;
 }
 moneycha();
}

function shujian(){
 a=parseInt(document.getElementById("tkcnum").value);
 if(isNaN(a)){document.getElementById("tkcnum").value=1;a=1;}
 if(a<=1){document.getElementById("tkcnum").value=1;}
 else{
 document.getElementById("tkcnum").value=a-1;
 }
 moneycha();
}

function numcheng(arg1,arg2)
{
var m=0,s1=arg1.toString(),s2=arg2.toString();
try{m+=s1.split(".")[1].length}catch(e){}
try{m+=s2.split(".")[1].length}catch(e){}
return Number(s1.replace(".",""))*Number(s2.replace(".",""))/Math.pow(10,m)
}

function moneycha(){
a=numcheng(parseFloat(document.getElementById("nowmoneyY").innerHTML),parseInt(document.getElementById("tkcnum").value));
document.getElementById("nowmoney").innerHTML=a;
}

//特色
function tscapover(x){
for(i=1;i<=3;i++){
if(document.getElementById("tscap"+i)){
document.getElementById("tscap"+i).className="";
document.getElementById("tsmain"+i).style.display="none";
}
}
document.getElementById("tscap"+x).className="a1";
document.getElementById("tsmain"+x).style.display="";
}

function simgover(x){
document.getElementById("bimg").src=x;
}

//加入购物车
var xmlHttpcar = false;
try {
  xmlHttpcar = new ActiveXObject("Msxml2.XMLHTTP");
} catch (e) {
  try {
    xmlHttpcar = new ActiveXObject("Microsoft.XMLHTTP");
  } catch (e2) {
    xmlHttpcar = false;
  }
}
if (!xmlHttpcar && typeof XMLHttpRequest != 'undefined') {
  xmlHttpcar = new XMLHttpRequest();
}

function carInto(x){
if(document.getElementById("tcnum")){if(taocanid==0){alert("请先选择套餐");document.getElementById("utc1").className="utc utc1";return false;}}
if(document.getElementById("tc2div"+taocanid)){if(taocanid2==0){alert("请先选择套餐");document.getElementById("tc2div"+taocanid).className="utc utc1";return false;}taocanid=taocanid2;}
url = "../tem/carInto.php?bh="+x+"&kcnum="+document.getElementById("tkcnum").value+"&tcid="+taocanid;
xmlHttpcar.open("get", url, true);
xmlHttpcar.onreadystatechange = updatePagecar;
xmlHttpcar.send(null);
}

function updatePagecar() {
 if(xmlHttpcar.readyState == 4) {
 response = xmlHttpcar.responseText;
 response=response.replace(/[\r\n]/g,'');
  if(response=="err1"){tclogin();return false;}
  else if(response=="err2"){alert("亲~不能将自己的商品放入购物车哦");return false;}
  else if(response=="ok"){
  document.getElementById("cara2").style.display="";
  document.getElementById("cara1").style.display="none";
  }else{alert("未知错误，请刷新重试");return false;}
 }
}

//立即购买
var xmlHttpbuy = false;
try {
  xmlHttpbuy = new ActiveXObject("Msxml2.XMLHTTP");
} catch (e) {
  try {
    xmlHttpbuy = new ActiveXObject("Microsoft.XMLHTTP");
  } catch (e2) {
    xmlHttpbuy = false;
  }
}
if (!xmlHttpbuy && typeof XMLHttpRequest != 'undefined') {
  xmlHttpbuy = new XMLHttpRequest();
}

function buyInto(x){
if(document.getElementById("tcnum")){if(taocanid==0){alert("请先选择套餐");document.getElementById("utc1").className="utc utc1";return false;}}
if(document.getElementById("tc2div"+taocanid)){if(taocanid2==0){alert("请先选择套餐");document.getElementById("tc2div"+taocanid).className="utc utc1";return false;}taocanid=taocanid2;}
url = "../tem/buyInto.php?bh="+x+"&kcnum="+document.getElementById("tkcnum").value+"&tcid="+taocanid;
xmlHttpbuy.open("get", url, true);
xmlHttpbuy.onreadystatechange = updatePagebuy;
xmlHttpbuy.send(null);
}

function updatePagebuy() {
 if(xmlHttpbuy.readyState == 4) {
 response = xmlHttpbuy.responseText;
 response=response.replace(/[\r\n]/g,'');
  if(response=="err1"){tclogin();return false;}
  else if(response=="err2"){alert("亲~不能购买自己的商品哦");return false;}
  else if(response=="ok"){location.href="../user/car.php";}else{alert("未知错误，请刷新重试");return false;}
 }
}

//店铺收藏
var xmlHttpfavs = false;
try {
  xmlHttpfavs = new ActiveXObject("Msxml2.XMLHTTP");
} catch (e) {
  try {
    xmlHttpfavs = new ActiveXObject("Microsoft.XMLHTTP");
  } catch (e2) {
    xmlHttpfavs = false;
  }
}
if (!xmlHttpfavs && typeof XMLHttpRequest != 'undefined') {
  xmlHttpfavs = new XMLHttpRequest();
}

function shopfavInto(x){
url = "../tem/favshopInto.php?id="+x;
xmlHttpfavs.open("get", url, true);
xmlHttpfavs.onreadystatechange = updatePagefavs;
xmlHttpfavs.send(null);
}

function updatePagefavs() {
 if(xmlHttpfavs.readyState == 4) {
 response = xmlHttpfavs.responseText;
 response=response.replace(/[\r\n]/g,'');
  if(response=="err1"){tclogin();return false;}
  else if(response=="err2"){alert("亲~不能收藏自己的店铺哦");return false;}
  else if(response=="ok"){
  document.getElementById("favsyes").style.display="";
  document.getElementById("favsno").style.display="none";
  }else{alert("未知错误，请刷新重试");return false;}
 }
}

//商品收藏
var xmlHttpfavp = false;
try {
  xmlHttpfavp = new ActiveXObject("Msxml2.XMLHTTP");
} catch (e) {
  try {
    xmlHttpfavp = new ActiveXObject("Microsoft.XMLHTTP");
  } catch (e2) {
    xmlHttpfavp = false;
  }
}
if (!xmlHttpfavp && typeof XMLHttpRequest != 'undefined') {
  xmlHttpfavp = new XMLHttpRequest();
}

function profavInto(x){
url = "../tem/favproInto.php?bh="+x;
xmlHttpfavp.open("get", url, true);
xmlHttpfavp.onreadystatechange = updatePagefavp;
xmlHttpfavp.send(null);
}

function updatePagefavp() {
 if(xmlHttpfavp.readyState == 4) {
 response = xmlHttpfavp.responseText;
 response=response.replace(/[\r\n]/g,'');
  if(response=="err1"){tclogin();return false;}
  else if(response=="err2"){alert("亲~不能收藏自己的商品哦");return false;}
  else if(response=="ok"){
  document.getElementById("favpyes").style.display="";
  document.getElementById("favpno").style.display="none";
  }else{alert("未知错误，请刷新重试");return false;}
 }
}

//标签按钮
function bqonc(x){
 for(i=1;i<=5;i++){
  if(document.getElementById("bqcap"+i)){
  document.getElementById("bqcap"+i).className="l0";
  document.getElementById("bqdiv"+i).style.display="none";
  }
 }
 document.getElementById("bqcap"+x).className="l1 g_bc0_h";
 document.getElementById("bqdiv"+x).style.display="";
 if(x==1){
  document.getElementById("bqdiv2").style.display="";
  document.getElementById("bqdiv3").style.display="";
  document.getElementById("bqdiv4").style.display="";
  document.getElementById("bqdiv5").style.display="";
 }
}

function wendaonc(x){
layer.open({
  type: 2,
  area: ['650px', '405px'],
  title:false,
  skin: 'layui-layer-rim', //加上边框
  content:['../tem/wenda.php?id='+x, 'no'] 
});
}