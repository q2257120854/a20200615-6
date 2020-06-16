<?
include("../../../../config/conn.php");
include("../../../../config/function.php");
?>
<!--一淘模板提示请不要倒卖否则停止更新-->
<div class="bfb bfbbot">
<div class="yjcode fontyh">
 <ul class="u1">
 <li class="l0 l1">
 <span class="cap"><a href="/help/search_j9v.html" target="_blank">买家指南</a></span>
 <a href="/help/search_j9v_k14v.html" target="_blank">如何注册</a><br>
 <a href="/help/view3.html" target="_blank">如何下载</a><br>
 <a href="/help/search_j9v_k16v.html" target="_blank">搜索商品</a><br>
 <a href="/help/search_j9v_k17v.html" target="_blank">支付方式</a><br>
 </li>
 <li class="l0 l2">
 <span class="cap"><a href="/help/search_j10v.html" target="_blank">卖家指南</a></span>
 <a href="/help/search_j10v_k18v.html" target="_blank">如何出售</a><br>
 <a href="/help/search_j10v_k19v.html" target="_blank">收费标准</a><br>
 <a href="/help/search_j10v_k20v.html" target="_blank">入驻签约</a><br>
 </li>
 <li class="l0 l3">
 <span class="cap"><a href="/help/search_j11v.html" target="_blank">安全交易</a></span>
 <a href="/help/search_j11v_k21v.html" target="_blank">钓鱼防骗</a><br>
 <a href="/help/search_j11v_k22v.html" target="_blank">预防盗号</a><br>
 <a href="/help/search_j11v_k23v.html" target="_blank">谨防诈骗</a><br>
 <a href="/help/search_j11v_k24v.html" target="_blank">实名认证</a><br>
 </li>
 <li class="l0 l4">
 <span class="cap"><a href="/help/search_j12v.html" target="_blank">常见问题</a></span>
 <a href="/help/search_j12v_k25v.html" target="_blank">如何充值</a><br>
 <a href="/help/search_j12v_k26v.html" target="_blank">如何提现</a><br>
 <a href="/help/view1.html" target="_blank">VIP等级说明</a><br>
 <a href="/help/search_j12v_k28v.html" target="_blank">忘记密码</a><br>
 </li>
 <li class="l5">
<img src="<?=weburl?>tem/getqr.php?u=<?=weburl?>m&size=4" width="90" height="90" />
 </li>
 </ul>
 <div class="bq">
 <a href="/">网站首页</a>&nbsp;&nbsp;|&nbsp;&nbsp;
 <a href="/help/aboutview2.html">关于我们</a>&nbsp;&nbsp;|&nbsp;&nbsp;
 <a href="/help/aboutview3.html">广告合作</a>&nbsp;&nbsp;|&nbsp;&nbsp;
 <a href="/help/aboutview4.html">联系我们</a>&nbsp;&nbsp;|&nbsp;&nbsp;
 <a href="/help/aboutview5.html">隐私条款</a>&nbsp;&nbsp;|&nbsp;&nbsp;
 <a href="/help/aboutview6.html">免责声明</a>&nbsp;&nbsp;|&nbsp;&nbsp;<br>
 免责声明：本站所有模板/文章除标明原创外，均来自网络转载，不对任何资源负法律责任。如有侵犯您的版权，请及时联系我们删除！<br>
CopyRight 2014-2024 <?=webname?> | <?=$rowcontrol[beian]?><br><?=$rowcontrol[webtj]?>
 </div>
 
</div>
</div>

<? while1("*","yjcode_ad where adbh='ADKF' and zt=0 order by xh asc limit 1");if($row1=mysql_fetch_array($res1)){echo $row1[txt];}?>

<!--***********右侧浮动开始*************-->
<div class="rightfd" style="display:;">

 <div class="d1">
  <span class="s1"></span>
  <div class="sd1">
  <?
  $qq=preg_split("/,/",$rowcontrol[webqqv]);
  for($qqi=0;$qqi<count($qq);$qqi++){
  $qv=preg_split("/\*/",$qq[$qqi]);
  if($qv[0]!=""){
  if($qv[1]==""){$qtit="网站客服";}else{$qtit=$qv[1];}
  ?>
  <a href="http://wpa.qq.com/msgrd?v=3&uin=<?=$qv[0]?>&site=<?=weburl?>&menu=yes" target="_blank"><?=$qtit?></a>
  <? }}?>
	  <i></i>
   </div>
 </div>

 <div class="d2">
  <span class="s1"></span>
  <div class="sd1">
  <strong>服务热线</strong>
  <p><?=$rowcontrol[webtelv]?></p>
  <i></i>
  </div>
 </div>

 <div class="d3">
  <span class="s1"></span>
  <div class="sd1">
 <img src="<?=weburl?>tem/getqr.php?u=<?=weburl?>m&size=4" width="150" height="150" />
  <p class="fz14">扫一扫进手机版</p>
  <i></i>
  </div>
 </div>

 <div class="d4" onClick="gotoTop();return false;">
  <span class="s1"></span>
 </div>
 
</div>
<script language="javascript" >
$(".rightfd .d4").hide()

$(window).scroll(function(){
    if($(window).scrollTop() > 100){
        $(".rightfd .d4").fadeIn()
    }else {
        $(".rightfd .d4").fadeOut()
    }
});
</script>
<div style="display:none"><a href="http://www.ytaomb.com">源码论坛</a></div>
<!--**********右侧浮动结束***************-->