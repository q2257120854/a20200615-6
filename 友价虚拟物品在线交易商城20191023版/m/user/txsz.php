<?
include("../../config/conn.php");
include("../../config/function.php");
sesCheck_m();

if(sqlzhuru($_POST[jvs])=="tx"){
 zwzr();
 if(empty($_POST[t1])){Audit_alert("验证码有误！","txsz.php");}
 $zfmm=sha1(sqlzhuru($_POST[t1]));
 if(panduan("uid,zfmm","yjcode_user where pwd='".$zfmm."' and uid='".$_SESSION[SHOPUSER]."'")==0){Audit_alert("登录密码有误！","txsz.php");}
 updatetable("yjcode_user","txyh='".sqlzhuru($_POST[ttxyh])."',txname='".sqlzhuru($_POST[ttxname])."',txzh='".sqlzhuru($_POST[ttxzh])."',txkhh='".sqlzhuru($_POST[ttxkhh])."' where uid='".$_SESSION[SHOPUSER]."'");
 php_toheader("../tishi/index.php?admin=999&b=../user/txsz.php"); 

}

$sqluser="select * from yjcode_user where uid='".$_SESSION[SHOPUSER]."'";mysql_query("SET NAMES 'GBK'");$resuser=mysql_query($sqluser);
$rowuser=mysql_fetch_array($resuser);

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
 if((document.f1.ttxzh.value).replace("/\s/","")==""){layerts("请输入卡号/账号");return false;}
 if((document.f1.ttxname.value).replace("/\s/","")==""){layerts("请输入户名");return false;}
 if((document.f1.t1.value).replace("/\s/","")==""){layerts("请输入登录密码");return false;}
 layer.open({type: 2,content: '正在提交',shadeClose:false});
 f1.action="txsz.php";
}

function txlxcha(){
 tx=document.getElementById("ttxyh").value;
 if(tx=="支付宝" || tx=="微信"){document.getElementById("khh").style.display="none";}else{document.getElementById("khh").style.display="";}
}
</script>
</head>
<body>
<? include("topuser.php");?>

<div class="bfbtop1 box">
 <div class="d1" onClick="gourl('index.php')"><img src="img/topleft.png" height="21" /></div>
 <div class="d2">提现设置</div>
 <div class="d3"></div>
</div>

 <form name="f1" method="post" onSubmit="return tj()">
 <input type="hidden" value="tx" name="jvs" />
 <div class="uk box">
  <div class="d1">提现类型<span class="s1"></span></div>
  <div class="d2">
  <select name="ttxyh" id="ttxyh" onChange="txlxcha()">
  <?
  $yharr=preg_split("/xcf/",$rowcontrol[txyh]);
  for($i=0;$i<=count($yharr);$i++){
  if(!empty($yharr[$i])){
  ?>
  <option value="<?=$yharr[$i]?>"<? if($rowuser[txyh]==$yharr[$i]){?> selected="selected"<? }?>><?=$yharr[$i]?></option>
  <?
  }}
  ?>
  </select>
  </div>
  <div class="d3"><img src="../img/rightjian.png" height="13" /></div>
 </div>
 <div class="uk box">
  <div class="d1">收款账号<span class="s1"></span></div>
  <div class="d2"><input type="text" value="<?=$rowuser[txzh]?>" class="inp" placeholder="请输入银行卡号/账号" name="ttxzh" /></div>
 </div>
 <div class="uk box" id="khh">
  <div class="d1">开户银行<span class="s1"></span></div>
  <div class="d2"><input type="text" value="<?=$rowuser[txkhh]?>" class="inp" placeholder="请输入开户行名称" name="ttxkhh" /></div>
 </div>
 <div class="uk box">
  <div class="d1">收款姓名<span class="s1"></span></div>
  <div class="d2"><input type="text" value="<?=$rowuser[txname]?>" class="inp" placeholder="请输入户名" name="ttxname" /></div>
 </div>
 <div class="uk box">
  <div class="d1">登录密码<span class="s1"></span></div>
  <div class="d2"><input type="password" class="inp" placeholder="请输入登录密码" name="t1" /></div>
 </div>

 <div class="fbbtn box">
 <div class="d1"><? tjbtnr_m("保存")?></div>
 </div>
 </form>

<script language="javascript">txlxcha();</script>
</body>
</html>