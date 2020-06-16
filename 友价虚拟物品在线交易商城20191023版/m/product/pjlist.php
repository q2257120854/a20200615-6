<?
include("../../config/conn.php");
include("../../config/function.php");
$getstr=$_GET[str];
$id=returnsx("i");
while0("*","yjcode_pro where zt<>99 and id=".$id);if(!$row=mysql_fetch_array($res)){php_toheader("../");}
$sj=date("Y-m-d H:i:s");
?>
<html>
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
<title><?=$row[tit]?>怎么样好不好、买家购买心得 - <?=webname?></title>
<? $cssjsty="a";include("../tem/cssjs.html");?>
<link href="view.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="view.js"></script>
</head>
<body>
<div class="yjcode">

<? $nowpagetit="评价信息";include("../tem/moban/".$rowcontrol[wapmb]."/tem/top.php");?>

<? 
if(returnsx("p")!=-1){$page=returnsx("p");}else{$page=1;}
pagef(" where probh='".$row[bh]."'",20,"yjcode_propj","order by sj desc");while($row=mysql_fetch_array($res)){
$usertx="../../upload/".$row[userid]."/user.jpg";
if(!is_file($usertx)){$usertx="../../user/img/nonetx.gif";}else{$usertx=$usertx."?id=".rnd_num(1000);} 
?>
<div class="pjlist box">
 <div class="d1"><img src="<?=$usertx?>" width="50" height="50" /><br><?=returnjiami(returnnc($row[userid]))?></div>
 <div class="d2">
  <span class="s0"><img src="../img/pj<?=$row[pjlx]?>.png" /></span>
  <span class="s1">
  <img src="../../img/x1.png" class="img1" width="76" height="15" />
  <? $pf=round(($row[pf1]+$row[pf2]+$row[pf3])/3,2);?>
  <div class="pf" style="width:<?=$pf/5*76?>px;"><img src="../../img/x2.png" width="76" height="15" /></div>
  </span>
  <span class="s2"><?=dateYMDHM($row[sj])?></span>
  <span class="s3"><?=$row[txt]?></span>
  <? if(1==$row[iftp]){?>
  <span class="s5">
  <? 
  while2("*","yjcode_tp where bh='".$row[orderbh]."' order by xh asc");while($row2=mysql_fetch_array($res2)){$tp="../../".str_replace(".","-1.",$row2[tp]);
  ?>
  <a href="../../<?=$row2[tp]?>" target="_blank"><img src="<?=$tp?>" width="50" height="50" /></a>&nbsp;&nbsp;
  <? }?>
  </span>
  <? }?>
  <? if(!empty($row[hf])){?><span class="s4">卖家回复：<?=$row[hf]?></span><? }?>
 </div>
</div>
<? }?>

</div>

<div class="npa">
<?
$nowurl="pjlist";
$nowwd="";
require("../tem/page.html");
?>
</div>

<? include("../tem/moban/".$rowcontrol[wapmb]."/tem/bottom.php");?>
</body>
</html>