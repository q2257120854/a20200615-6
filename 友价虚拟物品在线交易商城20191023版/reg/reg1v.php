<?
include("../config/conn.php");
include("../config/function.php");
if($_SESSION["DOMAINUSER"]!=""){php_toheader("../user/");}

$id=$_GET[id];
if($_GET["chk"]!=sha1($id.weburl)){php_toheader("../");}
while0("id,uid,emailyzm","yj_domain_user where id=".$id." and emailyzm='".$_GET[tmp]."'");if($row=mysql_fetch_array($res)){
 updatetable("yj_domain_user","emailyzm='',zt=1 where id=".$id);
 $sj=date("Y-m-d H:i:s");
 intotable("yj_domain_email","userid,email,zt,sj,yzm","".$id.",'".$row[uid]."',1,'".$sj."',''");
 $_SESSION["DOMAINUSER"]=$row[uid];
}

?>
<html>
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>注册用户 - <?=webname?></title>
<link href="../css/basic.css" rel="stylesheet" type="text/css" />
<link href="index.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script language="javascript" src="../js/jquery.SuperSlide.2.1.1.js"></script>
<script language="javascript" src="../js/jquery.SuperSlide.2.1.1.source.js"></script>
<script language="javascript" src="../js/basic.js"></script>
<script language="javascript" src="reg.js"></script>
</head>
<body>

<? include("../tem/top.html");?>
<? include("../tem/top1.html");?>
<? include("../tem/top2.html");?>

<div class="yjcode">

 <div class="jhok">
 <ul class="u1">
 <li class="l1">成功提示</li>
 <li class="l2">恭喜您，您的帐号已经成功激活</li>
 <li class="l3">
 <a href="../">回到首页</a>&nbsp;&nbsp;&nbsp;&nbsp;
 <a href="../user/">会员中心</a>
 </li>
 </ul>
 </div>
  
</div>

<? include("../tem/bottom.html");?>

</body>
</html>