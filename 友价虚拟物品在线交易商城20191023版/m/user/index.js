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

 if(confirm("确定执行该项操作吗?")){
 layer.open({type: 2,content: '正在处理数据',shadeClose:false});
 $.get("../../user/noRefresh.php",{admin:x,idbh:str,tab:y},function(result){
  layer.closeAll();
  a=result.replace(/[\r\n]/g,'');
  if(a=="ERR074"){alert("操作失败，请重试");return false;}
  else if(a=="ERR1"){alert("删除失败，该分类下还有二级分类或其他关联信息未删除");return false;}
  else if(a=="True"){location.reload();return false;}
 });
 
 }else{return false;}

}

//缩放/展开
function iimgonc(x){
idiv=document.getElementById("idiv"+x);
 if(idiv.className=="d2"){idiv.className="d2 d2la";document.getElementById("iimg"+x).src="img/jia.gif";}
 else{idiv.className="d2";document.getElementById("iimg"+x).src="img/jian3.gif";}
}
