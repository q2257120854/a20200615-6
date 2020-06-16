<?
include("../config/conn.php");
include("../config/function.php");
sesCheck();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>用户管理面板 - <?=webname?></title>
<? include("cssjs.html");?>
<link href="css/hudong.css" rel="stylesheet" type="text/css" />
</head>
<body>
<? include("../tem/top.html");?>
<? include("top.php");?>
<div class="yjcode">

<? include("left.php");?>

<!--RB-->
<div class="userright">
 
 <? include("rcap14.php");?>
 <script language="javascript">
 document.getElementById("rcap1").className="l1 l2";
 </script>

 <!--白B-->
 <div class="rkuang">
 
 <ul class="adlxcap">
 <li class="l1">选择</li>
 <li class="l2">广告位编号</li>
 <li class="l3">广告位说明</li>
 <li class="l4">剩余位置</li>
 <li class="l5">排队人数</li>
 </ul>
 <?
 while0("*","yjcode_adlx where admin=1 and zt=0 order by sj asc");while($row=mysql_fetch_array($res)){
 if(empty($row[maxnum])){$sywz="充足";}
 else{
  $a=$row[maxnum]-returncount("yjcode_ad where adbh='".$row[adbh]."' and zt=0");
  if($a<0){$sywz=0;}else{$sywz=$a;}
 }
 if($row[fflx]==1){$adlxu="adgd.php?bh=".$row[bh];}
 elseif($row[fflx]==2){$adlxu="adfd.php?bh=".$row[bh];}
 ?>
 <ul class="adlxlist">
 <li class="l1"><a href="<?=$adlxu?>">选择</a></li>
 <li class="l2"><?=$row[adbh]?></li>
 <li class="l3"><?=$row[tit]?></li>
 <li class="l4"><?=$sywz?></li>
 <li class="l5"><?=returncount("yjcode_ad where adbh='".$row[adbh]."' and zt=1")?></li>
 </ul>
 <? }?>

 <div class="clear clear15"></div>
 
 </div>
 <!--白E-->

</div> 
<!--RE-->

</div>

<div class="clear clear15"></div>
<? include("../tem/bottom.html");?>
</body>
</html>