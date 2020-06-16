<?
include("../../config/conn.php");
include("../../config/function.php");
sesCheck_m();

$bh=$_GET[bh];
$sj=date("Y-m-d H:i:s");
$sqluser="select * from yjcode_user where uid='".$_SESSION[SHOPUSER]."'";mysql_query("SET NAMES 'GBK'");$resuser=mysql_query($sqluser);
if(!$rowuser=mysql_fetch_array($resuser)){php_toheader("../reg/");}
$userid=$rowuser[id];

$sqltask="select * from yjcode_task where bh='".$bh."' and taskty=0 and zt=4 and userid=".$userid."";mysql_query("SET NAMES 'GBK'");$restask=mysql_query($sqltask);
if(!$rowtask=mysql_fetch_array($restask)){php_toheader("tasklist.php");}

$sqltaskhf="select * from yjcode_taskhf where bh='".$bh."' and taskty=0 and useridhf=".$rowtask[useridhf]." and ifxz=1";mysql_query("SET NAMES 'GBK'");$restaskhf=mysql_query($sqltaskhf);
if(!$rowtaskhf=mysql_fetch_array($restaskhf)){php_toheader("tasklist.php");}

if($_GET[control]=="ys"){
 $zt=$_POST[R1];
 if($zt=="yes"){
  $money1=$rowtask[money2];
  PointIntoM($rowtask[useridhf],"任务完成，获得佣金(任务编号".$bh.")",$money1);
  PointUpdateM($rowtask[useridhf],$money1);
  if(1==$rowtask[yjfs]){
  $m=$rowcontrol[taskyj]*$money1*(-1);
  PointIntoM($rowtask[useridhf],"任务完成，扣除平台中介费(任务编号".$bh.")",$m);
  PointUpdateM($rowtask[useridhf],$m);
  }elseif(2==$row[yjfs]){
  $m=$rowcontrol[taskyj]*$money1*(-1)*0.5;
  PointIntoM($rowtask[useridhf],"任务完成，扣除平台中介费(任务编号".$bh.")",$m);
  PointUpdateM($rowtask[useridhf],$m);
  }
  updatetable("yjcode_task","zt=5 where id=".$rowtask[id]);
  $txt="验收通过";
  intotable("yjcode_tasklog","bh,userid,useridhf,admin,txt,sj,fj","'".$bh."',".$rowtask[userid].",".$rowtask[useridhf].",1,'".$txt."','".$sj."',''");
  if(!empty($rowtask[jsbao])){
   PointIntoB($rowtask[useridhf],"任务完成通过验收，退还保证金",$rowtask[jsbao],2);
   PointUpdateB($rowtask[useridhf],$rowtask[jsbao]); 
  }
 }elseif($zt=="no"){
  $txt="验收不通过，申请平台介入";
  intotable("yjcode_tasklog","bh,userid,useridhf,admin,txt,sj,fj","'".$bh."',".$rowtask[userid].",".$rowtask[useridhf].",1,'".$txt."','".$sj."',''");
  updatetable("yjcode_task","zt=8 where id=".$rowtask[id]);
 }
 
 php_toheader("tasklist.php");
 
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
<script type="text/javascript" src="../../config/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="../../config/ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" src="../../config/ueditor/lang/zh-cn/zh-cn.js"></script>
<script language="javascript">
function tj(){
r=document.getElementsByName("R1");rr="";for(i=0;i<r.length;i++){if(r[i].checked==true){rr=r[i].value;}}if(rr==""){alert("请选择操作状态！");return false;}
if(!confirm("确定提交该操作吗？")){return false;}
layer.open({type: 2,content: '正在提交',shadeClose:false});
f1.action="taskys.php?bh=<?=$bh?>&control=ys";
}
</script>
</head>
<body>
<? include("topuser.php");?>
<div class="bfbtop1 box">
 <div class="d1" onClick="gourl('../task/view<?=$rowtask[id]?>.html')"><img src="img/topleft.png" height="21" /></div>
 <div class="d2">单人任务验收</div>
 <div class="d3"></div>
</div>

<? include("taskv.php");?>

<? while2("*","yjcode_user where id=".$rowtaskhf[useridhf]);$row2=mysql_fetch_array($res2);?>
<div class="taskmain1 box"><div class="d1"></div><div class="d2">中标信息</div></div>
<div class="taskmain2 box">
 <div class="d1">中标用户：</div>
 <div class="d2"><?=$row2[nc]?></div>
</div>
<div class="taskmain2 box">
 <div class="d1">报名时间：</div>
 <div class="d2"><?=$rowtaskhf[sj]?></div>
</div>
<div class="taskmain2 box">
 <div class="d1">中标时间：</div>
 <div class="d2"><?=$rowtaskhf[zbsj]?></div>
</div>
<div class="taskmain2 box">
 <div class="d1">联系QQ：</div>
 <div class="d2"><a href="javascript:void(0);" onClick="qqtang('<?=$row2[uqq]?>')"><?=$row2[uqq]?></a></div>
</div>
<? if(!empty($row2[mot])){?>
<div class="taskmain2 box">
 <div class="d1">联系电话：</div>
 <div class="d2"><?=$row2[mot]?></div>
</div>
<? }?>
<div class="taskmain2 box">
 <div class="d1">用户报价：</div>
 <div class="d2"><strong class="red">￥<?=$rowtaskhf[money1]?></strong></div>
</div>
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
<div class="taskmain3 box"></div>

<div class="taskmain1 box"><div class="d1"></div><div class="d2 red">时间提醒</div></div>
<div class="taskmain2 box">
 <div class="d1">任务截止：</div>
 <div class="d2"><?=$rowtaskhf[rwdq]?></div>
</div>
<div class="taskmain2 box">
 <div class="d1">验收截止：</div>
 <div class="d2">您需要在<span class="red"><?=$rowtaskhf[oksj]?></span>前处理本次任务验收，否则系统自动判定为验收合格</div>
</div>
<div class="taskmain3 box"></div>


<? if($rowtask[zt]==3 || $rowtask[zt]==4){?>
<form name="f1" method="post" onSubmit="return tj()">
<div class="taskmain1 box"><div class="d1"></div><div class="d2">验收说明</div></div>
<div class="txtbox box">
<div class="dmain">
 <script id="editor" name="content" type="text/plain" style="width:100%;height:200px;"></script>
</div>
</div>
<div class="uk box">
 <div class="d1">验收操作</div>
 <div class="d2">
 <label class="blue"><input name="R1" type="radio" value="yes" /> 确认验收</label>
 <label class="red"><input name="R1" type="radio" value="no" /> 并不满意，要求平台介入</label>
 </div>
</div>
<div class="uk box"><div class="d1">操作提示</div><div class="d21 red">请务必跟接手方确认后再进行操作</div></div>

<div class="fbbtn box">
 <div class="d1"><? tjbtnr_m("提交操作")?></div>
</div>
</form>
<? }?>

<script type="text/javascript">
var ue= UE.getEditor('editor',{toolbars:[[ 'source', '|', 'forecolor','fontsize', '|','link', 'unlink','simpleupload']]});
</script>

</body>
</html>