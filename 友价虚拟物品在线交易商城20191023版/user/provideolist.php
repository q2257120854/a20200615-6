<?
include("../config/conn.php");
include("../config/function.php");
sesCheck();
$bh=$_GET[bh];
$sqluser="select * from yjcode_user where uid='".$_SESSION[SHOPUSER]."'";mysql_query("SET NAMES 'GBK'");$resuser=mysql_query($sqluser);
$rowuser=mysql_fetch_array($resuser);
$userid=$rowuser[id];
$ses=" where userid=".$userid." and probh='".$bh."' and zt<>99";
$page=$_GET["page"];if($page==""){$page=1;}else{$page=intval($_GET["page"]);}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>用户管理面板 - <?=webname?></title>
<? include("cssjs.html");?>
<style type="text/css">
/*视频*/
body{background-color:#fff;}
.ksedi{float:left;margin:10px 10px 0 10px;width:880px;}
.ksedi .d1{float:left;}
.ksedi .d1 a{float:left;padding:5px 20px 0 20px;height:22px;border-radius:5px;margin:0 20px 0 0;}
.ksedi .d1 a:hover{text-decoration:none;}
.ksedi .d1 .a1{color:#fff;background-color:#FE5241;}
.ksedi .d1 .a2{color:#fff;background-color:#535353;}
.provideocap{float:left;border:#E1E1E2 solid 1px;width:880px;margin:10px 0 0 10px;height:40px;text-align:center;background-color:#F5F5F5;}
.provideocap li{float:left;border-right:#e1e1e2 solid 1px;padding:12px 0 0 0;height:28px;}
.provideocap .l0{width:30px;padding-top:13px;height:27px;}
.provideocap .l1{width:242px;text-align:left;padding-left:10px;}
.provideocap .l2{width:102px;}
.provideocap .l3{width:100px;}
.provideocap .l4{width:98px;}
.provideocap .l5{width:202px;}
.provideocap .l6{width:90px;border-right:0;}
.provideo{float:left;border:#E1E1E2 solid 1px;width:880px;margin:0 0 0 10px;height:32px;border-top:0;text-align:center;}
.provideo li{float:left;border-right:#e1e1e2 solid 1px;padding:8px 0 0 0;height:24px;}
.provideo .l0{width:30px;}
.provideo .l1{width:242px;text-align:left;padding-left:10px;}
.provideo .l2{width:102px;}
.provideo .l3{width:100px;}
.provideo .l4{width:98px;}
.provideo .l5{width:202px;}
.provideo .l6{width:90px;border-right:0;padding:6px 0 0 0;height:26px;}
.provideo .l6 .s1{float:left;width:59px;border:#E6E6E6 solid 1px;padding:1px 0 0 9px;height:18px;margin:0 0 0 10px;text-align:left;background:url(img/jian.gif) no-repeat;background-position:55px 8px;background-color:#fff;}
.provideo .l6 .gl{float:left;width:68px;border:#e6e6e6 solid 1px;border-top:0;margin:0 0 0 10px;position:relative;background-color:#fff;}
.provideo .l6 .gl a{float:left;width:68px;padding:3px 0 0 0;height:18px;}
.provideo .l6 .gl a:hover{text-decoration:none;background-color:#f2f2f2;}
.provideo:hover{background-color:#f9f9f9;}
</style>
<script language="javascript">
function glover(x){
 document.getElementById("gl"+x).style.display="";
}
function glout(x){
 document.getElementById("gl"+x).style.display="none";
}
</script>
</head>
<body>

 <!--白B-->
 
 <div class="ksedi">
  <div class="d1">
  <a href="javascript:void(0)" onclick="NcheckDEL(14,'yjcode_provideo')" class="a2">删除</a>
  <a href="provideolx.php?bh=<?=$bh?>" class="a1">发布视频</a>
  </div>
 </div>

 <ul class="provideocap">
 <li class="l0"><input name="C2" type="checkbox" onclick="xuan()" /></li>
 <li class="l1">视频标题</li>
 <li class="l2">审核状态</li>
 <li class="l3">是否推荐</li>
 <li class="l4">关注</li>
 <li class="l5">更新时间</li>
 <li class="l6">操作</li>
 </ul>
 <?
 pagef($ses,10,"yjcode_provideo","order by sj desc");while($row=mysql_fetch_array($res)){
 $aurl="provideo.php?bh=".$bh."&mybh=".$row[bh];
 ?>
 <ul class="provideo">
 <li class="l0"><input name="C1" type="checkbox" value="<?=$row[bh]?>" /></li>
 <li class="l1">
 <a title="<?=$row["tit"]?>" href="<?=$aurl?>" class="a1"><?=returntitdian($row["tit"],78)?></a>
 </li>
 <li class="l2"><?=returnztv($row[zt])?></li>
 <li class="l3"><? if(1==$row[iftj]){?>推荐<? }else{?>普通<? }?></li>
 <li class="l4"><?=$row[djl]?></li>
 <li class="l5"><?=$row[sj]?></li>
 <li class="l6" onmouseover="glover(<?=$row[id]?>)" onmouseout="glout(<?=$row[id]?>)">
  <span class="s1">管理</span>
  <div class="gl" style="display:none;" id="gl<?=$row[id]?>">
  <a href="<?=$aurl?>">编辑信息</a>
  <a href="<?=$row[url]?>" target="_blank">预览视频</a>
  </div>
 </li>
 </ul>
 <? }?>
 <div class="npa">
 <?
 $nowurl="provideolist.php";
 $nowwd="bh=".$bh;
 require("page.php");
 ?>
 </div>
 
 <!--白E-->


</body>
</html>