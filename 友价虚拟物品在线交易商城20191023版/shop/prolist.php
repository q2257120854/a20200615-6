<?
include("../config/conn.php");
include("../config/function.php");
include("../config/xy.php");
$sj=date("Y-m-d H:i:s");
$getstr=$_GET[str];

$uid=returnsx("i");
$sqluser="select * from yjcode_user where zt=1 and shopzt=2 and id=".$uid;mysql_query("SET NAMES 'GBK'");$resuser=mysql_query($sqluser);
if(!$rowuser=mysql_fetch_array($resuser)){php_toheader("./");}

$ses=" where zt=0 and ifxj=0 and userid=".$uid;
$ty1id=returnsx("j");
$ty2id=returnsx("k");
if($ty1id!=-1){$ses=$ses." and myty1id=".$ty1id;$name1=returntypem(1,$ty1id);}
if($ty2id!=-1){$ses=$ses." and myty2id=".$ty2id;}

if(returnsx("s")!=-1){
 $skey=safeEncoding(returnsx("s"));
 $a=preg_split("/\s/",$skey);
 $bs="(";
 for($i=0;$i<=count($a);$i++){
 if(!empty($a[$i])){$bs=$bs."tit like '%".$a[$i]."%' and ";}
 }
 $ses=$ses." and ".$bs." tit<>'')";
}

if(returnsx("p")!=-1){$page=returnsx("p");}else{$page=1;}

$orderpx="order by lastsj desc";
$f=intval(returnsx("f"));
if($f==1){$orderpx="order by xsnum asc";}
elseif($f==11){$orderpx="order by xsnum desc";}
elseif($f==2){$orderpx="order by pf1 asc";}
elseif($f==21){$orderpx="order by pf1 desc";}
elseif($f==3){$orderpx="order by money2 asc";}
elseif($f==31){$orderpx="order by money2 desc";}
elseif($f==4){$orderpx="order by lastsj asc";}
elseif($f==41){$orderpx="order by lastsj desc";}

$nserU="prolist";
?>
<html>
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><?=$rowuser[shopname]?>的网上店铺 - <?=webname?></title>
<? include("../tem/cssjs.html");?>
<link href="shop.css" rel="stylesheet" type="text/css" />
</head>
<body>
<? include("top.php");?>
<script language="javascript">
document.getElementById("shopmenu2").className="a1";
</script>

<div class="yjcode">

 <!--B-->
 <div class="psel fontyh">
 <ul class="u2">
 <li class="l1">选择商品：</li>
 <li class="l2">
 <a href="prolist_i<?=$rowuser[id]?>v.html"<? if($ty1id==-1){?> class="ax"<? }?>>不限</a>
 </li>
 <li class="l3">
 <? while1("*","yjcode_protype where admin=1 and zt=0 and userid=".$rowuser[id]." order by xh asc");while($row1=mysql_fetch_array($res1)){?>
 <a href="prolist_i<?=$rowuser[id]?>v_j<?=$row1[id]?>v.html" <? if(check_in("_j".$row1[id]."v",$getstr)){?> class="ax"<? }?>><?=$row1[name1]?></a>
 <? }?>
 </li>
 </ul>
 
 <? if($ty1id!=-1){?>
 <ul class="u2">
 <li class="l1"><?=$name1?>：</li>
 <li class="l2">
 <a href="<?=rentser('k','','','',$nserU);?>"<? if($ty2id==-1){?> class="ax"<? }?>>不限</a>
 </li>
 <li class="l3">
 <? while1("*","yjcode_protype where admin=2 and name1='".$name1."' and zt=0 and userid=".$rowuser[id]." order by xh asc");while($row1=mysql_fetch_array($res1)){?>
 <a href="prolist_i<?=$rowuser[id]?>v_j<?=$ty1id?>v_k<?=$row1[id]?>v.html" <? if(check_in("_k".$row1[id]."v",$getstr)){$name2=$row1[name2];?> class="ax"<? }?>><?=$row1[name2]?></a>
 <? }?>
 </li>
 </ul>
 <? }?>
 </div>
 
 
 <!--已选条件B-->
 <div class="nser fontyh">
 <ul class="u1">
 <li class="l1">已选条件：</li>
 <li class="l2">
 <? if($ty1id!=-1){?>
 <span class="s1" onMouseOver="this.className='s2';" onMouseOut="this.className='s1';"><a title="取消" href="<?=rentser('j','','k','',$nserU);?>"><?=$name1?></a></span>
 <? }?>
 
 <? if($ty2id!=-1){?>
 <span class="s1" onMouseOver="this.className='s2';" onMouseOut="this.className='s1';"><a title="取消" href="<?=rentser('k','','','',$nserU);?>"><?=$name2?></a></span>
 <? }?>
 </li>
 </ul>
 </div>
 <!--已选条件E--> 
 
 <!--排序B 1向上有色 11向下有色 a1向上有色 a2向下有色 a3向下无色-->
 <div class="paixu fontyh">
  <div class="d1">
  <a href="<?=rentser("f",'','','',$nserU);?>" <? if(returnsx("f")==-1){?> class="a4"<? }?>>综合</a>
  
  <? if(returnsx("f")==1){?>
  <a href="<?=rentser("f",11,'','',$nserU);?>" class="a1">成交量</a>
  <? }elseif(returnsx("f")==11){?>
  <a href="<?=rentser("f",1,'','',$nserU);?>" class="a2">成交量</a>
  <? }else{?>
  <a href="<?=rentser("f",1,'','',$nserU);?>" class="a3">成交量</a>
  <? }?>
  
  <? if(returnsx("f")==2){?>
  <a href="<?=rentser("f",21,'','',$nserU);?>" class="a1">评分</a>
  <? }elseif(returnsx("f")==21){?>
  <a href="<?=rentser("f",2,'','',$nserU);?>" class="a2">评分</a>
  <? }else{?>
  <a href="<?=rentser("f",2,'','',$nserU);?>" class="a3">评分</a>
  <? }?>
  
  <? if(returnsx("f")==3){?>
  <a href="<?=rentser("f",31,'','',$nserU);?>" class="a1">价格</a>
  <? }elseif(returnsx("f")==31){?>
  <a href="<?=rentser("f",3,'','',$nserU);?>" class="a2">价格</a>
  <? }else{?>
  <a href="<?=rentser("f",3,'','',$nserU);?>" class="a3">价格</a>
  <? }?>
  
  <? if(returnsx("f")==4){?>
  <a href="<?=rentser("f",41,'','',$nserU);?>" class="a1">最新</a>
  <? }elseif(returnsx("f")==41){?>
  <a href="<?=rentser("f",4,'','',$nserU);?>" class="a2">最新</a>
  <? }else{?>
  <a href="<?=rentser("f",4,'','',$nserU);?>" class="a3">最新</a>
  <? }?>
  
  </div>
  <div class="d2">
  <form name="f1" onSubmit="return ser(<?=$rowuser[id]?>)" method="post">
  <ul class="slistsea"> 
  <li class="l1"><input name="t1" type="text"  autocomplete="off" disableautocomplete value="<?=$skey?>" /></li>
  <li class="l2"><input type="image" src="img/ser.gif" /></li>
  </ul>
  </form>
  </div>
 </div>
 <!--排序E-->
 
 <div class="prlist">
 <? 
 $i=1;
 pagef($ses,20,"yjcode_pro",$orderpx);while($row=mysql_fetch_array($res)){
 $au="../product/view".$row[id].".html";
 $tp=returntp("bh='".$row[bh]."' order by iffm desc","-2");
 ?>
 <ul class="u2<? if($i % 5==0){echo " u21";}?>">
 <li class="l1"><a href="<?=$au?>" target="_blank"><img border="0" title="<?=$row[tit]?>"  src="<?=$tp?>" onerror="this.src='../img/none180x180.gif'" width="190" height="180" /></a></li>
 <li class="l2"><strong>￥<?=returnjgdian(returnyhmoney($row[yhxs],$row[money2],$row[money3],$sj,$row[yhsj1],$row[yhsj2],$row[id]))?></strong></li>
 <li class="l3"><a href="<?=$au?>" target="_blank" title="<?=$row[tit]?>"><?=strgb2312($row[tit],0,50)?></a></li>
 <li class="l4">成交：<?=$row[xsnum]?>次</li>
 <li class="l5"><a href="<?=$au?>" target="_blank">立即购买</a></li>
 </ul>
 <? $i++;}?>
  
 <div class="npa">
 <?
 $nowurl="prolist";
 $nowwd="";
 require("../tem/page.html");
 ?>
 </div>
  
 </div>
 <!--E-->

</div>

<? include("../tem/bottom.html");?>
</body>
</html>