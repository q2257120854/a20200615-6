<?
include("../config/conn.php");
include("../config/function.php");
while0("*","yjcode_help where id=".$_GET[id]);if(!$row=mysql_fetch_array($res)){php_toheader("./");}

while1("*","yjcode_help where sj>='".$row[sj]."' and id<>".$row[id]." order by sj asc");
if($row1=mysql_fetch_array($res1)){$pre="<a href='view".$row1[id].".html'>".$row1[tit]."</a>";}else{$pre="已是该分组下第一篇";}

while1("*","yjcode_help where sj<='".$row[sj]."' and id<>".$row[id]." order by sj desc");
if($row1=mysql_fetch_array($res1)){$nex="<a href='view".$row1[id].".html'>".$row1[tit]."</a>";}else{$nex="已是该分组下最后一篇";}
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
<? include("../tem/top.html");?>
<? include("../tem/top1.html");?>

<div class="yjcode">

<? include("left.php");?>
<!--开始-->
<div class="helpright">
 <div class="wz">
 您当前的位置：<a href="../">首页</a> <span>>></span> 
 <a href="./">帮助中心</a> <span>>></span> 
 <a href="search_j<?=$row[ty1id]?>v.html"><?=returnhelptype(1,$row[ty1id])?></a>
 <? if($row[ty2id]!=0){?><span>>></span> <a href="search_j<?=$row[ty1id]?>v_k<?=$row[ty2id]?>v.html"><?=returnhelptype(2,$row[ty2id])?></a><? }?> <span>>></span> 
 <?=$row[tit]?>
 </div>

 <h1 class="titcap fontyh"><a name="tit"><?=$row[tit]?></a></h1>
 <ul class="u1">
 <li class="l1">更新时间：<?=dateYMDHM($row[sj])?> 阅读次数：<?=$row[djl]?></li>
 <li class="l2" onMouseOver="objdis(1,'newm')" onMouseOut="objdis(0,'newm')">扫一扫，手机访问</li>
 </ul>
 <div id="newm" style="display:none;"><? $uw=weburl."help/view".$row[id].".html"; ?><img src="<?=weburl?>tem/getqr.php?u=<?=$uw?>&size=4" /></div>
 <div class="ntxt"><?=$row[txt]?></div>
 <div class="nxg">
 上一篇：<?=$pre?><br>
 下一篇：<?=$nex?>
 </div>

</div>
<!--结束-->

</div>
<? include("../tem/bottom.html");?>
</body>
</html>