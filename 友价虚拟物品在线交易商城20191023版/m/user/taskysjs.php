<?
include("../../config/conn.php");
include("../../config/function.php");
sesCheck_m();

$bh=$_GET[bh];
$sj=date("Y-m-d H:i:s");
$useridhf=returnuserid($_SESSION[SHOPUSER]);

$sqltask="select * from yjcode_task where bh='".$bh."' and taskty=0 and zt=3 and useridhf=".$useridhf."";mysql_query("SET NAMES 'GBK'");$restask=mysql_query($sqltask);
if(!$rowtask=mysql_fetch_array($restask)){php_toheader("taskhflist.php");}

if($_GET[control]=="ys"){
 $bh=$_GET[bh];
 updatetable("yjcode_task","zt=4 where id=".$rowtask[id]);
 $oksj=date("Y-m-d H:i:s",strtotime("+".$rowcontrol[taskoksj]." day"));
 updatetable("yjcode_taskhf","ystxt='".sqlzhuru($_POST[content])."',oksj='".$oksj."' where bh='".$bh."' and ifxz=1 and useridhf=".$useridhf." and taskty=0");
 $sj=date("Y-m-d H:i:s");
 $txt="已经完成任务，发起验收申请，雇主需要在".$oksj."前处理本次验收";
 intotable("yjcode_tasklog","bh,userid,useridhf,admin,txt,sj,fj","'".$bh."',".$rowtask[userid].",".$useridhf.",2,'".$txt."','".$sj."',''");
 php_toheader("taskhflist.php");
 
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
if(!confirm("确定提交该操作吗？")){return false;}
layer.open({type: 2,content: '正在提交',shadeClose:false});
f1.action="taskysjs.php?bh=<?=$bh?>&control=ys";
}
</script>
</head>
<body>
<? include("topuser.php");?>
<div class="bfbtop1 box">
 <div class="d1" onClick="gourl('../task/view<?=$rowtask[id]?>.html')"><img src="img/topleft.png" height="21" /></div>
 <div class="d2">提交验收</div>
 <div class="d3"></div>
</div>

<? include("taskv.php");?>

<? 
while1("*","yjcode_taskhf where bh='".$bh."' and ifxz=1");if($row1=mysql_fetch_array($res1)){
while2("*","yjcode_user where id=".$row1[useridhf]);$row2=mysql_fetch_array($res2);
?>
<form name="f1" method="post" onSubmit="return tj()">
<div class="taskmain1 box"><div class="d1"></div><div class="d2">验收说明</div></div>
<div class="txtbox box">
<div class="dmain">
 <script id="editor" name="content" type="text/plain" style="width:100%;height:200px;"></script>
</div>
</div>

<div class="fbbtn box">
 <div class="d1"><? tjbtnr_m("请求验收")?></div>
</div>
</form>
<? }?>

<script type="text/javascript">
var ue= UE.getEditor('editor',{toolbars:[[ 'source', '|', 'forecolor','fontsize', '|','link', 'unlink','simpleupload']]});
</script>

</body>
</html>