<?
include("../../config/conn.php");
include("../../config/function.php");
sesCheck_m();

if($_GET[control]=="del"){
 $Month = 864000 + time();
 setcookie(prohistoy,"", $Month,'/');
 $nch=$_COOKIE['prohistoy'];
 php_toheader("prohis.php");
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
function delprohis(){
if(!confirm("确定要清空浏览记录吗？")){return false;}
layer.open({type: 2,content: '正在处理',shadeClose:false});
location.href="prohis.php?control=del";
}
</script>
</head>
<body>
<div class="bfbtop1 box">
 <div class="d1" onClick="gourl('index.php')"><img src="img/topleft.png" height="21" /></div>
 <div class="d2">浏览记录</div>
 <div class="d4 red" onClick="delprohis()">清空</div>
</div>

 <? 
 $nch="";
 if(isset($_COOKIE['prohistoy'])){
 $nch=$_COOKIE['prohistoy'];
 $a=preg_split("/xcf/",$nch);
 for($i=0;$i<=count($a);$i++){
 if($a[$i]!=""){
  while1("*","yjcode_pro where id=".$a[$i]);if($row1=mysql_fetch_array($res1)){$tp=returntp("bh='".$row1[bh]."' order by xh asc","-2");
 ?>
 <div class="prohis box" onClick="gourl('../product/view<?=$row1[id]?>.html')">
  <div class="d1"><img src="<?=$tp?>" onerror="this.src='../img/none70x70.gif'" width="50" height="50"></div>
  <div class="d2"><?=$row1[tit]?></a><br><strong class="feng">￥<?=returnjgdian(returnyhmoney($row1[yhxs],$row1[money2],$row1[money3],$sj,$row1[yhsj1],$row1[yhsj2],$row1[id]))?></strong></div>
 </div>
 <? }}}
 ?>

<? }else{?>
<!--无B-->
<div class="wait box" onClick="gourl('../')">
 <div class="d1">
  <span class="s0"><img src="img/proser.png" width="70" /></span>
  <span class="s1">还没有商品浏览记录</span>
  <span class="s2">随便逛逛吧^_^</span>
 </div>
</div>
<!--无E-->
<? }?>

</body>
</html>