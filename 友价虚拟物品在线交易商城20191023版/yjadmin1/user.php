<?php
include("../config/conn.php");
include("../config/function.php");
require("../config/tpclass.php");
AdminSes_audit();
$id=$_GET[id];
$sj=date("Y-m-d H:i:s");

//函数开始
if($_GET[control]=="update"){
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0701,")){Audit_alert("权限不够","default.php");}
 zwzr();
 $nc=sqlzhuru($_POST[tnc]);if(empty($nc)){Audit_alert("错误的路径来源！","user.php");}
 $pwd=sqlzhuru($_POST[tpwd]);if(!empty($pwd)){$ses="pwd='".sha1($pwd)."',";}
 $zf=sqlzhuru($_POST[tzf]);if(!empty($zf)){$ses=$ses."zfmm='".sha1($zf)."',";}
 updatetable("yjcode_user",$ses."
			 nc='".$nc."',
			 mot='".sqlzhuru($_POST[tmot])."',
			 ifmot=".$_GET[ifm].",
			 email='".sqlzhuru($_POST[temail])."',
			 ifemail=".$_GET[ife].",
			 uqq='".sqlzhuru($_POST[tuqq])."',
			 weixin='".sqlzhuru($_POST[tweixin])."',
			 zt=".sqlzhuru($_POST[R1]).",
			 userdj='".$_POST[tuserdj]."',
			 userdjdq='".sqlzhuru($_POST[tuserdjdq])."'
			 where id=".$id);
 uploadtpnodata(1,"upload/".$id."/","user.jpg","allpic",124,124,0,0,"no");
 uploadtpnodata(2,"upload/".$id."/","wx.jpg","allpic",150,150,0,0,"no");
 php_toheader("user.php?t=suc&id=".$id);

}
//函数结果
while0("*","yjcode_user where id=".$id);if(!$row=mysql_fetch_array($res)){php_toheader("userlist.php");}
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
function tj(){
 if((document.f1.tnc.value).replace("/\s/","")==""){alert("请输入昵称");document.f1.tnc.focus();return false;}
 c=document.getElementsByName("Cr2");if(c[0].checked){ife=1;}else{ife=0;}
 c=document.getElementsByName("Cr3");if(c[0].checked){ifm=1;}else{ifm=0;}
 layer.msg('正在提交', {icon: 16  ,time: 0,shade :0.25});
 f1.action="user.php?control=update&id=<?=$id?>&ife="+ife+"&ifm="+ifm;
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
 <? if($_GET[t]=="suc"){systs("恭喜您，操作成功！","user.php?id=".$id);}?>
 <? include("rightcap3.php");?>
 <script language="javascript">document.getElementById("rtit1").className="a1";</script>
 <!--B-->
 <div class="rkuang">
 <form name="f1" method="post" onsubmit="return tj()" enctype="multipart/form-data">
 <ul class="uk">
 <li class="l1">会员帐号：</li>
 <li class="l2"><input type="text" class="inp redony" readonly="readonly" name="tuid" size="20" value="<?=$row[uid]?>" /><span class="fd"><a href="user_ses.php?uid=<?=$row[uid]?>" target="_blank">进后台</a></span></li>
 <li class="l1">会员密码：</li>
 <li class="l2"><input type="text" size="20" class="inp" name="tpwd" /><span class="fd">留空表示不修改</span></li>
 <li class="l1">支付密码：</li>
 <li class="l2"><input type="text" size="20" class="inp" name="tzf" /><span class="fd">留空表示不修改</span></li>
 <li class="l1"><span class="red">*</span> 昵称：</li>
 <li class="l2"><input type="text" size="20" value="<?=$row[nc]?>" class="inp" name="tnc" /></li>
 <li class="l1">邮箱地址：</li>
 <li class="l2">
 <input type="text" size="20" value="<?=$row["email"]?>" class="inp" name="temail" />
 <label style="margin-left:10px;"><input name="Cr2" type="checkbox" value="1"<? if(1==$row[ifemail]){?> checked="checked"<? }?>/> 绑定邮箱</label>
 </li>
 <li class="l1">手机号码：</li>
 <li class="l2">
 <input type="text" size="20" value="<?=$row[mot]?>" class="inp" name="tmot" />
 <label style="margin-left:10px;"><input name="Cr3" type="checkbox" value="1"<? if(1==$row[ifmot]){?> checked="checked"<? }?>/> 绑定手机</label>
 </li>
 <li class="l1">解绑留档手机：</li>
 <li class="l2"><input type="text" size="20" value="<?=$row[jbmot]?>" class="inp redony" readonly="readonly" /><span class="fd">这个号码只在这里显示的，是用户之前手机进行解绑时，系统进行留档的</span></li>
 <li class="l1">QQ号码：</li>
 <li class="l2"><input type="text" size="20" value="<?=$row[uqq]?>" class="inp" name="tuqq" /></li>
 <li class="l1">微信号码：</li>
 <li class="l2"><input type="text" size="20" value="<?=$row[weixin]?>" class="inp" name="tweixin" /></li>
 <li class="l1">微信二维码：</li>
 <li class="l2"><input type="file" name="inp2" id="inp2" class="inp1" size="15" accept=".jpg,.gif,.jpeg,.png"></li>
 <? $tx="../upload/".$id."/wx.jpg";if(is_file($tx)){?>
 <li class="l8"></li>
 <li class="l9"><img src="<?=$tx?>?t=<?=rnd_num(100)?>" width="54" height="54" /></li>
 <? }?>
 <li class="l1">个人头像：</li>
 <li class="l2"><input type="file" name="inp1" id="inp1" class="inp1" size="15" accept=".jpg,.gif,.jpeg,.png"></li>
 <? $tx="../upload/".$id."/user.jpg";if(is_file($tx)){?>
 <li class="l8"></li>
 <li class="l9"><img src="<?=$tx?>?t=<?=rnd_num(100)?>" width="54" height="54" /></li>
 <? }?>
 <li class="l1">会员等级：</li>
 <li class="l2">
 <select name="tuserdj" class="inp">
 <? while1("*","yjcode_userdj where zt=0 order by xh asc");while($row1=mysql_fetch_array($res1)){?>
 <option value="<?=$row1[name1]?>"<? if($row1[name1]==$row[userdj]){?> selected="selected"<? }?>><?=$row1[name1]?></option>
 <? }?>
 </select>
 </li>
 <li class="l1">等级到期：</li>
 <li class="l2"><input class="inp" name="tuserdjdq" value="<?=returnjgdw($row[userdjdq],"",$sj)?>" size="20" type="text"/><span class="fd">正确格式：<?=$sj?></span></li>
 </ul>
 
 <ul class="rcap"><li class="l1"></li><li class="l2">管理员操作</li><li class="l3"></li></ul>
 <ul class="uk">
 <li class="l1">是否禁用：</li>
 <li class="l2">
 <label><input name="R1" type="radio" value="1"<? if(1==$row[zt]){?> checked="checked"<? }?> /> 正常</label>
 <label><input name="R1" type="radio" value="0"<? if(0==$row[zt]){?> checked="checked"<? }?> /> 禁用</label>
 </li>
 <li class="l1">可用余额：</li>
 <li class="l2">
 <input class="inp redony" readonly="readonly" value="<?=$row[money1]?>" size="5" type="text"/><span class="fd">[<a href="usermoney.php?id=<?=$row[id]?>">改变金额</a>]</span>
 </li>
 <li class="l1">可用积分：</li>
 <li class="l2">
 <input class="inp redony" readonly="readonly" value="<?=$row[jf]?>" size="5" type="text"/><span class="fd">[<a href="userjf.php?id=<?=$row[id]?>">改变积分</a>]</span>
 </li>
 <li class="l3"><input type="submit" value="保存修改" class="btn1" /></li>
 </ul>
 </form>

 </div>
 <!--E-->
 
</div>
</div>
<?php include("bottom.php");?>
</body>
</html>