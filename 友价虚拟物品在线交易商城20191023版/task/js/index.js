//团购倒计时开始
var responsesj;
var time_server_client,timerID,xs,time_end1,timerID1;

function show_time(djsid)
{
 var time_now,time_distance,str_time;
 var int_day,int_hour,int_minute,int_second;
 var time_now=new Date();
 time_now=time_now.getTime()+time_server_client;
 time_end=time_end1;timerID=timerID1;
 
 time_distance=time_end-time_now;
 if(time_distance>0)
 {
  int_day=parseInt(Math.floor(time_distance/86400000))
  time_distance-=int_day*86400000;
  int_hour=parseInt(Math.floor(time_distance/3600000))
  time_distance-=int_hour*3600000;
  int_minute=parseInt(Math.floor(time_distance/60000))
  time_distance-=int_minute*60000;
  int_second=parseInt(Math.floor(time_distance/1000))
  mm = Math.floor((time_distance % 1000)/100);
   tv=int_day+"<span class='s1'>天</span>";
   tv=tv+int_hour+"<span class='s1'>时</span>";
   tv=tv+int_minute+"<span class='s1'>分</span>";
   tv=tv+int_second+"." + mm+"<span class='s1'>秒</span>";
   document.getElementById("djs").innerHTML=tv;
   setTimeout("show_time("+djsid+")",100);
  }
  else
 {
  tv="<span class='feng'>已结束</span>";
  document.getElementById("djs").innerHTML=tv;
  clearTimeout(timerID)
 }
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


function userChecksj() {
   responsesj = document.getElementById("nowsj").innerHTML;
   if(document.getElementById("dqsj")){dsj1=document.getElementById("dqsj").innerHTML;time_end1=new Date(dsj1);time_end1=time_end1.getTime();}//结束的时间
   time_now_server=new Date(responsesj);time_now_server=time_now_server.getTime();
   time_now_client=new Date();time_now_client=time_now_client.getTime();
   time_server_client=time_now_server-time_now_client;
   if(document.getElementById("dqsj")){timerID1=setTimeout("show_time(1)",100);}
}
//团购倒计时结束

//弹出登录窗口
function tclogin(){
layer.open({
  type: 2,
  area: ['650px', '415px'],
  title:["快捷登录","text-align:left"],
  skin: 'layui-layer-rim', //加上边框
  content:['../tem/openw.php', 'no'] 
});
}
