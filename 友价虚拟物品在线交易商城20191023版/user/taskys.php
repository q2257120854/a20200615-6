<?
include("../config/conn.php");
include("../config/function.php");
sesCheck();
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>用户管理面板 - <?=webname?></title>
<? include("cssjs.html");?>
<link href="css/task.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../config/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="../config/ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" src="../config/ueditor/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript">
function tj(){
r=document.getElementsByName("R1");rr="";for(i=0;i<r.length;i++){if(r[i].checked==true){rr=r[i].value;}}if(rr==""){alert("请选择操作状态！");return false;}
if(!confirm("确定提交该操作吗？")){return false;}
layer.msg('正在处理', {icon: 16  ,time: 0,shade :0.25});
f1.action="taskys.php?bh=<?=$bh?>&control=ys";
}
</script>
</head>
<body>
<? include("../tem/top.html");?>
<? include("top.php");?>
<div class="yjcode">

<? include("left.php");?>

<!--RB-->
<div class="userright">
 
 <? include("rcap17.php");?>
 <script language="javascript">
 document.getElementById("rcap1").className="l1 l2";
 </script>

 <!--白B-->
 <div class="rkuang">
 
 <? include("taskv.php");?>

 <?
 while2("*","yjcode_user where id=".$rowtaskhf[useridhf]);$row2=mysql_fetch_array($res2);
 ?>
 <ul class="taskmain">
 <li class="l1">中标用户：</li>
 <li class="l3"><?=$row2[nc]?></li>
 <li class="l1">联系QQ：</li>
 <li class="l3"><a href="http://wpa.qq.com/msgrd?v=3&uin=<?=$row2[uqq]?>&site=<?=weburl?>&menu=yes" target="_blank"><?=$row2[uqq]?></a></li>
 <li class="l1">联系电话：</li>
 <li class="l3"><?=$row2[mot]?></li>
 <li class="l1">用户报价：</li>
 <li class="l3"><strong class="red">￥<?=$rowtaskhf[money1]?></strong></li>
 <li class="l1">中介费用：</li>
 <li class="l3">
 <? 
 if(empty($rowtask[yjfs])){echo "雇主承担，费用为<strong class='feng'>￥".$rowtaskhf[money1]*$rowcontrol[taskyj]."</strong>";}
 elseif($rowtask[yjfs]==1){echo "接手方承担";}
 elseif($rowtask[yjfs]==2){echo "双方各承担一半，费用为<strong class='feng'>￥".$rowtaskhf[money1]*$rowcontrol[taskyj]*0.5."</strong>";}
 ?>
 </li>
 <li class="l1">用户IP：</li>
 <li class="l3"><a href="https://www.baidu.com/s?wd=<?=$rowtaskhf[uip]?>" target="_blank"><?=$rowtaskhf[uip]?></a></li>
 <li class="l1">报名时间：</li>
 <li class="l3"><?=$rowtaskhf[sj]?></li>
 <li class="l1">中标时间：</li>
 <li class="l3"><?=$rowtaskhf[zbsj]?></li>
 <li class="l1">任务截止：</li>
 <li class="l3"><?=$rowtaskhf[rwdq]?></li>
 <li class="l1">操作提示：</li>
 <li class="l2">您需要在<span class="red"><?=$rowtaskhf[oksj]?></span>前处理本次任务验收，否则系统自动判定为验收合格</li>
 </ul>
 
 <form name="f1" method="post" onsubmit="return tj()">
 <ul class="uk">
 <li class="l7">验收说明：</li>
 <li class="l8"><script id="editor" name="content" type="text/plain" style="width:770px;height:400px;"><?=$rowtaskhf[ystxt]?></script></li>
 <li class="l1">操作：</li>
 <li class="l2">
 <label class="blue"><input name="R1" type="radio" value="yes" /> 确认验收</label>&nbsp;&nbsp;&nbsp;&nbsp;
 <label class="red"><input name="R1" type="radio" value="no" /> 并不满意，要求平台介入</label>
 </li>
 <li class="l1">操作提示：</li>
 <li class="l21 red">请务必跟接手方确认后再进行操作</li>
 <li class="l3"><? tjbtnr("提交操作","tasklist.php")?></li>
 </ul>
 </form>
 
 <div class="clear clear10"></div>
 </div>
 <!--白E-->

</div> 
<!--RE-->

</div>

<div class="clear clear15"></div>
<? include("../tem/bottom.html");?>
<script type="text/javascript">
//实例化编辑器
var ue= UE.getEditor('editor'
, {
            toolbars:[
            ['fullscreen', 'source', '|', 'undo', 'redo', '|',
                'removeformat', 'formatmatch' ,'|', 'forecolor',
                 'fontsize', '|',
                'link', 'unlink',
                'insertimage', 'emotion', 'attachment']
        ]
        });
</script>
</body>
</html>