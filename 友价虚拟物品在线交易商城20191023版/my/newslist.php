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
document.getElementById("mytopa3").className="a1";
</script>

<div class="yjcode">
 <? include("left.php");?>
 <!--右B-->
 <div class="myright">
  <div class="myinflist myinflist1">
  <ul class="u1">
  <li class="l1">
  <a href="javascript:void(0);">我的文章</a>
  </li>
  <li class="l2"></li>
  </ul>
  <ul class="u2">
  <? 
  pagef(" where zt=0 and userid=".$rowuser[id]."",20,"yjcode_news","order by lastsj desc");while($row=mysql_fetch_array($res)){
  $au="../news/txtlist_i".$row[id]."v.html";
  ?>
  <li class="l1"><a href="<?=$au?>" target="_blank"><?=$row[tit]?></a></li>
  <li class="l2"><?=$row[lastsj]?></li>
  <li class="l3"><a href="<?=$au?>" target="_blank"><?=$row[wdes]?></a></li>
  <? }?>
  </ul>
  
  <div class="npa">
  <?
  $nowurl="newslist";
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