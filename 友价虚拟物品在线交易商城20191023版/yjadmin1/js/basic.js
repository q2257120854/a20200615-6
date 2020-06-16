function leftonc(x){
 /*
 $("#leftmenu"+leftMid+" .a1").removeClass('current');
 $("#leftmenu"+leftMid+" .level2").hide();
 $("#leftmenu"+x+" .a1").addClass('current');
 $("#leftmenu"+x+" .level2").show();
 leftMid=x;
 */
 if($("#leftmenu"+x+" .level2").css("display")=="none"){
  $("#leftmenu"+x+" .a1").addClass('current');
  $("#leftmenu"+x+" .level2").show();
 }else{
  $("#leftmenu"+x+" .level2").hide();
  $("#leftmenu"+x+" .a1").removeClass('current');
 }
}

function topd3over(){
document.getElementById("tla").style.display="";
}
function topd3out(){
document.getElementById("tla").style.display="none";
}

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

function checkDEL(x,y){
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
 layer.msg('正在处理数据', {icon: 16  ,time: 0,shade :0.25});
 $.get("noRefresh.php",{admin:x,idbh:str,tab:y},function(result){
  layer.closeAll();
  if(result=="True"){location.reload();return false;}
  else if(result=="Err9"){alert("删除失败，权限不够");return false;}
  else{alert("删除失败，该分类下还有二级分类或其他关联信息未删除");return false;}
 });
 
 }else{return false;}

}

//分页跳转
function pagegoto(x,y){
if(isNaN(document.getElementById("pagetext").value)){alert("请输入正确的页数！");document.getElementById("pagetext").select();return false;}	
gourl(x+"?"+"page="+document.getElementById("pagetext").value+"&"+y);
}
function gourl(x){
location.href=x;	
}
