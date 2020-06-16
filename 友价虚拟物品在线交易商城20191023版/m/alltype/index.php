<?
include("../../config/conn.php");
include("../../config/function.php");
?>
<html>
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="viewport" content="initial-scale=1, width=device-width, maximum-scale=1, user-scalable=no" />
<title>所有分类 - 手机版<?=webname?></title>
<? include("../tem/cssjs.html");?>
<script language="javascript">
function aonc(x){
 al=parseInt(document.getElementById("allnum").innerHTML);
 for(i=1;i<al;i++){
 document.getElementById("lefta"+i).className="";
 document.getElementById("pright"+i).style.display="none";
 }
 document.getElementById("lefta"+x).className="a1";
 document.getElementById("pright"+x).style.display="";
}
</script>
</head>
<body>
<? $nowpagetit="商品分类";include("../tem/moban/".$rowcontrol[wapmb]."/tem/top.php");?>

<div class="pleft" id="pleft">
<? $i=1;while1("*","yjcode_type where admin=1 order by xh asc");while($row1=mysql_fetch_array($res1)){?>
<a href="javascript:void(0);" id="lefta<?=$i?>" onClick="aonc(<?=$i?>)"><?=$row1[type1]?></a>
<? $i++;}?>
</div>
<span id="allnum" style="display:none;"><?=$i?></span>

<? $i=1;while1("*","yjcode_type where admin=1 order by xh asc");while($row1=mysql_fetch_array($res1)){?>
<div class="pright" id="pright<?=$i?>" style="display:none;">
 <? while2("*","yjcode_type where admin=2 and type1='".$row1[type1]."' order by xh asc");while($row2=mysql_fetch_array($res2)){?>
 <div class="d1" onClick="gourl('../product/search_j<?=$row1[id]?>v_k<?=$row2[id]?>v.html')"><img onerror="this.src='img/none.png'" src="../../upload/type/type2_<?=$row2[id]?>_m.png"><br><?=$row2[type2]?></div>
 <? }?>
</div>
<? $i++;}?>

<script language="javascript">
aonc(1);
</script>
</body>
</html>