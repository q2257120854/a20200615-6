<?
include("../config/conn.php");
include("../config/function.php");
include("../config/tpclass.php");
sesCheck();
$sqluser="select * from yjcode_user where uid='".$_SESSION[SHOPUSER]."'";mysql_query("SET NAMES 'GBK'");$resuser=mysql_query($sqluser);
if(!$rowuser=mysql_fetch_array($resuser)){php_toheader("../reg/");}

if($_POST[jvs]=="smrz"){
 zwzr();
 if(panduan("uid,sfzrz","yjcode_user where uid='".$_SESSION[SHOPUSER]."' and (sfzrz=2 or sfzrz=3)")==0){Audit_alert("错误的请求！","smrz.php");}
 $sfz=returndeldian($_POST[tsfz]);
 if(strlen(stripos($sfz,"/"))>0 || strlen(stripos($sfz,";"))>0){Audit_alert("身份证号码格式有误！","smrz.php");}
 updatetable("yjcode_user","uname='".sqlzhuru($_POST[tuname])."',sfz='".sqlzhuru($_POST[tsfz])."',sfzrz=0 where uid='".$_SESSION[SHOPUSER]."'");
 uploadtpnodata(1,"upload/".$rowuser[id]."/",strgb2312($sfz,0,15)."-1.jpg","allpic",510,0,0,0,"no");
 uploadtpnodata(2,"upload/".$rowuser[id]."/",strgb2312($sfz,0,15)."-2.jpg","allpic",510,0,0,0,"no");
 //uploadtpnodata(3,"upload/".$rowuser[id]."/",strgb2312($sfz,0,15)."-3.jpg","allpic",800,0,0,0,"no");
 php_toheader("smrz.php?t=suc"); 
}

$sfz1="../upload/".$rowuser[id]."/".strgb2312($rowuser[sfz],0,15)."-1.jpg";
$sfz2="../upload/".$rowuser[id]."/".strgb2312($rowuser[sfz],0,15)."-2.jpg";
//$sfz3="../upload/".$rowuser[id]."/".strgb2312($rowuser[sfz],0,15)."-3.jpg";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>用户管理面板 - <?=webname?></title>
<? include("cssjs.html");?>
<script language="javascript">
function tj(){
 if((document.f1.tuname.value).replace("/\s/","")==""){alert("请输入真实姓名");document.f1.tuname.focus();return false;}
 if((document.f1.tsfz.value).replace("/\s/","")==""){alert("请输入身份证号码");document.f1.tsfz.focus();return false;}
 layer.msg('正在提交', {icon: 16  ,time: 0,shade :0.25});
 tjwait();
 f1.action="smrz.php";
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
 
 <? include("rcap1.php");?>
 <script language="javascript">
 document.getElementById("rcap7").className="l1 l2";
 </script>

 <!--白B-->
 <div class="rkuang">
 
 <? systs("恭喜您，操作成功!","smrz.php")?>
 <div class="rts">
 认证状态<br>
 <? 
 if(0==$rowuser[sfzrz]){echo "<strong class='blue'>已提交资料，正在审核认证，请耐心等待</strong>";}
 elseif(1==$rowuser[sfzrz]){echo "<strong class='green'>已经通过实名认证</strong>";}
 elseif(2==$rowuser[sfzrz]){echo "<strong class='red'>认证被拒，原因：".$rowuser[sfzrzsm]."</strong>";}
 elseif(3==$rowuser[sfzrz]){echo "<strong>未提交认证资料，请填写以下信息并提交</strong>";}
 ?>
 </div>
 <form name="f1" method="post" onsubmit="return tj()" enctype="multipart/form-data">
 <input type="hidden" value="smrz" name="jvs" />
 <ul class="uk">
 <li class="l1">安全提示：</li>
 <li class="l21 blue">您的真实姓名、身份证号及身份证照片，我们仅用于实名认证，不会透露给任何第三方</li>
 <li class="l1"><span class="red" style="font-weight:normal;">*</span> 真实姓名：</li>
 <li class="l2"><input type="text" class="inp" name="tuname" value="<?=$rowuser[uname]?>" /></li>
 <li class="l1"><span class="red" style="font-weight:normal;">*</span> 身份证号：</li>
 <li class="l2"><input type="text" class="inp" name="tsfz" value="<?=$rowuser[sfz]?>" /></li>
 <li class="l1"><span class="red" style="font-weight:normal;">*</span> 身份证正面：</li>
 <li class="l2"><input type="file" class="inp" name="inp1" id="inp1" size="25"></li>
 <? if(is_file($sfz1)){?>
 <li class="l5"></li>
 <li class="l6"><a href="<?=$sfz1?>" target="_blank"><img border="0" src="<?=$sfz1?>?t=<?=time()?>" width="170" height="100" /></a></li>
 <? }?>
 <li class="l1"><span class="red" style="font-weight:normal;">*</span> 身份证反面：</li>
 <li class="l2"><input type="file" class="inp" name="inp2" id="inp2" size="25"></li>
 <? if(is_file($sfz2)){?>
 <li class="l5"></li>
 <li class="l6"><a href="<?=$sfz2?>" target="_blank"><img border="0" src="<?=$sfz2?>?t=<?=time()?>" width="170" height="100" /></a></li>
 <? }?>
 <? if(2==$rowuser[sfzrz] || 3==$rowuser[sfzrz]){?>
 <li class="l3"><? tjbtnr("保存修改")?></li>
 <? }?>
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