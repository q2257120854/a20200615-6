<?
include("../config/conn.php");
include("../config/function.php");
sesCheck();

$sqluser="select * from yjcode_user where uid='".$_SESSION[SHOPUSER]."'";mysql_query("SET NAMES 'utf8'");$resuser=mysql_query($sqluser);
if(!$rowuser=mysql_fetch_array($resuser)){php_toheader(gloweb);}

$ordering=returncount("yjcode_order where selluserid=".$rowuser[id]." and (ddzt='wait' or ddzt='db' or ddzt='back' or ddzt='backerr' or ddzt='jf')");

//入库操作开始
if($_POST[jvs]=="bao"){
 zwzr();
 if($ordering>0){Audit_alert("操作失败，因为有订单未处理","baomoney2.php");}
 $t1=floatval($_POST[t1]);
 if($t1>$rowuser[baomoney]){Audit_alert("可用保证金不足","baomoney2.php");}
 if($t1<=0){Audit_alert("未知错误","baomoney1.php");}
 PointIntoB($rowuser[id],"解冻保证金",$t1*(-1),0,1);
 PointUpdateB($rowuser[id],$t1*(-1)); 
 php_toheader("baomoney2.php?t=suc");
}
//入库操作结束 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>用户管理面板 - <?=webname?></title>
<? include("cssjs.html");?>
<script language="javascript">
function tj(){
<? if($ordering>0){?>alert("操作失败，因为有订单未处理");return false;<? }?>
if((document.f1.t1.value).replace(/\s/,"")==""){alert("请输入保证金数量");document.f1.t1.focus();return false;}	
if(!confirm("确定要解冻保证金吗？")){return false;}
layer.msg('正在提交', {icon: 16  ,time: 0,shade :0.25});
tjwait();
f1.action="baomoney2.php";
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
 
 <? include("rcap15.php");?>
 <script language="javascript">
 document.getElementById("rcap3").className="l1 l2";
 </script>

 <!--白B-->
 <div class="rkuang">
 
 <? systs("恭喜您，操作成功!","baomoney2.php")?>
 <form name="f1" method="post" onsubmit="return tj()">
 <input type="hidden" value="bao" name="jvs" />
 <ul class="uk">
 <li class="l1">可用保证金：</li>
 <li class="l21"><?=sprintf("%.2f",$rowuser[baomoney])?>元</li>
 <li class="l1">可用余额：</li>
 <li class="l21"><?=sprintf("%.2f",$rowuser[money1])?>元</li>
 <li class="l1"><span class="red" style="font-weight:normal;">*</span> 解冻保证金：</li>
 <li class="l2"><input type="text" class="inp" name="t1" /></li>
 <? if($ordering==0){?>
 <li class="l3"><?=tjbtnr("解冻保证金")?></li>
 <? }else{?>
 <li class="l1">操作提示：</li>
 <li class="l21">您当前还有<strong class="red"><?=$ordering?></strong>笔订单未完成处理，保证金需要等所有订单处理完毕后，才能申请解冻</li>
 <? }?>
 </ul>
 </form>
 
 </div>
 <!--白E-->

</div> 
<!--RE-->

</div>

<div class="clear clear15"></div>
<? include("../tem/bottom.html");?>
</body>
</html>