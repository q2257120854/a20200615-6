<? if(empty($nowpagebk)){$nowpagebk="window.history.back(-1);";}else{$nowpagebk="gourl('".$nowpagebk."')";}?>
<div class="mobantop1 box">
 <div class="d1" onClick="<?=$nowpagebk?>"><img src="../img/leftjian1.png" /></div>
 <div class="d2"><?=$nowpagetit?></div>
 <div class="d3">
 <img src="../img/all.png" onclick="topxiala()" />
 </div>
</div>

<div id="topzhezhao"></div>

<!--下拉B-->
<div id="topxialam" style="display:none;">

<div class="topxialam1 box">
 <div class="dmain flex">
  <div class="d1"><a href="<?=weburl?>m/"><img src="<?=weburl?>m/homeimg/tm1.png" /><br>返回首页</a></div>
  <div class="d1"><a href="<?=weburl?>m/reg/"><img src="<?=weburl?>m/homeimg/tm2.png" /><br>登录/注册</a></div>
  <div class="d1"><a href="<?=weburl?>m/product/"><img src="<?=weburl?>m/homeimg/tm3.png" /><br>商品列表</a></div>
  <div class="d1"><a href="<?=weburl?>m/shop/"><img src="<?=weburl?>m/homeimg/tm4.png" /><br>商家风采</a></div>
  <div class="d1"><a href="<?=weburl?>m/user/"><img src="<?=weburl?>m/homeimg/tm5.png" /><br>会员中心</a></div>
  <div class="d1"><a href="<?=weburl?>m/news/newslist.html"><img src="<?=weburl?>m/homeimg/tm6.png" /><br>行业资讯</a></div>
 </div>
</div> 

<div class="topxialam2 box">
 <div class="dmain flex"><img onclick="topxiala()" src="<?=weburl?>m/homeimg/close.png" /></div>
</div>

</div>
<!--下拉E-->
