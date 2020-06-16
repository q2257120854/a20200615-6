<div class="taskmain1 box"><div class="d1"></div><div class="d2">基本信息</div></div>
<div class="taskmain2 box">
 <div class="d1">任务主题：</div>
 <div class="d2"><a href="../task/view<?=$rowtask[id]?>.html"><strong><?=$rowtask[tit]?></strong></a></div>
</div>
<div class="taskmain2 box">
 <div class="d1">任务预算：</div>
 <div class="d2"><strong class="feng">￥<?=$rowtask[money1]?></strong></div>
</div>
<div class="taskmain2 box">
 <div class="d1">任务状态：</div>
 <div class="d2"><?=returntask($rowtask[zt])?></div>
</div>
<div class="taskmain2 box">
 <div class="d1">任务类型：</div>
 <div class="d2"><?=returntasktype(1,$rowtask[type1id])." ".returntasktype(2,$rowtask[type2id])?></div>
</div>
<div class="taskmain3 box"></div>
