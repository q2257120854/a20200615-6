function callServer() {
if((document.f1.t1.value).replace(/\s/,"")==""){alert("请输入后台登录密码！");document.f1.t1.focus();return false;}
layer.msg('正在提交', {icon: 16  ,time: 0,shade :0.25});
$.get("yheckcusk.php",{pwd:document.f1.t1.value},function(result){
 if(result=="err1"){alert("密码验证有误，升级失败");gourl("default.php");return false;}
 else if(result=="ok"){gxupdate();return false;}
 else{alert("升级失败！请把弹出错误截图给售后技术协调解决或访问官网查找方法(vip.928vip.cn)\n"+result);window.location.reload();return false;}
});
return false;
}


function gxupdate() {
 $.get("rjydo.php",{sersj:serversj},function(result){
  if(result=="ok"){location.href="tohtml.php?admin=0&action=gx";return false;}
  else{alert("升级失败！请把弹出错误截图给售后技术协调解决或访问官网查找方法(vip.928vip.cn)\n"+response);window.location.reload();return false;}
 });
}

var serversj;
function gxchk() {
 $.get("yjuck.php",{},function(result){
 document.getElementById("gx3").style.display="none";
  if(result=="zx"){document.getElementById("gx2").style.display="";return false;}
  else{document.getElementById("gx1").style.display="";serversj=result;return false;}
 });
}

function trimStr(str){return str.replace(/(^\s*)|(\s*$)/g,"");}