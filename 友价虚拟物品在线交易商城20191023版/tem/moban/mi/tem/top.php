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
    <a href="<?=weburl?>reg/">账号登录</a>
    <? if($rowcontrol[wxlogin]!="" && $rowcontrol[wxlogin]!=","){?>
    <a href="https://open.weixin.qq.com/connect/qrconnect?appid=<?=$wxlogin[0]?>&redirect_uri=<?=urlencode(weburl."reg/wxlogin.php")?>&response_type=code&scope=snsapi_login#wechat_redirect" target="_blank">微信登录</a>
    <? }?>
    <a href="<?=weburl?>config/qq/oauth/index.php">QQ登录</a>
    <a href="<?=weburl?>reg/reg.php">免费注册</a>
    <a class="feng" href="<?=weburl?>user/qiandao.php">每日签到</a>
   </span>
   <span id="yeslogin" style="display:none">
   <a id="yesuid" href="<?=weburl?>user/"></a>
   <a class="feng" href="<?=weburl?>user/qiandao.php" id="needqd" style="display:none;">每日签到</a>
   <a class="blue" id="dontqd" style="display:none;" href="<?=weburl?>user/qiandao.php">今日已签到</a>
   <a href="<?=weburl?>user/un.php">退出</a>
   </span>
  </li>
  <li class="l2">
  <a href="<?=weburl?>">网站首页</a>
  <a href="<?=weburl?>user/order.php">我的订单</a>
  <a href="<?=weburl?>user/" class="a1">会员中心</a>
  <a href="<?=weburl?>user/pay.php" class="feng">充值</a>
  <a href="<?=weburl?>user/tixian.php" class="green">提现</a>
  <a href="<?=weburl?>help/">新手帮助</a>
  <a href="<?=weburl?>user/gdlx.php" target="_blank">有问必答</a>
  </li>
  </ul>
 </div> 
 
</div>
</div>
<span id="webhttp" style="display:none"><?=weburl?></span>
<script language="javascript">
userCheckses();
</script>
<div class="yjcode"><? adwhile("ADTOP");?></div>