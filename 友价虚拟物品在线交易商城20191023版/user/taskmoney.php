<?
include("../config/conn.php");
include("../config/function.php");
sesCheck();
$bh=$_GET[bh];
$sqluser="select * from yjcode_user where uid='".$_SESSION[SHOPUSER]."'";mysql_query("SET NAMES 'GBK'");$resuser=mysql_query($sqluser);
if(!$rowuser=mysql_fetch_array($resuser)){php_toheader("../reg/");}
$userid=$rowuser[id];
$sqltask="select * from yjcode_task where bh='".$bh."' and taskty=1 and userid=".$userid." and zt=100";mysql_query("SET NAMES 'GBK'");$restask=mysql_query($sqltask);
if(!$rowtask=mysql_fetch_array($restask)){php_toheader("tasklist1.php");}


if($_GET[control]=="jn"){
 $zjm=0;
 if(empty($rowtask[yjfs])){$zjm=$rowtask[money1]*$rowcontrol[taskyj];}
 elseif($rowtask[yjfs]==2){$zjm=$rowtask[money1]*$rowcontrol[taskyj]*0.5;}
 $money3=$rowtask[money1]+$zjm;
 $djmoney=$money3-$rowtask[money4];
 if($djmoney>$rowuser[money1]){Audit_alert("余额不足，请先充值","taskmoney.php?bh=".$bh);}
 PointIntoM($rowuser[id],"任务开始，冻结金额(任务编号".$bh.")",$djmoney*(-1));
 PointUpdateM($rowuser[id],$djmoney*(-1));
 updatetable("yjcode_task","zt=101,money2=".$rowtask[money1].",money3=".$money3." where id=".$rowtask[id]);
 php_toheader("tasklist1.php");
 
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>用户管理面板 - <?=webname?></title>
<? include("cssjs.html");?>
<link href="css/task.css" rel="stylesheet" type="text/css" />
<script language="javascript">
function tj(){
if(!confirm("确定要缴纳费用吗？")){return false;}
layer.msg('正在处理', {icon: 16  ,time: 0,shade :0.25});
f1.action="taskmoney.php?bh=<?=$bh?>&control=jn";
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
 
 <? include("rcap17.php");?>
 <script language="javascript">
 document.getElementById("rcap2").className="l1 l2";
 </script>

 <!--白B-->
 <div class="rkuang">
 
 <? include("taskv1.php");?>

 <ul class="taskmain">
 <li class="l1">中介费用：</li>
 <li class="l2">
 <? 
 $zjm=0;
 if(empty($rowtask[yjfs])){$zjm=$rowtask[money1]*$rowcontrol[taskyj];echo "雇主承担，费用为<strong class='feng'>￥".$zjm."</strong>";}
 elseif($rowtask[yjfs]==1){echo "接手方承担";}
 elseif($rowtask[yjfs]==2){$zjm=$rowtask[money1]*$rowcontrol[taskyj]*0.5;echo "双方各承担一半，费用为<strong class='feng'>￥".$zjm."</strong>";}
 ?>
 </li>
 <li class="l1">待缴费用：</li>
 <li class="l2"><strong class="feng"><?=sprintf("%.2f",$zjm+$rowtask[money1])?></strong>元</li>
 <li class="l1">我的余额：</li>
 <li class="l2"><strong class="red"><?=sprintf("%.2f",$rowuser[money1])?></strong>元</li>
 </ul>
 <form name="f1" method="post" onsubmit="return tj()">
 <div class="ftjbtn"><? tjbtnr("缴纳费用","taskmoney.php")?></div>
 </form>
 
 <div class="clear clear20"></div>
 </div>
 <!--白E-->

</div> 
<!--RE-->

</div>

<div class="clear clear15"></div>
<? include("../tem/bottom.html");?>
</body>
</html>