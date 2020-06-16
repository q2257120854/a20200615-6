<?
include("../config/conn.php");
include("../config/function.php");
include("../config/tpclass.php");
sesCheck();
$sj=date("Y-m-d H:i:s");
$sqluser="select * from yjcode_user where uid='".$_SESSION[SHOPUSER]."'";mysql_query("SET NAMES 'GBK'");$resuser=mysql_query($sqluser);
$rowuser=mysql_fetch_array($resuser);
if(1==$rowuser[shopzt] || 2==$rowuser[shopzt] || 3==$rowuser[shopzt]){php_toheader("openshop3.php");}
$usertx="../upload/".$rowuser[id]."/shop.jpg";
if(!is_file($usertx)){$usertx="img/none100x100.gif";}else{$usertx=$usertx."?id=".rnd_num(1000);}

//入库操作开始
if($_POST[jvs]=="openshop"){
 zwzr();
 $t1=sqlzhuru($_POST[t1]);
 $t2=sqlzhuru($_POST[t2]);
 $s1=sqlzhuru($_POST[s1]);
 if(empty($t1) || empty($t2) || empty($s1)){Audit_alert("信息不完整，返回重试！","openshop1.php");}
 if(panduan("*","yjcode_user where shopname='".$t1."' and uid<>'".$_SESSION[SHOPUSER]."'")==1){Audit_alert("店铺名称已经被其他用户使用，返回重试！","openshop1.php");}
 updatetable("yjcode_user","shopname='".$t1."',seokey='".$t2."',seodes='".$s1."' where uid='".$_SESSION[SHOPUSER]."'");
 uploadtpnodata(1,"upload/".$rowuser[id]."/","shop.jpg","allpic",300,300,0,0,"no");
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>用户管理面板 - <?=webname?></title>
<? include("cssjs.html");?>
<link href="css/sell.css" rel="stylesheet" type="text/css" />
<script language="javascript">
function tj(){
if((document.f1.t1.value).replace(/\s/,"")==""){alert("请输入店铺名称");document.f1.t1.focus();return false;}	
if((document.f1.t2.value).replace(/\s/,"")==""){alert("请输入主营产品");document.f1.t2.focus();return false;}	
if((document.f1.s1.value).replace(/\s/,"")==""){alert("请输入店铺简要描述");document.f1.s1.focus();return false;}	
if(document.getElementById("C1").checked==false){alert("请先阅读并同意开店协议");return false;}
layer.msg('正在提交', {icon: 16  ,time: 0,shade :0.25});
tjwait();
f1.action="openshop1.php";
}
</script>
</head>
<body>
<? include("../tem/top.html");?>
<? include("top.php");?>
<div class="yjcode">

<? include("left.php");?>

<!--RB-->
<div class="userright">
 
 <? if($rowcontrol[ifsell]!="on"){?>
 <? include("kdcap.php");?>
 <script language="javascript">
 document.getElementById("step1").className="l1 l11";
 </script>
 <? }?>

 <!--白B-->
 <div class="rkuang">
 
 <form name="f1" method="post" onsubmit="return tj()" enctype="multipart/form-data">
 <input type="hidden" value="openshop" name="jvs" />
 <ul class="uk">
 <li class="l1">店铺名称：</li>
 <li class="l2"><input type="text" class="inp" value="<?=$rowuser[shopname]?>" name="t1" /></li>
 <li class="l1">店铺LOGO：</li>
 <li class="l2"><span class="finp"><input type="file" name="inp1" id="inp1" size="25"> 最佳尺寸：300*300</span></li>
 <li class="l5"></li>
 <li class="l6"><img src="<?=$usertx?>" width="100" height="100" /></li>
 <li class="l1">主营产品：</li>
 <li class="l2"><input type="text" class="inp" value="<?=$rowuser[seokey]?>" name="t2" size="60" /></li>
 <li class="l9">店铺简要描述：</li>
 <li class="l10"><textarea name="s1"><?=$rowuser[seodes]?></textarea></li>
 <li class="l1"></li>
 <li class="l2"><label><input id="C1" type="checkbox" value="1" /> 我已阅读《<a href="../help/aboutview7.html" class="feng" target="_blank">开店协议</a>》并同意</label></li>
 <li class="l3"><?=tjbtnr("下一步")?></li>
 </ul>
 </form>
 
 </div>
 <!--白E-->

</div> 
<!--RE-->

</div>

<div class="clear clear15"></div>
<? include("../tem/bottom.html");?>
</body>
</html>