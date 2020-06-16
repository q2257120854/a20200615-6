<?
include("../../../../config/conn.php");
include("../../../../config/function.php");
$wxlogin=preg_split("/,/",$rowcontrol[wxlogin]);
?>
<div class="bfb bfbtop fontyh">
<div class="yjcode">

 <div class="top">
  <ul class="u1">
  <li class="l1">
   <span id="notlogin" style="display:none">
    <span class="s1">
    您好，欢迎来<?=webname?>！[<a href="<?=weburl?>reg/">登录</a> | <a href="<?=weburl?>reg/reg.php">免费注册</a> | <a href="https://open.weixin.qq.com/connect/qrconnect?appid=<?=$wxlogin[0]?>&redirect_uri=<?=urlencode(weburl."reg/wxlogin.php")?>&response_type=code&scope=snsapi_login#wechat_redirect" target="_blank">微信登录</a> | <a href="<?=weburl?>config/qq/oauth/index.php">QQ登录</a>]
    </span>
   </span>
   <span id="yeslogin" style="display:none">欢迎您：<span id="yesuid"></span>&nbsp;&nbsp;[<a class="feng" href="<?=weburl?>user/qiandao.php" id="needqd" style="display:none;">每日签到</a><a class="blue" id="dontqd" style="display:none;" href="<?=weburl?>user/qiandao.php">今日已签到</a>]&nbsp;&nbsp;<a href="<?=weburl?>user/un.php">退出</a></span>
  </li>
  <li class="l2"><a href="<?=weburl?>">网站首页</a></li>
  <li class="l2"><a href="<?=weburl?>user/order.php">我的订单</a></li>
  <li class="l3" onmouseover="lover(3)" onmouseout="lout(3)" id="topu1l3">
  <a href="<?=weburl?>user/" class="a1">会员中心</a>
  <div class="umenu" id="umenu3" style="display:none;">
  <a href="<?=weburl?>user/">购买记录</a>
  <a href="<?=weburl?>user/pay.php">在线充值</a>
  <a href="<?=weburl?>user/paylog.php">资金明细</a>
  <a href="<?=weburl?>user/favpro.php">我的收藏</a>
  <a href="<?=weburl?>user/inf.php">个人信息</a>
  </div>
  </li>
  <li class="l0"></li>
  <li class="l2 l21"><a href="<?=weburl?>user/pay.php" class="feng">充值</a></li>
  <li class="l2 l21"><a href="<?=weburl?>user/tixian.php" class="green">提现</a></li>
  <li class="l2"><a href="<?=weburl?>help/">新手帮助</a></li>
  <li class="l2"><a href="<?=weburl?>user/gdlx.php" target="_blank" class="red">有问必答</a></li>
  </ul>
 </div> 
 
</div>
</div>
<span id="webhttp" style="display:none"><?=weburl?></span>
<script language="javascript">
userCheckses();
</script>
<div class="yjcode"><? adwhile("ADTOP");?></div>