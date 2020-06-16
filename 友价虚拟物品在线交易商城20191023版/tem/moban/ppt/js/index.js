function typeaover(x,y){
a=parseInt(document.getElementById("typea"+x).innerHTML);
for(i=0;i<a;i++){
document.getElementById("typea"+x+"_"+i).className="";
document.getElementById("dright"+x+"_"+i).style.display="none";
}
document.getElementById("typea"+x+"_"+y).className="a1";
document.getElementById("dright"+x+"_"+y).style.display="";
}

//切换
function banner(){	
	var bn_id = 0;
	var bn_id2= 1;
	var speed33=10000;
	var qhjg = 1;
    var MyMar33;
	$("#banner .d1").hide();
	$("#banner .d1").eq(0).fadeIn("slow");
	if($("#banner .d1").length>1)
	{
		$("#banner_id li").eq(0).addClass("nuw");
		function Marquee33(){
			bn_id2 = bn_id+1;
			if(bn_id2>$("#banner .d1").length-1)
			{
				bn_id2 = 0;
			}
			$("#banner .d1").eq(bn_id).css("z-index","2");
			$("#banner .d1").eq(bn_id2).css("z-index","1");
			$("#banner .d1").eq(bn_id2).show();
			$("#banner .d1").eq(bn_id).fadeOut("slow");
			$("#banner_id li").removeClass("nuw");
			$("#banner_id li").eq(bn_id2).addClass("nuw");
			bn_id=bn_id2;
		};
	
		MyMar33=setInterval(Marquee33,speed33);
		
		$("#banner_id li").click(function(){
			var bn_id3 = $("#banner_id li").index(this);
			if(bn_id3!=bn_id&&qhjg==1)
			{
				qhjg = 0;
				$("#banner .d1").eq(bn_id).css("z-index","2");
				$("#banner .d1").eq(bn_id3).css("z-index","1");
				$("#banner .d1").eq(bn_id3).show();
				$("#banner .d1").eq(bn_id).fadeOut("slow",function(){qhjg = 1;});
				$("#banner_id li").removeClass("nuw");
				$("#banner_id li").eq(bn_id3).addClass("nuw");
				bn_id=bn_id3;
			}
		})
		$("#banner_id").hover(
			function(){
				clearInterval(MyMar33);
			}
			,
			function(){
				MyMar33=setInterval(Marquee33,speed33);
			}
		)	
	}
	else
	{
		$("#banner_id").hide();
	}
}

//团购倒计时开始
var responsesj;
var time_server_client,timerID,xs,time_end1,time_end2,time_end3,time_end4,time_end5,timerID1,timerID2,timerID3,timerID4,timerID5;

function show_time(djsid)
{
 var time_now,time_distance,str_time;
 var int_day,int_hour,int_minute,int_second;
 var time_now=new Date();
 time_now=time_now.getTime()+time_server_client;
 if(djsid==1){time_end=time_end1;timerID=timerID1;}
 else if(djsid==2){time_end=time_end2;timerID=timerID2;}
 else if(djsid==3){time_end=time_end3;timerID=timerID3;}
 else if(djsid==4){time_end=time_end4;timerID=timerID4;}
 else if(djsid==5){time_end=time_end5;timerID=timerID5;}
 
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
   document.getElementById("djs"+djsid).innerHTML="剩余："+tv;
   setTimeout("show_time("+djsid+")",100);
  }
  else
 {
  tv="<span class='feng'>已结束</span>";
  document.getElementById("djs"+djsid).innerHTML=tv;
  document.getElementById("s"+djsid+"sj1").innerHTML=0;
  document.getElementById("s"+djsid+"sj2").innerHTML=0;
  document.getElementById("s"+djsid+"sj3").innerHTML=0;
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


function updatePagesj() {
  if (xmlHttpsj.readyState == 4) {
   responsesj = xmlHttpsj.responseText;
   if(document.getElementById("dqsj1")){dsj1=document.getElementById("dqsj1").innerHTML;time_end1=new Date(dsj1);time_end1=time_end1.getTime();}//结束的时间
   if(document.getElementById("dqsj2")){dsj2=document.getElementById("dqsj2").innerHTML;time_end2=new Date(dsj2);time_end2=time_end2.getTime();}//结束的时间
   if(document.getElementById("dqsj3")){dsj3=document.getElementById("dqsj3").innerHTML;time_end3=new Date(dsj3);time_end3=time_end3.getTime();}//结束的时间
   if(document.getElementById("dqsj4")){dsj4=document.getElementById("dqsj4").innerHTML;time_end4=new Date(dsj4);time_end4=time_end4.getTime();}//结束的时间
   if(document.getElementById("dqsj5")){dsj5=document.getElementById("dqsj5").innerHTML;time_end5=new Date(dsj5);time_end5=time_end5.getTime();}//结束的时间

time_now_server=new Date(responsesj);time_now_server=time_now_server.getTime();
time_now_client=new Date();time_now_client=time_now_client.getTime();
time_server_client=time_now_server-time_now_client;

   if(document.getElementById("dqsj1")){timerID1=setTimeout("show_time(1)",100);}
   if(document.getElementById("dqsj2")){timerID2=setTimeout("show_time(2)",100);}
   if(document.getElementById("dqsj3")){timerID3=setTimeout("show_time(3)",100);}
   if(document.getElementById("dqsj4")){timerID4=setTimeout("show_time(4)",100);}
   if(document.getElementById("dqsj5")){timerID5=setTimeout("show_time(5)",100);}
  }
}

function userChecksj(){
	if(document.getElementById("dqsj1")){
    var url = document.getElementById("webhttp").innerHTML+"tem/sjCheck.php";
    xmlHttpsj.open("post", url, true);
    xmlHttpsj.onreadystatechange = updatePagesj;
    xmlHttpsj.send(null);
	}
	}
//团购倒计时结束


//快速登录B
var xmlHttpidl = false;
try {
  xmlHttpidl = new ActiveXObject("Msxml2.XMLHTTP");
} catch (e) {
  try {
    xmlHttpidl = new ActiveXObject("Microsoft.XMLHTTP");
  } catch (e2) {
    xmlHttpidl = false;
  }
}
if (!xmlHttpidl && typeof XMLHttpRequest != 'undefined') {
  xmlHttpidl = new XMLHttpRequest();
}
function idldl(x){
 url ="tem/idl.php";
 xmlHttpidl.open("get", url, true);
 xmlHttpidl.onreadystatechange = updatePageidl;
 xmlHttpidl.send(null);
}
function updatePageidl() {
 if (xmlHttpidl.readyState == 4) {
  response = xmlHttpidl.responseText;
  response=response.replace(/[\r\n]/g,'');
  a=response.split("|");
  if(a[0]=="ok"){
  userCheckses();
  document.getElementById("idl1").innerHTML=a[1];
  document.getElementById("idl2").innerHTML=a[2];
  document.getElementById("idl3").innerHTML=a[3];
  document.getElementById("idl4").innerHTML=a[4];
  document.getElementById("idl5").innerHTML=a[5];
  document.getElementById("idlyes").style.display="";
  document.getElementById("idlno").style.display="none";
  }
 }
}

//快速登录E