<?
include("../../config/conn.php");
include("../../config/function.php");
if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false){ 
 sesCheck_m();
}else{

 $admin=intval($_GET[admin]);
 $uid=intval($_GET[uid]);
 $pwd=sqlzhuru($_GET[upwd]);
 if(!empty($admin) || !empty($uid)){
  $sqluser="select * from yjcode_user where id=".$uid." and pwd='".$pwd."'";mysql_query("SET NAMES 'GBK'");$resuser=mysql_query($sqluser);
  if(!$rowuser=mysql_fetch_array($resuser)){php_toheader("../reg/");}
  $_SESSION["SHOPUSER"]=$rowuser[uid];
  $_SESSION["SHOPUSERPWD"]=$rowuser[pwd];
  if($admin==1){php_toheader("carpay.php?carid=".$_GET[carid]);}
  elseif($admin==2){php_toheader("pay.php?m=".$_GET[m]);}
 }else{
 sesCheck_m();
 }

}


?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
<title>会员中心 <?=webname?></title>
<? include("../tem/cssjs.html");?>
<link href="css/buy.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body{background-color:#fff;}
</style>
</head>
<body>
<? include("topuser.php");?>

<div class="bfbtop1 box">
 <div class="d1" onClick="gourl('./')"><img src="img/topleft.png" height="21" /></div>
 <div class="d2">支付宝打开提示</div>
 <div class="d3"></div>
</div>

<div class="wxalipay box">
<div class="d1"><img src="../img/wxalipay.jpg" /></div>
</div>


<? include("bottom.php");?>
<script language="javascript">
bottomjd(4);
</script>

</body>
</html>