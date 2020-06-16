 <!--右B-->
  <? adwhile("ADTASK01")?>
  <div class="d1">
  <ul class="u1"><li class="l1">最新任务</li><li class="l2"></li></ul>
  <? while1("*","yjcode_task where zt=0 or zt=101 order by lastsj desc limit 10");while($row1=mysql_fetch_array($res1)){taskok($row1[id]);?>
  <ul class="u2">
  <li class="l1"><span class="red">￥<?=$row1[money1]?></span> <a href="view<?=$row1[id]?>.html" class="a1"><?=$row1[tit]?></a></li>
  <li class="l2"><?=dateYMD($row1[sj])?></li>
  <li class="l3"><span class="red"><?=returncount("yjcode_taskhf where bh='".$row1[bh]."'")?></span>人参与</li>
  </ul>
  <? }?>
  </div>
 <!--右E-->
