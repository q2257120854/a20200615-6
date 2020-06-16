<?
include("../config/conn.php");
include("../config/function.php");
sesCheck();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>用户管理面板 - <?=webname?></title>
<? include("cssjs.html");?>
<link href="css/sell.css" rel="stylesheet" type="text/css" />
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
<? include("../tem/top.html");?>
<? include("top.php");?>
<div class="yjcode">

<? include("left.php");?>

<!--RB-->
<div class="userright">
 
 <? include("sellzf.php");?>

 <!--白B-->
 <div class="rkuang">
 
 <div class="ksedi">
  <div class="d1">
  <a href="javascript:NcheckDEL(11,'yjcode_yunfei')" class="a2">删除</a>
  <a href="yunfeilx.php" class="a1">新增模板</a>
  </div>
 </div>

 <ul class="yunfeicap">
 <li class="l0"><input name="C2" onclick="xuan()" type="checkbox" /></li>
 <li class="l1">模板名称</li>
 <li class="l2">首重费用</li>
 <li class="l3">编辑时间</li>
 <li class="l4">操作</li>
 </ul>
 <?
 $ses=" where zt=0 and userid=".$luserid;
 $page=$_GET["page"];if($page==""){$page=1;}else{$page=intval($_GET["page"]);}
 pagef($ses,30,"yjcode_yunfei","order by sj desc");while($row=mysql_fetch_array($res)){
 ?>
 <ul class="yunfeilist">
 <li class="l0"><input name="C1" type="checkbox" value="<?=$row[id]?>" /></li>
 <li class="l1"><a href="yunfei.php?bh=<?=$row[bh]?>"><strong><?=$row[tit]?></strong></a></li>
 <li class="l2"><?=$row[money1]?>元</li>
 <li class="l3"><?=$row[sj]?></li>
 <li class="l4" onmouseover="glover(<?=$row[id]?>)" onmouseout="glout(<?=$row[id]?>)">
  <span class="s1">管理</span>
  <div class="gl" style="display:none;" id="gl<?=$row[id]?>">
  <a href="yunfei.php?bh=<?=$row[bh]?>">修改信息</a>
  <a href="yunfeiarea.php?id=<?=$row[id]?>">管理区域</a>
  </div>
 </li>
 </ul>
 <? }?>

 <div class="npa">
 <?
 $nowurl="yunfeilist.php";
 $nowwd="";
 require("page.php");
 ?>
 </div>
 <div class="clear clear15"></div>
 
 </div>
 <!--白E-->

</div> 
<!--RE-->

</div>

<div class="clear clear15"></div>
<? include("../tem/bottom.html");?>
</body>
</html>