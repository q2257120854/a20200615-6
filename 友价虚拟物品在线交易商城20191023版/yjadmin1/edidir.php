<?php
include("../config/conn.php");
include("../config/function.php");
AdminSes_audit();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><?=webname?>管理系统</title>
<link rel="stylesheet" href="layui/css/layui.css">
<link href="css/basic.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script language="javascript" src="js/basic.js"></script>
<script language="javascript" src="js/layer.js"></script>
<script language="javascript">
function tj(){
if((document.f1.t1.value).replace(/\s/,"")==""){alert("请输入新目录名称!");document.f1.t1.select();return false;}
layer1=layer.msg('正在提交', {icon: 16  ,time: 0,shade :0.25});
$.post("../tem/edidirdata.php",{t1v:document.f1.t1.value,yjcode:"edidir"},function(result){
 layer.close(layer1);
 if(result=="err1"){alert("操作失败，只支持数字、字母、下划线的格式");return false;}
 else if(result=="err2"){alert("操作失败，当前目录名称与新名称一致");return false;}
 else if(result=="err3"){alert("操作失败，权限不够");return false;}
 else if(result=="ok"){location.href="../"+document.f1.t1.value+"/";return false;}
 else{alert("操作失败："+result);return false;}
});
return false;
}
</script>
</head>
<body>
<? include("top.php");?>
<script language="javascript">
document.getElementById("menu1").className="a1";
</script>
<? if(!strstr($adminqx,",0,")){echo "<div class='noneqx'>无权限</div>";exit;}?>

<div class="yjcode">
 <? $leftid=1;include("menu_quan.php");?>

<div class="right">

<? if($_GET[t]=="suc"){systs("恭喜您，操作成功！","pwd.php");}?>

<div class="bqu1">
<a class="a1" href="edidir.php">修改后台目录</a>
</div>
  
<div class="rkuang">

 <form name="f1" method="post" onsubmit="return tj()">
 <ul class="uk">
 <li class="l1">新目录名称：</li>
 <li class="l2"><input type="text" class="inp" value="<?=$rowcontrol[admindir]?>" name="t1" id="t1" size="30" /></li>
 <li class="l1">系统提示：</li>
 <li class="l21 red">这个操作涉及您的系统安全，修改后请牢记后台名称</li>
 <li class="l3"><input type="submit" value="保存修改" class="btn1" /></li>
 </ul>
 </form>

</div>

</div>

</div>
<? include("bottom.php");?>
</body>
</html>