<?
include("../config/conn.php");
include("../config/function.php");
while1("*","yjcode_tp where bh='".$_GET[bh]."' order by xh asc");while($row1=mysql_fetch_array($res1)){
if(empty($row1[upty])){
 $tp1="../".$row1[tp];
 $tp2="../".str_replace(".","-1.",$row1[tp]);
}else{
 $tp1=$row1[tp];
 $tp2=returnnotp($row1[tp],"-1");
}
?>
<div class="d1">
<a href="<?=$tp1?>" class="a1" target="_blank"><img class="img" border="0" src="<?=$tp2?>" /></a>
<a href="javascript:void(0);" class="a2" onClick="deltp('<?=$row1[id]?>')"><img src="img/delbtn.png" /></a>
</div>
<? }?>
