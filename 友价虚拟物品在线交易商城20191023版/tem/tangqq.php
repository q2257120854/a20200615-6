<?
header("Content-type:text/html;charset=gb2312");
include("../config/conn.php");
include("../config/function.php");
$qq=$_GET[qq];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>QQ联系</title>
<link href="../css/global.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="../js/global.js"></script>
<script language="javascript" src="../js/jquery.min.js"></script>
<script language="javascript" src="../js/layer.js"></script>
<style type="text/css">
body{background-color:#F5F8FE;}
.tangqq{float:left;width:320px;text-align:left;}
.tangqq .u1{float:left;margin:15px 14px 0 14px;width:292px;}
.tangqq .u1 li{float:left;}
.tangqq .u1 .l1{width:160px;padding:5px 0 0 0;}
.tangqq .u1 .l2{width:132px;}
.tangqq .u1 .l2 a{float:left;width:58px;padding:4px 0 0 0;height:21px;text-align:center;}
.tangqq .u1 .l2 a:hover{background-color:#EAF3FE;color:#1774C2;}
.tangqq .u1 .l2 .a1{border:#E5E5E5 solid 1px;background-color:#fff;}
.tangqq .u1 .l2 .a2{border:#C5DDF5 solid 1px;background-color:#FEFEFE;color:#1774C2;float:right;}
.tangqq .u1 .l3{margin:10px 0 0 0;width:292px;padding:7px 0 0 0;line-height:19px;border-top:#BCCCED dotted 1px;}
body,td,th {
	font-family: "Microsoft YaHei", "微软雅黑", MicrosoftJhengHei, "华文细黑", STHeiti, MingLiu;
}
</style>
</head>
<body>
<div class="tangqq">
 <ul class="u1">
 <li class="l1"><strong>联系QQ：</strong><?=returnjgdw($qq,"","未填写QQ")?></li>
 <? if(!empty($qq)){?>
 <li class="l2"><a href="tencent://AddContact/?fromId=45&fromSubId=1&subcmd=all&uin=<?=$qq?>" target="_blank" class="a1">加为好友</a><a href="http://wpa.qq.com/msgrd?v=3&uin=<?=$qq?>&site=qq:<?=$qq?>&menu=yes" target="_blank" class="a2">直接对话</a></li>
 <? }?>
 <li class="l3">声明：该QQ号是用户提供，平台不确保其真实性，涉及资金交易时，请核实所要购买的商品与该QQ号是否有关联（谨防QQ无效、冒用等情况）</li>
 </ul>
</div>
</body>
</html>