<?
include("../config/conn.php");
include("../config/function.php");
$id=intval($_GET[id]);
$sqluser="select * from yjcode_user where id=".$id;mysql_query("SET NAMES 'GBK'");$resuser=mysql_query($sqluser);
if(!$rowuser=mysql_fetch_array($resuser)){php_toheader("./");}
?>
<html>
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><?=$rowuser[nc]?>的个人主页 - <?=webname?></title>
<? include("../tem/cssjs.html");?>
<script language="javascript">
function myinfonc(x){
 for(i=1;i<=3;i++){
 document.getElementById("myinfa"+i).className="";
 document.getElementById("myinf"+i).style.display="none";
 }
 document.getElementById("myinfa"+x).className="a1";
 document.getElementById("myinf"+x).style.display="";
}
</script>
</head>
<body>
<? include("../tem/top.html");?>

<? include("top.php");?>
<script language="javascript">
document.getElementById("mytopa1").className="a1";
</script>

<div class="yjcode">
 <? include("left.php");?>
 <!--右B-->
 <div class="myright">
  <ul class="myjs">
  <li class="l1">我的介绍</li>
  <li class="l2"><?=returntitdian($rowuser[mytxt],200)?>……[<a href="aboutview<?=$rowuser[id]?>.html">查看更多</a>]</li>
  </ul>
  <div class="myinflist">
  <ul class="u1">
  <li class="l1">
  <a href="javascript:void(0);" onClick="myinfonc(1)" id="myinfa1">我的文章</a>
  <a href="javascript:void(0);" onClick="myinfonc(2)" id="myinfa2">商品评论</a>
  <a href="javascript:void(0);" onClick="myinfonc(3)" id="myinfa3">资讯评论</a>
  </li>
  <li class="l2"></li>
  </ul>
  <ul class="u2" id="myinf1">
  <? 
  while1("*","yjcode_news where zt=0 and userid=".$rowuser[id]." order by lastsj desc limit 10");while($row1=mysql_fetch_array($res1)){
  $au="../news/txtlist_i".$row1[id]."v.html";
  ?>
  <li class="l1"><a href="<?=$au?>" target="_blank"><?=$row1[tit]?></a></li>
  <li class="l2"><?=$row1[lastsj]?></li>
  <li class="l3"><a href="<?=$au?>" target="_blank"><?=$row1[wdes]?></a></li>
  <? }?>
  </ul>
  <ul class="u3" id="myinf2" style="display:none;">
  <? 
  while1("*","yjcode_propj where userid=".$rowuser[id]." order by sj desc limit 10");while($row1=mysql_fetch_array($res1)){
  while2("*","yjcode_pro where bh='".$row1[probh]."'");$row2=mysql_fetch_array($res2);
  ?>
  <li class="l1"><img src="../<?=returntp("bh='".$row2[bh]."' order by xh asc","-2")?>" onerror="this.src='../img/none180x180.gif'" /></li>
  <li class="l2">
  <a href="../product/view<?=$row2[id]?>.html" class="a1" target="_blank">【点评】 <?=$row2[tit]?></a><br>
  <span class="s1">评价时间：<?=$row1[sj]?></span>
  <span class="s2">评价内容：<?=$row1[txt]?></span>
  <? }?>
  </ul>
  <ul class="u2" id="myinf3" style="display:none;">
  <? 
  while1("*","yjcode_newspj where zt=0 and userid=".$rowuser[id]." order by sj desc limit 10");while($row1=mysql_fetch_array($res1)){
  while2("*","yjcode_news where bh='".$row1[newsbh]."'");$row2=mysql_fetch_array($res2);
  ?>
  <li class="l1"><a href="../news/txtlist_i<?=$row2[id]?>v.html" target="_blank">【点评】 <?=$row2[tit]?></a></li>
  <li class="l2"><?=$row1[sj]?></li>
  <li class="l3"><?=$row1[txt]?></li>
  <? }?>
  </ul>
  </div>
 </div>
 <!--右E-->
 
</div>
<script language="javascript">myinfonc(1);</script>
<? include("../tem/bottom.html");?>
</body>
</html>