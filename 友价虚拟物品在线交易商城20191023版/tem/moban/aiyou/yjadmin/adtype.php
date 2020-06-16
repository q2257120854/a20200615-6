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

<div class="yjcode">
 <? $leftid=1;include("menu_ad.php");?>

<div class="right">
 <? if(!strstr($adminqx,",0,") && !strstr($adminqx,",0602,")){echo "<div class='noneqx'>无权限</div>";exit;}?>
 
 <? include("rightcap2.php");?>
 <script language="javascript">document.getElementById("rtit1").className="a1";</script>

 <!--begin-->
 <ul class="adtypecap">
 <li class="l1">广告定位编号</li>
 <li class="l2">说明</li>
 <li class="l3">管理</li>
 </ul>
 <?
 $adbh=array("ADDL","ADI00","ADTOP","ADI02","ADI13","ADI14","ADKF","aiyou_01","aiyou_02","aiyou_03","aiyou_04","aiyou_05","aiyou_06","aiyou_07","aiyou_08","aiyou_09","aiyou_10","aiyou_11");
 $adtit=array("对联广告","首页顶部广告","全站顶部广告","导航菜单","首页底部合作伙伴","首页底部友情链接","右侧自定义客服","快捷菜单左侧小图标","首页切换","底部联系我们","底部联系我们右侧广告","底部小图标","限时优惠上方横幅","畅销商品上方横幅","推荐商家上方横幅","限时优惠小标签","畅销商品小标签","推荐商家小标签");
 $adsize=array("100*?","1150*?","1150*?","","100*35","","","19*19","712*271","","100*100","106*40","1150*?","1150*?","1150*?","","","");
 $admust=array("pic","pic","","font","pic","font","code","pic","pic","code","pic","pic","","","","font","font","font");
 for($i=0;$i<count($adbh);$i++){
 $adurl="adlist.php?bh=".$adbh[$i]."&sm=".urlencode($adtit[$i]."-".$adsize[$i])."&must=".$admust[$i];
 ?>
 <ul class="adtypelist">
 <li class="l1"><?=$adbh[$i]?></li>
 <li class="l2"><?=$adtit[$i]." ".$adsize[$i]?></li>
 <li class="l3">
 <a href="<?=$adurl?>">列表</a><span></span>
 <a href="ad_lx.php?bh=<?=$adbh[$i]?>&sm=<?=urlencode($adtit[$i]."-".$adsize[$i])?>&must=<?=$admust[$i]?>">新增</a>
 </li>
 </ul>
 <?
 }
 ?>
 <!--end-->
 
</div>
</div>
<?php include("bottom.php");?>
</body>
</html>