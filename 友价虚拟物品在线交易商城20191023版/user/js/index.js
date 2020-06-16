//删除数据
function NcheckDEL(x,y){
	var c=document.getElementsByName("C1");
	str="";
	for(i=0;i<c.length;i++){
		if(c[i].checked){
			if(str==""){
				str=c[i].value;
				}else{
					str=str+","+c[i].value;
					}
			}
		}
	if(str==""){alert("请至少选择一条数据");return false;}
	if(confirm("确定要执行该操作吗?")){layer.msg('正在处理', {icon: 16  ,time: 0,shade :0.25});noRefresh(x,str,y);}else{return false;}
}
var xmlHttpdel = false;
try {
  xmlHttpdel = new ActiveXObject("Msxml2.XMLHTTP");
} catch (e) {
  try {
    xmlHttpdel = new ActiveXObject("Microsoft.XMLHTTP");
  } catch (e2) {
    xmlHttpdel = false;
  }
}
if (!xmlHttpdel && typeof XMLHttpRequest != 'undefined') {
  xmlHttpdel = new XMLHttpRequest();
}
function noRefresh(admin,bhid,tablename) {
  if(bhid==""){alert("条件不符！");return false;}
  var url = "noRefresh.php?admin="+admin+"&idbh="+bhid+"&tab="+tablename;
  xmlHttpdel.open("post", url, true);
  xmlHttpdel.onreadystatechange = updatePagedel;
  xmlHttpdel.send(null);  
}

function updatePagedel() {
  if (xmlHttpdel.readyState == 4) {
  var response = xmlHttpdel.responseText;
  a=response.replace(/[\r\n]/g,'');
  if(a=="ERR074"){alert("操作失败，请重试");return false;}
  else if(response=="ERR1"){alert("删除失败，该分类下还有二级分类或其他关联信息未删除");return false;}
  else if(a=="True"){location.reload();return false;}
  }
}
