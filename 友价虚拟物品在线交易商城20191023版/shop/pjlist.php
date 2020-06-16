<?
include("../config/conn.php");
include("../config/function.php");
include("../config/xy.php");
$sj=date("Y-m-d H:i:s");
$getstr=$_GET[str];

$uid=returnsx("i");
$sqluser="select * from yjcode_user where zt=1 and shopzt=2 and id=".$uid;mysql_query("SET NAMES 'GBK'");$resuser=mysql_query($sqluser);
if(!$rowuser=mysql_fetch_array($resuser)){php_toheader("./");}

$ses=" where selluserid=".$uid;
if(returnsx("p")!=-1){$page=returnsx("p");}else{$page=1;}
?>
<html>
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><?=$rowuser[shopname]?>的网上店铺 - <?=webname?></title>
<? include("../tem/cssjs.html");?>
<link href="shop.css" rel="stylesheet" type="text/css" />
</head>
<body>
<? include("top.php");?>
<script language="javascript">
document.getElementById("shopmenu1").className="a1";
</script>

<div class="bfb bfbshop">
<div class="yjcode">

 <!--左B-->
 <? include("left.php");?>
 <!--左E-->
 
 <!--右B-->
 <div class="iright">
 
  <div class="rcap">
   <div class="d1">客户评价</div>
  </div>
  <?
  $a1=returncount("yjcode_propj where selluserid=".$uid." and pf1=1")+returncount("yjcode_propj where selluserid=".$uid." and pf2=1")+returncount("yjcode_propj where selluserid=".$uid." and pf3=1");
  $a2=returncount("yjcode_propj where selluserid=".$uid." and pf1=2")+returncount("yjcode_propj where selluserid=".$uid." and pf2=2")+returncount("yjcode_propj where selluserid=".$uid." and pf3=2");
  $a3=returncount("yjcode_propj where selluserid=".$uid." and pf1=3")+returncount("yjcode_propj where selluserid=".$uid." and pf2=3")+returncount("yjcode_propj where selluserid=".$uid." and pf3=3");
  $a4=returncount("yjcode_propj where selluserid=".$uid." and pf1=4")+returncount("yjcode_propj where selluserid=".$uid." and pf2=4")+returncount("yjcode_propj where selluserid=".$uid." and pf3=4");
  $a5=returncount("yjcode_propj where selluserid=".$uid." and pf1=5")+returncount("yjcode_propj where selluserid=".$uid." and pf2=5")+returncount("yjcode_propj where selluserid=".$uid." and pf3=5");
  $al=$a1+$a2+$a3+$a4+$a5;
  if($al==0){$a1v=0;$a2v=0;$a3v=0;$a4v=0;$a5v=0;}
  else{
  $a1v=sprintf("%.1f",$a1/$al*100);
  $a2v=sprintf("%.1f",$a2/$al*100);
  $a3v=sprintf("%.1f",$a3/$al*100);
  $a4v=sprintf("%.1f",$a4/$al*100);
  $a5v=sprintf("%.1f",$a5/$al*100);
  }
  $hp=returncount("yjcode_propj where selluserid=".$uid." and pjlx=1");
  $pa=returncount("yjcode_propj where selluserid=".$uid."");
  if($pa==0){$av="100";}else{$av=sprintf("%.2f",$hp/$pa*100);}
  ?>
  <ul class="pjcap">
  <li class="l1"><span>好评率</span><strong><?=$av?>%</strong></li>
  <li class="l1"><span>综合得分</span><strong><?=round(($mspf+$fhpf+$shpf)/3,2)?></strong></li>
  <li class="l2">描述相符：<span><?=$mspf?></span>分<br>发货速度：<span><?=$fhpf?></span>分<br>服务态度：<span><?=$shpf?></span>分</li>
  </ul>
  <div class="pjcap1">
  <ul class="u1">
  <li class="l1"><span class="s0"><img src="<?=weburl?>shop/img/pjf1.gif" /></span><span class="s1"><strong>1</strong>分</span><span class="s2" style="width:<?=returnjgdw($a1v*1.2,"",1)?>px"></span><span class="s3"><?=$a1v?>%</span></li>
  <li class="l1"><span class="s0"><img src="<?=weburl?>shop/img/pjf2.gif" /></span><span class="s1"><strong>2</strong>分</span><span class="s2" style="width:<?=returnjgdw($a2v*1.2,"",1)?>px"></span><span class="s3"><?=$a2v?>%</span></li>
  <li class="l1"><span class="s0"><img src="<?=weburl?>shop/img/pjf3.gif" /></span><span class="s1"><strong>3</strong>分</span><span class="s2" style="width:<?=returnjgdw($a3v*1.2,"",1)?>px"></span><span class="s3"><?=$a3v?>%</span></li>
  <li class="l1"><span class="s0"><img src="<?=weburl?>shop/img/pjf4.gif" /></span><span class="s1"><strong>4</strong>分</span><span class="s2" style="width:<?=returnjgdw($a4v*1.2,"",1)?>px"></span><span class="s3"><?=$a4v?>%</span></li>
  <li class="l1"><span class="s0"><img src="<?=weburl?>shop/img/pjf5.gif" /></span><span class="s1"><strong>5</strong>分</span><span class="s2" style="width:<?=returnjgdw($a5v*1.2,"",1)?>px"></span><span class="s3"><?=$a5v?>%</span></li>
  </ul>
  </div>
  <? 
  pagef($ses,20,"yjcode_propj","order by sj desc");while($row=mysql_fetch_array($res)){
  $usertx="../upload/".$row[userid]."/user.jpg";
  if(!is_file($usertx)){$usertx="../user/img/nonetx.gif";}else{$usertx=$usertx."?id=".rnd_num(1000);}
  $pjlx=returnjgdw($row[pjlx],"",1);
  if($pjlx==1){$pj="好评";}
  elseif($pjlx==2){$pj="一般";}
  elseif($pjlx==3){$pj="差评";}
  ?>
  <div class="pj pj<?=$pjlx?>">
   <ul class="u1"><li class="l1"><img src="../user/img/nonetx.gif" width="50" height="50" /></li><li class="l2"><?=returnjiami(returnnc($row[userid]))?></li></ul>
   <ul class="u2">
   <li class="l1">
   <?=strip_tags($row[txt])?><br>
   <? 
   if(1==$row[iftp]){
   while2("*","yjcode_tp where bh='".$row1[orderbh]."' order by xh asc");while($row2=mysql_fetch_array($res2)){$tp="../".str_replace(".","-1.",$row2[tp]);
   ?>
   <a href="../<?=$row[tp]?>" target="_blank"><img src="<?=$tp?>" width="50" height="50" /></a>&nbsp;&nbsp;
   <? }}?>
   </li>
   <li class="l3"><?=$row[sj]?></li>
   </ul>
   <div class="d2"><span class="s<?=$pjlx?>"><?=$pj?></span></div>
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
 <!--右E-->

</div>
</div>
<? include("../tem/bottom.html");?>
</body>
</html>