<?
include("../../config/conn.php");
include("../../config/function.php");
$sj=date("Y-m-d H:i:s");
$getstr=$_GET[str];
$tit="商家风采";
$ses=" where zt=1 and shopzt=2 and shopname<>''";
if(returnsx("s")!=-1){$skey=safeEncoding(returnsx("s"));$ses=$ses." and shopname like '%".$skey."%'";$tit=$tit." ".$skey;}
if(returnsx("q")!=-1){$ses=$ses." and uqq='".returnsx("q")."'";}
if(returnsx("p")!=-1){$page=returnsx("p");}else{$page=1;}
$px="order by yxsj desc";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
<title><?=$tit?> - <?=webname?></title>
<? include("../tem/cssjs.html");?>
</head>
<body>
<div class="topfix">
<!--头部B-->
<div class="listtop box">
 <div class="d1" onClick="javascript:history.go(-1);"><img src="../img/leftjian.png" /></div>
 <div class="d2" onClick="gourl('../search/main.php?admin=2')"><span class="s1"><img src="../img/ser.png" /></span><span class="s2">请输入搜索关键词！</span></div>
</div>
<!--头部E-->
</div>
<div class="ntopv box"><div class="d1"></div></div>

<?
pagef($ses,20,"yjcode_user",$px);while($row=mysql_fetch_array($res)){
$au="view".$row[id].".html";
?>
<div class="shoplist1 box">
 <div class="d1"><img border="0" src="<?="../../upload/".$row[id]."/shop.jpg"?>" onerror="this.src='../img/none70x70.gif'" /></div>
 <div class="d2"><a href="<?=$au?>"><?=$row[shopname]?></a><span>共<?=returncount("yjcode_pro where zt=0 and ifxj=0 and userid=".$row[id])?>件商品</span></div>
 <div class="d3"><a href="<?=$au?>">进店</a></div>
</div>
<div class="shoplist2 box">
<div class="dmain">
 <?
 while2("*","yjcode_pro where userid=".$row[id]." and zt=0 and ifxj=0 order by lastsj desc limit 3");while($row2=mysql_fetch_array($res2)){
 $au2="../product/view".$row2[id].".html";
 $tp=returntp("bh='".$row2[bh]."' order by iffm desc","-2");
 ?>
 <div class="d1">
 <a href="<?=$au2?>">
 <img src="<?=$tp?>" onerror="this.src='../img/none70x70.gif'" border="0" />
 <span>￥<?=returnyhmoney($row2[yhxs],$row2[money2],$row2[money3],$sj,$row2[yhsj1],$row2[yhsj2],$row2[id])?></span>
 </a>
 </div>
 <? }?>
</div>
</div>
<? }?>

<div class="npa">
<?
$nowurl="search";
$nowwd="";
require("../tem/page.html");
?>
</div>

<? include("../tem/moban/".$rowcontrol[wapmb]."/tem/bottom.php");?>
</body>
</html>