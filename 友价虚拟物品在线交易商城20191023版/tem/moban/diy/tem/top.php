<?
include("../../../../config/conn.php");
include("../../../../config/function.php");
$wxlogin=preg_split("/,/",$rowcontrol[wxlogin]);
?>
<div class="bfb bfbtop">
<div class="yjcode">

 <a class="a1" href="<?=weburl?>"><?=webname?>，靠谱的在线交易网站</a>
 <a class="a2" href="<?=weburl?>help/">帮助</a>
 <a class="a3" href="<?=weburl?>user/qiandao.php">每日签到</a>
 
 <div id="notlogin" style="display:none;">
 <a class="a4" href="<?=weburl?>reg/reg.php">注册</a>
 <a class="a5" href="<?=weburl?>reg/">登录</a>
 <a class="a6" href="<?=weburl?>config/qq/oauth/index.php" target="_blank">QQ登录</a>
 <? if($rowcontrol[wxlogin]!="" && $rowcontrol[wxlogin]!=","){?>
 <a class="a7" href="https://open.weixin.qq.com/connect/qrconnect?appid=<?=$wxlogin[0]?>&redirect_uri=<?=urlencode(weburl."reg/wxlogin.php")?>&response_type=code&scope=snsapi_login#wechat_redirect" target="_blank">微信登录</a>
 <? }?>
 </div>
 
 <div id="yeslogin" style="display:none;">
 <a class="a8" href="<?=weburl?>user/un.php">退出</a>
 <a class="a5" href="<?=weburl?>user/">欢迎您：<span id="yesuid"></span></a>
 </div>
 
</div>
</div>
<span id="webhttp" style="display:none"><?=weburl?></span>
<script language="javascript">
userCheckses();
</script>
<div class="yjcode"><? adwhile("ADTOP");?></div>