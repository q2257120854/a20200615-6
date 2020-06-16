<?
include("../../config/conn.php");
include("../../config/function.php");
$getstr=$_GET[str];

$ses=" where zt=0 and ifxj=0";
$tit="商品列表";
$ty1id=returnsx("j");
if($ty1id!=-1){
 $sqlty1="select * from yjcode_type where admin=1 and id=".$ty1id;mysql_query("SET NAMES 'GBK'");$resty1=mysql_query($sqlty1);$rowty1=mysql_fetch_array($resty1);
 $ty1name=$rowty1[type1];
 $lastty=$ty1name;
 $ses=$ses." and ty1id=".$ty1id;
 if(empty($rowty1[seotit])){$tit=$ty1name;}else{$tit=$rowty1[seotit];}
 $seokey=$rowty1[seokey];
 $seodes=$rowty1[seodes];
}
$ty2id=returnsx("k");if($ty2id!=-1){$ty2name=returntype(2,$ty2id);$lastty=$ty2name;$ses=$ses." and ty2id=".$ty2id;}
$ty3id=returnsx("m");if($ty3id!=-1){$ty3name=returntype(3,$ty3id);$lastty=$ty3name;$ses=$ses." and ty3id=".$ty3id;}
$ty4id=returnsx("i");if($ty4id!=-1){$ty4name=returntype(4,$ty4id);$lastty=$ty4name;$ses=$ses." and ty4id=".$ty4id;}
$ty5id=returnsx("l");if($ty5id!=-1){$ty5name=returntype(5,$ty5id);$lastty=$ty5name;$ses=$ses." and ty5id=".$ty5id;}
if(returnsx("s")!=-1){
 $skey=safeEncoding(returnsx("s"));
 $a=preg_split("/\s/",$skey);
 $bs="(";
 for($i=0;$i<=count($a);$i++){
 if(!empty($a[$i])){$bs=$bs."tit like '%".$a[$i]."%' and ";}
 }
 $ses=$ses." and ".$bs." tit<>'')";
}

$hydj="会员优惠";
if(returnsx("g")!=-1){
 $ifuserdj=returnsx("g");
 if($ifuserdj==1){
 $hydj="已参与等级优惠";
 $ses=$ses." and ifuserdj=1";
 }elseif($ifuserdj==2){
 $hydj="未参与等级优惠";
 $ses=$ses." and ifuserdj=0";
 }
}

if(returnsx("p")!=-1){$page=returnsx("p");}else{$page=1;}
$px="order by lastsj desc";
$pxsm="排序方式";
$pxv=returnsx("f");
$pxvarr=array("默认排序","按更新时间","销量从高到低","销量从低到高","关注从高到低","关注从低到高","价格从高到低","价格从低到高");
if($pxv==1){$px="order by lastsj asc";$pxsm=$pxvarr[1];}
elseif($pxv==2){$px="order by xsnum desc";$pxsm=$pxvarr[2];}
elseif($pxv==3){$px="order by xsnum asc";$pxsm=$pxvarr[3];}
elseif($pxv==4){$px="order by djl desc";$pxsm=$pxvarr[4];}
elseif($pxv==5){$px="order by djl asc";$pxsm=$pxvarr[5];}
elseif($pxv==6){$px="order by money2 desc";$pxsm=$pxvarr[6];}
elseif($pxv==7){$px="order by money2 asc";$pxsm=$pxvarr[7];}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
<meta name="keywords" content="<?=$seokey?>">
<meta name="description" content="<?=$seodes?>">
<title><?=$tit?> - <?=webname?></title>
<? include("../tem/cssjs.html");?>
</head>
<body>
<!--头部B-->
<div class="topfix">

<div class="glotop box">
 <div class="d1" onClick="javascript:history.go(-1);"><img src="../img/back-vector.png" height="20" /></div>
 <div class="d2">商品列表</div>
 <div class="d4"><a href="search_j<?=$ty1id?>v.html">重置</a></div>
</div>

<div class="listtop box">
 <div class="d1" onClick="gourl('../search/main.php')"><span class="s1"><img src="../img/ser.png" /></span><span class="s2"><?=returnjgdw($skey,"","请输入搜索关键词！")?></span></div>
</div>

<!--选择1B-->
<div class="psel box">
 <div class="search">
 
  <div class="d1" onClick="sertjonc(1,3)"><span class="s1"><span><?=returnjgdw($lastty,"","全部分类")?></span></span></div>
  <div class="d1" onClick="sertjonc(2,3)"><span class="s1"><span><?=$pxsm?></span></span></div>
  <div class="d1 d0" onClick="sertjonc(3,3)"><span class="s1"><span><?=$hydj?></span></span></div>
 
 </div>
</div>
<!--选择1E-->

</div>
<div class="ntopv box"><div class="d1"></div></div>
<!--头部E-->

<!--选择2B-->
<div class="sertj box" id="sertj1" style="display:none;">

 <? if($ty2id==-1){?>
 <div class="d1">
 <a href="search.html"<? if($ty1id==-1){?> class="nx"<? }?>>不限</a>
 <? while1("*","yjcode_type where admin=1 order by xh asc");while($row1=mysql_fetch_array($res1)){?>
 <a href="search_j<?=$row1[id]?>v.html" <? if(check_in("_j".$row1[id]."v",$getstr)){?> class="nx"<? }?>><?=$row1[type1]?></a>
 <? }?>
 </div>
 <? }?>
 
 <? if($ty1id!=-1 && $ty3id==-1){?>
 <div class="d1">
 <a href="search_j<?=$ty1id?>v.html"<? if($ty2id==-1){?> class="nx"<? }?>>不限</a>
 <? while2("*","yjcode_type where admin=2 and type1='".$ty1name."' order by xh asc");while($row2=mysql_fetch_array($res2)){?>
 <a href="search_j<?=$ty1id?>v_k<?=$row2[id]?>v.html" <? if(check_in("_k".$row2[id]."v",$getstr)){?> class="nx"<? }?>><?=$row2[type2]?></a>
 <? }?>
 </div>
 <? }?>
 
 <? if($ty2id!=-1 && $ty4id==-1){?>
 <div class="d1">
 <a href="search_j<?=$ty1id?>v_k<?=$ty2id?>v.html"<? if($ty3id==-1){?> class="nx"<? }?>>不限</a>
 <? while3("*","yjcode_type where admin=3 and type1='".$ty1name."' and type2='".$ty2name."' order by xh asc");while($row3=mysql_fetch_array($res3)){?>
 <a href="search_j<?=$ty1id?>v_k<?=$ty2id?>v_m<?=$row3[id]?>v.html" <? if(check_in("_m".$row3[id]."v",$getstr)){?> class="nx"<? }?>><?=$row3[type3]?></a>
 <? }?>
 </div>
 <? }?>
 
 <? if($ty3id!=-1 && $ty5id==-1){?>
 <div class="d1">
 <a href="search_j<?=$ty1id?>v_k<?=$ty2id?>v_m<?=$ty3id?>v.html"<? if($ty4id==-1){?> class="nx"<? }?>>不限</a>
 <? while3("*","yjcode_type where admin=4 and type1='".$ty1name."' and type2='".$ty2name."' and type3='".$ty3name."' order by xh asc");while($row3=mysql_fetch_array($res3)){?>
 <a href="search_j<?=$ty1id?>v_k<?=$ty2id?>v_m<?=$ty3id?>v_i<?=$row3[id]?>v.html" <? if(check_in("_i".$row3[id]."v",$getstr)){?> class="nx"<? }?>><?=$row3[type4]?></a>
 <? }?>
 </div>
 <? }?>
 
 <? if($ty4id!=-1){?>
 <div class="d1">
 <a href="search_j<?=$ty1id?>v_k<?=$ty2id?>v_m<?=$ty3id?>v_i<?=$ty4id?>v.html"<? if($ty5id==-1){?> class="nx"<? }?>>不限</a>
 <? while3("*","yjcode_type where admin=5 and type1='".$ty1name."' and type2='".$ty2name."' and type3='".$ty3name."' and type4='".$ty4name."' order by xh asc");while($row3=mysql_fetch_array($res3)){?>
 <a href="search_j<?=$ty1id?>v_k<?=$ty2id?>v_m<?=$ty3id?>v_i<?=$ty4id?>v_l<?=$row3[id]?>v.html" <? if(check_in("_l".$row3[id]."v",$getstr)){?> class="nx"<? }?>><?=$row3[type5]?></a>
 <? }?>
 </div>
 <? }?>
 
</div>
<div class="sertj box" id="sertj2" style="display:none;">
 <div class="d1">
 <a href="<?=rentser('f','','','');?>" <? if(check_in("_fv",$getstr) || !check_in("_f",$getstr)){?> class="nx"<? }?>>不限</a>
 <? for($i=1;$i<=7;$i++){?>
 <a href="<?=rentser('f',$i,'','');?>" <? if(check_in("_f".$i."v",$getstr)){?> class="nx"<? }?>><?=$pxvarr[$i]?></a>
 <? }?>
 </div>
</div>
<div class="sertj box" id="sertj3" style="display:none;">
 <div class="d1">
 <a href="<?=rentser('g','','','');?>" <? if(check_in("_gv",$getstr) || !check_in("_g",$getstr)){?> class="nx"<? }?>>不限</a>
 <a href="<?=rentser('g',1,'','');?>" <? if(check_in("_g1v",$getstr)){?> class="nx"<? }?>>有优惠</a>
 <a href="<?=rentser('g',2,'','');?>" <? if(check_in("_g2v",$getstr)){?> class="nx"<? }?>>无优惠</a>
 </div>
</div>
<!--选择2E-->

<? 
pagef($ses,10,"yjcode_pro",$px);while($row=mysql_fetch_array($res)){
$tp=returntp("bh='".$row[bh]."' order by xh asc","-2");
$au="view".$row[id].".html";
$sqlsell="select * from yjcode_user where id=".$row[userid];mysql_query("SET NAMES 'GBK'");$ressell=mysql_query($sqlsell);$rowsell=mysql_fetch_array($ressell);
?>
<div class="list1 box">
 <div class="d1"><span class="s0"><img src="img/shop.png" width="14" /></span><span class="s1"><?=$rowsell[shopname]?></span></div>
 <div class="d2"><? if($row[fhxs]==2 || $row[fhxs]==3 || $row[fhxs]==4){echo "[自动发货]";}?></div>
</div>
<div class="list2 box" onclick="gourl('<?=$au?>')">
 <div class="d1"><img border="0" src="<?=$tp?>" onerror="this.src='../img/none70x70.gif'" width="80" height="80" /></div>
 <div class="d2">
  <a href="<?=$au?>" class="a1"><?=$row[tit]?></a>
  <div class="dn1">
  <? if($rowsell[baomoney]>0){?>
  <span class="s2">已缴保证金</span>
  <? }?>
  </div>
  <div class="dn2">￥<strong><?=returnjgdian(returnyhmoney($row[yhxs],$row[money2],$row[money3],$sj,$row[yhsj1],$row[yhsj2],$row[id]))?></strong></div>
 </div>
</div>
<? }?>

<div class="npa">
<?
$nowurl="search";
$nowwd="";
require("../tem/page.html");
?>
</div>

<? include("../tem/moban/".$rowcontrol[wapmb]."/tem/bottom.php");?>
</body>
</html>