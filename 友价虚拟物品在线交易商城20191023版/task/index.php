<?
include("../config/conn.php");
include("../config/function.php");
//已用标签a b j k p
$ses=" where (zt=0 or zt=3 or zt=4 or zt=5 or zt=101 or zt=102)";
$taskty=returnsx("a");if($taskty!=-1){$ses=$ses." and taskty=".$taskty;}
$taskzt=returnsx("b");if($taskzt==-1){$ses=$ses." and (zt=0 or zt=3 or zt=4 or zt=101)";}else{$ses=$ses." and (zt=5 or zt=102)";}
$ty1id=returnsx("j");if($ty1id!=-1){$ses=$ses." and type1id=".$ty1id;$ty1name=returntasktype(1,$ty1id);}
$ty2id=returnsx("k");if($ty2id!=-1){$ses=$ses." and type2id=".$ty2id;$ty2name=returntasktype(2,$ty2id);}

if(returnsx("p")!=-1){$page=returnsx("p");}else{$page=1;}
?>
<html>
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>任务大厅 - <?=webname?></title>
<? include("../tem/cssjs.html");?>
</head>
<body>
<? include("../tem/top.html");?>
<? include("../tem/top1.html");?>
<div class="yjcode">
 <div class="dqwz">
 <ul class="u1">
 <li class="l1">当前位置：<a href="<?=weburl?>">首页</a> > 任务大厅</li></ul>
 </div>
</div>

<div class="bfb bfbtask fontyh">
<div class="yjcode">
 
 <!--会员B-->
 <div class="hy">
  <? 
  if(!empty($_SESSION[SHOPUSER])){$usertx="../upload/".returnuserid($_SESSION[SHOPUSER])."/user.jpg";if(!is_file($usertx)){$usertx="../user/img/nonetx.gif";}
  $sqluser="select * from yjcode_user where uid='".$_SESSION[SHOPUSER]."'";mysql_query("SET NAMES 'GBK'");$resuser=mysql_query($sqluser);
  if(!$rowuser=mysql_fetch_array($resuser)){php_toheader("../reg/");}
  ?>
  <div class="d1">
  <ul class="u1">
  <li class="l1"><a href="../user/"><img border="0" src="<?=$usertx?>" width="70" height="70" /></a></li>
  <li class="l2">
  <span class="s1">
  欢迎您：<?=$_SESSION[SHOPUSER]?><br>
  <a href="../user/mobbd.php"><? if(1==$rowuser[ifmot]){?><img src="../user/img/sj1.gif"  /><span>手机已认证</span><? }else{?><img src="../user/img/sj0.gif" /><span>手机未认证</span><? }?></a>
  <a href="../user/emailbd.php"><? if(1==$rowuser[ifemail]){?><img src="../user/img/yx1.gif" /><span>邮箱已认证</span><? }else{?><img src="../user/img/yx0.gif" /><span>邮箱未认证</span><? }?></a>

  </span>
  <a href="../user/pay.php" class="a1">充值</a>
  <a href="../user/tixian.php" class="a2">提现</a>
  </li>
  </ul>
  <ul class="u2">
  <li class="l1 l2"><strong class="s1">帐户余额</strong><strong class="s2 red"><?=sprintf("%.2f",$rowuser[money1])?></strong></li>
  <li class="l1"><strong class="s1">发起任务</strong><strong class="s2 green"><?=returncount("yjcode_task where userid=".$rowuser[id]."")?></strong></li>
  <li class="l1"><strong class="s1">接手任务</strong><strong class="s2 blue"><?=returncount("yjcode_task where useridhf=".$rowuser[id]." and taskty=0")+returncount("yjcode_taskhf where useridhf=".$rowuser[id]." and taskty=1")?></strong></li>
  <li class="l1 l0"><strong class="s1">交易成功</strong><strong class="s2"><?=returncount("yjcode_task where userid=".$rowuser[id]." and (zt=5 or zt=102)")+returncount("yjcode_task where useridhf=".$rowuser[id]." and taskty=0 and zt=5")+returncount("yjcode_taskhf where useridhf=".$rowuser[id]." and taskty=1 and zt=2")?></strong></li>
  </ul>
  </div>
  <? }else{?>
  <div class="d0">
  <a href="javascript:void(0);" onClick="tclogin()" class="a1">快速登录</a>
  <a href="../reg/reg.php" target="_blank" class="a2">免费注册</a>
  </div>
  <? }?>
  
  <div class="d2">
  <ul class="u1">
  <li class="cap">网站公告</li>
  <li class="mo"><a href="../help/gglist.html" target="_blank">更多>></a></li>
  <? while0("*","yjcode_gg where zt=0 order by sj desc limit 5");while($row=mysql_fetch_array($res)){?>
  <li class="l1">·<a href="../help/ggview<?=$row[id]?>.html" title="<?=$row[tit]?>" target="_blank"><?=strgb2312($row[tit],0,36)?></a></li>
  <li class="l2">[<?=dateMD($row[sj])?>]</li>
  <? }?>
  </ul>
  </div>
  
  <div class="d3"><? adread("ADTASK02","375","164")?></div>
  
 </div>
 <!--会员E-->
 
 <div class="tasklist">
 
 <div class="tasksel">
 <ul class="listcap">
 <li class="l1">任务类型：</li>
 <li class="l2">
 <a href="<?=rentser('j','','k','')?>"<? if(returnsx("j")==-1){?> class="g_bg1"<? }else{?> class="g_ac0"<? }?>>全部</a>
 <? while1("*","yjcode_tasktype where admin=1 order by xh asc");while($row1=mysql_fetch_array($res1)){?>
 <a href="<?=rentser('j',$row1[id],'k','')?>"<? if(returnsx("j")==$row1[id]){?> class="g_bg1"<? }else{?> class="g_ac0"<? }?>><?=$row1[name1]?></a>
 <? }?>
 </li>
 </ul>
 <? if($ty1id!=-1){?>
 <ul class="listcap">
 <li class="l1"><?=$ty1name?>：</li>
 <li class="l2">
 <a href="<?=rentser('k','','','')?>"<? if(returnsx("k")==-1){?> class="g_bg1"<? }else{?> class="g_ac0"<? }?>>全部</a>
 <? while1("*","yjcode_tasktype where admin=2 and name1='".$ty1name."' order by xh asc");while($row1=mysql_fetch_array($res1)){?>
 <a href="<?=rentser('k',$row1[id],'p','1')?>"<? if(returnsx("k")==$row1[id]){?> class="g_bg1"<? }else{?> class="g_ac0"<? }?>><?=$row1[name2]?></a>
 <? }?>
 </li>
 </ul>
 <? }?>
 <ul class="listcap listcap0">
 <li class="l1">任务形式：</li>
 <li class="l2">
 <a href="<?=rentser('a','','','')?>"<? if(returnsx("a")==-1){?> class="g_bg1"<? }else{?> class="g_ac0"<? }?>>全部</a>
 <a href="<?=rentser('a','0','','')?>"<? if(returnsx("a")==0){?> class="g_bg1"<? }else{?> class="g_ac0"<? }?>>单人任务</a>
 <a href="<?=rentser('a','1','','')?>"<? if(returnsx("a")==1){?> class="g_bg1"<? }else{?> class="g_ac0"<? }?>>多人任务</a>
 </li>
 </ul>
 </div>
 
 <ul class="rwcap g_bc0_h">
 <li class="<? if($taskzt==-1){?>l11 g_bg1<? }else{?>l1<? }?>"><a href="./">进行中</a></li>
 <li class="<? if($taskzt==1){?>l11 g_bg1<? }else{?>l1<? }?>"><a href="search_b1v.html">成功案例</a></li>
 <li class="l2"><a href="taskadd.php" class="a1">发布任务</a><a href="./" class="a2">刷新任务</a></li>
 </ul>
 
 <ul class="rwbt">
 <li class="l1">任务标题</li>
 <li class="l2">托管金额</li>
 <li class="l3">任务形式</li>
 <li class="l4">剩余数量</li>
 <li class="l5">总预算</li>
 <li class="l6">任务进度</li>
 <li class="l7">操作</li>
 </ul>
 
 <?
 pagef($ses,30,"yjcode_task","order by sj desc");while($row=mysql_fetch_array($res)){
 taskok($row[id]);
 ?>
 <ul class="ulist fontyh">
 <li class="l1">
 <a href="view<?=$row[id]?>.html" title="<?=$row[tit]?>" target="_blank" class="g_ac2"><?=returntitdian($row[tit],50)?></a><br>
 <span class="hui"><?=strgb2312(strip_tags($row[txt]),0,60)?></span>
 </li>
 <li class="l2"><? if($row[money3]>0){?><span class="s1">已托管金额</span><? }else{?><span class="s2">选标后托管</span><? }?></li>
 <li class="l3"><?=returntaskxs($row[taskty])?></li>
 <?
 if(empty($row[taskty])){
 ?>
 <li class="l4">
 <? if(empty($row[zt])){?><strong>1</strong>份<? }else{?><strong>0</strong>份<? }?>
 </li>
 <? }else{?>
 <li class="l41">
 <span class="s1"><strong><?=$row[tasknum]-$row[taskcy]?></strong>份(共<?=$row[tasknum]?>份)</span>
 <span class="s2"></span>
 <span class="s3" style="width:<? $okbfb=$row[taskcy]/$row[tasknum];echo 100*(1-$okbfb);?>px;"></span>
 <span class="s4"><?=sprintf("%.2f",(1-$okbfb)*100)?>%</span>
 </li>
 <? }?>
 <li class="l5"><strong><?=$row[money1]?></strong>元</li>
 <li class="l6"><?=returntask($row[zt])?></li>
 <li class="l7">
 <?
 if((empty($row[taskty]) && 0==$row[zt]) || (1==$row[taskty] && 101==$row[zt])){
 ?>
 <a href="view<?=$row[id]?>.html" class="a1" target="_blank">抢此任务</a>
 <?
 }else{
 ?>
 <a href="view<?=$row[id]?>.html" class="a2" target="_blank">查看任务</a>
 <? }?>
 </li>
 </ul>
 <? }?>
 <div class="npa">
 <?
 $nowurl="search";
 $nowwd="";
 require("../tem/page.html");
 ?>
 </div>
 </div>
 
</div>
</div>
<? include("../tem/bottom.html");?>
</body>
</html>