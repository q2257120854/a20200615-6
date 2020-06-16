<?
include("../config/conn.php");
include("../config/function.php");
sesCheck();
$sqluser="select * from yjcode_user where uid='".$_SESSION[SHOPUSER]."'";mysql_query("SET NAMES 'GBK'");$resuser=mysql_query($sqluser);
$rowuser=mysql_fetch_array($resuser);
$userid=$rowuser[id];
$bh=$_GET[bh];
while0("*","yjcode_gd where bh='".$bh."' and zt=99 and userid=".$userid);if(!$row=mysql_fetch_array($res)){php_toheader("gdlist.php");}

//函数开始
if($_GET[control]=="update"){
 zwzr();
 $sj=date("Y-m-d H:i:s");
 $txt=sqlzhuru1($_POST[content]);
 updatetable("yjcode_gd","
			 sj='".$sj."',
			 zt=1,
			 mot='".sqlzhuru($_POST[tmot])."',
			 mail='".sqlzhuru($_POST[tmail])."',
			 orderbh='".sqlzhuru($_POST[torderbh])."',
			 txt='".$txt."',
			 gdzt=1
			 where bh='".$bh."' and userid=".$userid);
 php_toheader("gdlist.php");

}
//函数结果

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>用户管理面板 - <?=webname?></title>
<? include("cssjs.html");?>
<script type="text/javascript" src="../config/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="../config/ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" src="../config/ueditor/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript">
function tj(){
layer.msg('正在提交', {icon: 16  ,time: 0,shade :0.25});
tjwait();
f1.action="gd.php?bh=<?=$bh?>&control=update";
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
 
 <? include("rcap12.php");?>
 <script language="javascript">
 document.getElementById("rcap1").className="l1 l2";
 </script>

 <!--白B-->
 <div class="rkuang">
 
 <!--B-->
 <form name="f1" method="post" onsubmit="return tj()" enctype="multipart/form-data">
 <ul class="uk">
 <li class="l7"><span class="red">*</span> 问题描述：</li>
 <li class="l8"><script id="editor" name="content" type="text/plain" style="width:770px;height:400px;"></script></li>
 <li class="l1">订单编号：</li>
 <li class="l2"><input type="text" size="20" class="inp" name="torderbh" /><span class="fd">[<a href="order.php" target="_blank">查看我的订单</a>]</span></li>
 <li class="l1">手机号码：</li>
 <li class="l2"><input type="text" size="20" value="<?=$rowuser[mot]?>" class="inp" name="tmot" /></li>
 <li class="l1">邮箱号码：</li>
 <li class="l2"><input type="text" size="20" value="<?=$rowuser[email]?>" class="inp" name="tmail" /></li>
 <li class="l3"><? tjbtnr("提交问题","gdlist.php")?></li>
 </ul>
 </form>

 <!--E-->
 
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