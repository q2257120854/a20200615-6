 <ul class="taskmain">
 <li class="l1">任务主题：</li>
 <li class="l2"><a href="../task/view<?=$rowtask[id]?>.html" target="_blank"><strong><?=$rowtask[tit]?></strong></a></li>
 <li class="l1">任务预算：</li>
 <li class="l3"><strong class="feng">￥<?=$rowtask[money1]?></strong></li>
 <li class="l1">任务状态：</li>
 <li class="l3"><?=returntask($rowtask[zt])?></li>
 <li class="l1">任务类型：</li>
 <li class="l3"><?=returntasktype(1,$rowtask[type1id])." ".returntasktype(2,$rowtask[type2id])?></li>
 </ul>

