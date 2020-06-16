<?
include("../../config/conn.php");
include("../../config/function.php");
$getstr=$_GET[str];
$ses=" where zt=0";
if(returnsx("p")!=-1){$page=returnsx("p");}else{$page=1;}
?>
<html>
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="viewport" content="initial-scale=1, width=device-width, maximum-scale=1, user-scalable=no" />
<title>网站公告</title>
<? include("../tem/cssjs.html");?>
</head>
<body>
<? $nowpagetit="网站公告";$nowpagebk="../";include("../tem/moban/".$rowcontrol[wapmb]."/tem/top.php");?>

<? 
$i=1;pagef($ses,20,"yjcode_gg","order by sj desc");while($row=mysql_fetch_array($res)){
$tit=$row[tit];
?>
<a href="ggview<?=$row[id]?>.html">
<div class="ilist box">
 <div class="d1 flex">
  <span class="s1"><?=$tit?></span>
  <span class="s2">关注：<?=$row[djl]?></span>
  <span class="s3"><?=dateYMDHM($row[sj])?></span>
 </div>
</div>
</a>
<? }?>
</div>
<div class="npa">
<?
$nowurl="gglist";
$nowwd="";
require("../tem/page.html");
?>
</div>

<? include("../tem/moban/".$rowcontrol[wapmb]."/tem/bottom.php");?>

</body>
</html>