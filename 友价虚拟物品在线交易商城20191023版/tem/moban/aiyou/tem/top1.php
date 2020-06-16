<?
include("../../../../config/conn.php");
include("../../../../config/function.php");
?>
<!--一淘模板提示请不要倒卖否则停止更新-->
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
  <li class="l3"><input type="image" src="<?=weburl?>homeimg/btn1.png" /></li>
  </ul>
  </form>
  
  <div class="sqkd"><a href="<?=weburl?>user/openshop1.php">申请开店</a></div>
 
  <div class="menu fontyh">
   <!--左B-->
   <? $ai=returncount("yjcode_type where admin=1");?>
   <span id="typeallnum" style="display:none;"><?=$ai?></span>
   <div class="m1" onmouseover="leftmenuover()" onmouseout="leftmenuout()">
   <span class="t">全部分类</span>
   <!--主导航下拉开始-->
   <div class="menun fontyh" id="leftmenu" style="display:none;">
    <!--商品B-->
    <? 
	while3("*","yjcode_ad where zt=0 and adbh='aiyou_01' order by xh asc");
	$i=1;while1("*","yjcode_type where admin=1 order by xh asc");while($row1=mysql_fetch_array($res1)){
	$row3=mysql_fetch_array($res3);
	?>
    <div class="menu1" id="yhmenu<?=$i?>" onmouseover="yhmenuover(<?=$i?>)" onmouseout="yhmenuout(<?=$i?>)">
     <div class="lu1"><a href="<?=weburl?>product/search_j<?=$row1[id]?>v.html"><span class="s0"><img src="<?=weburl?><?=returnjgdw($rowcontrol[addir],"","gg")?>/<?=$row3[bh].".".$row3[jpggif]?>" /></span><span class="s1"><?=$row1[type1]?></span></a></div>
     <div class="rmenu rmenu1" style="display:none;margin-top:-<?=50*$i?>px;min-height:<?=50*returncount("yjcode_type where admin=1")?>px;" id="rmenu<?=$i?>">
      <? while2("*","yjcode_type where type1='".$row1[type1]."' and admin=2 order by xh asc");while($row2=mysql_fetch_array($res2)){?>
	  <span class="s1"><a href="<?=weburl?>product/search_j<?=$row1[id]?>v_k<?=$row2[id]?>v.html"><?=$row2[type2]?></a></span>
	  <? }?>
      
      <? 
      while2("*","yjcode_typesx where admin=1 and typeid=".$row1[id]." and ifsel=1 order by xh asc");while($row2=mysql_fetch_array($res2)){
      ?>
      <div class="tsx" style="display:none;"></div>
      <? while0("*","yjcode_typesx where admin=2 and name1='".$row2[name1]."' and typeid=".$row2[typeid]." order by xh asc");while($row=mysql_fetch_array($res)){?>
      <span class="s1" style="display:none;"><a href="<?=weburl?>product/search_j<?=$row1[id]?>v_e<?=$row2[id]?>_<?=$row[id]?>v.html"><?=$row[name2]?></a></span>
      <? }?>
      <? }?>

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
