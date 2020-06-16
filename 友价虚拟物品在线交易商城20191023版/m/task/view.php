<?
include("../../config/conn.php");
include("../../config/function.php");
$id=$_GET[id];
$sj=date("Y-m-d H:i:s");
while0("*","yjcode_task where id=".$id);if(!$row=mysql_fetch_array($res)){php_toheader("./");}
$bh=$row[bh];
taskok($row["id"]);

$sqluser="select * from yjcode_user where id=".$row[userid]."";mysql_query("SET NAMES 'GBK'");$resuser=mysql_query($sqluser);$rowuser=mysql_fetch_array($resuser);
$userid=0;
$xgnum=0;
$userbaomoney=0;
if(!empty($_SESSION[SHOPUSER])){
$sqluserM="select * from yjcode_user where uid='".$_SESSION[SHOPUSER]."'";mysql_query("SET NAMES 'GBK'");$resuserM=mysql_query($sqluserM);$rowuserM=mysql_fetch_array($resuserM);
$userid=$rowuserM[id];
$userbaomoney=$rowuserM[baomoney];
$taskjs=1;
if(strstr($rowcontrol[taskjs],"xcf1xcf")){if($rowuserM[ifmot]!=1){$taskjs=0;}}
if(strstr($rowcontrol[taskjs],"xcf2xcf")){if($rowuserM[ifemail]!=1){$taskjs=0;}}
if(strstr($rowcontrol[taskjs],"xcf3xcf")){if($rowuserM[sfzrz]!=1){$taskjs=0;}}
if(strstr($rowcontrol[taskjs],"xcf4xcf")){if($rowuserM[shopzt]!=2){$taskjs=0;}}
while1("*","yjcode_taskhf where bh='".$bh."' and useridhf=".$userid."");if($row1=mysql_fetch_array($res1)){$xgnum=$row1[xgnum];$mybh=$row1[mybh];$myid=$row1[id];$mymoney=$row1[money1];$mytxt=$row1[txt];}
}

if($_GET[control]=="add"){ //单人任务
 if(empty($_SESSION[SHOPUSER])){Audit_alert("请先登录！","../reg/");}
 if(empty($taskjs)){Audit_alert("不满足接任务的条件！","view".$id.".html");}
 $userid=returnuserid($_SESSION[SHOPUSER]);
 if(0!=$row[zt]){Audit_alert("该任务停止接收报价！","view".$id.".html");}
 if($xgnum>1){Audit_alert("您已经修改过该任务的报价，不能再修改！","view".$id.".html");}
 $sj=date("Y-m-d H:i:s");
 $uip=$_SERVER["REMOTE_ADDR"];
 if($userid==$row[userid]){Audit_alert("无法给自己的任务提交报价！","view".$id.".html");}
 $money1=sqlzhuru($_POST[t1]);
 if(!is_numeric($money1)){Audit_alert("报价无效。","view".$id.".html");}
 if($money1<=0){Audit_alert("报价无效。","view".$id.".html");exit;}
 $txt=sqlzhuru($_POST[s1]);
 if(panduan("*","yjcode_taskhf where bh='".$row[bh]."' and useridhf=".$userid."")==0){
  if(!empty($row[jsbao])){
   if($row[jsbao]>$userbaomoney){Audit_alert("您的保证金不足，请先缴纳（如已缴纳，请刷新页面重新提交）","view".$id.".html");}
   PointIntoB($userid,"接手任务，冻结保证金(任务验收不通过，将赔给雇主)",$row[jsbao]*(-1),2);
   PointUpdateB($userid,$row[jsbao]*(-1)); 
  }
 $mybh=time()."t".$userid;
 intotable("yjcode_taskhf","mybh,bh,uip,userid,useridhf,sj,txt,money1,ifxz,xgnum,taskty","'".$mybh."','".$row[bh]."','".$uip."',".$row[userid].",".$userid.",'".$sj."','".$txt."',".$money1.",0,1,0");
 }else{
 updatetable("yjcode_taskhf","money1=".$money1.",txt='".$txt."',xgnum=xgnum+1 where bh='".$row[bh]."' and useridhf=".$userid."");
 }
 
 if(!empty($rowuser[email]) && $rowuser[ifemail]==1 && $row[yjtx]==1){
 require("../../config/mailphp/sendmail.php");
 $str="有人给出报价了，请尽快处理。<br>任务：".$row[tit]."<br>报价：<font color='red' style='font-size:18px;'>".$money1."</font><br>【".webname."】<hr>该邮件为系统发出，请勿回复";
 @yjsendmail("任务接手提醒【".webname."】",$rowuser[email],$str,"../");
 }

 php_toheader("../tishi/index.php?admin=6&lx=1&id=".$id);

}elseif($_GET[control]=="add1"){ //多人任务
 if(empty($_SESSION[SHOPUSER])){Audit_alert("请先登录！","../reg/");}
 if(empty($taskjs)){Audit_alert("不满足接任务的条件！","view".$id.".html");}
 $userid=returnuserid($_SESSION[SHOPUSER]);
 if(101!=$row[zt]){Audit_alert("该任务停止报名参与！","view".$id.".html");}
 if($row[taskcy]>=$row[tasknum]){Audit_alert("该任务被抢光啦！","view".$id.".html");}
 $sj=date("Y-m-d H:i:s");
 $uip=$_SERVER["REMOTE_ADDR"];
 if($userid==$row[userid]){Audit_alert("不能接手自己的任务！","view".$id.".html");}
 if(panduan("*","yjcode_taskhf where bh='".$row[bh]."' and useridhf=".$userid." and (zt=0 or zt=1 or zt=3 or zt=4)")==1){Audit_alert("你有任务未完成，不能再次接单！","view".$id.".html");}
 $txt=sqlzhuru($_POST[s1]);
 $mybh=returnbh();
 $money1=$row[money1]/$row[tasknum];
 $rwdq=date("Y-m-d H:i:s",strtotime("+".$row[rwzq]." day"));
 if(!empty($row[jsbao])){
  if($row[jsbao]>$userbaomoney){Audit_alert("您的保证金不足，请先缴纳（如已缴纳，请刷新页面重新提交）","view".$id.".html");}
  PointIntoB($userid,"接手任务，冻结保证金(任务验收不通过，将赔给雇主)",$row[jsbao]*(-1),2);
  PointUpdateB($userid,$row[jsbao]*(-1)); 
 }
 intotable("yjcode_taskhf","mybh,bh,uip,userid,useridhf,sj,txt,money1,ifxz,xgnum,taskty,zt,zbsj,rwdq","'".$mybh."','".$row[bh]."','".$uip."',".$row[userid].",".$userid.",'".$sj."','".$txt."',".$money1.",0,1,1,0,'".$sj."','".$rwdq."'");
 $uf=$row[useridhf]."yj".$userid."yj";
 updatetable("yjcode_task","useridhf='".$uf."' where id=".$id);
 $txt="接手成功，开始做任务，须在".$rwdq."前完成任务，并提交验收";
 intotable("yjcode_tasklog","bh,userid,useridhf,admin,txt,sj,fj","'".$bh."',".$row[userid].",".$userid.",2,'".$txt."','".$sj."',''");
 
 if(!empty($rowuser[email]) && $rowuser[ifemail]==1 && $row[yjtx]==1){
 require("../../config/mailphp/sendmail.php");
 $str="有人接手了你的任务，请关注任务进度。<br>任务：".$row[tit]."<br>【".webname."】<hr>该邮件为系统发出，请勿回复";
 @yjsendmail("任务接手提醒【".webname."】",$rowuser[email],$str,"../");
 }

 php_toheader("../tishi/index.php?admin=6&lx=2&id=".$id);
}

?>
<html>
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
<meta name="keywords" content="<?=$row[wkey]?>">
<meta name="description" content="<?=$row[wdes]?>">
<title><?=$row[tit]?> - <?=webname?></title>
<? include("../tem/cssjs.html");?>
<script language="javascript">
function tj(){
t1v=parseFloat(document.f1.t1.value);
if(isNaN(t1v)){layerts("请输入有效的报价");return false;}
<? if(!empty($row[jsbao])){?>
if(<?=$row[jsbao]?>><?=$userbaomoney?>){layerts("您的保证金不足，请先缴纳（如已缴纳，请刷新页面重新提交）");return false;}
<? }?>
if(!confirm("确定要提交吗？")){return false;}
layer.open({type: 2,content: '正在提交',shadeClose:false});
f1.action="view.php?control=add&id=<?=$id?>";
}
function tbxg(){
document.getElementById("tbedit").style.display="none";
document.getElementById("baojia").style.display="";
}
function tj1(){
<? if(!empty($row[jsbao])){?>
if(<?=$row[jsbao]?>><?=$userbaomoney?>){layerts("您的保证金不足，请先缴纳（如已缴纳，请刷新页面重新提交）");return false;}
<? }?>
if(!confirm("确定要接手该任务吗？")){return false;}
layer.open({type: 2,content: '正在提交',shadeClose:false});
f1.action="view.php?control=add1&id=<?=$id?>";
}
</script>
</head>
<body>
<? $nowpagetit="任务详情";$nowpagebk="./";include("../tem/moban/".$rowcontrol[wapmb]."/tem/top.php");?>

<div class="infmain box">
<div class="dmain flex">
  <div class="d1"><?=$row[tit]?></div>
  <div class="d2">
   <ul class="ujg">
   <li class="l1"><?=returntaskjgxs($row[jgxs])?></li>
   <li class="l2">
   ￥<strong><?=returntaskjg($row[jgxs],$row[money1],$row[money2])?> </strong>
   <span><? if($row[taskty]==1){echo "(需要".$row[tasknum]."人，单人佣金".$row[money1]/$row[tasknum]."元)";}?></span>
   </li>
   <li class="l4">本次任务需要支付手续费：<span class="s1"><?=$rowcontrol[taskyj]*100?>%</span> (<? if(empty($row[yjfs])){echo "雇主支付";}elseif($row[yjfs]==1){echo "接手方支付";}else{echo "双方各承担50%";}?>)</li>
   </ul>
  </div>
  <?
  $yxq=strtotime($row[yxq]);
  $nsj=strtotime($sj);
  if(0==$row[zt] || 1==$row[zt] || 2==$row[zt] || 100==$row[zt] || 101==$row[zt] || 105==$row[zt] || 106==$row[zt]){
  ?>
  <div class="tasjdjs">
  <? 
  if($yxq>=$nsj){$dqsj=str_replace("-","/",$row[yxq]);
  ?>
  任务接手倒计时：
  <span id="nowsj" style="display:none;"><?=str_replace("-","/",date("Y-m-d H:i:s"))?></span>
  <span id="dqsj" style="display:none;"><?=$dqsj?></span>
  <span class="djs" id="djs">正在加载</span>
  <script language="javascript">userChecksj();</script>
  <? }else{?>
  已结束
  <? }?>
  </div>
  <? }?>
</div>
</div>

<div class="infcap box">
 <div class="d1"></div>
 <div class="d2">基本信息</div>
 <div class="d3 flex"></div>
</div>
<div class="inftxt box">
 <div class="dmain flex">
 任务状态：<strong><? $bmnum=returncount("yjcode_taskhf where bh='".$row[bh]."'");?>
 <? if(0==$row[zt] && $bmnum==0){echo "等待接手";?>
 <? }elseif(0==$row[zt] && $bmnum>0){echo "雇主选标";?>
 <? }elseif(1==$row[zt] || 105==$row[zt]){echo "正在审核";?>
 <? }elseif(2==$row[zt] || 106==$row[zt]){echo "任务关闭";?>
 <? }elseif(3==$row[zt]){echo "接手方做任务";?>
 <? }elseif(4==$row[zt]){echo "等待雇主验收";?>
 <? }elseif(5==$row[zt]){echo "交易完成";?>
 <? }elseif(8==$row[zt]){echo "平台处理纠纷";?>
 <? }elseif(9==$row[zt]){echo "判定雇主胜诉";?>
 <? }elseif(10==$row[zt] || 104==$row[zt]){echo "任务到期";?>
 <? }elseif(100==$row[zt]){echo "等待缴纳费用";?>
 <? }elseif(101==$row[zt]){echo "任务进行中";?>
 <? }elseif(102==$row[zt]){echo "平台处理纠纷";?>
 <? }?></strong>
 <br>
 任务编号：<?=$row[bh]?><br>
 任务形式：<?=returntaskxs($row[taskty])?><br>
 更新时间：<?=dateYMD($row[sj])?><br>
 任务周期：<?=$row[rwzq]?>天
 </div>
</div>

<?
$sqlsell="select * from yjcode_user where id=".$row[userid];mysql_query("SET NAMES 'GBK'");$ressell=mysql_query($sqlsell);
if(!$rowsell=mysql_fetch_array($ressell)){php_toheader("../");}
?>
<div class="inf4 box">
 <div class="d1"><img src="<?="../../upload/".$rowsell[id]."/user.jpg";?>" /></div>
 <div class="d2">
  <span class="sling"><?=$rowsell[nc]?></span>
  <?
  if($row[qqxs]==1){$qqxsvalue="投标服务商可查看QQ";}elseif($row[qqxs]==2){$qqxsvalue="中标服务商可查看QQ";}elseif(empty($row[qqxs])){$qqxsvalue="登录后查看QQ";}
  if($row[motxs]==1){$motxsvalue="投标服务商可查看电话";}elseif($row[motxs]==2){$motxsvalue="中标服务商可查看电话";}elseif(empty($row[motxs])){$motxsvalue="登录后查看电话";}
  if(empty($row[qqxs]) && !empty($_SESSION[SHOPUSER])){$qqxs=1;}
  elseif(1==$row[qqxs] && returncount("yjcode_taskhf where bh='".$row[bh]."' and useridhf=".$userid."")>0){$qqxs=1;}
  elseif(2==$row[qqxs] && returncount("yjcode_taskhf where bh='".$row[bh]."' and ifxz=1 and useridhf=".$userid."")>0){$qqxs=1;}
  elseif($userid==$row[userid]){$qqxs=1;}
  else{$qqxs=0;}
  if(empty($row[motxs]) && !empty($_SESSION[SHOPUSER])){$motxs=1;}
  elseif(1==$row[motxs] && returncount("yjcode_taskhf where bh='".$row[bh]."' and useridhf=".$userid."")>0){$motxs=1;}
  elseif(2==$row[motxs] && returncount("yjcode_taskhf where bh='".$row[bh]."' and ifxz=1 and useridhf=".$userid."")>0){$motxs=1;}
  elseif($userid==$row[userid]){$motxs=1;}
  else{$motxs=0;}
  ?>
  <? if(1==$qqxs){?>
  <span class="s1 s0">QQ：<a href="javascript:void(0);" onClick="qqtang('<?=$rowuser[uqq]?>')"><?=$rowuser[uqq]?></a></span>
  <? }else{?>
  <span class="s1"><?=$qqxsvalue?></span>
  <? }?>
  <? if($motxs==1){?>
  <span class="s1 s0">手机：<?=$rowuser[mot]?></span>
  <? }else{?>
  <span class="s1"><?=$motxsvalue?></span>
  <? }?>
 </div>
</div>

<div class="infcap box">
 <div class="d1"></div>
 <div class="d2">任务详情</div>
 <div class="d3 flex"></div>
</div>
<div class="inftxt box">
 <div class="dmain flex">
 <?=$row[txt]?><br><? $fj="../../upload/".$row[userid]."/".$row[bh]."/".$row[fj];if(is_file($fj)){?><a href="<?=$fj?>" class="downfj" target="_blank">下载附件</a><? }?>
 </div>
</div>

<div class="dtaskjs box">
<div class="dmain flex">
  <!--单人任务开始-->
  <? if(empty($row[taskty])){?>
  <div class="baojia" id="baojia"<? if(empty($userid) || (!empty($userid)) && $userid!=$row[userid] && $xgnum==0){?><? }else{?> style="display:none;"<? }?>>
   <form name="f1" method="post" onSubmit="return tj()">
   <ul class="u1">
   <li class="l1">任务报价：</li>
   <li class="l2"><input type="text" name="t1" value="<?=$mymoney?>" /> <span class="fd">元（雇主的预算为：<?=returntaskjg($row[jgxs],$row[money1],$row[money2])?>元)</span></li>
   <li class="l3">报价说明：</li>
   <li class="l4"><textarea name="s1"><?=$mytxt?></textarea></li>
   <? if(!empty($userid)){?>
   <li class="l6">接手该任务需要冻结您的保证金<strong class="red" style="font-size:20px;"><?=$row[jsbao]?></strong>元，您当前可用保证金为：<strong class="blue" style="font-size:20px;"><?=$userbaomoney?></strong>元 [<a href="../user/baomoney1.php" class="red">缴纳保证金</a>]</li>
   <? }?>
   <li class="l5">
   <? if(!empty($userid)){?>
    <? if($taskjs==1){?><input type="submit" value="提交报价" /><? }else{include("taskjs.php");}?>
   <? }else{?>
   <input class="inp1" type="button" value="请先登录" onClick="gourl('../reg/')" />
   <? }?>
   </li>
   </ul>
   </form>
  </div>
 
  <? if(!empty($userid) && $userid!=$row[userid] && $xgnum==1){?>
  <div class="jisuan" id="tbedit">
  您的投标号：<?=$mybh?>，【<a href="#tb<?=$myid?>" class="blue">查看</a>】&nbsp;&nbsp;【<a href="javascript:void(0);" onClick="tbxg()" class="blue">修改</a>】
  </div>
  <? }?>
 
  <? if($userid==$row[userid]){$cy=returncount("yjcode_taskhf where bh='".$row[bh]."'");?>
  <? if($cy==0){?>
  <div class="jisuan">
  <strong>雇主您好，暂时没有人给出报价，请继续关注</strong><br>
  </div>
  <? }else{?>
  <div class="jisuan">
  <strong>雇主您好，当前共有<?=$cy;?>人参与了任务：</strong><br>
  <?
  $zh=returnsum("money1","yjcode_taskhf where bh='".$row[bh]."'");
  while1("*","yjcode_taskhf where bh='".$bh."' order by money1 desc");$row1=mysql_fetch_array($res1);$moneyg=$row1[money1];
  while1("*","yjcode_taskhf where bh='".$bh."' order by money1 asc");$row1=mysql_fetch_array($res1);$moneyd=$row1[money1];
  ?>
  均报价：<span class="feng"><?=sprintf("%.2f",$zh/$cy)?></span>元，最高报价：<span class="red"><?=$moneyg?></span>元，最低报价<span class="green"><?=$moneyd?></span>元。
  </div>
  <? }?>
  <? }?>
  <? }?>
  <!--单人任务结束-->
 
  <!--多人任务开始-->
  <? if($row[taskty]==1 && $userid!=$row[userid] && panduan("*","yjcode_taskhf where bh='".$row[bh]."' and useridhf=".$userid." and (zt=0 or zt=1 or zt=3 or zt=4)")==0){?>
  <div class="baojia">
   <form name="f1" method="post" onSubmit="return tj1()">
   <ul class="u1">
   <li class="l3">接手说明：</li>
   <li class="l4"><textarea name="s1">我已接单，会按要求尽快完工^_^</textarea></li>
   <? if(!empty($userid)){?>
   <li class="l6">接手该任务需要冻结您的保证金<strong class="red" style="font-size:20px;"><?=$row[jsbao]?></strong>元，您当前可用保证金为：<strong class="blue" style="font-size:20px;"><?=$userbaomoney?></strong>元 [<a href="../user/baomoney1.php" class="red">缴纳保证金</a>]</li>
   <? }?>
   <li class="l5">
   <? if(!empty($userid)){?>
    <? if($taskjs==1){?><input type="submit" value="接单" /><? }else{include("taskjs.php");}?>
   <? }else{?>
   <input class="inp1" type="button" value="请先登录" onClick="tclogin()" />
   <? }?>
   </li>
   </ul>
   </form>
  </div>
  <? }?>
  <!--多人任务结束-->
</div>
</div>

<div class="taskhfm box">
<div class="dmain flex">
  <?
  while1("*","yjcode_taskhf where bh='".$bh."' order by sj desc");while($row1=mysql_fetch_array($res1)){
  while2("*","yjcode_user where id=".$row1[useridhf]);$row2=mysql_fetch_array($res2);
  ?>
  <a name="tb<?=$row1[id]?>"></a>
  <div class="taskhf">
   <ul class="u1">
   <li class="l1"><img src="<?=returntppd("../../upload/".$row1[useridhf]."/user.jpg","../../img/none60x60.gif")?>" width="60" height="60" /></li>
   <li class="l2">
   <strong><?=$row2[nc]?></strong><br>
   联系QQ：<? if($userid==$row[userid]){?><a href="javascript:void(0);" onClick="qqtang('<?=$row2[uqq]?>')"><?=$row2[uqq]?></a><? }else{?>雇主可见<? }?>
   </li>
   <li class="l3">
   <? if($userid==$row[userid] && 0==$row[zt]){?><a href="../user/taskbjsel.php?bh=<?=$row[bh]?>&mid=<?=$row1[id]?>" class="xz">选此<br>投标</a><? }?>
   <? if($row[useridhf]==$row2[id]){?><img src="img/suc.gif" class="zb" /><? }?>
   </li>
   </ul>
   <div class="hftxt">任务报价：<strong class="feng"><? if($userid==$row[userid]){?>￥<?=$row1[money1]?><? }else{?>雇主可见<? }?></strong><br><?=$row1[txt]?><br><br><span class="hui">投标编号：<?=$row1[mybh]?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;参与时间：<?=$row1[sj]?></span></div>
  </div>
  <?
  }
  ?>
</div>
</div>

</body>
</html>