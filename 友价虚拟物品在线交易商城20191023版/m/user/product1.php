<?
include("../../config/conn.php");
include("../../config/function.php");
sesCheck_m();
$sqluser="select * from yjcode_user where uid='".$_SESSION[SHOPUSER]."' and shopzt=2";mysql_query("SET NAMES 'GBK'");$resuser=mysql_query($sqluser);
if(!$rowuser=mysql_fetch_array($resuser)){php_toheader("openshop3.php");}

$userid=$rowuser[id];
$bh=sqlzhuru($_GET[bh]);
while0("*","yjcode_pro where bh='".$bh."' and userid=".$userid);if(!$row=mysql_fetch_array($res)){php_toheader("productlist.php");}

//函数开始
if($_GET[control]=="update"){
 zwzr();
 $txt=sqlzhuru1($_POST["content"]);
 updatetable("yjcode_pro","
			 txt='".$txt."'
			 where bh='".$bh."' and userid=".$userid);
 
 php_toheader("prosuc.php?bh=".$bh."&id=".$row[id]);

}
//函数结果

$ijia=1;
?>
<html>
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
<title>会员中心 <?=webname?></title>
<? include("../tem/cssjs.html");?>
<link href="css/sell.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="../../config/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="../../config/ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" src="../../config/ueditor/lang/zh-cn/zh-cn.js"></script>

<script language="javascript">
function tj(){
layer.open({type: 2,content: '正在提交',shadeClose:false});
f1.action="product1.php?bh=<?=$bh?>&control=update";
}
</script>

</head>
<body>
<? include("topuser.php");?>

<div class="bfbtop2 box">
 <div class="d1" onClick="gourl('product.php?bh=<?=$bh?>')"><img src="img/topleft1.png" height="21" /></div>
 <div class="d2">商品详情编辑</div>
 <div class="d3"></div>
</div>

<!--开始-->
<form name="f1" method="post" onSubmit="return tj()">
<div class="txtbox box">
<div class="dmain">
 <script id="editor" name="content" type="text/plain" style="width:100%;height:calc(100% - 230px);"><?=$row[txt]?></script>
</div>
</div>
<div class="uk box" style="margin-top:10px;">
 <div class="d1">操作建议</div>
 <div class="d21 red">在电脑上进行商品详情编辑，功能将更强大</div>
</div>
<div class="probottom"></div>
<div class="fbbtn fbbtnfix box">
 <div class="d1"><? tjbtnr_m("保存")?></div>
</div>

</form>
<!--结束-->

<script type="text/javascript">

var ue= UE.getEditor('editor'

, {

            toolbars:[

            [ 'source', '|', 'forecolor',

                 'fontsize', '|',

                'link', 'unlink',

                'simpleupload']

        ]

        });
</script>

</body>
</html>