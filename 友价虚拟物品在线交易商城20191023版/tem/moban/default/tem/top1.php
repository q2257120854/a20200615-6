<?
include("../../../../config/conn.php");
include("../../../../config/function.php");
?>
<div class="bfb bfbtop1">
<div class="yjcode">
 <div class="top1">
  <h1 class="logo"><a href="<?=weburl?>"><img alt="<?=webname?>" border="0" src="<?=weburl?>img/logo.png" /></a></h1>
  
  <form name="topf1" method="post" onsubmit="return topftj()">
  <ul class="u1">
  <li class="l1" onmouseover="topover()" onmouseout="topout()">
  <span id="topnwd">商品</span>
  <div id="topdiv" style="display:none;">
  <a href="javascript:void();" onclick="topjconc(1,'商品')">商品</a>
  <a href="javascript:void();" onclick="topjconc(2,'店铺')">店铺</a>
  <a href="javascript:void();" onclick="topjconc(3,'资讯')">资讯</a>
  </div>
  </li>
  <li class="l2"><input name="topt" id="topt" type="text" /></li>
  <li class="l3"><input type="image" src="<?=weburl?>img/btn1.gif" width="40" height="40" /></li>
  </ul>
  </form>
  
  <div class="topsad"><? adread("ADI05",250,75)?></div>
  
  <div class="he"><img src="<?=weburl?>homeimg/icon1.gif" width="209" height="10" /></div>
  <div class="menu">
  
   <!--左B-->
   <div class="m1" onmouseover="leftmenuover()" onmouseout="leftmenuout()">
   <span class="t"><img src="<?=weburl?>homeimg/type.gif" width="200" height="42" /></span>
   <!--主导航下拉开始-->
   <div class="menun fontyh" id="leftmenu" style="display:none;">
    <!--商品B-->
    <div class="menu1" id="yhmenu1" onmouseover="yhmenuover(1)" onmouseout="yhmenuout(1)">
     <ul class="lu1 lm1">
     <li class="l1">宝贝分类</li>
     <li class="l2">共 <strong class="feng"><?=returncount("yjcode_pro where zt=0 and ifxj=0")?></strong> 件宝贝在售</li>
     </ul>
     <span class="rx"></span>
     <div class="rmenu rmenu1" style="display:none;" id="rmenu1">
      <span class="cap"><strong>宝贝分类</strong></span>
      <? while1("*","yjcode_type where admin=1 order by xh asc");while($row1=mysql_fetch_array($res1)){?>
      <ul class="ru1">
      <li class="l1"><a href="<?=weburl?>product/search_j<?=$row1[id]?>v.html"><?=$row1[type1]?></a></li>
      <li class="l2">
      <? while2("*","yjcode_type where type1='".$row1[type1]."' and admin=2 order by xh asc");while($row2=mysql_fetch_array($res2)){?>
      <a href="<?=weburl?>product/search_j<?=$row1[id]?>v_k<?=$row2[id]?>v.html"><?=$row2[type2]?></a>
	  <? }?>
      </li>
      </ul>
      <? }?>
      <span class="cap cap1"><strong>推荐商家</strong></span>
      <ul class="ru2">
      <? 
	  while1("*","yjcode_user where zt=1 and shopzt=2 and shopname<>'' and pm>0 order by pm asc limit 4");while($row1=mysql_fetch_array($res1)){
	  if(is_file("../upload/".$row1[id]."/shop.jpg")){$tp="upload/".$row1[id]."/shop.jpg";}else{$tp="img/none60x60.gif";}
	  ?>
      <li class="l1"><a href="<?=weburl?>shop/view<?=$row1[id]?>.html" target="_blank"><img border="0" width="45" align="left" height="45" src="<?=weburl.$tp?>" /><?=strgb2312($row1[shopname],0,16)?><br><?=returncount("yjcode_pro where zt=0 and ifxj=0 and userid=".$row1[id])?>件宝贝</a></li>
      <? }?>
      </ul>
     </div>
    </div>
    <!--商品E-->
    <!--任务B-->
    <div class="menu1" id="yhmenu2" onmouseover="yhmenuover(2)" onmouseout="yhmenuout(2)">
     <ul class="lu1 lm2">
     <li class="l1">任务大厅</li>
     <li class="l2">
     <? while2("*","yjcode_tasktype where admin=1 order by xh asc limit 2");while($row2=mysql_fetch_array($res2)){?>
     <a href="<?=weburl?>task/search_j<?=$row2[id]?>v.html" target="_blank"><?=$row2[name1]?></a>&nbsp;&nbsp;
	 <? }?>
     </li>
     </ul>
     <span class="rx"></span>
     <div class="rmenu rmenu2" style="display:none;" id="rmenu2">
      <span class="cap"><strong>任务大厅</strong></span>
      <? while1("*","yjcode_tasktype where admin=1 order by xh asc");while($row1=mysql_fetch_array($res1)){?>
      <ul class="ru1">
      <li class="l1"><a href="<?=weburl?>task/search_j<?=$row1[id]?>v.html" target="_blank"><?=$row1[name1]?></a></li>
      <li class="l2">
      <? while2("*","yjcode_tasktype where admin=2 and name1='".$row1[name1]."' order by xh asc");while($row2=mysql_fetch_array($res2)){?>
      <a href="<?=weburl?>task/search_j<?=$row1[id]?>v_k<?=$row2[id]?>v.html" target="_blank"><?=$row2[name2]?></a>
	  <? }?>
      </li>
      </ul>
      <? }?>
     </div>
    </div>
    <!--任务E-->
    <!--资讯B-->
    <div class="menu1" id="yhmenu3" onmouseover="yhmenuover(3)" onmouseout="yhmenuout(3)">
     <ul class="lu1 lm3">
     <li class="l1">业界资讯</li>
     <li class="l2">
     <? while2("*","yjcode_newstype where admin=1 order by xh asc limit 2");while($row2=mysql_fetch_array($res2)){?>
     <a href="<?=weburl?>news/newslist_j<?=$row1[id]?>v.html"><?=$row2[name1]?></a>
	 <? }?>
     </li>
     </ul>
     <span class="rx"></span>
     <div class="rmenu rmenu3" style="display:none;" id="rmenu3">
      <span class="cap"><strong>资讯分类</strong></span>
      <? while1("*","yjcode_newstype where admin=1 order by xh asc");while($row1=mysql_fetch_array($res1)){?>
      <ul class="ru1">
      <li class="l1"><a href="<?=weburl?>news/newslist_j<?=$row1[id]?>v.html"><?=$row1[name1]?></a></li>
      <li class="l2">
      <? while2("*","yjcode_newstype where name1='".$row1[name1]."' and admin=2 order by xh asc");while($row2=mysql_fetch_array($res2)){?>
      <a href="<?=weburl?>news/newslist_j<?=$row1[id]?>v_k<?=$row2[id]?>v.html"><?=$row2[name2]?></a>
	  <? }?>
      </li>
      </ul>
      <? }?>
     </div>
    </div>
    <!--资讯E-->
    <!--会员B-->
    <div class="menu1" id="yhmenu4" onmouseover="yhmenuover(4)" onmouseout="yhmenuout(4)">
     <ul class="lu1 lm4">
     <li class="l1">会员中心</li>
     <li class="l2"><a href="<?=weburl?>user/" target="_blank">进入我的会员中心</a></li>
     </ul>
     <span class="rx"></span>
     <div class="rmenu rmenu4" style="display:none;" id="rmenu4">
      <span class="cap"><strong>买家中心</strong></span>
      <ul class="ru1">
      <li class="l1"><a href="<?=weburl?>user/">常用功能</a></li>
      <li class="l2">
      <a href="<?=weburl?>user/order.php">我的订单</a>
      <a href="<?=weburl?>user/favpro.php">我的收藏</a>
      <a href="<?=weburl?>user/car.php">购物车</a>
      <a href="<?=weburl?>user/tasklist.php">我的任务</a>
      </li>
      </ul>
      <ul class="ru1">
      <li class="l1"><a href="<?=weburl?>user/paylog.php">财务管理</a></li>
      <li class="l2">
      <a href="<?=weburl?>user/pay.php">我要充值</a>
      <a href="<?=weburl?>user/tixian.php">我要提现</a>
      <a href="<?=weburl?>user/tixianlog.php">提现明细</a>
      <a href="<?=weburl?>user/jflog.php">积分明细</a>
      <a href="<?=weburl?>user/zfmm.php">安全码设置</a>
      </li>
      </ul>
      <ul class="ru1">
      <li class="l1"><a href="<?=weburl?>user/inf.php">基本资料</a></li>
      <li class="l2">
      <a href="<?=weburl?>user/inf.php">个人资料</a>
      <a href="<?=weburl?>user/touxiang.php">用户头像</a>
      <a href="<?=weburl?>user/mobbd.php">手机认证</a>
      <a href="<?=weburl?>user/emailbd.php">邮箱认证</a>
      </li>
      </ul>
      <span class="cap cap1"><strong>卖家管理</strong></span>
      <ul class="ru1 ru11">
      <li class="l1"><a href="<?=weburl?>user/shop.php">我是卖家</a></li>
      <li class="l2">
      <a href="<?=weburl?>user/shop.php">店铺设置</a>
      <a href="<?=weburl?>user/productlist.php">我的宝贝</a>
      <a href="<?=weburl?>user/sellorder.php">我的订单</a>
      </li>
      </ul>
     </div>
    </div>
    <!--会员E-->
   </div>
   <!--主导航下拉结束-->
   </div> 
   <!--左E-->
   
   <div class="m2">
   <a href="<?=weburl?>">首页</a>
   <? while1("*","yjcode_ad where adbh='ADI02' and type1='文字' and zt=0 order by xh asc");while($row1=mysql_fetch_array($res1)){?>
   <a href="<?=$row1[aurl]?>"><?=$row1[tit]?></a>
   <? }?>
   </div>
  </div>
  
 </div>
 
</div>
</div>