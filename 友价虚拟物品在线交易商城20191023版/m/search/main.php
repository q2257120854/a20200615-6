<?
include("../../config/conn.php");
include("../../config/function.php");
$admin=intval($_GET[admin]);
if($admin==0){$admin=1;}

if($admin==1){
 $tit="商品搜索";
}elseif($admin==2){
 $tit="店铺搜索";
}
?>
<html>
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="viewport" content="initial-scale=1, width=device-width, maximum-scale=1, user-scalable=no" />
<title><?=$tit?> - 手机版<?=webname?></title>
<? include("../tem/cssjs.html");?>
</head>
<body>
<? $nowpagetit=$tit;include("../tem/moban/".$rowcontrol[wapmb]."/tem/top.php");?>

<form name="f1" method="post" action="index.php?admin=<?=$admin?>">
<div class="uk box">
 <div class="d1"><input placeholder="请输入关键词" type="text" name="topt" /></div>
</div>

<div class="tjbutton box">
 <div class="d0"></div>
 <div class="d1"><input type="submit" class="tjinput" value="开始搜索" /></div>
 <div class="d0"></div>
</div>

</form>

<? include("../tem/moban/".$rowcontrol[wapmb]."/tem/bottom.php");?>
</body>
</html>