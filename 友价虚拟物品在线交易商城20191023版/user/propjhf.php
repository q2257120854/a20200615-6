<?
include("../config/conn.php");
include("../config/function.php");
sesCheck();
$sj=date("Y-m-d H:i:s");
$id=intval($_GET[id]);
$userid=returnuserid($_SESSION[SHOPUSER]);

while0("*","yjcode_propj where selluserid=".$userid." and id=".$id);if(!$row=mysql_fetch_array($res)){Audit_alert("来源错误","propjlist.php","parent.");}

if($_GET[control]=="update"){
 zwzr();
 updatetable("yjcode_propj","hf='".sqlzhuru($_POST[s1])."',hfsj='".$sj."' where selluserid=".$userid." and id=".$id);
 php_toheader("propjhf.php?t=suc&id=".$id);
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
.uk{float:left;width:600px;font-size:14px;padding:0 10px 10px 10px;}
.uk li{float:left;}
.uk .l1{width:80px;text-align:right;padding:49px 10px 0 0;height:70px;}
.uk .l2{width:510px;height:106px;padding:13px 0 0 0;}
.uk .l2 textarea{width:500px;height:90px;border:#B6B7C9 solid 1px;float:left;}
.uk .l3{width:211px;padding-left:89px;}
.uk .l3 input{cursor:pointer;float:left;width:211px;border:0;font-weight:700;color:#fff;background-color:#ff6600;height:35px;}
</style>
<script language="javascript" src="../js/jquery.min.js"></script>
<script language="javascript" src="../js/layer.js"></script>
<script language="javascript">
function tj(){
layer.msg('正在保存', {icon: 16  ,time: 0,shade :0.25});
f1.action="propjhf.php?control=update&id=<?=$id?>";
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
<li class="l1">回复内容：</li>
<li class="l2"><textarea name="s1"><?=$row[hf]?></textarea></li>
<li class="l3"><? tjbtnr("提交回复")?></li>
</ul>
</form>
</body>
</html>