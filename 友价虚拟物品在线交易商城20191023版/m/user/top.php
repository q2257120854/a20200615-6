<? include("topuser.php");?>
<div class="buytop box">
 <div class="d1" onclick="gourl('shezhi.php')"><img src="img/setting.png" width="40" /></div>
 <div class="d2" onclick="gourl('touxiang.php')"><img border="0" src="<?=$usertx?>" width="60" height="60" /><br><?=returnjgdw($rowuser[nc],"",$rowuser[uid])?></div>
 <div class="d3">
 <? if(2!=$rowuser[shopzt] && 4!=$rowuser[shopzt] && $rowcontrol[ifopenshop]=="on"){?>
 <a href="openshop1.php">我要开店</a>
 <? }elseif($rowuser[shopzt]==1 || $rowuser[shopzt]==2 || $rowuser[shopzt]==3 || $rowuser[shopzt]==4){?>
 <a href="sell.php">进入商家版</a>
 <? }?>
 </div>
</div>
<div class="buytop1 box">
 <div class="d1" onclick="gourl('favpro.php')"><?=returncount("yjcode_profav where userid=".$rowuser[id])?><br>商品收藏</div>
 <div class="d1" onclick="gourl('favshop.php')"><?=returncount("yjcode_shopfav where userid=".$rowuser[id])?><br>店铺收藏</div>
 <div class="d1" onclick="gourl('prohis.php')"><img src="img/food.png" width="14" /><br>我的足迹</div>
 <?
 $sj=date("Y-m-d H:i:s");
 while1("*","yjcode_qiandao where userid=".$rowuser[id]." order by sj desc limit 1");
 if($row1=mysql_fetch_array($res1)){
 $a_ux = strtotime($sj);
 $a_date = date('Y-m-d',$a_ux);
 $b_date = date('Y-m-d',strtotime($row1[sj]));
 if($a_date==$b_date){$ifq=1;}else{$ifq=0;}
 }else{$ifq=0;}
 ?>
 <? if($ifq==0){?>
 <div class="d1 d2" onclick="gourl('qiandao.php')"><img src="img/qd.png" width="14" /><br>前去签到</div>
 <? }else{?>
 <div class="d1" onclick="gourl('qiandao.php')"><img src="img/qd.png" width="14" /><br>已签到</div>
 <? }?>
</div>