<!--头B-->
<div class="bfbtop">
 <div class="d1"><img src="img/logo.png" /></div>
 <div class="d2">
 <? if(strstr($adminqx,",0,") || strstr($adminqx,",0302,")){?><a id="menu1" href="default.php"><img src="img/tm1.png" /><br>全局设置</a><? }?>
 <? if(strstr($adminqx,",0,") || strstr($adminqx,",0102,")){?><a id="menu3" href="productlist.php"><img src="img/tm2.png" /><br>商品管理</a><? }?>
 <? if(strstr($adminqx,",0,") || strstr($adminqx,",0702,")){?><a id="menu2" href="userlist.php"><img src="img/tm3.png" /><br>会员管理</a><? }?>
 <? if(strstr($adminqx,",0,") || strstr($adminqx,",0402,")){?><a id="menu6" href="orderlist.php"><img src="img/tm4.png" /><br>订单管理</a><? }?>
 <? if(strstr($adminqx,",0,") || strstr($adminqx,",0202,")){?><a id="menu4" href="newslist.php"><img src="img/tm5.png" /><br>资讯管理</a><? }?>
 <? if(strstr($adminqx,",0,") || strstr($adminqx,",0602,")){?><a id="menu5" href="adtypeglobal.php"><img src="img/tm6.png" /><br>广告互动</a><? }?>
 <? if(strstr($adminqx,",0,") || strstr($adminqx,",0302,")){?><a id="menu7" href="chajian.php"><img src="img/tm7.png" /><br>插件专区</a><? }?>
 </div>
 <div class="d3" onmouseover="topd3over()" onmouseout="topd3out()">
  <ul class="u1">
  <li class="l1"><img src="img/user.png" /></li>
  <li class="l2"><?=$_SESSION[SHOPADMIN]?></li>
  <li class="l3"><img src="img/jian1.png" /></li>
  </ul>
  <div id="tla" style="display:none;">
  <a href="tohtml.php?admin=0&action=gx">清理缓存</a>
  <a href="../" target="_blank" class="a1">返回首页</a>
  <a href="pwd.php" class="a1">修改密码</a>
  <a href="un.php" class="a1">退出</a></div>
 </div>
</div>
<!--头E-->
