<?
include("../../../../config/conn.php");
include("../../../../config/function.php");
?>
<!--导航B-->
<div class="bfb bfbtop1 fontyh">
<div class="yjcode">
 <? if(is_file("../tem/moban/".$rowcontrol[nowmb]."/homeimg/logo.png")){$logo=weburl."tem/moban/".$rowcontrol[nowmb]."/homeimg/logo.png";}else{$logo=weburl."img/logo.png";}?>
 <div class="logo"><a href="<?=weburl?>"><img alt="<?=webname?>" border="0" src="<?=$logo?>" /></a></div>
 <div class="menu">
 <a href="<?=weburl?>">首页</a>
 <? while1("*","yjcode_ad where adbh='ADI02' and type1='文字' and zt=0 order by xh asc limit 8");while($row1=mysql_fetch_array($res1)){?>
 <a href="<?=$row1[aurl]?>"><?=$row1[tit]?></a>
 <? }?>
 </div>
</div>
</div>
<!--导航E-->
