 <ul class="hotpro">
 <li class="l1">商品推荐</li>
 <? 
 while1("*","yjcode_pro where zt=0 and ifxj=0 and iftj>0 order by iftj asc limit 5");while($row1=mysql_fetch_array($res1)){
 ?>
 <li class="l2"><a href="../product/view<?=$row1[id]?>.html"><img alt="<?=$row1[tit]?>" src="<?=returntp("bh='".$row1[bh]."' order by iffm asc","-2")?>" width="50" height="50" align="left"></a><a href="../product/view<?=$row1[id]?>.html" title="<?=$row1[tit]?>"><?=returntitdian($row1[tit],66)?></a><br><strong class="feng">￥<?=returnjgdian(returnyhmoney($row1[yhxs],$row1[money2],$row1[money3],$sj,$row1[yhsj1],$row1[yhsj2],$row1[id]))?></strong></li>
 <? }?>
 </ul> 

 
 <div class="hotnew">
 <ul class="u1 fontyh">
 <li class="l1">资讯排行榜</li>
 <li class="l2"><a href="./">更多>></a></li>
 </ul>
 <ul class="u2">
 <? $i=1;while1("*","yjcode_news where zt=0 order by djl desc limit 10");while($row1=mysql_fetch_array($res1)){?>
 <li class="l1"><span class="s<?=$i?>"><?=$i?></span></li>
 <li class="l2"><a href="txtlist_i<?=$row1[id]?>v.html" class="g_ac0" title="<?=$row1[tit]?>"><?=strgb2312($row1[tit],0,40)?></a></li>
 <? $i++;}?>
 </ul>
 </div>