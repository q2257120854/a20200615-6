<?
include("../../config/conn.php");
include("../../config/function.php");
$id=intval($_GET[id]);
while0("*","yjcode_gg where id=".$id);if(!$row=mysql_fetch_array($res)){php_toheader("gglist.html");}
checkdjl("c2",$row[id],"yjcode_gg");

while1("*","yjcode_gg where sj>='".$row[sj]."' and id<>".$row[id]." and zt<>99 order by sj asc");
if($row1=mysql_fetch_array($res1)){$pre="<a href='ggview".$row1[id].".html' class='a1'>上一篇</a>";}
while1("*","yjcode_gg where sj<='".$row[sj]."' and id<>".$row[id]." and zt<>99 order by sj desc");
if($row1=mysql_fetch_array($res1)){$nex="<a href='ggview".$row1[id].".html' class='a2'>下一篇</a>";}
?>
<html>
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
<meta name="keywords" content="<?=$row[wkey]?>">
<meta name="description" content="<?=$row[wdes]?>">
<title><?=$row[tit]?> - <?=webname?></title>
<? include("../tem/cssjs.html");?>
</head>
<body>
<? $nowpagetit="网站公告";$nowpagebk="gglist.html";include("../tem/moban/".$rowcontrol[wapmb]."/tem/top.php");?>

<div class="wz box">
 <div class="d1">
 位置：<a href="gglist.html">网站公告</a> > 详情
 </div>
</div>

<div class="ntit box">
<div class="d1">
<strong><?=$row[tit]?></strong><br>
<?=dateYMDHM($row[sj])?> 阅读:<?=$row[djl]?>
</div>
</div>

<div class="ntxt box"><div class="d1"><?=$row[txt]?></div></div>

<div class="xgtxt box">
 <div class="dm">
 <?=$pre?>
 <?=$nex?>
 </div>
</div>

<? include("../tem/moban/".$rowcontrol[wapmb]."/tem/bottom.php");?>
</body>
</html>