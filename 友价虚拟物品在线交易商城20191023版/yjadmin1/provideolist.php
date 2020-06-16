<?php
include("../config/conn.php");
include("../config/function.php");
AdminSes_audit();
$bh=$_GET[bh];
$ses=" where zt<>99 and probh='".$bh."'";
?>
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
<style type="text/css">
/*视频*/
.provcap{float:left;border:#CACACA solid 1px;border-left:0;margin:7px 10px 0 10px;height:38px;width:880px;background-color:#E8E8E8;font-weight:700;}
.provcap li{float:left;padding-top:10px;border-left:#CACACA solid 1px;height:28px;}
.provcap .l1{width:27px;height:26px;text-align:left;padding:12px 0 0 8px;}
.provcap .l1 input{float:left;width:16px;height:16px;}
.provcap .l2{width:-moz-calc(100% - 552px);width:-webkit-calc(100% - 552px);width:calc(100% - 552px);text-align:left;padding-left:10px;}
.provcap .l3{width:182px;}
.provcap .l4{width:120px;}
.provcap .l5{width:200px;}
.provcap .l6{width:140px;text-align:right;padding-right:10px;}
.provlist{float:left;border:#CACACA solid 1px;border-left:0;margin:0 10px;border-top:0;height:37px;width:880px;background-color:#fff;}
.provlist li{float:left;padding-top:10px;border-left:#CACACA solid 1px;height:27px;}
.provlist .l1{width:27px;height:25px;text-align:left;padding:12px 0 0 8px;background-color:#F1F1F1;}
.provlist .l1 input{float:left;width:16px;height:16px;}
.provlist .l2{width:-moz-calc(100% - 552px);width:-webkit-calc(100% - 552px);width:calc(100% - 552px);text-align:left;padding-left:10px;}
.provlist .l3{width:182px;}
.provlist .l4{width:120px;}
.provlist .l5{width:200px;}
.provlist .l6{width:150px;}
.provlist .l6 a{float:right;margin-right:10px;}
.provlist .l6 a:hover{color:#ff6600;text-decoration:underline;}
.provlist .l6 span{float:right;height:11px;border-left:#cacaca solid 1px;margin:3px 10px 0 0;}
.provlist:hover{background:rgba(249,249,249,1);-webkit-transition:background-color 0.3s linear;-moz-transition:background-color 0.3s linear;-o-transition:background-color 0.3s linear;transition:background-color 0.3s linear;}
.upage{width:-moz-calc(100% - 22px);width:-webkit-calc(100% - 22px);width:calc(100% - 22px);margin:0 10px;}
</style>
</head>
<body>

 <!--B-->
 <ul class="ksedi">
 <li class="l2">
 <a href="javascript:void(0)" onclick="checkDEL(40,'fcw_xqvideo')" style="margin-left:10px;" class="a2">变更审核</a>
 <a href="javascript:void(0)" onclick="checkDEL(41,'fcw_xqvideo')" class="a2">删除</a>
 <a href="provideolx.php?bh=<?=$bh?>" class="a1">发布视频</a>
 </li>
 </ul>
 <ul class="provcap">
 <li class="l1"><input name="C2" type="checkbox" onclick="xuan()" /></li>
 <li class="l2">商品视频信息</li>
 <li class="l3">审核</li>
 <li class="l4">关注</li>
 <li class="l5">时间</li>
 <li class="l6">操作</li>
 </ul>
 <?
 pagef($ses,10,"yjcode_provideo","order by sj desc");while($row=mysql_fetch_array($res)){
 $aurl="provideo.php?action=update&bh=".$bh."&mybh=".$row[bh];
 ?>
 <ul class="provlist">
 <li class="l1"><input name="C1" type="checkbox" value="<?=$row[bh]?>" /></li>
 <li class="l2"><a href="<?=$aurl?>"><?=returntitdian($row["tit"],78)?></a></li>
 <li class="l3"><?=returnztv($row[zt])?></li>
 <li class="l4"><?=$row[djl]?></li>
 <li class="l5"><?=$row[sj]?></li>
 <li class="l6"><a href="<?=$aurl?>">修改</a><span></span><a href="#" target="_blank">预览</a></li>
 </ul>
 <? }?>
 <?
 $nowurl="provideolist.php";
 $nowwd="bh=".$bh;
 include("page.php");
 ?>
 <!--E-->
 
</div>
</div>
</body>
</html>