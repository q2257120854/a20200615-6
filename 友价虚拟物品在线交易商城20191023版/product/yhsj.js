var nowx; //1表示开始前 2表示结束
var time_now_server,time_now_client,time_end,time_server_client,timerID;
function show_time()
{
 var time_now,time_distance,str_time;
 var int_day,int_hour,int_minute,int_second;
 var time_now=new Date();
 time_now=time_now.getTime()+time_server_client;
 time_distance=time_end-time_now;
 if(time_distance>0)
 {
  int_day=Math.floor(time_distance/86400000);if(int_day>0){dayv=int_day+"天";}else{dayv="";}
  time_distance-=int_day*86400000;
  int_hour=Math.floor(time_distance/3600000);if(int_hour>0){hourv=int_hour+"小时";}else{hourv="";}
  time_distance-=int_hour*3600000;
  int_minute=Math.floor(time_distance/60000);if(int_minute>0){minutev=int_minute+"分";}else{minutev="";}
  time_distance-=int_minute*60000;
  int_second=Math.floor(time_distance/1000);
  mm = Math.floor((time_distance % 1000)/100);
  if(nowx==1){st="开始";}else{st="结束";}
  document.getElementById("yhsjv").innerHTML=dayv+hourv+minutev+int_second+ "." + mm +"秒后"+st;
  timerID=setTimeout("show_time()",100);
  }
  else
 {
  clearTimeout(timerID);
  yhsjchk();
  if(1==nowx){document.getElementById("nowmoney").innerHTML=document.getElementById("nmoney3").innerHTML;yhsj(2);}
  else{document.getElementById("xsyh").style.display="none";document.getElementById("nowmoney").innerHTML=document.getElementById("nmoney2").innerHTML;}
 }
}

function yhsj(x) {
nowx=x;
rsj = document.getElementById("nowsj").innerHTML;
if(x==1){d="nyhsj1";}else{d="nyhsj2";}
dsj=document.getElementById(d).innerHTML;
time_end=new Date(dsj);  //结束的时间
time_end=time_end.getTime();
time_now_server=new Date(rsj);//开始的时间
time_now_server=time_now_server.getTime();
time_now_client=new Date();
time_now_client=time_now_client.getTime();
time_server_client=time_now_server-time_now_client;
show_time();
}

var xmlHttpsj = false;
try {
  xmlHttpsj = new ActiveXObject("Msxml2.XMLHTTP");
} catch (e) {
  try {
    xmlHttpsj = new ActiveXObject("Microsoft.XMLHTTP");
  } catch (e2) {
    xmlHttpsj = false;
  }
}
if (!xmlHttpsj && typeof XMLHttpRequest != 'undefined') {
  xmlHttpsj = new XMLHttpRequest();
}


function updatePagesj() {
 if (xmlHttpsj.readyState == 4){
 responsesj = xmlHttpsj.responseText;
 document.getElementById("nowsj").innerHTML=responsesj;
 }
}

function yhsjchk(){
 var url = document.getElementById("webhttp").innerHTML+"tem/sjCheck.php";
 xmlHttpsj.open("get", url, true);
 xmlHttpsj.onreadystatechange = updatePagesj;
 xmlHttpsj.send(null);
}
