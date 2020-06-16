<?php
include("../config/conn.php");
include("../config/function.php");
AdminSes_audit();

if($_GET[control]=="add"){
 if(!strstr($adminqx,",0,")){Audit_alert("权限不够！","default.php");}
 if(panduan("adminuid","yjcode_admin where adminuid='".sqlzhuru($_POST[t1])."'")==1){Audit_alert("该管理员帐号已经存在！","admin.php");}
 $pwd=sha1(sqlzhuru($_POST[t2]));
 if(strstr($_GET[qx],",0,")){$qxv=",0,";}else{$qxv=$_GET[qx];}
 intotable("yjcode_admin","adminuid,adminpwd,uname,qx","'".sqlzhuru($_POST[t1])."','".$pwd."','".sqlzhuru($_POST[t4])."','".$qxv."'");
 php_toheader("admin.php?t=suc");

}elseif($_GET[control]=="update"){
 if(!strstr($adminqx,",0,")){Audit_alert("权限不够！","default.php");}
 if(panduan("id,adminuid","yjcode_admin where adminuid='".sqlzhuru($_POST[t1])."' and id<>".$_GET[id])==1){Audit_alert("该管理员帐号已经存在！","admin.php?action=update&id=".$_GET[id]);}
 if(strstr($_GET[qx],",0,")){$qxv=",0,";}else{$qxv=$_GET[qx];}
 if(!empty($_POST[t2])){$pwd=sha1(sqlzhuru($_POST[t2]));$ses=",adminpwd='".$pwd."'";}
 updatetable("yjcode_admin","adminuid='".sqlzhuru($_POST[t1])."',uname='".sqlzhuru($_POST[t4])."',qx='".$qxv."'".$ses." where id=".$_GET[id]);
 php_toheader("admin.php?action=update&t=suc&id=".$_GET[id]);

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><?=webname?>管理系统</title>
<link href="css/basic.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script language="javascript" src="js/basic.js"></script>
<script language="javascript" src="js/layer.js"></script>
</head>
<body>
<? include("top.php");?>
<script language="javascript">
document.getElementById("menu2").className="a1";
</script>
<? if(!strstr($adminqx,",0,")){echo "<div class='noneqx'>无权限</div>";exit;}?>

<div class="yjcode">
 <? $leftid=6;include("menu_user.php");?>

<div class="right">
 
 <? if($_GET[t]=="suc"){systs("恭喜您，操作成功！","admin.php?action=".$_GET[action]."&id=".$_GET[id]);}?>
 
 <div class="bqu1">
 <a href="javascript:void(0);" class="a1">管理员</a>
 <a href="adminlist.php">返回列表</a>
 </div> 
 <!--Begin-->
 <div class="rkuang">
 <? if($_GET[action]==""){?>
 <script language="javascript">
 function tj(){
  if((document.f1.t1.value).replace(/\s/,"")==""){alert("请输入管理员帐号");document.f1.t1.focus();return false;}	 
  if((document.f1.t2.value).replace(/\s/,"")==""){alert("请输入管理员密码");document.f1.t2.focus();return false;}	 
  if(document.f1.t2.value!=document.f1.t3.value){alert("密码不一致");document.f1.t3.focus();return false;}	 
  if((document.f1.t4.value).replace(/\s/,"")==""){alert("请输入管理员姓名");document.f1.t4.focus();return false;}	
  c=document.getElementsByName("C1");
  str=",";
  for(i=0;i<c.length;i++){if(c[i].checked){str=str+c[i].value+",";}}
  if(str==","){alert("未设置权限");return false;}
  layer.msg('正在提交', {icon: 16  ,time: 0,shade :0.25});
  f1.action="admin.php?control=add&qx="+str;
 }
 </script>
 <form name="f1" method="post" onsubmit="return tj()">
 <ul class="uk">
 <li class="l1">管理员帐号：</li>
 <li class="l2"><input type="text" class="inp" name="t1" size="20" onfocus="inpf(this)" onblur="inpb(this)" /></li>
 <li class="l1">密码：</li>
 <li class="l2"><input type="password" class="inp" name="t2" size="20" onfocus="inpf(this)" onblur="inpb(this)" /></li>
 <li class="l1">重复密码：</li>
 <li class="l2"><input type="password" class="inp" name="t3" size="20" onfocus="inpf(this)" onblur="inpb(this)" /></li>
 <li class="l1">姓名：</li>
 <li class="l2"><input type="text" class="inp" name="t4" size="20" onfocus="inpf(this)" onblur="inpb(this)" /></li>
 <li class="l1">权限：</li>
 <li class="l2">
 <label><input name="C1" type="checkbox" value="0" /> 超级管理员</label>
 </li>
 <?
 $qx=returnadminqx();
 for($i=0;$i<count($qx);$i++){
 ?>
 <li class="l1"></li>
 <li class="l2">
 <span class="finp">
 <? 
 $qxv=preg_split("/\|/",$qx[$i]);
 for($j=0;$j<count($qxv);$j++){
 $q=preg_split("/,/",$qxv[$j]);
 ?>
 <label><input name="C1" type="checkbox" value="<?=$q[0]?>" /> <?=$q[1]?></label>
 <?
 }
 ?>
 </span>
 </li>
 <? }?>
 <li class="l4">允许商品ID：</li>
 <li class="l5"><textarea name="tproid"></textarea></li>
 <li class="l1">说明：</li>
 <li class="l21">如果填入商品ID，则表示未填入的不允许操作，需要配合上方权限使用。多个商品ID用逗号隔开，如无商品权限细分要求，建议留空</li>
 <li class="l3"><input type="submit" value="保存修改" class="btn1" /></li>
 </ul>
 </form>
 
 <? 
 }elseif($_GET[action]=="update"){
 while0("*","yjcode_admin where id=".$_GET[id]);if(!$row=mysql_fetch_array($res)){php_toheader("adminlist.php");}
 ?>
 <script language="javascript">
 function tj(){
  if((document.f1.t1.value).replace(/\s/,"")==""){alert("请输入管理员帐号");document.f1.t1.focus();return false;}	 
  if((document.f1.t2.value).replace(/\s/,"")!=""){
   if(document.f1.t2.value!=document.f1.t3.value){alert("密码不一致");document.f1.t3.focus();return false;}	 
  }
  if((document.f1.t4.value).replace(/\s/,"")==""){alert("请输入管理员姓名");document.f1.t4.focus();return false;}	
  c=document.getElementsByName("C1");
  str=",";
  for(i=0;i<c.length;i++){if(c[i].checked){str=str+c[i].value+",";}}
  if(str==","){alert("未设置权限");return false;}
  layer.msg('正在提交', {icon: 16  ,time: 0,shade :0.25});
  f1.action="admin.php?control=update&id=<?=$row[id]?>&qx="+str;
 }
 </script>
 <form name="f1" method="post" onsubmit="return tj()">
 <ul class="uk">
 <li class="l1">管理员帐号：</li>
 <li class="l2"><input type="text" value="<?=$row[adminuid]?>" class="inp" name="t1" size="20" onfocus="inpf(this)" onblur="inpb(this)" /></li>
 <li class="l1">新密码：</li>
 <li class="l2"><input type="password" class="inp" name="t2" size="20" onfocus="inpf(this)" onblur="inpb(this)" /><span class="fd">留空表示不修改</span></li>
 <li class="l1">重复新密码：</li>
 <li class="l2"><input type="password" class="inp" name="t3" size="20" onfocus="inpf(this)" onblur="inpb(this)" /></li>
 <li class="l1">姓名：</li>
 <li class="l2"><input type="text" value="<?=$row[uname]?>" class="inp" name="t4" size="20" onfocus="inpf(this)" onblur="inpb(this)" /></li>
 <li class="l1">权限：</li>
 <li class="l2">
 <label><input name="C1"<? if(strstr($row[qx],",0,")){?> checked="checked"<? }?> type="checkbox" value="0" /> 超级管理员</label>
 </li>
 <?
 $qx=returnadminqx();
 for($i=0;$i<count($qx);$i++){
 ?>
 <li class="l1"></li>
 <li class="l2">
 <span class="finp">
 <? 
 $qxv=preg_split("/\|/",$qx[$i]);
 for($j=0;$j<count($qxv);$j++){
 $q=preg_split("/,/",$qxv[$j]);
 ?>
 <label><input name="C1" type="checkbox"<? if(strstr($row[qx],",".$q[0].",")){?> checked="checked"<? }?> value="<?=$q[0]?>" /> <?=$q[1]?></label>
 <? }?>
 </span>
 </li>
 <? }?>
 <li class="l3"><input type="submit" value="保存修改" class="btn1" /></li>
 </ul>
 </form>
 <? }?>
 </div>
 <!--End-->
 
</div>
</div>
<?php include("bottom.php");?>
</body>
</html>