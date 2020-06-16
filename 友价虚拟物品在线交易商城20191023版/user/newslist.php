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
<link href="css/hudong.css" rel="stylesheet" type="text/css" />
</head>
<body>
<? include("../tem/top.html");?>
<? include("top.php");?>
<div class="yjcode">

<? include("left.php");?>

<!--RB-->
<div class="userright">
 
 <? include("rcap13.php");?>
 <script language="javascript">
 document.getElementById("rcap1").className="l1 l2";
 </script>

 <!--白B-->
 <div class="rkuang">
 
 <div class="ksedi">
  <div class="d1">
  <a href="javascript:NcheckDEL(12,'yjcode_news')" class="a2">删除</a>
  <a href="newslx.php" class="a1">我要投稿</a>
  </div>
 </div>
  
 <ul class="newslistcap">
 <li class="l0"><input name="C2" type="checkbox" onclick="xuan()" /></li>
 <li class="l1">标题</li>
 <li class="l2">点击</li>
 <li class="l3">审核状态</li>
 <li class="l4">最后更新</li>
 </ul>
 <?
 $ses=" where zt<>99 and userid=".$luserid;
 $page=$_GET["page"];if($page==""){$page=1;}else{$page=intval($_GET["page"]);}
 pagef($ses,30,"yjcode_news","order by lastsj desc");while($row=mysql_fetch_array($res)){
 if($row[zt]==1){$au="news.php?bh=".$row[bh];}else{$au="javascript:void(0);";}
 ?>
 <ul class="newslist">
 <li class="l0"><? if($row[zt]!=0){?><input name="C1" type="checkbox" value="<?=$row[bh]?>" /><? }?></li>
 <li class="l1"><a href="<?=$au?>"><?=strgb2312($row[tit],0,60)?></a> [<a href="../news/txtlist_i<?=$row[id]?>v.html" target="_blank" class="feng">预览</a>]</li>
 <li class="l2"><?=$row[djl]?></li>
 <li class="l3"><?=returnztv($row[zt])?></li>
 <li class="l4"><?=$row[lastsj]?></li>
 </ul>
 <? }?>
 <div class="npa">
 <?
 $nowurl="newslist.php";
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