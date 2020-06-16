<?
include("../config/conn.php");
include("../config/function.php");
$getstr=$_GET[str];
$id=returnsx("i");
while0("*","yjcode_news where id=".$id);if(!$row=mysql_fetch_array($res)){php_toheader(weburl."404.html");exit;}
if(returnsx("p")!=-1){$page=returnsx("p");}else{$page=1;}
?>
<html>
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="keywords" content="<?=$row[wkey]?>">
<meta name="description" content="<?=$row[wdes]?>">
<title><?=$row[tit]?> - <?=webname?></title>
<? include("../tem/cssjs.html");?>
</head>
<body>
<? include("../tem/openwv.php");?>
<? include("../tem/top.html");?>
<? include("../tem/top1.html");?>

<div class="yjcode">
 <div class="dqwz">
 <ul class="u1">
 <li class="l1">当前位置：<a href="<?=weburl?>">首页</a> > <a href="./">资讯评论</a></li>
 </ul>
 </div>

<div class="newsmain">
 <!--左B-->
 <div class="left">
 <h1 class="titcap fontyh"><a href="txtlist_i<?=$id?>v.html"><?=$row[tit]?></a></h1>
 
 <!--评论B-->
 <? $ses="yjcode_newspj where newsbh='".$row[bh]."'";?>
 <div class="pinlun fontyh">
  <ul class="plu1">
  <li class="l1"><strong>全部评论</strong>(<?=returncount($ses." and zt=0")?>)</li><li class="l2"></li>
  </ul>
  <form name="f1" method="post" onSubmit="return newspj()">
  <input type="hidden" value="<?=$row[bh]?>" name="bh" />
  <ul class="plu0">
  <li class="l1"><textarea id="pjt" name="pjt"></textarea></li>
  <li class="l3"></li>
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
  pagef(" where newsbh='".$row[bh]."' and zt=0",20,"yjcode_newspj","order by sj desc");while($row=mysql_fetch_array($res)){
  $usertx="../upload/".$row[userid]."/user.jpg";
  if(!is_file($usertx)){$usertx="../user/img/nonetx.gif";}
  ?>
  <div class="pld">
  <div class="pld1"><img src="<?=$usertx?>" width="50" height="50" /></div>
  <ul class="plu2">
  <li class="l1"><?=returnnc($row[userid])?></li>
  <li class="l2"><?=$row[txt]?></li>
  <li class="l3"><?=$row[sj]?></li>
  </ul>
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
 <!--评论E-->
 
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