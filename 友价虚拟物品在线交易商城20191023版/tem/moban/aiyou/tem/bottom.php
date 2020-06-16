<?
include("../../../../config/conn.php");
include("../../../../config/function.php");
?>
<!--一淘模板提示请不要倒卖否则停止更新-->
<div class="bfb bfbbottom">
<div class="yjcode">

 <div class="d1">
 <ul class="u1">
 <? while1("*","yjcode_helptype where admin=1 order by xh asc limit 5");while($row1=mysql_fetch_array($res1)){?>
 <li>
 <span><a href="<?=weburl?>help/search_j<?=$row1[id]?>v.html" target="_blank"><?=$row1[name1]?></a></span>
 <? 
 while2("*","yjcode_helptype where admin=2 and name1='".$row1[name1]."' order by xh asc limit 5");while($row2=mysql_fetch_array($res2)){
 $aurl="search_j".$row1[id]."v_k".$row2[id]."v.html";
 if(returncount("yjcode_help where ty1id=".$row1[id]." and ty2id=".$row2[id])==1){
 while3("id,ty1id,ty2id","yjcode_help where ty1id=".$row1[id]." and ty2id=".$row2[id]);$row3=mysql_fetch_array($res3);
 $aurl="view".$row3[id].".html";
 }
 ?>
 <a href="<?=weburl?>help/<?=$aurl?>" target="_blank" class="a1"><?=$row2[name2]?></a><br>
 <? }?>
 </li>
 <? }?>
 </ul>
 </div>
 
 <div class="d2">
 <strong>联系我们</strong><br>
 <? while1("*","yjcode_ad where adbh='aiyou_03' and zt=0 order by xh asc");if($row1=mysql_fetch_array($res1)){echo $row1[txt];}?>
 </div>
 
 <div class="d3">
 <? while1("*","yjcode_ad where adbh='aiyou_04' and zt=0 order by xh asc");if($row1=mysql_fetch_array($res1)){?>
 <a href="<?=$row1[aurl]?>" target="_blank"><img src="<?=weburl?><?=returnjgdw($rowcontrol[addir],"","gg")?>/<?=$row1[bh].".".$row1[jpggif]?>" width="100" height="100" /><br><?=$row1[tit]?></a>
 <? }?>
 </div>
 
 <ul class="u2">
 <li class="l1">
 <a href="<?=weburl?>help/aboutview2.html" target="_blank">关于我们</a>&nbsp;&nbsp;
 <a href="<?=weburl?>help/aboutview3.html" target="_blank">广告合作</a>&nbsp;&nbsp;
 <a href="<?=weburl?>help/aboutview4.html" target="_blank">联系我们</a>&nbsp;&nbsp;
 <a href="<?=weburl?>help/aboutview5.html" target="_blank">隐私条款</a>&nbsp;&nbsp;
 <a href="<?=weburl?>help/aboutview6.html" target="_blank">免责声明</a>&nbsp;&nbsp;
 <i>|&nbsp;&nbsp;Copyright <?=date("Y")+1?> <?=webname?>  版权所有</i><br>
 <a href="http://www.miitbeian.gov.cn/" target="_blank"><?=$rowcontrol[beian]?></a> <?=$rowcontrol[webtj]?>
 </li>
 <li class="l2">
 <? while1("*","yjcode_ad where adbh='aiyou_05' and zt=0 order by xh asc limit 5");while($row1=mysql_fetch_array($res1)){?>
 <a href="<?=$row1[aurl]?>" target="_blank"><img src="<?=weburl?><?=returnjgdw($rowcontrol[addir],"","gg")?>/<?=$row1[bh].".".$row1[jpggif]?>" width="106" height="40" /></a>
 <? }?>
 </li>
 </ul>
 
</div>
</div>

<? while1("*","yjcode_ad where adbh='ADKF' and zt=0 order by xh asc limit 1");if($row1=mysql_fetch_array($res1)){echo $row1[txt];}?>

<!--***********右侧浮动开始*************-->
<div class="rightfd" style="display:<? if($rowcontrol[ifkf]=="off"){?>none<? }?>;">

 <div class="d1">
  <span class="s1">联系客服</span>
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
  <strong class="fontyh">联系客服<br><?=$rowcontrol[webtelv]?></strong>
  </div>
 </div>

 <div class="d2">
  <span class="s1">手机版</span>
  <div class="sd1">
  <img src="<?=weburl?>tem/getqr.php?u=<?=weburl?>m&size=4" width="100" height="100" /><br>扫一扫进手机版
  </div>
 </div>

 <div class="d3">
  <span class="s1" onClick="gotoTop();return false;">返回顶部</span>
 </div>
 
</div>
<div style="display:none"><a href="http://www.0598128.com">源码论坛</a></div>
<!--**********右侧浮动结束***************-->

