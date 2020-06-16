<?
include("../../config/conn.php");
include("../../config/function.php");
sesCheck_m();
$userid=returnuserid($_SESSION[SHOPUSER]);
$sj=date("Y-m-d H:i:s");
if($_GET[control]=="del"){
deletetable("yjcode_shdz where userid=".$userid." and id=".$_GET[id]);
php_toheader("shdzlist.php");
}
?>
<html>
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
<title>会员中心 <?=webname?></title>
<? include("../tem/cssjs.html");?>
<link href="css/buy.css" rel="stylesheet" type="text/css" />
<script language="javascript">
function shdzdel(x){
 if(!confirm("确认删除？")){return false;}
 layer.open({type: 2,content: '正在删除'});
 $.get("shdzdel.php",{id:x},function(result){
 location.reload();
 });
}
</script>
</head>
<body>
<? include("topuser.php");?>

<div class="bfbtop1 box">
 <div class="d1" onClick="gourl('index.php')"><img src="img/topleft.png" height="21" /></div>
 <div class="d2">收货地址</div>
 <div class="d4 red" onClick="gourl('shdzlx.php')">新增</div>
</div>

<? if(panduan("*","yjcode_shdz where zt=0 and userid=".$rowuser[id])==1){?>

<?
if($_GET[page]!=""){$page=$_GET[page];}else{$page=1;}
pagef(" where zt=0 and userid=".$userid,10,"yjcode_shdz","order by sj desc");while($row=mysql_fetch_array($res)){
$addr=returnarea($row[add1])." ".returnarea($row[add2])." ".returnarea($row[add3])." ".$row[addr];
$au="shdz.php?bh=".$row[bh];
?>
<div class="shdzlist box">
 <div class="d1"><?=$row[lxr]?></div>
 <div class="d2"><?=$row[mot]?></div>
 <div class="d3" onClick="shdzdel(<?=$row[id]?>)"><img src="img/cardel.png" height="13" /></div>
 <div class="d3" onClick="gourl('<?=$au?>')"><img src="img/edit.png" height="13" /></div>
</div>
<div class="shdzlist1 box" onClick="gourl('<?=$au?>')">
 <div class="d0"></div>
 <div class="d1"><? if(1==$row[ifmr]){?><span class="red">[默认地址]</span> <? }?><?=$addr?></div>
 <div class="d0"></div>
</div>
<? }?>
<div class="npa">
<?
$nowurl="shdzlist.php";
$nowwd="";
require("page.html");
?>
</div>

<? }else{?>
<div class="wait box" onClick="gourl('shdzlx.php')">
 <div class="d1">
  <span class="s0"><img src="img/shdz.png" width="70" /></span>
  <span class="s1">您还没有添加收货地址</span>
  <span class="s2">添加新地址</span>
 </div>
</div>
<? }?>

</body>
</html>