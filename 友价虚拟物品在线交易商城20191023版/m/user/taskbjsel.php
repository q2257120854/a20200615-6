<?
include("../../config/conn.php");
include("../../config/function.php");
sesCheck_m();
$bh=$_GET[bh];
$mid=$_GET[mid];
$sj=date("Y-m-d H:i:s");
$sqluser="select * from yjcode_user where uid='".$_SESSION[SHOPUSER]."'";mysql_query("SET NAMES 'GBK'");$resuser=mysql_query($sqluser);
if(!$rowuser=mysql_fetch_array($resuser)){php_toheader("../reg/");}
$userid=$rowuser[id];

$sqltask="select * from yjcode_task where bh='".$bh."' and taskty=0 and userid=".$userid."";mysql_query("SET NAMES 'GBK'");$restask=mysql_query($sqltask);
if(!$rowtask=mysql_fetch_array($restask)){php_toheader("tasklist.php");}

$sqltaskhf="select * from yjcode_taskhf where bh='".$bh."' and userid=".$userid." and id=".$mid;mysql_query("SET NAMES 'GBK'");$restaskhf=mysql_query($sqltaskhf);
if(!$rowtaskhf=mysql_fetch_array($restaskhf)){php_toheader("taskbjlist.php?bh=".$bh);}

if($_GET[control]=="hz"){
 if(0!=$row[zt]){Audit_alert("操作失败，返回重试","taskbjsel.php?bh=".$bh."&mid=".$mid);}
 $money5=0;
 if(empty($rowtask[yjfs])){$money5=$rowtaskhf[money1]*$rowcontrol[taskyj];}
 elseif($rowtask[yjfs]==2){$money5=$rowtaskhf[money1]*$rowcontrol[taskyj]*0.5;}
 $djmoney=$rowtaskhf[money1]-$rowtask[money4]+$money5;
 if($djmoney>$rowuser[money1]){Audit_alert("余额不足，请先充值","taskbjsel.php?bh=".$bh."&mid=".$mid);}
 PointIntoM($rowuser[id],"任务开始，冻结金额(任务编号".$bh.")",$djmoney*(-1));
 PointUpdateM($rowuser[id],$djmoney*(-1));
 $money3=$rowtaskhf[money1]+$money5;
 updatetable("yjcode_task","zt=3,useridhf=".$rowtaskhf[useridhf].",money2=".$rowtaskhf[money1].",money3=".$money3.",money5=".$money5." where id=".$rowtask[id]);
 $rwdq=date("Y-m-d H:i:s",strtotime("+".$rowtask[rwzq]." day"));
 updatetable("yjcode_taskhf","ifxz=1,zbsj='".$sj."',rwdq='".$rwdq."' where id=".$mid);
 $txt="已选标，接手方开始做任务，并且需要在".$rwdq."前完成任务并提交验收";
 intotable("yjcode_tasklog","bh,userid,useridhf,admin,txt,sj,fj","'".$bh."',".$rowtask[userid].",".$rowtaskhf[useridhf].",1,'".$txt."','".$sj."',''");
 if(!empty($rowtask[jsbao])){
  while1("bh,useridhf,ifxz","yjcode_taskhf where bh='".$rowtask[bh]."' and ifxz=0");while($row1=mysql_fetch_array($res1)){
   PointIntoB($row1[useridhf],"任务未中标，退还保证金",$rowtask[jsbao],2);
   PointUpdateB($row1[useridhf],$rowtask[jsbao]); 
  }
 }
 php_toheader("taskbjlist.php?bh=".$bh);
 
}
?>
<html>
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
<title>会员中心 <?=webname?></title>
<? include("../tem/cssjs.html");?>
<link href="css/task.css" rel="stylesheet" type="text/css" />
<script language="javascript">
function tj(){
if(!confirm("确定选择该用户使用吗？")){return false;}
layer.open({type: 2,content: '正在提交',shadeClose:false});
f1.action="taskbjsel.php?bh=<?=$bh?>&mid=<?=$mid?>&control=hz";
}
</script>
</head>
<body>
<? include("topuser.php");?>
<div class="bfbtop1 box">
 <div class="d1" onClick="gourl('../task/view<?=$rowtask[id]?>.html')"><img src="img/topleft.png" height="21" /></div>
 <div class="d2">选择用户</div>
 <div class="d3"></div>
</div>

<? include("taskv.php");?>

<? while2("*","yjcode_user where id=".$rowtaskhf[useridhf]);$row2=mysql_fetch_array($res2);?>
<div class="taskmain1 box"><div class="d1"></div><div class="d2">用户信息</div></div>
<div class="taskmain2 box"><div class="d1">选择用户：</div><div class="d2"><?=$row2[nc]?></div></div>
<div class="taskmain2 box"><div class="d1">联系QQ：</div><div class="d2"><a href="javascript:void(0);" onClick="qqtang('<?=$row2[uqq]?>')"><?=$row2[uqq]?></a></div></div>
<? if(!empty($row2[mot])){?>
<div class="taskmain2 box"><div class="d1">联系电话：</div><div class="d2"><?=$row2[mot]?></div></div>
<? }?>
<div class="taskmain2 box"><div class="d1">用户报价：</div><div class="d2"><strong class="red">￥<?=$rowtaskhf[money1]?></strong></div></div>
<div class="taskmain2 box">
 <div class="d1">中介费用：</div>
 <div class="d2">
 <? 
 if(empty($rowtask[yjfs])){echo "雇主承担，费用为<strong class='feng'>￥".$rowtaskhf[money1]*$rowcontrol[taskyj]."</strong>";}
 elseif($rowtask[yjfs]==1){echo "接手方承担";}
 elseif($rowtask[yjfs]==2){echo "双方各承担一半，费用为<strong class='feng'>￥".$rowtaskhf[money1]*$rowcontrol[taskyj]*0.5."</strong>";}
 ?>
 </div>
</div>
<div class="taskmain2 box"><div class="d1">报名时间：</div><div class="d2"><?=$rowtaskhf[sj]?></div></div>
<div class="taskmain2 box"><div class="d1">我的余额：</div><div class="d2"><strong class="red">￥<?=$rowuser[money1]?></strong> [<a href="pay.php">充值</a>]</div></div>
<div class="taskmain2 box"><div class="d1">接手留言：</div><div class="d2"><?=strip_tags(returnjgdw($rowtaskhf[txt],"","未填写任何说明"))?></div></div>
<div class="taskmain2 box"><div class="d1">合作须知：</div><div class="d2">选择合作后，需要冻结报价金额(减去订金)</div></div>
<div class="taskmain3 box"></div>


<? if(0==$rowtask[zt]){?>
<form name="f1" method="post" onsubmit="return tj()">
<div class="fbbtn box">
 <div class="d1"><? tjbtnr_m("选择合作")?></div>
</div>
</form>
<? }?>

</body>
</html>