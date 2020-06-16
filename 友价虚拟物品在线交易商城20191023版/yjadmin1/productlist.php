<?php
include("../config/conn.php");
include("../config/function.php");
AdminSes_audit();
$sj=date("Y-m-d H:i:s");
$ses=" where zt<>99";
if($_GET[zt]=="1"){$ses=$ses." and zt=1";}
elseif($_GET[zt]=="2"){$ses=$ses." and zt=2";}
if($_GET[st0]!=""){$ses=$ses." and id = ".intval($_GET[st0])."";}
if($_GET[st1]!=""){$ses=$ses." and tit like '%".$_GET[st1]."%'";}
if($_GET[st2]!=""){$ses=$ses." and mybh='".$_GET[st2]."'";}
if($_GET[st3]!=""){$ses=$ses." and userid='".returnuserid($_GET[st3])."'";}
if($_GET[sd1]!=""){$ses=$ses." and ty1id=".$_GET[sd1];}
if($_GET[page]!=""){$page=$_GET[page];}else{$page=1;}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><?=webname?>管理系统</title>
<link href="css/basic.css" rel="stylesheet" type="text/css" />
<link href="css/product.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script language="javascript" src="js/basic.js"></script>
<script language="javascript" src="js/layer.js"></script>
<script language="javascript">
function ser(){
location.href="productlist.php?st0="+document.getElementById("st0").value+"&st1="+document.getElementById("st1").value+"&st3="+document.getElementById("st3").value+"&sd1="+document.getElementById("sd1").value;	
}

</script>
</head>
<body>
<? include("top.php");?>
<script language="javascript">
document.getElementById("menu3").className="a1";
</script>
<? if(!strstr($adminqx,",0,") && !strstr($adminqx,",0102,")){echo "<div class='noneqx'>无权限</div>";exit;}?>

<div class="yjcode">
 <? $leftid=1;include("menu_product.php");?>

<div class="right">
 
 <div class="bqu1">
 <a class="a1" href="productlist.php">商品列表</a>
 </div>
 <!--B-->
 <ul class="psel">
 <li class="l1">宝贝ID：</li><li class="l2"><input value="<?=$_GET[st0]?>" type="text" id="st0" size="15" /></li>
 <li class="l1">宝贝名称：</li><li class="l2"><input value="<?=$_GET[st1]?>" type="text" id="st1" size="15" /></li>
 <li class="l1">宝贝类目：</li>
 <li class="l2">
 <select id="sd1">
 <option value="">==不限==</option>
 <? while1("*","yjcode_type where admin=1 order by xh asc");while($row1=mysql_fetch_array($res1)){?>
 <option value="<?=$row1[id]?>"<? if($_GET[sd1]==$row1[id]){?> selected="selected"<? }?>><?=$row1[type1]?></option>
 <? }?>
 </select>
 </li>
 <li class="l1">发布会员：</li><li class="l2"><input value="<?=$_GET[st3]?>" type="text" id="st3" size="15" /></li>
 <li class="l3"><a href="javascript:ser()" class="a2">搜索</a></li>
 </ul>
 <ul class="ksedi">
 <li class="l2">
 <a href="javascript:checkDEL(12,'yjcode_pro')" class="a2">变更审核</a>
 <a href="javascript:checkDEL(13,'yjcode_pro')" class="a2">上/下架</a>
 <a href="javascript:checkDEL(14,'yjcode_pro')" class="a1">删除</a>
 </li>
 </ul>
 <ul class="productcap">
 <li class="l1"><input name="C2" type="checkbox" onclick="xuan()" /></li>
 <li class="l2">商品名称</li>
 <li class="l3">价格</li>
 <li class="l4">库存</li>
 <li class="l5">销售量</li>
 <li class="l6">最后更新</li>
 <li class="l7">操作</li>
 </ul>
 <?
 pagef($ses,10,"yjcode_pro","order by lastsj desc");while($row=mysql_fetch_array($res)){
 $aurl="product.php?bh=".$row[bh];
 if(0==$row[ifxj]){$xjv="<span class='blue'>上架</span>";}else{$xjv="<span class='red'>已下架</span>";}
 ?>
 <ul class="productlist">
 <li class="l1"><input name="C1" type="checkbox" value="<?=$row[bh]?>" /></li>
 <li class="l2">
 <a href="<?=$aurl?>"><img border="0" class="imgtp" src="<?=returntp("bh='".$row[bh]."' order by xh asc","-2")?>" onerror="this.src='../img/none60x60.gif'" width="52" height="52" align="left" /></a>
 <? if($row[iftj]>0){?><span class="red">推荐<?=$row[iftj]?> </span><? }?>
 <? if(!empty($row[iftuan])){?><span class="red">团购 </span><? }?>
 <a title="<?=$row["tit"]?>" href="<?=$aurl?>" class="a1"><?=returntitdian($row["tit"],43)?></a><br>
 <?=$xjv." | ".returnztv($row[zt],$row[ztsm])."<br>".returntype(1,$row[ty1id])." - ".returntype(2,$row[ty2id])?>
 </li>
 <li class="l3"><strong class="feng"><?=returnjgdian(returnyhmoney($row[yhxs],$row[money2],$row[money3],$sj,$row[yhsj1],$row[yhsj2],$row[id]))?></strong><br><s class="hui">原价<?=returnjgdw($row[money1],"元","暂无")?></s></li>
 <li class="l4"><?=$row[kcnum]?><? if(4==$row[fhxs]){?><br>【<a href="kclist.php?bh=<?=$row[bh]?>" class="blue">管理库存</a>】<? }?></li>
 <li class="l5"><?=$row[xsnum]?></li>
 <li class="l6"><?=$row[lastsj]?></li>
 <li class="l7">
 <a href="<?=$aurl?>">编辑商品</a><span></span>
 <a href="../product/view<?=$row[id]?>.html" target="_blank">预览</a>
 </li>
 </ul>
 <? }?>
 <?
 $nowurl="productlist.php";
 $nowwd="zt=".$_GET[zt]."&st0=".$_GET[st0]."&st1=".$_GET[st1]."&st3=".$_GET[st3]."&sd1=".$_GET[sd1];
 include("page.php");
 ?>
 <!--E-->
 
</div>
</div>
<?php include("bottom.php");?>
</body>
</html>