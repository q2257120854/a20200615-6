<?php
include("../config/conn.php");
include("../config/function.php");
AdminSes_audit();
$ses=" where id>0";
if(!empty($_GET[zt])){$ses=$ses." and zt=".$_GET[zt];}
$page=$_GET["page"];if($page==""){$page=1;}else{$page=intval($_GET["page"]);}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><?=webname?>管理系统</title>
<link href="css/basic.css" rel="stylesheet" type="text/css" />
<link href="css/ad.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script language="javascript" src="js/basic.js"></script>
<script language="javascript" src="js/layer.js"></script>
</head>
<body>
<? include("top.php");?>
<script language="javascript">
document.getElementById("menu5").className="a1";
</script>
<? if(!strstr($adminqx,",0,") && !strstr($adminqx,",0602,")){echo "<div class='noneqx'>无权限</div>";exit;}?>

<div class="yjcode">
 <? $leftid=5;include("menu_ad.php");?>

<div class="right">

 <div class="bqu1">
 <a class="a1" href="jubaolist.php">举报管理</a>
 </div>
 <!--B-->
 <ul class="ksedi">
 <li class="l2">
 <a href="javascript:checkDEL(43,'yjcode_jubao')" class="a2">删除</a>
 </li>
 </ul>
 <ul class="jubaolistcap">
 <li class="l1"><input name="C2" type="checkbox" onclick="xuan()" /></li>
 <li class="l2">举报内容</li>
 <li class="l3">对象</li>
 <li class="l4">被举报主题</li>
 <li class="l5">状态</li>
 <li class="l6">举报时间</li>
 <li class="l7">操作</li>
 </ul>
 <?
 pagef($ses,20,"yjcode_jubao","order by sj desc");while($row=mysql_fetch_array($res)){
 $aurl="jubao.php?bh=".$row[bh];
 while1("*","yjcode_jubaotype where id=".$row[tyid]);$row1=mysql_fetch_array($res1);
 if($row[admin]==1){
  while2("*","yjcode_pro where id=".$row[jbid]);$row2=mysql_fetch_array($res2);
  $jbtit=$row2[tit];
  $dx="商品";
  $jburl="../product/view".$row2[id].".html";
 }
 if($row[zt]==1){$zt="<span class='red'>未查看</span>";}
 elseif($row[zt]==2){$zt="<span class='blue'>已查看</span>";}
 ?>
 <ul class="jubaolist">
 <li class="l1"><input name="C1" type="checkbox" value="<?=$row[bh]?>" /></li>
 <li class="l2"><a href="<?=$aurl?>"><?=strgb2312($row1["tit"],0,78)?></a></li>
 <li class="l3"><?=$dx?></li>
 <li class="l4"><a href="<?=$jburl?>" target="_blank"><?=strgb2312($jbtit,0,78)?></a></li>
 <li class="l5"><?=$zt?></li>
 <li class="l6"><?=$row[sj]?></li>
 <li class="l7"><a href="<?=$aurl?>">查看</a></li>
 </ul>
 <? }?>
 <?
 $nowurl="jubaolist.php";
 $nowwd="zt=".$_GET[zt];
 include("page.php");
 ?>
 <!--E-->
 
</div>
</div>
<?php include("bottom.php");?>
</body>
</html>