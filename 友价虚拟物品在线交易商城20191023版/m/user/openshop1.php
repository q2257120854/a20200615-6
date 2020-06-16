<?
include("../../config/conn.php");
include("../../config/function.php");
sesCheck_m();
$sj=date("Y-m-d H:i:s");
$sqluser="select * from yjcode_user where uid='".$_SESSION[SHOPUSER]."'";mysql_query("SET NAMES 'GBK'");$resuser=mysql_query($sqluser);
$rowuser=mysql_fetch_array($resuser);
if(1==$rowuser[shopzt] || 2==$rowuser[shopzt] || 3==$rowuser[shopzt]){php_toheader("openshop3.php");}

//入库操作开始
if($_POST[yjcode]=="openshop"){
 zwzr();
 $t1=sqlzhuru($_POST[t1]);
 $t2=sqlzhuru($_POST[t2]);
 $s1=sqlzhuru($_POST[s1]);
 if(empty($t1) || empty($t2) || empty($s1)){Audit_alert("信息不完整，返回重试！","openshop1.php");}
 if(panduan("*","yjcode_user where shopname='".$t1."' and uid<>'".$_SESSION[SHOPUSER]."'")==1){Audit_alert("店铺名称已经被其他用户使用，返回重试！","openshop1.php");}
 updatetable("yjcode_user","shopname='".$t1."',seokey='".$t2."',seodes='".$s1."' where uid='".$_SESSION[SHOPUSER]."'");
 if($rowcontrol[ifsell]=="on"){
 $dqsj=date('Y-m-d H:i:s',strtotime ("+12 month",strtotime($sj)));
 updatetable("yjcode_user","shopzt=2,dqsj='".$dqsj."' where id=".$rowuser[id]);
 php_toheader("openshop3.php");
 }else{
 php_toheader("openshop2.php");
 }
}
//入库操作结束

?>
<html>
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
<title>会员中心 <?=webname?></title>
<? include("../tem/cssjs.html");?>
<link href="css/sell.css" rel="stylesheet" type="text/css" />
<script language="javascript">
function tj(){
if((document.f1.t1.value).replace(/\s/,"")==""){layerts("请输入店铺名称");return false;}	
if((document.f1.t2.value).replace(/\s/,"")==""){layerts("请输入主营产品");return false;}	
if((document.f1.s1.value).replace(/\s/,"")==""){layerts("请输入店铺简要描述");return false;}	
layer.open({type: 2,content: '正在保存',shadeClose:false});
f1.action="openshop1.php";
}
</script>
</head>
<body>
<? include("topuser.php");?>

<div class="bfbtop1 box">
 <div class="d1" onClick="gourl('index.php')"><img src="img/topleft.png" height="21" /></div>
 <div class="d2">我要开店</div>
 <div class="d3"></div>
</div>

<? include("kdcap.php");?>
<script language="javascript">
document.getElementById("step1").className="d1 d11";
</script>

<form name="f1" method="post" onSubmit="return tj()">
<input type="hidden" value="openshop" name="yjcode" />
<div class="uk box">
 <div class="d1">店铺名称<span class="s1"></span></div>
 <div class="d2"><input type="text" class="inp" placeholder="请输入店铺名称" name="t1" value="<?=$rowuser[shopname]?>" /></div>
</div>
<div class="uk box">
 <div class="d1">主营产品<span class="s1"></span></div>
 <div class="d2"><input type="text" class="inp" placeholder="请输入主营产品" name="t2" value="<?=$rowuser[seokey]?>" /></div>
</div>
<div class="uk box">
 <div class="d1">简要描述<span class="s1"></span></div>
 <div class="d2"><textarea name="s1" placeholder="请输入简要描述"><?=$rowuser[seodes]?></textarea></div>
</div>
<!--效果图B-->
<div class="uk box">
 <div class="d1">店铺图标<span class="s1"></span></div>
 <div class="d2"><iframe style="float:left;" src="tpupload.php?admin=1" width="103" scrolling="no" height="103" frameborder="0"></iframe></div>
</div>
<div class="xgtp box">
<div class="xgtpm">
 <div id="xgtp1" style="display:none;">正在处理</div>
 <div id="xgtp2"></div>
</div>
</div>
<!--效果图E-->
<div class="fbbtn box">
 <div class="d1"><? tjbtnr_m("下 一 步")?></div>
</div>

</form>
</body>
</html>