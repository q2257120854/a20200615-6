<?
include("../../config/conn.php");
include("../../config/function.php");
$a=intval($_GET[admin]);
if($a==1){
$str="密码修改成功，请牢记您的新密码";
$errdis="okts";
$bkurl="../user/";

}elseif($a==2){
$str="支付密码修改成功，请牢记";
$errdis="okts";
$bkurl="../user/";

}elseif($a==3){
$str="基本资料修改成功";
$errdis="okts";
$bkurl="../user/inf.php";

}elseif($a==4){
$str="恭喜您，商品购买成功";
$errdis="okts";
$bkurl="../user/order.php";

}elseif($a==5){
$str="账号或密码有误，返回重试";
$errdis="errts";
$bkurl=$_GET[b];

}elseif($a==6){
if(intval($_GET[lx]=="1")){$str="您的投标信息已发送，等待雇主选标";}
elseif(intval($_GET[lx]=="2")){$str="你已接单成功<br>完成任务后，请一定及时提交验收";}
$errdis="okts";
$bkurl="../task/view".$_GET["id"].".html";

}elseif($a==999){
$str="操作成功";
$errdis="okts";
$bkurl=$_GET[b];

}
?>
<html>
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="viewport" content="initial-scale=1, width=device-width, maximum-scale=1, user-scalable=no" />
<meta http-equiv="refresh" content="5;url=<?=$bkurl?>">  
<title>操作提示 - 手机版<?=webname?></title>
<? include("../tem/cssjs.html");?>
<style type="text/css">
body{background-color:#EBEBEB;}
</style>
</head>
<body>
<!--内页头部B-->
<div class="ntop">操作提示</div>
<!--内页头部E-->

<div class="<?=$errdis?> box"><div class="dts"><strong><?=$str?></strong><br><a href="<?=$bkurl?>">5秒后系统会自动跳转，也可点击此处直接跳转</a></div></div>

<? include("../tem/moban/".$rowcontrol[wapmb]."/tem/bottom.php");?>
</body>
</html>