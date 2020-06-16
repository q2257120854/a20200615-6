<?
include("../../../../config/conn.php");
include("../../../../config/function.php");
$wxlogin=preg_split("/,/",$rowcontrol[wxlogin]);
?>
<!--一淘模板提示请不要倒卖否则停止更新-->
<div class="bfb bfbtop fontyh">

<div class="yjcode">



 <div class="top">

  <ul class="u1">

  <li class="l1">

   <span id="notlogin" style="display:none">

    <span class="s1">您好，欢迎光临<?=webname?>！[<a href="/reg/">登录</a> | <a href="/reg/reg.php">免费注册</a> | <a class="feng" href="/user/qiandao.php">每日签到</a>]</span>

    <span class="s2"><a href="/config/qq/oauth/index.php"><img border="0" src="/img/qq_login.png" /></a></span>

   </span>

   <span id="yeslogin" style="display:none">欢迎您：<span id="yesuid"></span>&nbsp;&nbsp;[<a class="feng" href="/user/qiandao.php" id="needqd" style="display:none;">每日签到</a><a class="blue" id="dontqd" style="display:none;" href="/user/qiandao.php">今日已签到</a>]&nbsp;&nbsp;<a href="/user/un.php">退出</a></span>

  </li>

  <li class="l2"><a href="/">网站首页</a></li>

  <li class="l2"><a href="/user/order.php">我的订单</a></li>

  <li class="l3" onmouseover="lover(3)" onmouseout="lout(3)" id="topu1l3">

  <a href="/user/" class="a1">会员中心</a>

  <div class="umenu" id="umenu3" style="display:none;">

  <a href="/user/">购买记录</a>

  <a href="/user/pay.php">在线充值</a>

  <a href="/user/paylog.php">资金明细</a>

  <a href="/user/favpro.php">我的收藏</a>

  <a href="/user/inf.php">个人信息</a>

  </div>

  </li>

  <li class="l0"></li>

  <li class="l2 l21"><a href="/user/pay.php" class="feng">充值</a></li>

  <li class="l2 l21"><a href="/user/tixian.php" class="green">提现</a></li>

  <li class="l2"><a href="/help/">新手帮助</a></li>

  <li class="l2"><a href="/user/gdlx.php" target="_blank" class="red">有问必答</a></li>

  </ul>

 </div> 

 

</div>

</div>

<span id="webhttp" style="display:none">/</span>

<script language="javascript">

userCheckses();

</script>

<div class="yjcode"></div>