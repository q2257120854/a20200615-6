<?
include("../config/conn.php");
include("../config/function.php");

$sj=date("Y-m-d H:i:s");
$getstr=$_GET[str];
$ses=" where zt=1";
$tit="";
if(returnsx("s")!=-1){$skey=safeEncoding(returnsx("s"));$ses=$ses." and (tit like '%".$skey."%' or txt like '%".$skey."%')";$tit=$tit.$skey."_";}
if(returnsx("f")!=-1){$tyid=returnsx("f");$tyidv="xcf".$tyid."xcf";$ses=$ses." and tyid like '%".$tyidv."%'";$tit=$tit.returnfenlei(2,$tyid);}
if(returnsx("t")!=-1){$ymhzid=returnsx("t");$ses=$ses." and ymhzid=".$ymhzid;$tit=$tit.returnymhz($ymhzid);}
$ifba=returnsx("a");
if($ifba!=-1){if($ifba==1){$ses=$ses." and bah=''";$tit=$tit."未备案";}else{$ses=$ses." and bah<>''";$tit=$tit."已备案";}}
if(returnsx("b")!=-1){$mon1=returnsx("b");$ses=$ses." and money1>=".$mon1;}
if(returnsx("c")!=-1){$mon2=returnsx("c");$ses=$ses." and money1<=".$mon2;}
if(returnsx("d")!=-1){$ses=$ses." and ifyz=1";}
if(returnsx("g")!=-1){$nolike=safeEncoding(returnsx("g"));$ses=$ses." and (tit not like '%".$nolike."%')";}
if(returnsx("h")!=-1){$jssj=returnsx("h");$sj1=strtotime($sj);$sj2=time()+$jssj*3600;$ses=$ses." and yxq>=".$sj1." and yxq<=".$sj2."";}
if(returnsx("j")!=-1){$len1=returnsx("j");$ses=$ses." and ymcd>=".$len1;}
if(returnsx("k")!=-1){$len2=returnsx("k");$ses=$ses." and ymcd<=".$len2;}
$jyfs=returnsx("l");if($jyfs!=-1){$ses=$ses." and jyfs=".returnsx("l");}
if(returnsx("p")!=-1){$page=returnsx("p");}else{$page=1;}

$px="order by lastsj desc";
$pxv=returnsx("e");
if($pxv==1){$px=" order by money1 asc";}
elseif($pxv==2){$px=" order by ymcd asc";}
elseif($pxv==3){$px=" order by lastsj desc";}
elseif($pxv==4){$px=" order by djl desc";}
elseif($pxv==5){$px=" order by zcsj asc";}

$tit=$tit.returnjyfs($jyfs)."域名";

?>
<html>
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$tit?> - <?=webname?></title>
<link href="../css/basic.css" rel="stylesheet" type="text/css" />
<link href="index.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script language="javascript" src="../js/jquery.SuperSlide.2.1.1.js"></script>
<script language="javascript" src="../js/jquery.SuperSlide.2.1.1.source.js"></script>
<script language="javascript" src="../js/basic.js"></script>
<script language="javascript" src="index.js"></script>
</head>
<body>
<? include("../tem/top.html");?>
<? include("../tem/top1.html");?>
<? include("../tem/top2.html");?>

<div class="yjcode">

 <div class="dqwz">
 <ul class="u1">
 <li class="l1"><img src="../img/home.gif" width="21" height="21" /></li>
 <li class="l2">当前位置：<a href="<?=weburl?>">首页</a> > 域名列表 > <?=returnjgdw(returnjyfs($jyfs),"","")?></li>
 </ul>
 </div>
 
 <!--搜索B-->
 <form name="f1" method="post" action="../search/index.php?admin=5">
 <div class="selmain">
 <ul class="u1">
 <li class="l1">域名：</li>
 <li class="l2"><input placeholder="域名或简介" class="inp" type="text" value="<?=$skey?>" style="width:210px;" name="t1" /></li>
 </ul>
 
 <ul class="u2">
 <li class="l1">分类：</li>
 <li class="l2">
 <select name="d1" class="inp">
 <option value="">所有域名</option>
 <? while1("*","yj_domain_fenlei where admin=1 and zt=1 order by xh asc");while($row1=mysql_fetch_array($res1)){?>
 <option value="<?=$row1[id]?>"<? if(strstr($tyidv,"xcf".$row1[id]."xcf")){?> selected<? }?>><?=$row1[name1]?></option>
 <? while2("*","yj_domain_fenlei where admin=2 and zt=1 and name1='".$row1[name1]."' order by xh asc");while($row2=mysql_fetch_array($res2)){?>
 <option value="<?=$row2[id]?>"<? if(strstr($tyidv,"xcf".$row2[id]."xcf")){?> selected<? }?>>&nbsp;&nbsp;&nbsp;&nbsp;<?=$row2[name2]?></option>
 <? }}?>
 </select>
 </li>
 </ul>
 
 <ul class="u3">
 <li class="l1">备案：</li>
 <li class="l2">
 <select name="d2" class="inp">
 <option value="">不限</option>
 <option value="2"<? if($ifba==2){?> selected<? }?>>已备案</option>
 <option value="1"<? if($ifba==1){?> selected<? }?>>未备案</option>
 </select>
 </li>
 </ul>
 
 <ul class="u4">
 <li class="l1">注册商：</li>
 <li class="l2">
 <select name="d3" class="inp">
 <option value="">全部</option>
 </select>  
 </li>
 </ul>
 
 <ul class="u5">
 <li class="l1">价格：</li>
 <li class="l2">
 <input type="text" style="width:50px;" value="<?=$mon1?>" name="t2" class="inp"><span class="fd"> - </span><input type="text" name="t3" value="<?=$mon2?>" style="width:50px;" class="inp">
 </li>
 </ul>
 
 <ul class="u6">
 <li class="l1">排除：</li>
 <li class="l2"><input value="<?=$nolike?>" type="text" class="inp" style="width:210px;" name="t4" /></li>
 </ul>
 
 <ul class="u7">
 <li class="l1">后缀：</li>
 <li class="l2">
 <select name="d4" class="inp">
 <option value="">所有后缀</option>
 <? while1("*","yj_domain_houzhui where zt=1 order by xh asc");while($row1=mysql_fetch_array($res1)){?>
 <option value="<?=$row1[id]?>"<? if($row1[id]==$ymhzid){?> selected<? }?>><?=$row1[name1]?></option>
 <? }?>
 </select>
 </li>
 </ul>
 
 <ul class="u8">
 <li class="l1">排序：</li>
 <li class="l2">
 <select name="d5" class="inp">
 <option value="">不限</option>
 <option value="1"<? if($pxv==1){?> selected<? }?>>域名价格</option>
 <option value="2"<? if($pxv==2){?> selected<? }?>>域名长度</option>
 <option value="3"<? if($pxv==3){?> selected<? }?>>最新上架</option>
 <option value="4"<? if($pxv==4){?> selected<? }?>>浏览热门</option>
 <option value="5"<? if($pxv==5){?> selected<? }?>>注册时间</option>
 </select>
 </li>
 </ul>
 
 <ul class="u9">
 <li class="l1">结束时间：</li>
 <li class="l2">
 <select name="d6" class="inp">
 <option value="">不限</option>
 <option value="1"<? if($jssj==1){?> selected<? }?>>1小时</option>
 <option value="2"<? if($jssj==2){?> selected<? }?>>2小时</option>
 <option value="3"<? if($jssj==3){?> selected<? }?>>3小时</option>
 <option value="6"<? if($jssj==6){?> selected<? }?>>6小时</option>
 <option value="12"<? if($jssj==12){?> selected<? }?>>12小时</option>
 <option value="24"<? if($jssj==24){?> selected<? }?>>1天</option>
 <option value="48"<? if($jssj==48){?> selected<? }?>>2天</option>
 <option value="72"<? if($jssj==72){?> selected<? }?>>3天</option>
 <option value="96"<? if($jssj==96){?> selected<? }?>>4天</option>
 <option value="120"<? if($jssj==120){?> selected<? }?>>5天</option>
 <option value="144"<? if($jssj==144){?> selected<? }?>>6天</option>
 <option value="168"<? if($jssj==168){?> selected<? }?>>7天</option>
 </select>
 </li>
 </ul>
 
 <ul class="u10">
 <li class="l1">长度：</li>
 <li class="l2">
 <input type="text" style="width:50px;" value="<?=$len1?>" name="t5" class="inp"><span class="fd"> - </span><input type="text" name="t6" value="<?=$len2?>" style="width:50px;" class="inp">
 </li>
 </ul>
 
 <ul class="u99">
 <li class="l1">
 <input type="submit" class="inp1" value="搜索" />
 <input type="reset" class="inp2" value="重置" />
 </li>
 </ul>
 
 </div>
 </form>
 <!--搜索E-->

 <!--列表B-->
 <ul class="listcap">
 <li class="l1">域名</li>
 <li class="l2">简介</li>
 <li class="l4">交易类型</li>
 <li class="l5">当前价格</li>
 <li class="l6">剩余时间</li>
 <li class="l7"></li>
 </ul>
 <? 
 $i=1;
 $sjarr=array();
 pagef($ses,40,"yj_domain_pro",$px);while($row=mysql_fetch_array($res)){
 $sjarr[$i-1]=DateDiff(date("Y-m-d H:i:s",$row[yxq]),$sj,"s");
 $au="view".$row[id].".html";
 if($i % 2==0){$ncss=" prolista";}else{$ncss="";}
 $mcss="";
 if($row[jyfs]==1){
  if($row[money1]>=1000){$mcss=" red";}
 }elseif($row[jyfs]==2){
  if($row[money5]>=1000){$mcss=" red";}
 }
 ?>
 <ul class="prolist<?=$ncss?>" onMouseMove="this.className='prolist prolist1<?=$ncss?>'" onMouseOut="this.className='prolist<?=$ncss?>';">
 <li class="l1"><a href="<?=$au?>" target="_blank"><?=$row[tit]?></a></li>
 <li class="l2"><a href="<?=$au?>" title="<?=$row[txt]?>" target="_blank"><?=returntitdian($row[txt],27)?></a></li>
 <li class="l4"><?=returnjyfs($row[jyfs])?></li>
 <li class="l5<?=$mcss?>">￥<?=number_format(returnmoney($row[id]))?></li>
 <li class="l6"><span id="djs<?=$i?>">正在加载</span></li>
 <li class="l7"><a href="<?=$au?>" target="_blank">详情</a></li>
 </ul>
 <? $i++;}?>
 <script language="javascript">
 <? for($i=0;$i<count($sjarr);$i++){?>
 addTimer("djs<?=$i+1?>", <?=$sjarr[$i]?>); 
 <? }?>
 </script>
 <?
 $nowurl="";
 $nowwd="";
 include("../tem/page.php");
 ?>
 <!--列表E-->

</div>

<? include("../tem/bottom.html");?>

</body>
</html>