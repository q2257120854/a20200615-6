<?
include("../config/conn.php");
include("../config/function.php");
$getstr=$_GET[str];
$id=intval(returnsx("i"));
$sqluser="select * from yjcode_user where id=".$id;mysql_query("SET NAMES 'GBK'");$resuser=mysql_query($sqluser);
if(!$rowuser=mysql_fetch_array($resuser)){php_toheader("./");}

if(returnsx("p")!=-1){$page=returnsx("p");}else{$page=1;}
?>
<html>
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><?=$rowuser[nc]?>的个人主页 - <?=webname?></title>
<? include("../tem/cssjs.html");?>
</head>
<body>
<? include("../tem/top.html");?>

<? include("top.php");?>
<script language="javascript">
document.getElementById("mytopa4").className="a1";
</script>

<div class="yjcode">
 <? include("left.php");?>
 <!--右B-->
 <div class="myright">
  <div class="myinflist myinflist1">
  <ul class="u1">
  <li class="l1">
  <a href="javascript:void(0);">商品评论</a>
  </li>
  <li class="l2"></li>
  </ul>
  <ul class="u3">
  <? 
  pagef(" where userid=".$rowuser[id]."",20,"yjcode_propj","order by sj desc");while($row=mysql_fetch_array($res)){
  while2("*","yjcode_pro where bh='".$row[probh]."'");$row2=mysql_fetch_array($res2);
  ?>
  <li class="l1"><img src="<?=returntp("bh='".$row2[bh]."' order by xh asc","-2")?>" onerror="this.src='../img/none180x180.gif'" /></li>
  <li class="l2">
  <a href="../product/view<?=$row2[id]?>.html" class="a1" target="_blank">【点评】 <?=$row2[tit]?></a><br>
  <span class="s1">评价时间：<?=$row[sj]?></span>
  <span class="s2">评价内容：<?=$row[txt]?></span>
  <? }?>
  </ul>
  
  <div class="npa">
  <?
  $nowurl="propllist";
  $nowwd="";
  require("../tem/page.html");
  ?>
  </div>

  </div>
 </div>
 <!--右E-->
 
</div>
<? include("../tem/bottom.html");?>
</body>
</html>