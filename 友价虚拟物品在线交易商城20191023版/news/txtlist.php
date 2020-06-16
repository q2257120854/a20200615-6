<?
include("../config/conn.php");
include("../config/function.php");
$getstr=$_GET[str];
$id=returnsx("i");
while0("*","yjcode_news where id=".$id);if(!$row=mysql_fetch_array($res)){php_toheader(weburl."404.html");exit;}

$sj=date("Y-m-d H:i:s");
while1("*","yjcode_news where type1id=".$row[type1id]." and type2id=".$row[type2id]." and zt=0 and lastsj>='".$row[lastsj]."' and id<>".$row[id]." order by sj asc");
if($row1=mysql_fetch_array($res1)){$pre="<a href='txtlist_i".$row1[id]."v.html'>".$row1[tit]."</a>";}
else{$pre="已是第一篇内容";}
while1("*","yjcode_news where type1id=".$row[type1id]." and type2id=".$row[type2id]." and zt=0 and lastsj<='".$row[lastsj]."' and id<>".$row[id]." order by sj desc");
if($row1=mysql_fetch_array($res1)){$nex="<a href='txtlist_i".$row1[id]."v.html'>".$row1[tit]."</a>";}
else{$nex="已是最后一篇内容";}
checkdjl("c2",$row[id],"yjcode_news");
$t=preg_split("/_ueditor_page_break_tag_/",$row[txt]);
if(returnsx("p")==-1){$page=1;}else{$page=returnsx("p");}
$txt=$t[$page-1];
?>
<html>
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="keywords" content="<?=$row[wkey]?>">
<meta name="description" content="<?=$row[wdes]?>">
<title><?=$row[tit]?> - <?=webname?></title>
<? include("../tem/cssjs.html");?>
<? if(empty($rowcontrol[ifwap])){?>
<script language="javascript">
if(is_mobile()) {document.location.href= '<?=weburl?>m/news/txtlist_i<?=$id?>v.html';}
</script>
<? }?>
</head>
<body>
<? include("../tem/openwv.php");?>
<? include("../tem/top.html");?>
<? include("../tem/top1.html");?>

<div class="yjcode">
 <div class="dqwz">
 <ul class="u1">
 <li class="l1">
 当前位置：<a href="<?=weburl?>">首页</a> > <a href="./">资讯</a> > <a href="newslist_j<?=$row[type1id]?>v.html"><?=returnnewstype(1,$row[type1id])?></a>
 <? if(0!=$row[type2id]){?> > <a href="newslist_j<?=$row[type1id]?>v_k<?=$row[type2id]?>v.html"><?=returnnewstype(2,$row[type2id])?></a><? }?>
 </li>
 </ul>
 </div>

<div class="newsmain">
 <!--左B-->
 <div class="left">
 <h1 class="titcap fontyh"><a name="tit"><?=$row[tit]?></a></h1>
 <ul class="u1">
 <li class="l1">时间：<?=dateYMDHM($row[lastsj])?> 编辑：<?=$row[zze]?> 来源：<a href="<?=returndw($row[lyurl],"","#")?>" class="blue" target="_blank"><?=$row[ly]?></a> 阅读：<?=$row[djl]?></li>
 <li class="l2" onMouseOver="objdis(1,'newm')" onMouseOut="objdis(0,'newm')">扫一扫，手机访问</li>
 </ul>
 <div id="newm" style="display:none;"><? $uw=weburl."m/news/txtlist_i".$row[id]."v.html"; ?><img src="<?=weburl?>tem/getqr.php?u=<?=$uw?>&size=4" /></div>
 <div class="zytad"><? adwhile("ADNV03")?></div>
 <div class="zhaiy "><strong>摘要：</strong><?=$row[wdes]?></div>
 <div class="ntxt"><?=$txt?></div>
 <? if(count($t)>1){?>
 <div class="txtpage">
 <a href="<?=rentser('p',1,'','',"txtlist");?>#tit">第1页</a>
 <? for($i=1;$i<=count($t);$i++){?>
 <? if($page!=$i){?><a href="<?=rentser('p',$i,'','',"txtlist");?>#tit"><?=$i?></a><? }else{?><strong><?=$i?></strong><? }?>
 <? }?>
 <a href="<?=rentser('p',count($t),'','',"txtlist");?>#tit">最后1页</a>
 </div>
 <? }?>
 
 <!--评论B-->
 <? $ses="yjcode_newspj where newsbh='".$row[bh]."'";?>
 <a name="pj"></a>
 <div class="pinlun fontyh">
  <ul class="plu1">
  <li class="l1"><strong>全部评论</strong>(<?=returncount($ses." and zt=0")?>)</li><li class="l2"></li>
  </ul>
  <form name="f1" method="post" target="_blank" onSubmit="return newspj()">
  <input type="hidden" value="<?=$row[bh]?>" name="bh" />
  <ul class="plu0">
  <li class="l1"><textarea id="pjt" name="pjt"></textarea></li>
  <li class="l3">[<a href="pjlist_i<?=$id?>v.html" target="_blank">展开所有评论</a>]</li>
  <li class="l2"><input type="submit" value="发表评论"></li>
  </ul>
  </form>
  <? 
  if(!empty($_SESSION[SHOPUSER])){
  $userid=returnuserid($_SESSION[SHOPUSER]);
  while1("*",$ses." and zt=1 and userid=".$userid." order by sj desc");while($row1=mysql_fetch_array($res1)){
  $usertx="../upload/".$row1[userid]."/user.jpg";
  if(!is_file($usertx)){$usertx="../user/img/nonetx.gif";}
  ?>
  <div class="pld">
  <div class="pld1"><img src="<?=$usertx?>" width="50" height="50" /></div>
  <ul class="plu2">
  <li class="l1"><?=returnnc($row1[userid])?> <span class="red">(正在审核)</span></li>
  <li class="l2"><?=$row1[txt]?></li>
  <li class="l3"><?=$row1[sj]?></li>
  </ul>
  </div>
  <? }}?>
  
  <? 
  while1("*",$ses." and zt=0 order by sj desc limit 10");while($row1=mysql_fetch_array($res1)){
  $usertx="../upload/".$row1[userid]."/user.jpg";
  if(!is_file($usertx)){$usertx="../user/img/nonetx.gif";}
  ?>
  <div class="pld">
  <div class="pld1"><img src="<?=$usertx?>" width="50" height="50" /></div>
  <ul class="plu2">
  <li class="l1"><a href="../my/view<?=$row1[userid]?>.html" target="_blank"><?=returnnc($row1[userid])?></a></li>
  <li class="l2"><?=$row1[txt]?></li>
  <li class="l3"><?=$row1[sj]?></li>
  </ul>
  </div>
  <? }?>
 </div>
 <!--评论E-->
 
 <div class="nxg">
 上一篇：<?=$pre?><br>
 下一篇：<?=$nex?>
 </div>
 <div class="lad"><? adwhile("ADNV02");?></div>
 <div class="otherxg">
 <strong>最新发布的资讯信息</strong><br>
 <? while1("*","yjcode_news where zt=0 order by lastsj desc limit 10");while($row1=mysql_fetch_array($res1)){?>
 【<?=returnnewstype(1,$row1[type1id])."|".returnnewstype(2,$row1[type2id])?>】<a href="txtlist_i<?=$row1[id]?>v.html" class="g_ac0"><?=$row1[tit]?></a><span class="hui">(<?=dateYMDHM($row1[lastsj])?>)</span><br>
 <? }?>
 </div>
 </div>
 <!--左E-->
 
 <!--右B-->
 <div class="right">
 <div class="adf"><? adwhile("ADNV01");?></div>
 <? include("right.php");?>
 </div>
 <!--右E-->

</div>

</div>

<? include("../tem/bottom.html");?>
</body>
</html>