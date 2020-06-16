<?
include("../config/conn.php");
include("../config/function.php");
sesCheck();
$bh=$_GET[bh];
$sqluser="select * from yjcode_user where uid='".$_SESSION[SHOPUSER]."'";mysql_query("SET NAMES 'GBK'");$resuser=mysql_query($sqluser);
if(!$rowuser=mysql_fetch_array($resuser)){Audit_alert("登录超时","./","parent.");}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>微信传图</title>
<style type="text/css">
body{margin:0;font-size:12px;text-align:center;color:#333;word-wrap:break-word;font-family:"Microsoft YaHei",微软雅黑,"MicrosoftJhengHei",华文细黑,STHeiti,MingLiu;}
*{margin:0 auto;padding:0;}
.d1{float:left;text-align:center;width:200px;clear:both;padding:10px 0 0 0;height:27px;font-size:14px;background-color:#f2f2f2;}
.d2{float:left;text-align:center;width:200px;clear:both;}
.d2 img{width:198px;height:198px;}
.d3{float:left;text-align:center;width:200px;clear:both;}
.d3 a{float:left;width:150px;color:#fff;background-color:#ff6600;height:25px;font-size:14px;padding:5px 0 0 0;text-align:center;margin:0 0 0 25px;text-decoration:none;}
</style>
<script language="javascript" src="../js/jquery.min.js"></script>
<script language="javascript" src="../js/layer.js"></script>
<script language="javascript">
function clo(){
parent.layer.closeAll();
parent.xgtread("<?=$bh?>");
}
</script>
</head>
<body>
<div class="d1">请用微信扫一扫</div>
<div class="d2">
<? $u=weburl."m/user/wapctlist_a".$_GET[admin]."v_b".$bh."v_c".$rowuser[mybh]."v_d".$rowuser[pwd]."v.html";?>
<img src="<?=weburl?>tem/getqr.php?u=<?=$u?>m&size=6" />
</div>
<div class="d3"><a href="javascript:void(0);" onclick="clo()">已传完，关闭二维码</a></div>
</body>
</html>