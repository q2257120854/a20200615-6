<?
include("../../../../config/conn.php");
include("../../../../config/function.php");
?>
<div class="bfb bfbtop1">
<div class="yjcode">
 <div class="top1">
  <h1 class="logo"><a href="<?=weburl?>"><img alt="<?=webname?>" border="0" src="<?=weburl?>img/logo.png" /></a></h1>
  
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
  <li class="l3"><input type="image" src="<?=weburl?>homeimg/btn1.gif" width="40" height="40" /></li>
  </ul>
  </form>
  
  <div class="topsad"><? adread("ADI05",250,75)?></div>
 
  <div class="menu fontyh">
   <!--左B-->
   <div class="m1" onmouseover="leftmenuover()" onmouseout="leftmenuout()">
   <span class="t"><img src="<?=weburl?>homeimg/type.gif" width="220" height="50" /></span>
   <!--主导航下拉开始-->
   <div class="menun fontyh" id="leftmenu" style="display:none;">
    <!--商品B-->
    <? $i=1;$ai=returncount("yjcode_type where admin=1");while1("*","yjcode_type where admin=1 order by xh asc");while($row1=mysql_fetch_array($res1)){?>
    <div class="menu1" id="yhmenu<?=$i?>" onmouseover="yhmenuover(<?=$i?>)" onmouseout="yhmenuout(<?=$i?>)">
     <ul class="lu1" style="background:url(../upload/type/type1_<?=$row1[id]?>.png) no-repeat;background-position:28px 12px;">
     <li class="l1"><?=$row1[type1]?></li>
     </ul>
     <span class="rx"></span>
     <div class="rmenu rmenu1" style="display:none;margin-top:-<?=45*$i-1?>px;min-height:<?=43*$ai-1?>px;" id="rmenu<?=$i?>">
      <span class="cap"><strong>小 类 别</strong></span>
      <ul class="ru1">
      <li class="l1">
      <? while2("*","yjcode_type where type1='".$row1[type1]."' and admin=2 order by xh asc");while($row2=mysql_fetch_array($res2)){?>
      <a href="<?=weburl?>product/search_j<?=$row1[id]?>v_k<?=$row2[id]?>v.html"><?=$row2[type2]?></a>
	  <? }?>
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
