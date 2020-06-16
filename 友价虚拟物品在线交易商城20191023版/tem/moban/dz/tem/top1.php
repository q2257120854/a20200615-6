<?
include("../../../../config/conn.php");
include("../../../../config/function.php");
?>
<!--一淘模板提示请不要倒卖否则停止更新-->
<div class="bfb bfbtop1">
<div class="yjcode">
 <div class="top1">
  <h1 class="logo"><a href="<?=weburl?>"><img alt="<?=webname?>" border="0" src="<?=weburl?>homeimg/logo.png" /></a></h1>
  
  <form name="topf1" method="post" onSubmit="return topftj()">
  <ul class="u1">
  <li class="l1" onMouseOver="topover()" onMouseOut="topout()">
  <span id="topnwd">商品</span>
  <div id="topdiv" style="display:none;">
  <a href="javascript:void();" onClick="topjconc(1,'商品')">商品</a>
  <a href="javascript:void();" onClick="topjconc(2,'店铺')">店铺</a>
  <a href="javascript:void();" onClick="topjconc(3,'资讯')">资讯</a>
  </div>
  </li>
  <li class="l2"><input name="topt" id="topt" type="text" /></li>
  <li class="l3"><input type="image" src="<?=weburl?>homeimg/btn1.png"/></li>
  </ul>
  </form>

<div class="myuser">
				<h2>
					我的个人中心
				</h2>
				<div class="dropdown">
					<div class="worbli" id="notloginb">
						您好 , <a href="<?=weburl?>reg/">请登陆</a>  或  <a href="<?=weburl?>reg/reg.php">注册</a>  进行账号交易
					</div>
					<div class="worbli" id="yesloginb" style="display:none;">
						您好 , <a href="<?=weburl?>user/" id="yesuidb"></a>
					</div>
					<div class="model">
						<a href="<?=weburl?>user/order.php">我购买的商品</a>
						<a href="<?=weburl?>user/favpro.php">我收藏的商品</a>
						<a href="<?=weburl?>user/pay.php">资金充值操作</a>
					</div>
					<div class="model last" >
						<a href="<?=weburl?>user/productlist.php">我出售的商品</a>
						<a href="<?=weburl?>user/productlx.php">我要发布商品</a>
						<a href="<?=weburl?>user/productlist.php">商品库存查看</a>
						<a href="<?=weburl?>user/tixian.php">资金提现操作</a>
					</div>
		</div>
  
  </div>

  <div class="menu fontyh">
   <!--左B-->
  
   <? $ai=returncount("yjcode_type where admin=1");?>
   <span id="typeallnum" style="display:none;"><?=$ai?></span>
   <div class="m1" onmouseover="leftmenuover()" onmouseout="leftmenuout()">
   <span class="t">全部商品分类</span>
   <!--主导航下拉开始-->
   <div class="menun fontyh" id="leftmenu" style="display:none;">
    <!--商品B-->
      <? 
	while3("*","yjcode_ad where zt=0 and adbh='928vip_06' order by xh asc");
	$i=1;while1("*","yjcode_type where admin=1 order by xh asc");while($row1=mysql_fetch_array($res1)){
	$row3=mysql_fetch_array($res3);
	?>
    <div class="menu1" id="yhmenu<?=$i?>" onmouseover="yhmenuover(<?=$i?>)" onmouseout="yhmenuout(<?=$i?>)">
     <ul class="lu1">
     <li class="l1"><span class="s0"><img src="<?=weburl?><?=returnjgdw($rowcontrol[addir],"","gg")?>/<?=$row3[bh].".".$row3[jpggif]?>" width="30"/></span>&nbsp;&nbsp;<a href="<?=weburl?>product/search_j<?=$row1[id]?>v.html"><?=$row1[type1]?></a></li>
     </ul>
	 
     <div class="rmenu rmenu1" style="display:none;margin-top:-<?=50*$i-1?>px;min-height:<?=50*$ai-1?>px;" id="rmenu<?=$i?>"> 
      <ul class="ru1">
      <li class="l2">
      <? while2("*","yjcode_type where type1='".$row1[type1]."' and admin=2 order by xh asc");while($row2=mysql_fetch_array($res2)){?>
      &nbsp;&nbsp;&nbsp;<a href="<?=weburl?>product/search_j<?=$row1[id]?>v_k<?=$row2[id]?>v.html"><?=$row2[type2]?></a>&nbsp;&nbsp;&nbsp;
      <? }?>&nbsp;
      </li>
      </ul>

     </div>
    </div>
    <? $i++;}?>
    <!--商品E-->
   </div>
   <!--主导航下拉结束-->
   </div> 
   <!--左E-->

   <div class="m2">
   <a href="<?=weburl?>" id="topmenu1">首页</a>
   <? while1("*","yjcode_ad where adbh='ADI02' and type1='文字' order by xh asc");while($row1=mysql_fetch_array($res1)){?>
   <a href="<?=$row1[aurl]?>"><?=$row1[tit]?></a>
   <? }?>
   </div>
  </div>
 
 </div>
</div>
</div>
