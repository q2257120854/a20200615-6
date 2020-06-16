<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><?=webname?>管理系统</title>
<link href="css/basic.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script language="javascript" src="js/basic.js"></script>
<script language="javascript" src="js/layer.js"></script>
<script language="javascript">
function r1onc(x){
document.getElementById("r1main1").style.display="none";
document.getElementById("r1main2").style.display="none";
document.getElementById("r1main"+x).style.display="";
}
</script>
</head>
<body>
<div class="yjcode">
<div class="treebox">

 <ul class="menu">

 <li class="level1">
   <a href="javascript:void(0);" class="<? if($leftid==1){?>current <? }?>a1"><em></em>所有推送记录<i></i></a>
    <ul class="level2" style="display:block;">
		<li> <a href="tuisong.php"><em></em>百度推送记录<i></i></a></li>
		<li> <a href="tuisong1.php"><em></em>熊掌推送记录<i></i></a></li>
	</ul>
 </li>

 </ul>
</div>
<!--LEFT E-->
<? include("left.php");?>
