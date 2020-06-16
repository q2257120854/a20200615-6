<?
include("../../config/conn.php");
include("../../config/function.php");
sesCheck_m();

$bh=$_GET[bh];
$userid=returnuserid($_SESSION[SHOPUSER]);

$sqltask="select * from yjcode_task where bh='".$bh."' and taskty=0 and useridhf=".$userid."";mysql_query("SET NAMES 'GBK'");$restask=mysql_query($sqltask);
if(!$rowtask=mysql_fetch_array($restask)){php_toheader("taskhflist.php");}

$sqltaskhf="select * from yjcode_taskhf where bh='".$bh."' and taskty=0 and useridhf=".$rowtask[useridhf]." and ifxz=1";mysql_query("SET NAMES 'GBK'");$restaskhf=mysql_query($sqltaskhf);
if(!$rowtaskhf=mysql_fetch_array($restaskhf)){php_toheader("taskhflist.php");}

//函数开始
if($_GET[control]=="add"){
 zwzr();
 $txt=sqlzhuru1($_POST[content]);
 $sj=date("Y-m-d H:i:s");
 intotable("yjcode_tasklog","bh,userid,useridhf,admin,txt,sj,fj","'".$bh."',".$rowtask[userid].",".$userid.",2,'".$txt."','".$sj."',''");
 php_toheader("taskgt.php?t=suc&bh=".$bh);

}
//函数结果
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
if(!confirm("确定提交该操作吗？")){return false;}
layer.open({type: 2,content: '正在提交',shadeClose:false});
f1.action="taskgt.php?bh=<?=$bh?>&control=add";
}
</script>
</head>
<body>
<? include("topuser.php");?>
<div class="bfbtop1 box">
 <div class="d1" onClick="gourl('../task/view<?=$rowtask[id]?>.html')"><img src="img/topleft.png" height="21" /></div>
 <div class="d2">单人任务沟通记录</div>
 <div class="d3"></div>
</div>

<? include("taskv.php");?>

<div class="taskmain1 box"><div class="d1"></div><div class="d2">沟通记录</div></div>
<div class="gtlistv box">
 <div class="gtlist">
 <ul class="u1 u0">
 <li class="l1"><img src="<?=returntppd("../../upload/".$rowtask[userid]."/user.jpg","../img/nonetx.gif")?>" width="40" height="40" /></li>
 <li class="l2">[雇主] 发起任务<br><?=$rowtask[sj]?></li>
 </ul>
 <? 
 while1("*","yjcode_tasklog where bh='".$bh."' order by sj asc");while($row1=mysql_fetch_array($res1)){
 $txt=$row1[txt];
 if($row1[admin]==1){$tp=returntppd("../../upload/".$row1[userid]."/user.jpg","../img/nonetx.jpg");$sf="雇主";}
 elseif($row1[admin]==2){$tp=returntppd("../../upload/".$row1[useridhf]."/user.jpg","../img/nonetx.jpg");$sf="接手方";}
 elseif($row1[admin]==3){$tp="../img/nonetx.jpg";$sf="平台";}
 ?>
 <ul class="u1">
 <li class="l1"><img src="<?=$tp?>" width="40" height="40" /></li>
 <li class="l2">[<?=$sf?>] <?=$txt?><br><?=$row1[sj]?></li>
 </ul>
 <? }?>
 </div>
</div>

<? if($rowtask[zt]==3 || $rowtask[zt]==4 || $rowtask[zt]==8){?>
<form name="f1" method="post" onSubmit="return tj()">
<div class="taskmain1 box"><div class="d1"></div><div class="d2">回复内容</div></div>
<div class="txtbox box">
<div class="dmain">
 <script id="editor" name="content" type="text/plain" style="width:100%;height:200px;"></script>
</div>
</div>

<div class="fbbtn box">
 <div class="d1"><? tjbtnr_m("提交内容")?></div>
</div>
</form>
<? }?>

<script type="text/javascript">
var ue= UE.getEditor('editor',{toolbars:[[ 'source', '|', 'forecolor','fontsize', '|','link', 'unlink','simpleupload']]});
</script>

</body>
</html>