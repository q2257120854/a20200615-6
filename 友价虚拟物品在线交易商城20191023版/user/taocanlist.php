<?
include("../config/conn.php");
include("../config/function.php");
sesCheck();
$bh=$_GET[bh];
while0("*","yjcode_pro where bh='".$bh."'");if(!$row=mysql_fetch_array($res)){php_toheader("productlist.php");}
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
function glover(x){
 document.getElementById("gl"+x).style.display="";
}
function glout(x){
 document.getElementById("gl"+x).style.display="none";
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
 
 <? include("protop.php");?>
 <? include("rcap3.php");?>
 <script language="javascript">
 document.getElementById("rcap3").className="l1 l2";
 </script>

 <!--白B-->
 <div class="rkuang">
 
 <div class="ksedi">
  <div class="d1">
  <a href="taocanlx.php?bh=<?=$bh?>" class="a1">新增套餐</a>
  <a href="javascript:NcheckDEL(9,'yjcode_taocan')" class="a2">删除</a>
  </div>
 </div>

 <ul class="tccap">
 <li class="l1"><input name="C2" type="checkbox" onclick="xuan()" /></li>
 <li class="l2">套餐说明</li>
 <li class="l3">序号</li>
 <li class="l4">原价</li>
 <li class="l5">优惠价</li>
 <li class="l6">操作&nbsp;</li>
 </ul>
 <?
 while1("*","yjcode_taocan where probh='".$bh."' and userid=".$luserid." and zt=0 and admin is null order by xh asc");while($row1=mysql_fetch_array($res1)){
 $nu="taocan.php?id=".$row1[id]."&bh=".$bh;
 ?>
 <ul class="tclist1" onmouseover="this.className='tclist1 tclist11';" onmouseout="this.className='tclist1';">
 <li class="l1"><input name="C1" type="checkbox" value="<?=$row1[id]?>xcf0" /></li>
 <li class="l2"><a href="<?=$nu?>"><?=$row1[tit]?></a></li>
 <li class="l3"><?=$row1[xh]?></li>
 <li class="l4"><?=$row1[money2]?></li>
 <li class="l5"><?=$row1[money1]?></li>
 <li class="l6" onmouseover="glover(<?=$row1[id]?>)" onmouseout="glout(<?=$row1[id]?>)">
  <span class="s1">管理</span>
  <div class="gl" style="display:none;" id="gl<?=$row1[id]?>">
  <a href="<?=$nu?>">编辑信息</a>
  <a href="taocan1lx.php?ty1id=<?=$row1[id]?>&bh=<?=$bh?>">添加二级</a>
  <? if(4==$row1[fhxs]){?><a href="kclist_tc.php?tcid=<?=$row1[id]?>&bh=<?=$bh?>">库存管理</a><? }?>
  </div>
 </li>
 </ul>
 <?
 while2("*","yjcode_taocan where admin=2 and tit='".$row1[tit]."' and zt=0 and userid=".$luserid." and probh='".$bh."' order by xh asc");while($row2=mysql_fetch_array($res2)){
 $nu="taocan1.php?id=".$row2[id]."&ty1id=".$row1[id]."&bh=".$bh; 
 ?>
 <ul class="tclist2">
 <li class="l1"><input name="C1" type="checkbox" value="xcf<?=$row2[id]?>" /></li>
 <li class="l2"><a href="<?=$nu?>"><?=$row2[tit2]?></a></li>
 <li class="l3"><?=$row2[xh]?></li>
 <li class="l4"><?=$row2[money2]?></li>
 <li class="l5"><?=$row2[money1]?></li>
 <li class="l6" onmouseover="glover(<?=$row2[id]?>)" onmouseout="glout(<?=$row2[id]?>)">
  <span class="s1">管理</span>
  <div class="gl" style="display:none;" id="gl<?=$row2[id]?>">
  <a href="<?=$nu?>">编辑信息</a>
  <? if(4==$row2[fhxs]){?><a href="kclist_tc.php?tcid=<?=$row2[id]?>&bh=<?=$bh?>">库存管理</a><? }?>
  </div>
 </li>
 </ul>
 <? }}?>

 <div class="clear clear10"></div>
 
 </div>
 <!--白E-->

</div> 
<!--RE-->

</div>

<div class="clear clear15"></div>
<? include("../tem/bottom.html");?>
</body>
</html>