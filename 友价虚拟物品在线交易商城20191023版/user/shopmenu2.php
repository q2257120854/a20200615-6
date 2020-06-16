<?
include("../config/conn.php");
include("../config/function.php");
sesCheck();
$bh=$_GET[bh];
$sqluser="select * from yjcode_user where uid='".$_SESSION[SHOPUSER]."' and shopzt=2";mysql_query("SET NAMES 'GBK'");$resuser=mysql_query($sqluser);
if(!$rowuser=mysql_fetch_array($resuser)){Audit_alert("来源错误","openshop3.php","parent.");}
$userid=$rowuser[id];
while0("*","yjcode_shopmenu where userid=".$userid." and bh='".$bh."' and admin=2");if(!$row=mysql_fetch_array($res)){Audit_alert("来源错误","shopmenulist.php","parent.");}

if($_GET[control]=="update"){
 zwzr();
 if(panduan("*","yjcode_shopmenu where admin=2 and tit1='".sqlzhuru($_POST[ttit1])."' and tit2='".sqlzhuru($_POST[ttit2])."' and userid=".$userid." and id<>".$row[id])==1)
 {Audit_alert("该导航已存在！","shopmenu2.php?bh=".$bh);}
 updatetable("yjcode_shopmenu","tit2='".sqlzhuru($_POST[ttit2])."',aurl='".sqlzhuru($_POST[taurl])."',xh=".sqlzhuru($_POST[txh]).",targ=".sqlzhuru($_POST[R1]).",zt=0 where userid=".$userid." and id=".$row[id]);
 php_toheader("shopmenu2.php?t=suc&bh=".$bh);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>商铺导航</title>
<style type="text/css">
body{margin:0;font-size:12px;text-align:center;color:#333;word-wrap:break-word;font-family:"Microsoft YaHei",微软雅黑,"MicrosoftJhengHei",华文细黑,STHeiti,MingLiu;}
*{margin:0 auto;padding:0;}
ul{list-style-type:none;margin:0;padding:0;}
.uk{float:left;width:600px;font-size:14px;padding:10px;}
.uk li{float:left;}
.uk .l1{width:80px;padding:7px 10px 0 0;height:36px;text-align:right;}
.uk .l2{width:510px;height:43px;}
.uk .l2 .inp{float:left;border:#CCCCCC solid 1px;height:27px;padding:4px 0 0 5px;outline:medium;}
.uk .l2 label{float:left;cursor:pointer;margin:-2px 10px 0 0;padding:8px 10px 0 10px;height:22px;background-color:#FCFCFD;border:#ECECEC solid 1px;border-radius:5px;}
.uk .l3{width:211px;padding-left:89px;}
.uk .l3 input{cursor:pointer;float:left;width:211px;border:0;font-weight:700;color:#fff;background-color:#ff6600;height:35px;}
</style>
<script language="javascript" src="../js/jquery.min.js"></script>
<script language="javascript" src="../js/layer.js"></script>
<script language="javascript">
function tj(){
layer.msg('正在保存', {icon: 16  ,time: 0,shade :0.25});
f1.action="shopmenu2.php?control=update&bh=<?=$bh?>";
}
<? if($_GET["t"]=="suc"){?>
parent.location.reload();
<? }?>
</script>
</head>
<body>
<form name="f1" method="post" onsubmit="return tj()">
<input type="hidden" value="menu" name="yjcode" />
<ul class="uk">
<li class="l1">一级导航：</li>
<li class="l2"><input type="text" class="inp" readonly="readonly" name="ttit1" value="<?=$row[tit1]?>" /></li>
<li class="l1">二级导航：</li>
<li class="l2"><input type="text" class="inp" name="ttit2" value="<?=$row[tit2]?>" /></li>
<li class="l1">导航链接：</li>
<li class="l2"><input type="text" class="inp" style="width:500px;" name="taurl" value="<?=$row[aurl]?>" /></li>
<li class="l1">打开方式：</li>
<li class="l2">
<label><input name="R1" type="radio" value="1"<? if($row[targ]==1){?> checked="checked"<? }?> /> 当前页面</label>
<label><input name="R1" type="radio" value="2"<? if($row[targ]==2){?> checked="checked"<? }?> /> 新窗口</label>
</li>
<li class="l1">分组序号：</li>
<li class="l2"><input type="text" class="inp" name="txh" value="<?=$row[xh]?>" /></li>
<li class="l3"><? tjbtnr("保存修改")?></li>
</ul>
</form>
</body>
</html>