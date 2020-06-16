<?
$sj=date("Y-m-d H:i:s");
$sqluser="select * from yjcode_user where uid='".$_SESSION[SHOPUSER]."'";mysql_query("SET NAMES 'GBK'");$resuser=mysql_query($sqluser);
$rowuser=mysql_fetch_array($resuser);
if(empty($rowuser[mybh])){updatetable("yjcode_user","mybh='".returnbh()."' where id=".$rowuser[id]);}
if($sj>$rowuser[dqsj] && !empty($rowuser[dqsj])){updatetable("yjcode_user","shopzt=4 where shopzt=2 and id=".$rowuser[id]);}

$luserid=$rowuser[id];
sellmoneytj($luserid);
$autoses="(selluserid=".$luserid." or userid=".$luserid.")";
if(is_file("auto.php")){include("auto.php");}
?>

<div class="bfb usertop">
<div class="yjcode">
 
 <? if(is_file("img/logo.png")){?>
 <div class="d1"><a href="../"><img src="img/logo.png" /></a></div>
 <? }?>
 <ul class="u1">
 <li class="l1">用户中心</li>
 <li class="l2"><a href="./" class="a1">返回会员主页</a></li>
 </ul>
 
 <div class="d2"><a href="../">首页</a></div>
 
 <div class="d3">
  <a href="inf.php" class="a1">账户设置</a>
  <div class="d3v">
  <a href="inf.php">基本资料</a>
  <a href="userdj.php">会员等级</a>
  <a href="smrz.php">实名认证</a>
  <a href="mobbd.php">手机认证</a>
  <a href="emailbd.php">邮箱认证</a>
  <a href="touxiang.php">设置头像</a>
  <a href="shdzlist.php">收货地址</a>
  </div>
 </div>
 
 <div class="d3">
  <a href="paylog.php" class="a1">财务管理</a>
  <div class="d3v">
  <a href="paylog.php">详细资金记录</a>
  <a href="pay.php">我要充值</a>
  <a href="tixian.php">我要提现</a>
  <a href="tixianlog.php">提现记录</a>
  <a href="baomoneylog.php">保证金管理</a>
  <a href="jflog.php">积分管理</a>
  </div>
 </div>
 
 <div class="d3">
  <a href="gdlist.php" class="a1">工单管理</a>
  <div class="d3v">
  <a href="gdlist.php">我的工单</a>
  <a href="gdlx.php">提交工单</a>
  </div>
 </div>
 
 <div class="d3">
  <a href="pwd.php" class="a1">安全设置</a>
  <div class="d3v">
  <a href="pwd.php">登录密码</a>
  <a href="zfmm.php">支付密码</a>
  <a href="qq.php">QQ绑定</a>
  <? 
  $wxlogin=preg_split("/,/",$rowcontrol[wxlogin]);
  if($rowcontrol[wxlogin]!="" && $rowcontrol[wxlogin]!=","){
  ?>
  <a href="weixin.php">微信绑定</a>
  <?
  }
  ?>
  <a href="loginlog.php">登录记录</a>
  </div>
 </div>
 
 <div class="d4" style="display:none;"><a href="">消息</a><span>0</span></div>
 
</div>
</div>

<? if(strcmp(sha1("123456"),$rowuser[pwd])==0){?><div class="yjcode"><div class="pwderr">您的当前密码为123456，过于简单，建议您立即修改!【<a href="pwd.php">点击修改登录密码</a>】</div></div><? }?>
<? if(strcmp($rowuser[pwd],$rowuser[zfmm])==0){?><div class="yjcode"><div class="pwderr">您的支付密码与登录密码一致，建议立即修改!【<a href="zfmm.php">点击修改支付密码</a>】</div></div><? }?>
