<?
$sqlpro="select * from yjcode_pro where bh='".$bh."' and userid=".$rowuser[id]."";mysql_query("SET NAMES 'GBK'");$respro=mysql_query($sqlpro);
if(!$rowpro=mysql_fetch_array($respro)){php_toheader("productlist.php");}
$promoney=returnjgdian(returnyhmoney($rowpro[yhxs],$rowpro[money2],$rowpro[money3],$sj,$rowpro[yhsj1],$rowpro[yhsj2],$rowpro[id]));
$protp=returntp("bh='".$rowpro[bh]."' order by xh asc","-2");
?>
 <div class="rproglo">
 <ul class="u1">
 <li class="l1"><a href="../product/view<?=$rowpro[id]?>.html" target="_blank"><img border="0" class="tp" src="<?=$protp?>" onerror="this.src='../img/none60x60.gif'" width="80" height="80" /></a></li>
 <li class="l2"><strong><?=$rowpro[tit]?></strong></li>
 <li class="l3">售价：<strong class="feng"><?=$promoney?></strong></li>
 <li class="l4">已被关注<?=$rowpro[djl]?>次，销量<?=$rowpro[xsnum]?>，审核状态：<strong><?=returnztv($rowpro[zt])?></strong></li>
 </ul>
 </div>