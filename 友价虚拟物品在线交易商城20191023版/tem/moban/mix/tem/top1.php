<?
include("../../../../config/conn.php");
include("../../../../config/function.php");
?>
<div class="bfb bfbtop1" id="zhuTop">
<div class="yjcode">
 <div class="top1">
  <?
  if(is_file("../tem/moban/".$rowcontrol[nowmb]."/homeimg/logo.png")){$logo=weburl."tem/moban/".$rowcontrol[nowmb]."/homeimg/logo.png";}else{$logo=weburl."img/logo.png";}
  ?>
  <h1 class="logo"><a href="<?=weburl?>"><img alt="<?=webname?>" border="0" src="<?=$logo?>" /></a></h1>
  
  <div class="topmu fontyh">
  <a href="<?=weburl?>" id="topmenu1">首页</a>
  <? while1("*","yjcode_ad where adbh='ADI02' and type1='文字' order by xh asc");while($row1=mysql_fetch_array($res1)){?>
  <a href="<?=$row1[aurl]?>"><?=$row1[tit]?></a>
  <? }?>
  </div>
  
  <form name="topf1" method="post" onSubmit="return topftj()">
  <ul class="u1">
  <li class="l2"><input name="topt" id="topt" type="text" /></li>
  <li class="l3"><input type="image" src="<?=weburl?>homeimg/btn1.gif" width="40" height="40" /></li>
  </ul>
  </form>
 
  <div class="menu fontyh">
 <!--左B-->
   <? $ai=returncount("yjcode_type where admin=1");?>
   <span id="typeallnum" style="display:none;"><?=$ai?></span>
   <div class="m1" onmouseover="leftmenuover()" onmouseout="leftmenuout()">
   <span class="t">全部商品分类</span>
   <!--主导航下拉开始-->
   <div class="menun fontyh" id="leftmenu" style="display:none;">
    <!--商品B-->
    <? $i=1;while1("*","yjcode_type where admin=1 order by xh asc");while($row1=mysql_fetch_array($res1)){?>
    <div class="menu1" id="yhmenu<?=$i?>" onmouseover="yhmenuover(<?=$i?>)" onmouseout="yhmenuout(<?=$i?>)">
     <ul class="lu1">
     <li class="l1"><a href="<?=weburl?>product/search_j<?=$row1[id]?>v.html"><?=$row1[type1]?></a></li>
     </ul>
     <div class="rmenu rmenu1" style="display:none;margin-top:-<?=45*$i?>px;min-height:<?=45*$ai?>px;" id="rmenu<?=$i?>">
      <? while2("*","yjcode_type where type1='".$row1[type1]."' and admin=2 order by xh asc");while($row2=mysql_fetch_array($res2)){?>
      <ul class="ru1">
      <li class="l0"><img src="<?=weburl?>upload/type/type2_<?=$row2[id]?>.png" /></li>
      <li class="l1"><a href="<?=weburl?>product/search_j<?=$row1[id]?>v_k<?=$row2[id]?>v.html"><?=$row2[type2]?></a></li>
      <li class="l2"><a href="<?=weburl?>product/search_j<?=$row1[id]?>v_k<?=$row2[id]?>v.html">选购</a></li>
      </ul>
	  <? }?>
     </div>
    </div>
    <? $i++;}?>
    <!--商品E-->
 
 
   <!--主导航下拉结束-->
   </div> 
   <!--左E-->
 
 
 </div>
</div>
</div>
