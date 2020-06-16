<?
include("../config/conn.php");
include("../config/function.php");
sesCheck();
$bh=$_GET[bh];
$userid=returnuserid($_SESSION["SHOPUSER"]);
if($_GET[control]=="update"){
 $sj=date("Y-m-d H:i:s");	
 $ifmr=intval($_POST[R1]);
 if(1==$ifmr){updatetable("yjcode_shdz","ifmr=0");}
 $area1=sqlzhuru($_POST[area1]);
 $area2=sqlzhuru($_POST[add2]);
 $area3=sqlzhuru($_POST[add3]);
 updatetable("yjcode_shdz","lxr='".sqlzhuru($_POST[t1])."',add1=".$area1.",add1v='".returnarea($area1)."',add2=".$area2.",add2v='".returnarea($area2)."',add3=".$area3.",add3v='".returnarea($area3)."',addr='".sqlzhuru($_POST[t2])."',mot='".sqlzhuru($_POST[t3])."',yb='".sqlzhuru($_POST[t4])."',sj='".$sj."',zt=0,ifmr=".$ifmr." where bh='".$bh."' and userid=".$userid);
 php_toheader("shdz.php?t=suc&bh=".$bh);
}

while0("*","yjcode_shdz where bh='".$bh."' and userid=".$userid);if(!$row=mysql_fetch_array($res)){php_toheader("shdzlist.php");}
$ifarea="yes";
$add1=$row[add1];
$add2=$row[add2];
$add3=$row[add3];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>收货地址管理</title>
<style type="text/css">
body{margin:0;font-size:12px;text-align:center;color:#333;word-wrap:break-word;font-family:"Microsoft YaHei",微软雅黑,"MicrosoftJhengHei",华文细黑,STHeiti,MingLiu;}
*{margin:0 auto;padding:0;}
ul{list-style-type:none;margin:0;padding:0;}
.red{color:#ff0000;}
.uk{float:left;width:700px;font-size:14px;}
.uk li{float:left;}
.uk .l1{width:100px;text-align:right;padding:14px 8px 0 0;height:36px;border-bottom:#F5F5F5 dotted 1px;}
.uk .l2{width:592px;height:42px;padding:8px 0 0 0;border-bottom:#F5F5F5 dotted 1px;}
.uk .l2 label{float:left;cursor:pointer;margin:0 20px 0 0;padding:8px 20px 0 10px;height:22px;background-color:#FCFCFD;border:#ECECEC solid 1px;border-radius:5px;}
.uk .l2 .inp{float:left;outline:none;border:#CCCCCC solid 1px;height:27px;padding:4px 0 0 5px;margin-right:7px;}
.uk .l2 .fd{float:left;margin-right:5px;}
.uk .l3{width:100px;text-align:right;padding:13px 8px 0 0;height:55px;border-bottom:#F5F5F5 dotted 1px;font-weight:700;}
.uk .l4{width:592px;height:55px;padding:13px 0 0 0;border-bottom:#F5F5F5 dotted 1px;}
.btn1{cursor:pointer;float:left;border:0;color:#fff;width:173px;height:44px;margin-right:10px;background-color:#E83A17;font-size:16px;}
.btn2{background-color:#D43211;}
</style>
<script language="javascript" src="../js/jquery.min.js"></script>
<script language="javascript" src="../js/layer.js"></script>
<script language="javascript">
function tj(){
if(document.f1.t1.value==""){alert("请输入收货人姓名");document.f1.t1.focus();return false;}	
if(document.f1.t2.value==""){alert("请输入详细地址");document.f1.t2.focus();return false;}	
if(document.f1.t3.value==""){alert("请输入手机号码");document.f1.t3.focus();return false;}	
layer.msg('正在保存', {icon: 16  ,time: 0,shade :0.25});
f1.action="shdz.php?control=update&bh=<?=$bh?>";
}
function area1cha(){
 farea2.location="../tem/area2.php?area1id="+document.getElementById("area1").value;	
}
<? if($_GET[t]=="suc"){?>
parent.location.reload();
<? }?>
</script>
</head>
<body>
<form name="f1" method="post" onsubmit="return tj()">
<input type="hidden" value="shdz" name="jvs" />
<ul class="uk">
<li class="l1"><span class="red">*</span> 收货人：</li>
<li class="l2"><input name="t1" class="inp" value="<?=$row[lxr]?>" size="25" type="text" /></li>
<li class="l1"><span class="red">*</span> 所在地区：</li>
<li class="l2"><? include("../tem/area.php");?></li>
<li class="l1"><span class="red">*</span> 详细地址：</li>
<li class="l2"><input name="t2" class="inp" value="<?=$row[addr]?>" size="50" type="text" /></li>
<li class="l1"><span class="red">*</span> 手机号码：</li>
<li class="l2"><input name="t3" class="inp" value="<?=$row[mot]?>" size="25" type="text" /></li>
<li class="l1">默认地址：</li>
<li class="l2">
<span class="finp">
<label><input name="R1" type="radio" value="0"<? if(empty($row[ifmr])){?> checked="checked"<? }?> /> 否</label>&nbsp;&nbsp;&nbsp;
<label><input name="R1" type="radio" value="1"<? if($row[ifmr]==1){?> checked="checked"<? }?> /> 是</label>
</span>
</li>
<li class="l1">邮编：</li>
<li class="l2"><input name="t4" class="inp" value="<?=$row[yb]?>" size="10" type="text" /></li>
<li class="l3"></li>
<li class="l4"><?=tjbtnr("保存修改")?></li>
</ul>
</form>
</body>
</html>