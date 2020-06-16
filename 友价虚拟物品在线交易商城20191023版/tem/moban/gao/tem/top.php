<?
include("../../../../config/conn.php");
include("../../../../config/function.php");
$wxlogin=preg_split("/,/",$rowcontrol[wxlogin]);
?>
<div class="bfb bfbtop fontyh">
<div class="yjcode">

 <div class="top">
  <ul class="u1">
  <li class="l1"><?=webname?>欢迎您</li>
  <li class="l2">
   <span id="notlogin" style="display:none">
    <a href="<?=weburl?>reg/" class="feng">登录</a>&nbsp;&nbsp;|&nbsp;&nbsp;
    <a href="<?=weburl?>reg/reg.php">免费注册</a>&nbsp;&nbsp;|&nbsp;&nbsp;
    <? if($rowcontrol[wxlogin]!="" && $rowcontrol[wxlogin]!=","){?>
    <a href="https://open.weixin.qq.com/connect/qrconnect?appid=<?=$wxlogin[0]?>&redirect_uri=<?=urlencode(weburl."reg/wxlogin.php")?>&response_type=code&scope=snsapi_login#wechat_redirect" target="_blank">微信登录</a>&nbsp;&nbsp;|&nbsp;&nbsp;
    <? }?>
    <a href="<?=weburl?>config/qq/oauth/index.php">QQ登录</a>&nbsp;&nbsp;|&nbsp;&nbsp;
    <a href="<?=weburl?>user/qiandao.php">每日签到</a>
   </span>
   <span id="yeslogin" style="display:none">
    <a id="yesuid" href="<?=weburl?>user/"></a>&nbsp;&nbsp;|&nbsp;&nbsp;
    <a href="<?=weburl?>user/">会员中心</a>&nbsp;&nbsp;|&nbsp;&nbsp;
    <a class="feng" href="<?=weburl?>user/qiandao.php" id="needqd" style="display:none;">每日签到</a>
    <a class="blue" id="dontqd" style="display:none;" href="<?=weburl?>user/qiandao.php">今日已签到</a>
    &nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?=weburl?>user/un.php">退出</a>
   </span>
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