<?
include("../config/conn.php");
include("../config/function.php");
$getstr=$_GET[str];
$id=returnsx("i");
while0("*","yjcode_pro where zt<>99 and id=".$id);if(!$row=mysql_fetch_array($res)){php_toheader("../");}
$sj=date("Y-m-d H:i:s");
$tp=returntp("bh='".$row[bh]."' order by iffm asc","-2");
?>
<html>
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><?=$row[tit]?>怎么样好不好、买家购买心得 - <?=webname?></title>
<? include("../tem/cssjs.html");?>
<link href="view.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="view.js"></script>
</head>
<body>
<? include("../tem/top.html");?>
<? include("../tem/top1.html");?>

<div class="yjcode">
 <div class="dqwz">
 <ul class="u1">
 <li class="l1">
 当前位置：<a href="<?=weburl?>">首页</a> > <a href="search_j<?=$row[ty1id]?>v.html"><?=returntype(1,$row[ty1id])?></a>
 <? if(0!=$row[ty2id]){?> > <a href="search_j<?=$row[ty1id]?>v_k<?=$row[ty2id]?>v.html"><?=returntype(2,$row[ty2id])?></a><? }?>
 <? if(0!=$row[ty3id]){?> > <a href="search_j<?=$row[ty1id]?>v_k<?=$row[ty2id]?>v_m<?=$row[ty3id]?>v.html"><?=returntype(3,$row[ty3id])?></a><? }?>
 > 评价
 </li>
 </ul>
 </div>

 <!--左B-->
 <div class="pjvleft">
 <ul class="u1">
 <li class="l1 fontyh">商品信息</li>
 <li class="l2"><a href="view<?=$row[id]?>.html"><img border="0" src="<?=$tp?>" onerror="this.src='../img/none180x180.gif'" width="178" height="178" /></a><br><a href="view<?=$row[id]?>.html"><?=$row[tit]?></a></li>
 <li class="l3">
 优惠价：<strong class="red">￥<?=returnjgdian(returnyhmoney($row[yhxs],$row[money2],$row[money3],$sj,$row[yhsj1],$row[yhsj2],$row[id]))?></strong><br>
 已销售：<?=$row[xsnum]?>
 </li>
 <li class="l4"><a href="view<?=$row[id]?>.html"></a></li>
 </ul>
 </div>
 <!--左E-->

 <!--右B-->
 <div class="right">
 <ul class="pjcap">
 <li class="l1">商品评价</li>
 <li class="l2">描述相符<br><strong><?=$row[pf1]?></strong></li>
 <li class="l2">发货速度<br><strong><?=$row[pf2]?></strong></li>
 <li class="l2">服务态度<br><strong><?=$row[pf3]?></strong></li>
 <li class="l2">综合评分<br><strong><?=round(($row[pf1]+$row[pf2]+$row[pf3])/3,2)?></strong></li>
 <li class="l3"><a href="../user/order.php?ddzt=suc">写评价赚积分</a></li>
 </ul>
 <? 
 if(returnsx("p")!=-1){$page=returnsx("p");}else{$page=1;}
 pagef(" where probh='".$row[bh]."'",20,"yjcode_propj","order by sj desc");while($row=mysql_fetch_array($res)){
 $usertx="../upload/".$row[userid]."/user.jpg";
 if(!is_file($usertx)){$usertx="../user/img/nonetx.gif";}else{$usertx=$usertx."?id=".rnd_num(1000);} 
 ?>
 <div class="pj pj<?=$row[pjlx]?>">
  <ul class="u1"><li class="l1"><img src="<?=$usertx?>" width="50" height="50" /></li><li class="l2"><?=returnjiami(returnnc($row[userid]))?></li></ul>
  <ul class="u2">
  <li class="l1">
  <?=$row[txt]?><br>
  <? 
  if(1==$row[iftp]){
  while2("*","yjcode_tp where bh='".$row[orderbh]."' order by xh asc");while($row2=mysql_fetch_array($res2)){$tp="../".str_replace(".","-1.",$row2[tp]);
  ?>
  <a href="../<?=$row2[tp]?>" target="_blank"><img src="<?=$tp?>" width="50" height="50" /></a>&nbsp;&nbsp;
  <? }}?>
  </li>
  <? if(!empty($row[hf])){?><li class="l2">卖家回复：<?=$row[hf]?></li><? }?>
  <li class="l3"><?=$row[sj]?></li>
  </ul>
  <div class="d2">
  <? if(1==$row[pjlx]){?><span class="s1">好评</span><? }?>
  <? if(2==$row[pjlx]){?><span class="s2">中评</span><? }?>
  <? if(3==$row[pjlx]){?><span class="s3">差评</span><? }?>
  </div>
  <div class="d3">
  <img src="../img/x1.png" class="img1" width="76" height="15" />
  <? $pf=round(($row[pf1]+$row[pf2]+$row[pf3])/3,2);?>
  <div class="pf" style="width:<?=$pf/5*76?>px;"><img src="../img/x2.png" title="<?=$pf?>分" width="76" height="15" /></div>
  </div>
 </div>
 <? }?>
 <div class="npa">
 <?
 $nowurl="pjlist";
 $nowwd="";
 require("../tem/page.html");
 ?>
 </div>
 </div>
 <!--右E-->

</div>

<? include("../tem/bottom.html");?>
</body>
</html>