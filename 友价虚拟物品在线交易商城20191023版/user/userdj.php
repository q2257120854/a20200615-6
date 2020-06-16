<?
include("../config/conn.php");
include("../config/function.php");
sesCheck();

$sj=date("Y-m-d H:i:s");
$sqluser="select * from yjcode_user where uid='".$_SESSION[SHOPUSER]."'";mysql_query("SET NAMES 'GBK'");$resuser=mysql_query($sqluser);
if(!$rowuser=mysql_fetch_array($resuser)){php_toheader("../reg/");}
$userdj=returnuserdj($rowuser[id]);
$nowdj=0;
if(empty($userdj)){Audit_alert("本站未启用会员等级系统，请联系客服！","./");}

if($_GET[control]=="xf"){ //续费
 while1("*","yjcode_userdj where name1='".$userdj."'");if($row1=mysql_fetch_array($res1)){
 if($rowuser[money1]<$row1[money1]){Audit_alert("余额不足，请先充值！","userdj.php");}
 $money1=$row1["money1"]*(-1);
 PointUpdateM($rowuser[id],$money1); 
 PointIntoM($rowuser[id],$row1[name1]."会员等级费用支出(续费)",$money1);
 if(empty($rowuser[userdjdq])){$dq=$sj;}else{
  $sjv=$rowuser[userdjdq];
  if($rowuser[userdjdq]<$sj){$sjv=$sj;}
  if(empty($row1[jgdw])){$ds="month";}else{$ds="year";}
  $dq=date('Y-m-d H:i:s',strtotime ("+1 ".$ds,strtotime($sjv)));
 }
 updatetable("yjcode_user","userdjdq='".$dq."' where id=".$rowuser[id]);
 }
 php_toheader("userdj.php?t=suc");
 
}elseif($_GET[control]=="ts"){ //提升等级
 while2("*","yjcode_userdj where name1='".$userdj."'");$row2=mysql_fetch_array($res2);
 while1("*","yjcode_userdj where id=".$_GET[id]);if($row1=mysql_fetch_array($res1)){
 
 /*
 if(empty($row2[jgdw])){$nt=$row2[money1]/30;}else{$nt=$row2[money1]/365;}
 if(empty($row1[jgdw])){$st=$row1[money1]/30;}else{$st=$row1[money1]/365;}
 $sjc=DateDiff($dq,$sj,"d");
 $djcj=$st-$nt;
 $cj=intval($djcj*$sjc);
 */
 if(empty($row1[jgdw])){$ts="month";}else{$ts="year";}
 if(empty($rowuser[userdjdq]) || $rowuser[userdjdq]<$sj){$ndq=$sj;}else{$ndq=$rowuser[userdjdq];}
 $dq=date('Y-m-d H:i:s',strtotime ("+1 ".$ts,strtotime($ndq)));

 if($rowuser[money1]<$row1[money1]){Audit_alert("余额不足，请先充值！","userdj.php");}
 $money1=$row1[money1]*(-1);
 PointUpdateM($rowuser[id],$money1); 
 PointIntoM($rowuser[id],"会员等级提升",$money1);
 updatetable("yjcode_user","userdj='".$row1[name1]."',userdjdq='".$dq."' where id=".$rowuser[id]);
 }
 php_toheader("userdj.php?t=suc");

}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>用户管理面板 - <?=webname?></title>
<? include("cssjs.html");?>
<link href="css/inf.css" rel="stylesheet" type="text/css" />
<script language="javascript">
function tj(x,y){
 if(confirm("确定提交吗？")){}else{return false;}
 layer.msg('正在处理数据，请稍候', {icon: 16  ,time: 0,shade :0.25});
 location.href="userdj.php?id="+y+"&control="+x;
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
 
 <ul class="wz">
 <li class="l1 l2"><a href="userdj.php">会员等级</a></li>
 </ul>

 <!--白B-->
 <div class="rkuang">
 
 <? systs("恭喜您，操作成功!","userdj.php")?>
 <ul class="uk">
 <li class="l1">您的等级：</li>
 <li class="l21"><strong class="green"><?=$userdj?></strong> (到期：<?=returnjgdw($rowuser[userdjdq],"","永久不到期")?>)</li>
 <li class="l1">您的余额：</li>
 <li class="l21"><?=sprintf("%.2f",$rowuser[money1])?>元  [<a href="pay.php" class="red"><strong>充值</strong></a>]</li>
 </ul>

 <ul class="djcap">
 <li class="l1">会员等级</li>
 <li class="l2">尊享服务</li>
 <li class="l3">续费费用 </li>
 <li class="l4">操作</li>
 </ul>
 <? 
 while2("*","yjcode_userdj where name1='".$userdj."'");if($row2=mysql_fetch_array($res2)){$nowdj=$row2[xh];}
 if(empty($rowuser[userdjdq]) || $rowuser[userdjdq]<$sj){$dq=date('Y-m-d H:i:s',strtotime ("+1 month",strtotime($sj)));}else{$dq=$rowuser[userdjdq];}
 while1("*","yjcode_userdj where zt=0 order by xh asc");while($row1=mysql_fetch_array($res1)){
 ?>
 <ul class="djlist">
 <li class="l1"><?=$row1[name1]?></li>
 <li class="l2">购买会员商品享<strong><?=$row1[zhekou]?></strong>折</li>
 <li class="l3"><?=$row1[money1]?>元/<? if(empty($row1[jgdw])){echo "月";}else{echo "年";}?> </li>
 <li class="l4">
 <? if($nowdj<$row1[xh]){?>
 <a href="javascript:void(0);" onclick="tj('ts',<?=$row1[id]?>)" class="a0">提升等级</a>
 <span class="s1" style="display:none;">
 补差价:<? 
 if(empty($row2[jgdw])){$nt=$row2[money1]/30;}else{$nt=$row2[money1]/365;}
 if(empty($row1[jgdw])){$st=$row1[money1]/30;}else{$st=$row1[money1]/365;}
 $sjc=DateDiff($dq,$sj,"d");
 $djcj=$st-$nt;
 $cj=intval($djcj*$sjc);
 echo $cj;
 ?>元
 </span>
 <? }elseif($nowdj==$row1[id]){?>
 <a href="javascript:void(0);" onclick="tj('xf',<?=$row1[id]?>)" class="a1">续费</a>
 <? }?>
 </li>
 </ul>
 <? }?>
 
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