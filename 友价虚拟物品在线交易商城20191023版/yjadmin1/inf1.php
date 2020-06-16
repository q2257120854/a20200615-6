<?php
include("../config/conn.php");
include("../config/function.php");
AdminSes_audit();

if($_POST[jvs]=="control"){
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0301,")){Audit_alert("权限不够","default.php");}
 zwzr();
 if(panduan("*","yjcode_control")==0){intotable("code_control","webnamev","'保存失败'");}
 $regmob=sqlzhuru($_POST[Rregmob]);
 updatetable("yjcode_control","
			  ifsell='".sqlzhuru($_POST[Rifsell])."',
			  openshop=".intval($_POST[topenshop]).",
			  openbao=".intval($_POST[topenbao]).",
			  ifproduct='".sqlzhuru($_POST[Rifproduct])."',
			  ifkf='".sqlzhuru($_POST[Rifkf])."',
			  taskok=".sqlzhuru($_POST[Rtaskok]).",
			  shoprz='".$_GET[shoprz]."',
			  ifuc=".$_POST[Rifuc].",
			  ifwap=".$_POST[Rifwap].",
			  iftask=".$_POST[Riftask].",
			  regmob=".$regmob.",
			  taskjs='".$_GET[taskjs]."',
			  ifshell=".intval($_POST[Rifshell]).",
			  fenxiang=".intval($_POST[Rfenxiang]).",
			  qzmot=".intval($_POST[Rqzmot]).",
			  ipzcnum=".intval($_POST[tipzcnum]).",
			  ipnewsnum=".intval($_POST[tipnewsnum]).",
			  ifopenshop='".sqlzhuru($_POST[Rifopenshop])."',
			  mrbuy=".intval($_POST[Rmrbuy])."
			  ");
			  
 deletetable("yjcode_openyue");
 $al=intval($_POST[yuenum]);
 for($i=1;$i<=$al;$i++){
 $yue=$_POST["yue_".$i];
 $money1=$_POST["money1_".$i];
 intotable("yjcode_openyue","yue,money1","".$yue.",".$money1."");
 }
  
 move_uploaded_file($_FILES["inp1"]['tmp_name'], "../img/anzhuo.apk");
 php_toheader("inf1.php?t=suc");

}

while0("*","yjcode_control");$row=mysql_fetch_array($res);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><?=webname?>管理系统</title>
<link href="css/basic.css" rel="stylesheet" type="text/css" />
<link href="css/quanju.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script language="javascript" src="js/basic.js"></script>
<script language="javascript" src="js/layer.js"></script>
<script language="javascript">
function tj(){
c=document.getElementsByName("C1");str="xcf";for(i=0;i<c.length;i++){if(c[i].checked){str=str+c[i].value+"xcf";}}
c=document.getElementsByName("C2");str1="xcf";for(i=0;i<c.length;i++){if(c[i].checked){str1=str1+c[i].value+"xcf";}}
layer.msg('正在提交', {icon: 16  ,time: 0,shade :0.25});
f1.action="inf1.php?shoprz="+str+"&taskjs="+str1;
}
function shoprzonc(x){
if(x=="on"){document.getElementById("shoprz1").style.display="none";}
else if(x=="off"){document.getElementById("shoprz1").style.display="";}
}
function yueadd2(){
a=parseInt(document.f1.yuenum.value);
document.f1.yuenum.value=a+5;
str=document.getElementById("yue2").innerHTML;
for(i=1;i<=5;i++){
b=a+i;
str=str+"<ul class=\"yue\"><li class=\"l1\"><input type=\"text\" name=\"yue_"+b+"\" /></li><li class=\"l2\"><input type=\"text\" name=\"money1_"+b+"\" /></li></ul>";
}
document.getElementById("yue2").innerHTML=str;
}
</script>
</head>
<body>
<? include("top.php");?>
<script language="javascript">
document.getElementById("menu1").className="a1";
</script>
<? if(!strstr($adminqx,",0,") && !strstr($adminqx,",0302,")){echo "<div class='noneqx'>无权限</div>";exit;}?>

<div class="yjcode">
 <? $leftid=1;include("menu_quan.php");?>

<div class="right">
 
 <? if($_GET[t]=="suc"){systs("恭喜您，操作成功！","inf1.php");}?>
 <? include("rightcap1.php");?>
 <script language="javascript">document.getElementById("rtit2").className="a1";</script>
 
 <!--Begin-->
 <div class="rkuang">
 <form name="f1" method="post" onsubmit="return tj()" enctype="multipart/form-data">
 <input type="hidden" name="jvs" value="control" />
 <ul class="uk">
 <li class="l1">卖家开店权限：</li>
 <li class="l2">
 <label><input name="Rifsell" onclick="shoprzonc('off')" type="radio" value="off" <? if($row[ifsell]=="off"){?> checked="checked"<? }?> /> 需要审核</label>
 <label><input name="Rifsell" onclick="shoprzonc('on')" type="radio" value="on" <? if($row[ifsell]=="on"){?> checked="checked"<? }?> /> 不需要审核</label>
 <span class="fd">如果设置不需要审核，系统将免费赠送一年的开店时长</span>
 </li>
 </ul>
 
 <div id="shoprz1" style="display:none;">
 <ul class="uk">
 <li class="l1">开店审核费：</li>
 <li class="l2"><input type="text" class="inp" name="topenshop" size="10" value="<?=$row[openshop]?>" /></li>
 <li class="l1">开店保证金：</li>
 <li class="l2"><input type="text" class="inp" name="topenbao" size="10" value="<?=$row[openbao]?>" /></li>
 <li class="l1">开店认证：</li>
 <li class="l2">
 <label><input name="C1" type="checkbox" value="1" <? if(strstr($row[shoprz],"xcf1xcf")){?> checked="checked"<? }?> /> 需要通过手机认证</label>
 <label><input name="C1" type="checkbox" value="2" <? if(strstr($row[shoprz],"xcf2xcf")){?> checked="checked"<? }?> /> 需要通过邮箱认证</label>
 <label><input name="C1" type="checkbox" value="3" <? if(strstr($row[shoprz],"xcf3xcf")){?> checked="checked"<? }?> /> 需要通过个人实名认证</label>
 </li>
 </ul>
 <ul class="openyf">
 <li class="l1">购买月数</li>
 <li class="l2">所需费用</li>
 </ul>
 <? $j=1;while1("*","yjcode_openyue order by yue asc");while($row1=mysql_fetch_array($res1)){?>
 <ul class="yue">
 <li class="l1"><input type="text" name="yue_<?=$j?>" value="<?=$row1[yue]?>" /></li>
 <li class="l2"><input type="text" name="money1_<?=$j?>" value="<?=$row1[money1]?>" /></li>
 </ul>
 <? $j++;}?>
 <? for($i=1;$i<=2;$i++){?>
 <ul class="yue">
 <li class="l1"><input type="text" name="yue_<?=$j?>" /></li>
 <li class="l2"><input type="text" name="money1_<?=$j?>" /></li>
 </ul>
 <? $j++;}?>
 <div id="yue2"></div>
 <ul class="uk uk0"><li class="l1"></li><li class="l21"><a href="javascript:void(0);" onclick="yueadd2()">【新增五行】</a></li></ul>
 <input type="hidden" value="<?=$j?>" name="yuenum" />
 </div>

 
 <ul class="uk uk0">
 <li class="l1">商品展示权限：</li>
 <li class="l2">
 <label><input name="Rifproduct" type="radio" value="off" <? if($row[ifproduct]=="off"){?> checked="checked"<? }?> /> 需要审核</label>
 <label><input name="Rifproduct" type="radio" value="on" <? if($row[ifproduct]=="on"){?> checked="checked"<? }?> /> 不需要审核</label>
 </li>
 <li class="l1">注册短信验证：</li>
 <li class="l2">
 <label><input name="Rregmob" type="radio" value="1" <? if(1==$row[regmob]){?> checked="checked"<? }?> /> 启用</label>
 <label><input name="Rregmob" type="radio" value="0" <? if(0==$row[regmob]){?> checked="checked"<? }?> /> 关闭</label>
 </li>
 <li class="l1">默认购买方式：</li>
 <li class="l2">
 <label><input name="Rmrbuy" type="radio" value="0" <? if(empty($row[mrbuy])){?> checked="checked"<? }?> /> 常规账号登录</label>
 <label><input name="Rmrbuy" type="radio" value="1" <? if($row[mrbuy]==1){?> checked="checked"<? }?> /> 免登录方式</label>
 </li>
 <li class="l1">右侧客服：</li>
 <li class="l2">
 <label><input name="Rifkf" type="radio" value="on" <? if($row[ifkf]=="on"){?> checked="checked"<? }?> /> 启用</label>
 <label><input name="Rifkf" type="radio" value="off" <? if($row[ifkf]=="off"){?> checked="checked"<? }?> /> 不启用</label>
 </li>
 <li class="l1">任务大厅：</li>
 <li class="l2">
 <label><input name="Riftask" type="radio" value="0" <? if(empty($row[iftask])){?> checked="checked"<? }?> /> 开启</label>
 <label><input name="Riftask" type="radio" value="1" <? if($row[iftask]==1){?> checked="checked"<? }?> /> 关闭</label>
 </li>
 <li class="l1">任务审核权限：</li>
 <li class="l2">
 <label><input name="Rtaskok" type="radio" value="0" <? if(empty($row[taskok])){?> checked="checked"<? }?> /> 需要审核</label>
 <label><input name="Rtaskok" type="radio" value="1" <? if($row[taskok]==1){?> checked="checked"<? }?> /> 无需审核</label>
 </li>
 <li class="l1">任务接手权限：</li>
 <li class="l2">
 <label><input name="C2" type="checkbox" value="1" <? if(strstr($row[taskjs],"xcf1xcf")){?> checked="checked"<? }?> /> 需要通过手机认证</label>
 <label><input name="C2" type="checkbox" value="2" <? if(strstr($row[taskjs],"xcf2xcf")){?> checked="checked"<? }?> /> 需要通过邮箱认证</label>
 <label><input name="C2" type="checkbox" value="3" <? if(strstr($row[taskjs],"xcf3xcf")){?> checked="checked"<? }?> /> 需要通过个人实名认证</label>
 <label><input name="C2" type="checkbox" value="4" <? if(strstr($row[taskjs],"xcf4xcf")){?> checked="checked"<? }?> /> 需要正常开店</label>
 </li>
 <li class="l1">手机版：</li>
 <li class="l2">
 <label><input name="Rifwap" type="radio" value="0" <? if(empty($row[ifwap])){?> checked="checked"<? }?> /> 开启</label>
 <label><input name="Rifwap" type="radio" value="1" <? if($row[ifwap]==1){?> checked="checked"<? }?> /> 关闭</label>
 </li>
 <li class="l1">安卓APP：</li>
 <li class="l2"><input class="inp1" type="file" name="inp1" id="inp1" size="15" accept=".apk"></li>
 <? if(is_file("../img/anzhuo.apk")){?>
 <li class="l8"></li>
 <li class="l9"><a href="../img/anzhuo.apk" target="_blank"><img border="0" src="img/anzhuo.png" width="54" height="54" /></a></li>
 <? }?>
 <li class="l1">是否开启UC：</li>
 <li class="l2">
 <label><input name="Rifuc" type="radio" value="0" <? if(empty($row[ifuc])){?> checked="checked"<? }?> /> 不开启</label>
 <label><input name="Rifuc" type="radio" value="1" <? if($row[ifuc]==1){?> checked="checked"<? }?> /> 开启 (<a href="http://www.yj99.cn/faq/view41.html" target="_blank">查看教程</a>)</label>
 </li>
 <li class="l1">检测脚本权限：</li>
 <li class="l2">
 <label><input name="Rifshell" type="radio" value="0" <? if(empty($row[ifshell])){?> checked="checked"<? }?> /> 开启</label>
 <label><input name="Rifshell" type="radio" value="1" <? if($row[ifshell]==1){?> checked="checked"<? }?> /> 关闭</label>
 <span class="fd"><a href="http://www.yj99.cn/faq/view133.html" class="red" target="_blank">查看说明</a></span>
 </li>
 <li class="l1">页面分享：</li>
 <li class="l2">
 <label><input name="Rfenxiang" type="radio" value="0" <? if(empty($row[fenxiang])){?> checked="checked"<? }?> /> 开启</label>
 <label><input name="Rfenxiang" type="radio" value="1" <? if($row[fenxiang]==1){?> checked="checked"<? }?> /> 关闭</label>
 </li>
 <li class="l1">强制手机验证：</li>
 <li class="l2">
 <label><input name="Rqzmot" type="radio" value="0" <? if(empty($row[qzmot])){?> checked="checked"<? }?> /> 不强制</label>
 <label><input name="Rqzmot" type="radio" value="1" <? if($row[qzmot]==1){?> checked="checked"<? }?> /> 强制</label>
 <span class="fd"><a href="http://www.yj99.cn/faq/view149.html" class="red" target="_blank">查看说明</a></span>
 </li>
 <li class="l1">开店入口通道：</li>
 <li class="l2">
 <label><input name="Rifopenshop" type="radio" value="on" <? if($row[ifopenshop]=="on"){?> checked="checked"<? }?> /> 开启</label>
 <label><input name="Rifopenshop" type="radio" value="off" <? if($row[ifopenshop]=="off"){?> checked="checked"<? }?> /> 关闭</label>
 </li>
 <li class="l1">IP注册限制：</li>
 <li class="l2"><input type="text" class="inp" name="tipzcnum" size="10" value="<?=intval($row[ipzcnum])?>" /><span class="fd">同个IP地址24小时内注册会员数量，0表示不限制</span></li>
 <li class="l1">IP发帖限制：</li>
 <li class="l2"><input type="text" class="inp" name="tipnewsnum" size="10" value="<?=intval($row[ipnewsnum])?>" /><span class="fd">同个IP地址24小时内发帖数量，0表示不限制</span></li>
 </ul>
 
 <ul class="uk uk0">
 <li class="l3"><input type="submit" value="保存修改" class="btn1" /></li>
 </ul>
 </form>
 </div>
 <!--End-->
 
</div>
</div>

<script language="javascript">
shoprzonc("<?=$row[ifsell]?>");
</script>
<? include("bottom.php");?>
</body>
</html>