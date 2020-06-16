<?
include("../config/conn.php");
include("../config/function.php");
if($_SESSION["SHOPUSER"]!=""){php_toheader("../user/");}

//修改该文件，要同步修改下reg/reg.php、reg/qqreturnlast.php 、m/reg/reg.php

//写入数据库开始
if($_GET[action]=="add"){
 $sj=date("Y-m-d H:i:s");
 $uip=$_SERVER["REMOTE_ADDR"];
 zwzr();
 
 //需要短信验证B
 if(1==$rowcontrol[regmob]){
 $mot=$_SESSION["REGMOT"];
 $motyz=sqlzhuru($_POST[t9]);
 $ifmot=1;
 if($motyz!=$_SESSION["REGMOTYZ"] || empty($motyz)){Audit_alert("短信验证码不正确，返回重试！","reg.php");}
 $_SESSION["REGMOT"]="";
 $_SESSION["REGMOTYZ"]="";
 }
 //需要短信验证E
 
 if(strtolower($_SESSION["authnum_session"])!=strtolower(sqlzhuru($_POST["t5"]))){Audit_alert("验证码不正确，返回修改验证码！","reg.php");}
 
 include("../tem/uc/reg.php");
 
 $uid=sqlzhuru(trim($_POST[t1]));
 $pwd=sqlzhuru($_POST[t2]);
 $nc=sqlzhuru($_POST[t4]);
 $uqq=sqlzhuru($_POST[t6]);
 $email=sqlzhuru($_POST[t7]);
 include("reg_tem.php");
 
 include("../tem/uc/reg1.php");
 
 php_toheader(returnjgdw($_SESSION["tzURL"],"","../user/"));
 
}
//写入数据库结束


//推荐人ID COOKIE入
$tid=$_GET[tid];
if(!empty($tid)){
 $Month = 864000 + time();
 setcookie(tjuserid,$tid, $Month,'/');
}

?>
<html>
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>注册会员 - <?=webname?></title>
<? include("../tem/cssjs.html");?>
</head>
<body>
<? include("../tem/top.html");?>
<? include("../tem/top1.html");?>

<div class="bfb regbfb fontyh">
<div class="yjcode">

  <div class="regleft">
  <form name="f1" method="post" onSubmit="return tj()">
  <div class="dcap"><span class="s1 g_bg0">会员注册</span><span class="s2"></span></div>
  <ul class="u1">
  <li class="l1">注册帐号</li>
  <li class="l2">
  <input type="text" class="inp1" name="t1" autocomplete="off" disableautocomplete onBlur="userCheck()">
  <span class="s1" id="imgts1"></span>
  <span class="s2" id="ts1">4-20位字母、数字或下划线组合</span>
  </li>
  <li class="l1">密码</li>
  <li class="l2">
  <input type="password" class="inp1" name="t2" autocomplete="off" disableautocomplete onBlur="pwd1chk()">
  <span class="s1" id="imgts2"></span>
  <span class="s2" id="ts2">6-20个字母、数字、下划线的组合</span>
  </li>
  <li class="l1">确认密码</li>
  <li class="l2">
  <input type="password" class="inp1" name="t3" autocomplete="off" disableautocomplete onBlur="pwd2chk()">
  <span class="s1" id="imgts3"></span>
  <span class="s2" id="ts3">确保密码输入正确</span>
  </li>
  <li class="l1">昵称</li>
  <li class="l2">
  <input type="text" class="inp1" name="t4" autocomplete="off" disableautocomplete onBlur="ncCheck()">
  <span class="s1" id="imgts4"></span>
  <span class="s2" id="ts4">请输入您在本站的昵称</span>
  </li>
  <li class="l1">联系QQ</li>
  <li class="l2">
  <input type="text" class="inp1" name="t6" autocomplete="off" disableautocomplete onBlur="qqCheck()">
  <span class="s1" id="imgts6"></span>
  <span class="s2" id="ts6">请务必填写正确的联系QQ</span>
  </li>
  <li class="l1">常用邮箱</li>
  <li class="l2">
  <input type="text" class="inp1" name="t7" autocomplete="off" disableautocomplete onBlur="yxCheck()">
  <span class="s1" id="imgts7"></span>
  <span class="s2" id="ts7">请填写您的常用邮箱</span>
  </li>
  <li class="l1">验证码</li>
  <li class="l2">
  <input type="text" class="inp1 inp2" name="t5" autocomplete="off" disableautocomplete onBlur="yzmCheck()"> 
  <img src="../config/getYZM.php" onClick="this.src='../config/getYZM.php?'+Math.random();" class="img1" />
  <span class="s1" id="imgts5"></span>
  <span class="s2" id="ts5">请输入图形验证码</span>
  </li>

  <? if(1==$rowcontrol[regmob]){?>
  <li class="l1">手机号码</li>
  <li class="l2">
  <input type="text" class="inp1" name="t8" autocomplete="off" disableautocomplete onBlur="motCheck()">
  <span class="s1" id="imgts8"></span>
  <span class="s2" id="ts8">请填写您的手机号码</span>
  </li>
  <li class="l1">手机验证码</li>
  <li class="l2">
  <input type="text" class="inp1 inp2" name="t9" autocomplete="off" disableautocomplete onBlur="motyzmCheck()"> 
  <a href="javascript:void(0);" id="fs1" class="a1" onClick="yzonc()">获取短信验证码</a>
  <a href="javascript:void(0);" id="fs2" class="a1" style="display:none;">发送中……(<span id="sjzouv" class="red">120</span>秒)</span></a>
  <span class="s1" id="imgts9"></span>
  <span class="s2" id="ts9">请填写您收到的验证码</span>
  </li>
  <? }?>

  <li class="l4"><input name="C1" type="checkbox" checked value="1"><a href="../help/aboutview1.html" target="_blank">我已阅读并接爱<?=webname?>会员注册协议</a></li>
  <li class="l3">
  <input type="submit" value="注册">
  <span><strong>已经有账号？</strong><a href="./" class="feng"><strong>请登录</strong></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="getmm.php">忘记密码</a></span>
  </li>
  </ul>
  </form>
  </div>
  
  <div class="regright">
  <ul class="u1">
  <li class="l1">第三方帐号登录</li>
  <li class="l2">
  <? if(!empty($rowcontrol[qqappid])){?>
  <a href="<?=weburl?>config/qq/oauth/index.php" target="_blank" class="a1">QQ登录</a>
  <? }?>
  <? if($rowcontrol[wxlogin]!="" && $rowcontrol[wxlogin]!=","){$wxlogin=preg_split("/,/",$rowcontrol[wxlogin]);?>
  <a href="https://open.weixin.qq.com/connect/qrconnect?appid=<?=$wxlogin[0]?>&redirect_uri=<?=urlencode(weburl."reg/wxlogin.php")?>&response_type=code&scope=snsapi_login#wechat_redirect" target="_blank" class="a2">微信登录</a>
  <? }?>
  </li>
  </ul>
  
  <ul class="u2">
  <li class="l1 g_ac0_h">推荐商家</li>
  <li class="l2"><a href="../shop/" class="g_ac2">更多</a></li>
  <li class="l3">
  <? 
  while1("*","yjcode_user where zt=1 and shopzt=2 and pm>0 order by pm asc limit 12");while($row1=mysql_fetch_array($res1)){
  $au="../shop/view".$row1[id].".html";
  ?>
  <a href="<?=$au?>" target="_blank">
  <img border="0" src="<?=returntppd("../upload/".$row1[id]."/shop.jpg","../img/none180x180.gif")?>" width="64" height="64" />
  <span><?=$row1[shopname]?></span>
  </a>
  <? }?>
  </li>
  </ul>
    
  </div>

</div>
</div>

<? include("../tem/bottom.html");?>

</body>
</html>