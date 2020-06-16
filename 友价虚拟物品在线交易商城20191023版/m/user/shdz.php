<?
include("../../config/conn.php");
include("../../config/function.php");
sesCheck_m();

$bh=$_GET[bh];
$userid=returnuserid($_SESSION["SHOPUSER"]);
if($_GET[control]=="update"){
 $sj=date("Y-m-d H:i:s");	
 $ifmr=intval($_POST[R1]);
 if(1==$ifmr){updatetable("yjcode_shdz","ifmr=0");}
 $area1=sqlzhuru($_POST[add1]);
 $area2=sqlzhuru($_POST[add2]);
 $area3=sqlzhuru($_POST[add3]);
 updatetable("yjcode_shdz","lxr='".sqlzhuru($_POST[t1])."',add1=".$area1.",add1v='".returnarea($area1)."',add2=".$area2.",add2v='".returnarea($area2)."',add3=".$area3.",add3v='".returnarea($area3)."',addr='".sqlzhuru($_POST[t2])."',mot='".sqlzhuru($_POST[t3])."',yb='".sqlzhuru($_POST[t4])."',sj='".$sj."',zt=0,ifmr=".$ifmr." where bh='".$bh."' and userid=".$userid);
 php_toheader("../tishi/index.php?admin=999&b=../user/shdzlist.php"); 
}

while0("*","yjcode_shdz where bh='".$bh."' and userid=".$userid);if(!$row=mysql_fetch_array($res)){php_toheader("shdzlist.php");}
$add1=$row[add1];
$add2=$row[add2];
$add3=$row[add3];
$add1v=$row[add1v];
$add2v=$row[add2v];
$add3v=$row[add3v];

?>
<html>
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
<title>会员中心 <?=webname?></title>
<? include("../tem/cssjs.html");?>
<link href="css/buy.css" rel="stylesheet" type="text/css" />
<script language="javascript">
function tj(){
if(document.f1.t1.value==""){layerts("请输入收货人姓名");return false;}	
if(document.f1.t2.value==""){layerts("请输入详细地址");return false;}	
if(document.f1.t3.value==""){layerts("请输入手机号码");return false;}	
layer.open({type: 2,content: '正在提交',shadeClose:false});
f1.action="shdz.php?control=update&bh=<?=$bh?>";
}
function area1cha(){
	alert(document.getElementById("area1").value)
 farea2.location="../tem/area2.php?area1id="+document.getElementById("area1").value;	
}
function qytang(){
layer.open({
    type: 1
    ,content: document.getElementById("shdztang").innerHTML
    ,anim: 'up'
    ,style: 'position:fixed; bottom:0; left:0; width: 100%; height: 200px; padding:10px 0; border:none;'
  });
}
</script>
</head>
<body>
<? include("topuser.php");?>

<div class="bfbtop1 box">
 <div class="d1" onClick="gourl('shdzlist.php')"><img src="img/topleft.png" height="21" /></div>
 <div class="d2">编辑收货地址</div>
 <div class="d3"></div>
</div>

<!--区域B-->
<div id="shdztang" style="display:none;">
<div class="shdzt box">
 <div class="d1">选择收货地址</div>
</div>
<div class="shdzt2 box">
 <div class="d1">
  <iframe name="farea2" id="farea2" marginwidth="1" scrolling="no" marginheight="1" width="100%" height="200" border="0" frameborder="0" src="../tem/area2.php?area1id=<?=$add1?>&area2id=<?=$add2?>&area3id=<?=$add3?>"></iframe>
 </div>
</div>
</div>
<!--区域E-->

<form name="f1" method="post" onSubmit="return tj()">
<input type="hidden" value="<?=$add1?>" id="add1" name="add1" />
<input type="hidden" value="<?=$add2?>" id="add2" name="add2" />
<input type="hidden" value="<?=$add3?>" id="add3" name="add3" />
<input type="hidden" value="inf" name="jvs" />
<div class="uk box">
 <div class="d1">收 件 人<span class="s1"></span></div>
 <div class="d2"><input type="text" name="t1" class="inp" value="<?=$row[lxr]?>" /></div>
</div>
<div class="uk box" onClick="qytang()">
 <div class="d1">所在地区<span class="s1"></span></div>
 <div class="d2" id="qyname"><?=$add1v.$add2v.$add3v?></div>
 <div class="d3"><img src="../img/rightjian.png" height="13" /></div>
</div>
<div class="uk box">
 <div class="d1">详情地址<span class="s1"></span></div>
 <div class="d2"><input type="text" name="t2" class="inp" value="<?=$row[addr]?>" /></div>
</div>
<div class="uk box">
 <div class="d1">手机号码<span class="s1"></span></div>
 <div class="d2"><input type="text" name="t3" class="inp" value="<?=$row[mot]?>" /></div>
</div>
<div class="uk box">
 <div class="d1">邮 编<span class="s1"></span></div>
 <div class="d2"><input type="text" name="t4" class="inp" value="<?=$row[yb]?>" /></div>
</div>
<div class="uk box">
 <div class="d1">默认地址<span class="s1"></span></div>
 <div class="d2">
 <select name="R1" style="font-size:13px;">
 <option value="0"<? if(empty($row[ifmr])){?> selected<? }?>>否</option>
 <option value="1"<? if($row[ifmr]==1){?> selected<? }?>>是</option>
 </select>
 </div>
 <div class="d3"><img src="../img/rightjian.png" height="13" /></div>
</div>

<div class="fbbtn box">
 <div class="d1"><? tjbtnr_m("保存地址")?></div>
</div>

</form>

</body>
</html>