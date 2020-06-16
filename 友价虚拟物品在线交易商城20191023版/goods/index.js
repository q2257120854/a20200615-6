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
  if(response=="err1"){tangc(1);return false;}
  else if(response=="err2"){alert("亲~不能收藏自己的商品哦");return false;}
  else if(response=="ok"){
  document.getElementById("favpyes").style.display="";
  document.getElementById("favpno").style.display="none";
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
url = "../tem/buyInto.php?bh="+x;
xmlHttpbuy.open("get", url, true);
xmlHttpbuy.onreadystatechange = updatePagebuy;
xmlHttpbuy.send(null);
}

function updatePagebuy() {
 if(xmlHttpbuy.readyState == 4) {
 response = xmlHttpbuy.responseText;
 response=response.replace(/[\r\n]/g,'');
  if(response=="err1"){tangc(1);return false;}
  else if(response=="err2"){alert("亲~不能购买自己的商品哦");return false;}
  else if(response=="ok"){location.href="../user/car.php";}else{alert("未知错误，请刷新重试");return false;}
 }
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
url = "../tem/carInto.php?bh="+x;
xmlHttpcar.open("get", url, true);
xmlHttpcar.onreadystatechange = updatePagecar;
xmlHttpcar.send(null);
}

function updatePagecar() {
 if(xmlHttpcar.readyState == 4) {
 response = xmlHttpcar.responseText;
 response=response.replace(/[\r\n]/g,'');
  if(response=="err1"){tangc(1);return false;}
  else if(response=="err2"){alert("亲~不能将自己的商品放入购物车哦");return false;}
  else if(response=="ok"){
  document.getElementById("cara2").style.display="";
  document.getElementById("cara1").style.display="none";
  }else{alert("未知错误，请刷新重试");return false;}
 }
}

//参与竞拍
var xmlHttppai = false;
try {
  xmlHttppai = new ActiveXObject("Msxml2.XMLHTTP");
} catch (e) {
  try {
    xmlHttppai = new ActiveXObject("Microsoft.XMLHTTP");
  } catch (e2) {
    xmlHttppai = false;
  }
}
if (!xmlHttppai && typeof XMLHttpRequest != 'undefined') {
  xmlHttppai = new XMLHttpRequest();
}

function paiInto(x){
url = "../tem/paiInto.php?bh="+x;
xmlHttppai.open("get", url, true);
xmlHttppai.onreadystatechange = updatePagepai;
xmlHttppai.send(null);
}

function updatePagepai() {
 if(xmlHttppai.readyState == 4) {
 response = xmlHttppai.responseText;
 response=response.replace(/[\r\n]/g,'');
  if(response=="err1"){tangc(1);return false;}
  else if(response=="err2"){alert("亲~不能参与自身商品的竞拍哦");return false;}
  else if(response=="ok"){tangpai(1);}else{alert("未知错误，请刷新重试");return false;}
 }
}

//弹窗竞拍
function tangpai(x){
if(1==x){document.getElementById("bghui").style.display="";document.getElementById("pai").style.display="";}
else if(0==x){document.getElementById("bghui").style.display="none";document.getElementById("pai").style.display="none";}
document.getElementById("bghui").style.width="100%";
document.getElementById("pai").style.top=230+Math.max(document.documentElement.scrollTop,document.body.scrollTop);
if(!+[1,]){
document.getElementById("bghui").style.height=document.body.clientHeight;
document.getElementById("pai").style.left=document.body.clientWidth/2-181;
}else{
document.getElementById("bghui").style.height=document.documentElement.clientHeight;
document.getElementById("pai").style.left=document.documentElement.clientWidth/2-181;
}
}


//参与询价
var xmlHttpxun = false;
try {
  xmlHttpxun = new ActiveXObject("Msxml2.XMLHTTP");
} catch (e) {
  try {
    xmlHttpxun = new ActiveXObject("Microsoft.XMLHTTP");
  } catch (e2) {
    xmlHttpxun = false;
  }
}
if (!xmlHttpxun && typeof XMLHttpRequest != 'undefined') {
  xmlHttpxun = new XMLHttpRequest();
}

function xunInto(x){
url = "../tem/xunInto.php?bh="+x;
xmlHttpxun.open("get", url, true);
xmlHttpxun.onreadystatechange = updatePagexun;
xmlHttpxun.send(null);
}

function updatePagexun() {
 if(xmlHttpxun.readyState == 4) {
 response = xmlHttpxun.responseText;
 response=response.replace(/[\r\n]/g,'');
  if(response=="err1"){tangc(1);return false;}
  else if(response=="err2"){alert("亲~不能参与自身商品的询价哦");return false;}
  else if(response=="ok"){tangxun(1);}else{alert("未知错误，请刷新重试");return false;}
 }
}

//询价弹窗
function tangxun(x){
if(1==x){document.getElementById("bghui").style.display="";document.getElementById("xun").style.display="";}
else if(0==x){document.getElementById("bghui").style.display="none";document.getElementById("xun").style.display="none";}
document.getElementById("bghui").style.width="100%";
document.getElementById("xun").style.top=230+Math.max(document.documentElement.scrollTop,document.body.scrollTop);
if(!+[1,]){
document.getElementById("bghui").style.height=document.body.clientHeight;
document.getElementById("xun").style.left=document.body.clientWidth/2-181;
}else{
document.getElementById("bghui").style.height=document.documentElement.clientHeight;
document.getElementById("xun").style.left=document.documentElement.clientWidth/2-181;
}
}



//倒计时
var addTimer = function () {  
        var list = [],  
            interval;  
  
        return function (id, time) {  
            if (!interval)  
                interval = setInterval(go, 1000);  
            list.push({ ele: document.getElementById(id), time: time });  
        }  
  
        function go() {  
            for (var i = 0; i < list.length; i++) {  
                list[i].ele.innerHTML = getTimerString(list[i].time ? list[i].time -= 1 : 0);  
                if (!list[i].time)  
                    list.splice(i--, 1);  
            }  
        }  
  
        function getTimerString(time) {  
            var not0 = !!time,  
                d = Math.floor(time / 86400),  
                h = Math.floor((time %= 86400) / 3600),  
                m = Math.floor((time %= 3600) / 60),  
                s = time % 60;  
            if (d>0 || h>0 || m>0 || s>0)  
                return d + "天" + h + "小时" + m + "分" + s + "秒";  
            else return "交易时间已经截止";  
        }  
    } (); 
