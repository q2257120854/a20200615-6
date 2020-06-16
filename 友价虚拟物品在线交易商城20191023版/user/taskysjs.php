<?
include("../config/conn.php");
include("../config/function.php");
sesCheck();
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
if(!confirm("确定提交该操作吗？")){return false;}
layer.msg('正在处理', {icon: 16  ,time: 0,shade :0.25});
f1.action="taskysjs.php?bh=<?=$bh?>&control=ys";
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
 
 <? include("rcap9.php");?>
 <script language="javascript">
 document.getElementById("rcap1").className="l1 l2";
 </script>

 <!--白B-->
 <div class="rkuang">
 
 <? include("taskv.php");?>
 <? 
 while1("*","yjcode_taskhf where bh='".$bh."' and ifxz=1");if($row1=mysql_fetch_array($res1)){
 while2("*","yjcode_user where id=".$row1[useridhf]);$row2=mysql_fetch_array($res2);
 ?>
 <form name="f1" method="post" onsubmit="return tj()">
 <ul class="uk">
 <li class="l7">验收说明：</li>
 <li class="l8"><script id="editor" name="content" type="text/plain" style="width:770px;height:400px;"></script></li>
 <li class="l3"><? tjbtnr("请求验收","taskhflist.php")?></li>
 </ul>
 </form>
 <? }?>
 
 <div class="clear clear10"></div>
 </div>
 <!--白E-->

</div> 
<!--RE-->

</div>

<script language="javascript">
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
<div class="clear clear15"></div>
<? include("../tem/bottom.html");?>
</body>
</html>