<?
include("../../config/conn.php");
include("../../config/function.php");
sesCheck_m();
$sj=date("Y-m-d H:i:s");
$sqluser="select * from yjcode_user where uid='".$_SESSION[SHOPUSER]."' and shopzt=2";mysql_query("SET NAMES 'GBK'");$resuser=mysql_query($sqluser);
if(!$rowuser=mysql_fetch_array($resuser)){php_toheader("openshop3.php");}

$ses=" where zt<>99 and userid=".$rowuser[id];
if($_GET[page]!=""){$page=$_GET[page];}else{$page=1;}
?>
<html>
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
<title>会员中心 <?=webname?></title>
<? include("../tem/cssjs.html");?>
<link href="css/sell.css" rel="stylesheet" type="text/css" />
<script language="javascript">
function shuaxin(x){
document.getElementById("chk"+x).checked=true;
NcheckDEL(7,'yjcode_pro');
}
function del(x){
document.getElementById("chk"+x).checked=true;
NcheckDEL(2,'yjcode_pro');
}
</script>
</head>
<body>
<? include("topuser.php");?>

<div class="bfbtop2 box">
 <div class="d1" onClick="gourl('sell.php')"><img src="img/topleft1.png" height="21" /></div>
 <div class="d2">我的商品(<?=returncount("yjcode_pro".$ses)?>个)</div>
 <div class="d4" onClick="gourl('productlx.php')">发布</div>
</div>

<div class="prots box"><div class="d1">刷新一个商品消耗<strong class="feng"><?=$rowcontrol[sxjf]?></strong>分，您剩余<strong class="blue"><?=$rowuser[jf]?></strong>分 【<a href="jfbank.php">兑换积分</a>】</div></div>

 <!--列表开始-->
 <?
 pagef($ses,10,"yjcode_pro","order by lastsj desc");while($row=mysql_fetch_array($res)){
 $au1="product.php?bh=".$row[bh];
 $au2="../product/view".$row[id].".html";
 if(0==$row[ifxj]){$xjv="&nbsp;";}else{$xjv="<span class='red'>已下架</span>";}
 ?>
 <div class="productlist0 box">
  <div class="d0"><input name="C1" id="chk<?=$row[id]?>" type="checkbox" value="<?=$row[bh]?>" /></div>
  <div class="d1">商品ID:<?=$row[id]?></div>
  <div class="d2"><?=$row[lastsj]?></div>
 </div>
 <div class="productlist1 box" onClick="gourl('<?=$au1?>')">
  <div class="d1"><img src="<?=returntp("bh='".$row[bh]."' order by xh asc","-2")?>" onerror="this.src='../img/none70x70.gif'" width="70" height="70" /></div>
  <div class="d2">
   <span class="s0"><?=$row["tit"]?></span>
   <span class="s1">已售<?=$row[xsnum]?></span><span class="s2">库存<?=$row[kcnum]?></span>
   <span class="s3"><?=returnztv($row[zt],$row[ztsm])?></span>
  </div>
  <div class="d3">￥<?=returnyhmoney($row[yhxs],$row[money2],$row[money3],$sj,$row[yhsj1],$row[yhsj2],$row[id])?></div>
 </div>
 <div class="productlist2 box">
  <div class="d1">
  <a href="<?=$au2?>">预览</a>
  <a href="javascript:void(0);" onClick="del(<?=$row[id]?>)">删除</a>
  <a href="<?=$au1?>">修改</a>
  <a href="javascript:void(0);" onClick="shuaxin(<?=$row[id]?>)">刷新</a>
  </div>
 </div>
 <? }?>
 <!--列表结束-->
 <div class="npa">
 <?
 $nowurl="productlist.php";
 $nowwd="";
 require("page.html");
 ?>
 </div>
 
</body>
</html>