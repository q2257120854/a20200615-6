//资讯评论
function newspj(){
t=document.getElementById("pjt").value;
if(t==""){alert("请输入评价内容");document.getElementById("pjt").focus();return false;}
f1.action="newspj.php";
}

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
