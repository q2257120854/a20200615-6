<?php
include("../config/conn.php");
include("../config/function.php");
AdminSes_audit();

if(sqlzhuru($_POST[xl])==sha1("pwd")){
 zwzr();
 if(!strstr($adminqx,",0,")){Audit_alert("权限不够","pwd.php");}
 if(panduan("*","yjcode_admin where adminpwd='".sha1(sqlzhuru($_POST[t0]))."' and adminuid='".$_SESSION[SHOPADMIN]."'")==1){
 updatetable("yjcode_admin","adminpwd='".sha1(sqlzhuru($_POST[t1]))."' where adminuid='".$_SESSION[SHOPADMIN]."'");
 php_toheader("pwd.php?t=suc");

}else{Audit_alert("原密码输入有误，请重试！","pwd.php");}

}
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
if((document.f1.t0.value).replace(/\s/,"")==""){alert("请输入旧密码!");document.f1.t0.select();return false;}
if((document.f1.t1.value).replace(/\s/,"")==""){alert("请输入新密码!");document.f1.t1.select();return false;}
if(document.f1.t1.value!=document.f1.t2.value){alert("两次密码输入不一致,请重试!");document.f1.t2.select();return false;}
layer.msg('正在验证', {icon: 16  ,time: 0,shade :0.25});
f1.action="pwd.php";
}
</script>
</head>
<body>
<? include("top.php");?>
<script language="javascript">
document.getElementById("menu1").className="a1";
</script>

<div class="yjcode">
 <? $leftid=1;include("menu_quan.php");?>

<div class="right">

<? if($_GET[t]=="suc"){systs("恭喜您，操作成功！","pwd.php");}?>

<div class="bqu1">
<a class="a1" href="pwd.php">密码修改</a>
</div>
  
<div class="rkuang">

 <form name="f1" method="post" onsubmit="return tj()">
 <input type="hidden" value="<?=sha1('pwd')?>" name="xl" />
 <ul class="uk">
 <li class="l1">旧密码：</li>
 <li class="l2"><input type="password" class="inp" name="t0" size="30" /></li>
 <li class="l1">新密码：</li>
 <li class="l2"><input type="password" class="inp" name="t1" size="30" /></li>
 <li class="l1">重复密码：</li>
 <li class="l2"><input type="password" class="inp" name="t2" size="30" /></li>
 <li class="l3"><input type="submit" value="保存修改" class="btn1" /></li>
 </ul>
 </form>

</div>

</div>

</div>
<? include("bottom.php");?>
</body>
</html>