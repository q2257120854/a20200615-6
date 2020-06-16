<?php
include("../config/conn.php");
include("../config/function.php");
require("../config/tpclass.php");
AdminSes_audit();
$id=$_GET[id];

//函数开始
if(sqlzhuru($_POST[jvs])=="sf"){
 zwzr();
 $sfz=sqlzhuru($_POST[tsfz]);
 if(strlen(stripos($sfz,"/"))>0 || strlen(stripos($sfz,";"))>0){Audit_alert("身份证号码格式有误！","userrz.php?id=".$id);}
 updatetable("yjcode_user","
			 uname='".sqlzhuru($_POST[tuname])."',
			 sfz='".$sfz."',
			 sfzrz=".sqlzhuru($_POST[R1]).",
			 sfzrzsm='".sqlzhuru($_POST[tsfzrzsm])."' 
			 where id=".$id);
 uploadtpnodata(1,"upload/".$id."/",strgb2312($sfz,0,15)."-1.jpg","allpic",510,0,0,0,"no");
 uploadtpnodata(2,"upload/".$id."/",strgb2312($sfz,0,15)."-2.jpg","allpic",510,0,0,0,"no");
 php_toheader("userrz.php?id=".$id); 

}
//函数结果
while0("*","yjcode_user where id=".$id);if(!$row=mysql_fetch_array($res)){php_toheader("userlist.php");}
$sfz1="../upload/".$id."/".strgb2312($row[sfz],0,15)."-1.jpg";
$sfz2="../upload/".$id."/".strgb2312($row[sfz],0,15)."-2.jpg";
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
<script language="javascript">
function tjsf(){
 if((document.fsf.tuname.value).replace("/\s/","")==""){alert("请输入真实姓名");document.fsf.tuname.focus();return false;}
 if((document.fsf.tsfz.value).replace("/\s/","")==""){alert("请输入身份证号码");document.fsf.tsfz.focus();return false;}
 layer.msg('正在提交', {icon: 16  ,time: 0,shade :0.25});
 fsf.action="userrz.php?id=<?=$id?>";
}
function sfzrzonc(x){
if(2==x){document.getElementById("sfzrzsmv").style.display="";}else{document.getElementById("sfzrzsmv").style.display="none";}
}
</script>
</head>
<body>
<? include("top.php");?>
<script language="javascript">
document.getElementById("menu2").className="a1";
</script>
<? if(!strstr($adminqx,",0,") && !strstr($adminqx,",0702,")){echo "<div class='noneqx'>无权限</div>";exit;}?>

<div class="yjcode">
 <? $leftid=1;include("menu_user.php");?>

<div class="right">

 <? include("rightcap3.php");?>
 <script language="javascript">document.getElementById("rtit5").className="a1";</script>
 <!--B-->
 <div class="rights">
 身份证认证状态<br>
 <? 
 if(0==$row[sfzrz]){echo "&nbsp;<strong class='blue'>身份证已提交，需要审核认证</strong>";}
 elseif(1==$row[sfzrz]){echo "&nbsp;<strong class='green'>已经通过实名认证</strong>";}
 elseif(2==$row[sfzrz]){echo "&nbsp;<strong class='red'>认证被拒，原因：".$row[sfzrzsm]."</strong>";}
 elseif(3==$row[sfzrz]){echo "&nbsp;<strong>未提交认证资料</strong>";}
 ?>
 </div>
 <div class="rkuang">
 <form name="fsf" method="post" onsubmit="return tjsf()" enctype="multipart/form-data">
 <input type="hidden" value="sf" name="jvs" />
 <ul class="uk">
 <li class="l1">会员帐号：</li>
 <li class="l2"><input type="text" class="inp redony" readonly="readonly" name="tuid" size="20" value="<?=$row[uid]?>" /></li>
 <li class="l1">身份证审核：</li>
 <li class="l2">
 <label><input name="R1" type="radio" onclick="sfzrzonc(0)" value="0"<? if(0==$row[sfzrz]){?> checked="checked"<? }?> /> 等待审核</label>
 <label><input name="R1" type="radio" onclick="sfzrzonc(0)" value="1"<? if(1==$row[sfzrz]){?> checked="checked"<? }?> /> 通过认证</label>
 <label><input name="R1" type="radio" onclick="sfzrzonc(2)" value="2"<? if(2==$row[sfzrz]){?> checked="checked"<? }?> /> 认证不通过</label>
 <label><input name="R1" type="radio" onclick="sfzrzonc(0)" value="3"<? if(3==$row[sfzrz]){?> checked="checked"<? }?> /> 未提交认证</label>
 </li>
 </ul>
 <ul class="uk uk0" id="sfzrzsmv" style="display:none;">
 <li class="l1">被拒原因：</li>
 <li class="l2"><input type="text" class="inp" name="tsfzrzsm" size="90" value="<?=$row[sfzrzsm]?>" /></li>
 </ul>
 <ul class="uk uk0">
 <li class="l1"><span class="red" style="font-weight:normal;">*</span> 真实姓名：</li>
 <li class="l2"><input type="text" class="inp" name="tuname" value="<?=$row[uname]?>" /></li>
 <li class="l1"><span class="red" style="font-weight:normal;">*</span> 身份证号：</li>
 <li class="l2"><input type="text" class="inp" name="tsfz" value="<?=$row[sfz]?>" /></li>
 <li class="l1"><span class="red" style="font-weight:normal;">*</span> 身份证正面：</li>
 <li class="l2"><input type="file" name="inp1" class="inp1" id="inp1" size="25"></li>
 <? if(is_file($sfz1)){?>
 <li class="l8"></li>
 <li class="l9"><a href="<?=$sfz1?>" target="_blank"><img border="0" src="<?=$sfz1?>?t=<?=time()?>" width="100" height="50" /></a></li>
 <? }?>
 <li class="l1"><span class="red" style="font-weight:normal;">*</span> 身份证反面：</li>
 <li class="l2"><input type="file" name="inp2" class="inp1" id="inp2" size="25"></li>
 <? if(is_file($sfz2)){?>
 <li class="l8"></li>
 <li class="l9"><a href="<?=$sfz2?>" target="_blank"><img border="0" src="<?=$sfz2?>?t=<?=time()?>" width="100" height="50" /></a></li>
 <? }?>
 <li class="l3"><input type="submit" value="保存修改" class="btn1" /></li>
 </ul>
 </form>
 </div>
 <script language="javascript">
 sfzrzonc(<?=$row[sfzrz]?>);
 </script>
 <!--E-->

</div>
</div>
<?php include("bottom.php");?>
</body>
</html>