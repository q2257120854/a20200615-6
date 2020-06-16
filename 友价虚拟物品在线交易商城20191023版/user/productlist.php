<?
include("../config/conn.php");
include("../config/function.php");
sesCheck();
$sj=date("Y-m-d H:i:s");
$sqluser="select * from yjcode_user where uid='".$_SESSION[SHOPUSER]."' and shopzt=2";mysql_query("SET NAMES 'GBK'");$resuser=mysql_query($sqluser);
if(!$rowuser=mysql_fetch_array($resuser)){php_toheader("openshop3.php");}
$ncapv=1;
$ses=" where zt<>99 and userid=".$rowuser[id];
if($_GET[zt]=="1"){$ses=$ses." and zt=1";}
elseif($_GET[zt]=="2"){$ses=$ses." and zt=2";}
if($_GET[t1v]!=""){$ses=$ses." and tit like '%".$_GET[t1v]."%'";}
$t2v=$_GET[t2v];if(is_numeric($t2v)){$ses=$ses." and id=".$t2v;}
$t3v=$_GET[t3v];if(is_numeric($t3v)){$ses=$ses." and money2>=".$t3v."";}
$t4v=$_GET[t4v];if(is_numeric($t4v)){$ses=$ses." and money2<=".$t4v."";}
$t5v=$_GET[t5v];if(is_numeric($t5v)){$ses=$ses." and xsnum>=".$t5v."";}
$t6v=$_GET[t6v];if(is_numeric($t6v)){$ses=$ses." and xsnum<=".$t6v."";}
$t7v=$_GET[t7v];if(is_numeric($t7v)){$ses=$ses." and kcnum>=".$t7v."";}
$t8v=$_GET[t8v];if(is_numeric($t8v)){$ses=$ses." and kcnum<=".$t8v."";}
if($_GET[sd1v]!=""){$ses=$ses." and ty1id=".$_GET[sd1v]."";}
if($_GET[ifxj]=="1"){$ses=$ses." and ifxj=1";$ncapv=3;}
if($_GET[page]!=""){$page=$_GET[page];}else{$page=1;}
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
function psel(){
 str="t1v="+document.getElementById("t1").value;
 str=str+"&t2v="+document.getElementById("t2").value;
 str=str+"&t3v="+document.getElementById("t3").value;
 str=str+"&t4v="+document.getElementById("t4").value;
 str=str+"&t5v="+document.getElementById("t5").value;
 str=str+"&t6v="+document.getElementById("t6").value;
 str=str+"&t7v="+document.getElementById("t7").value;
 str=str+"&t8v="+document.getElementById("t8").value;
 str=str+"&sd1v="+document.getElementById("sd1").value;
 location.href="productlist.php?"+str;
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
 
 <!--搜索B-->
 <div class="prosel">
 <ul class="u1">
 <li class="l1">宝贝名称：</li>
 <li class="l2"><input type="text" value="<?=$_GET[t1v]?>" id="t1" class="inp" style="width:194px;" /></li>
 <li class="l1">宝贝ID：</li>
 <li class="l2"><input type="text" value="<?=$_GET[t2v]?>" id="t2" class="inp" style="width:194px;"/></li>
 <li class="l1">宝贝类目：</li>
 <li class="l2">
 <select id="sd1"class="inp" >
 <option value="">不限</option>
 <? while1("*","yjcode_type where admin=1 order by xh asc");while($row1=mysql_fetch_array($res1)){?>
 <option value="<?=$row1[id]?>"<? if($row1[id]==$_GET[sd1v]){?> selected="selected"<? }?>><?=$row1[type1]?></option>
 <? }?>
 </select>
 </li>
 <li class="l1">价格：</li>
 <li class="l2"><input type="text" class="inp" value="<?=$_GET[t3v]?>" style="width:80px;" id="t3" /><span class="fd">到</span><input type="text" class="inp" value="<?=$_GET[t4v]?>" style="width:80px;" id="t4"/></li>
 <li class="l1">总销量：</li>
 <li class="l2"><input type="text" class="inp" value="<?=$_GET[t5v]?>" style="width:80px;" id="t5"/><span class="fd">到</span><input type="text" class="inp" value="<?=$_GET[t6v]?>" style="width:80px;" id="t6"/></li>
 <li class="l1">库存量：</li>
 <li class="l2"><input type="text" class="inp" value="<?=$_GET[t7v]?>" style="width:80px;" id="t7"/><span class="fd">到</span><input type="text" class="inp" value="<?=$_GET[t8v]?>" style="width:80px;" id="t8"/></li>
 <li class="ltj"><input type="button" onclick="psel()" class="bt1" value="搜索" /> <input type="button" onclick="gourl('productlist.php')" class="bt2" value="重置" /></li>
 </ul>
 </div>
 <!--搜索E-->

 <!--白B-->
 <div class="rkuang">
 
  <ul class="procz">
  <li class="l1"><label><input name="C2" type="checkbox" onclick="xuan()" /> 全选</label></li>
  <li class="l2">
  <a href="javascript:void(0);" onclick="NcheckDEL(1,'yjcode_pro')" class="a1">批量上/下架</a>
  <a href="javascript:void(0);" onclick="NcheckDEL(2,'yjcode_pro')" class="a1">删除选中</a>
  <a href="javascript:void(0);" onclick="NcheckDEL(7,'yjcode_pro')" class="a1">更新商品</a>
  <span class="fd">说明：更新一个商品将消耗<strong class="feng"><?=$rowcontrol[sxjf]?></strong>积分，您剩余<strong class="blue"><?=$rowuser[jf]?></strong>积分 【<a href="jfbank.php">兑换积分</a>】</span>
  </li>
  <li class="l3"><a href="productlx.php">+添加新商品</a></li>
  </ul>
  <ul class="prou1">
  <li class="l1">商品信息(共找到<?=returncount("yjcode_pro".$ses)?>个)</li>
  <li class="l2">售价(元)</li>
  <li class="l3">库存</li>
  <li class="l4">销量</li>
  <li class="l5">最近更新</li>
  <li class="l6">操作</li>
  </ul>
  <?
  pagef($ses,10,"yjcode_pro","order by lastsj desc");while($row=mysql_fetch_array($res)){
  $au1="product.php?bh=".$row[bh];
  $au2="../product/view".$row[id].".html";
  if(0==$row[ifxj]){$xjv="&nbsp;";}else{$xjv="<span class='red'>已下架</span>";}
  ?>
  <ul class="prou2">
  <li class="l1"><input name="C1" type="checkbox" value="<?=$row[bh]?>" /></li>
  <li class="l2">
  商品编码：<?=$row[bh]?>&nbsp;&nbsp;&nbsp;&nbsp;
  所属类目：<?=returntype(1,$row[ty1id])." - ".returntype(2,$row[ty2id])?>
  </li>
  <li class="l3"><?=$xjv?></li>
  <li class="l4">
  <a href="<?=$au2?>" target="_blank"><img border="0" src="<?=returntp("bh='".$row[bh]."' order by xh asc","-2")?>" onerror="this.src='img/none60x60.gif'" /></a>
  </li>
  <li class="l5"><a href="<?=$au2?>" target="_blank" class="a1"><?=returntitdian($row["tit"],75)?></a><br><?=returnztv($row[zt],$row[ztsm])?></li>
  <li class="l6">
  <strong class="feng"><?=returnyhmoney($row[yhxs],$row[money2],$row[money3],$sj,$row[yhsj1],$row[yhsj2],$row[id])?>元</strong><br>
  <s class="hui">原价<?=returnjgdw($row[money1],"元","暂无")?></s>
  </li>
  <li class="l7">
  <? if(4==$row[fhxs]){?><?=$row[kcnum]?><br>【<a href="kclist.php?bh=<?=$row[bh]?>" class="blue">管理库存</a>】<? }else{?>
  <?=$row[kcnum]?>
  <? }?>
  </li>
  <li class="l8"><?=$row[xsnum]?></li>
  <li class="l9"><?=$row[lastsj]?></li>
  <li class="l10">
  <a href="<?=$au1?>" class="a1">修改</a>
  <a href="<?=$au2?>" target="_blank" class="a2">预览</a>
  </li>
  </ul>
  <? }?>
  <?
  $nowurl="productlist.php";
  $nowwd="zt=".$_GET[zt]."&t1v=".$_GET[t1v]."&t2v=".$_GET[t2v]."&t3v=".$_GET[t3v]."&t4v=".$_GET[t4v]."&t5v=".$_GET[t5v]."&t6v=".$_GET[t6v]."&t7v=".$_GET[t7v]."&t8v=".$_GET[t8v]."&sd1v=".$_GET[sd1]."&ifxj=".$_GET[ifxj];
  include("page.php");
  ?>
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