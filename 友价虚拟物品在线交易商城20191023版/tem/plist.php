  <? $money1=returnjgdian(returnyhmoney($row[yhxs],$row[money2],$row[money3],$sj,$row[yhsj1],$row[yhsj2],$row[id]));?>
  <ul class="u1<? if($i % 5==0){echo " u12";}?>" id="list<?=$i?>" onMouseOver="listover(<?=$i?>)" onMouseOut="listout(<?=$i?>)">
  <li class="l1">
  <a href="<?=$au?>" target="_blank"><img id="listbimg<?=$i?>" border="0" src="<?=returntp("bh='".$row[bh]."' order by xh asc","-1")?>" onerror="this.src='img/none200x200.gif'" width="210" height="210" class="bimtp" alt="<?=$row[tit]?>" /></a>
  </li>
  <li class="l2"><a href="<?=$au?>" class="acy" target="_blank" title="<?=$row[tit]?>"><?=strgb2312($row[tit],0,55)?></a></li>
  <li class="l3">£¤<strong><?=$money1?></strong></li>
  <li class="l4"><span class="s1">Á¢Ê¡<?=$row[money1]-$money1?>Ôª</span><s class="s2">£¤<?=$row[money1]?></s></li>
  </ul>