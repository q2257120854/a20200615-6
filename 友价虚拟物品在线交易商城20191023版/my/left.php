 <!--左B-->
 <? checkdjl("c1",$rowuser[id],"yjcode_user");?>
 <div class="myleft">
  <ul class="u1">
  <li class="l1"><img src="../upload/<?=$rowuser[id]?>/user.jpg" onerror="this.src='../img/none180x180.gif'" /></li>
  <li class="l2"><?=returnjiami($rowuser[nc])?></li>
  <li class="l3">访客数：<?=$rowuser[djl]?></li>
  </ul>
  <ul class="u2">
  <li class="l1">TA的活跃度</li>
  <li class="l2">
  <?
  $sj1=dateYMD(date("Y-m-d H:i:s",strtotime("-30 day")))." 00:00:00";
  $sj2=dateYMD(getsj())." 23:59:59";
  ?>
  <span class="s1">近30天登录：<?=returncount("yjcode_loginlog where admin=1 and sj>'".$sj1."' and sj<'".$sj2."'")?></span>
  <span class="s2">商品总评价：<?=returncount("yjcode_propj where userid=".$rowuser[id]."")?></span>
  <span class="s3">资讯总评论：<?=returncount("yjcode_newspj where userid=".intval($rowuser[id])." and zt=0")?></span>
  <span class="s4">发表文章：<?=returncount("yjcode_news where userid=".$rowuser[id]." and zt=0")?></span>
  </li>
  </ul>
 </div>
 <!--左E-->
