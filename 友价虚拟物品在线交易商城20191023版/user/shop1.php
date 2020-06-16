<?
include("../config/conn.php");
include("../config/function.php");
sesCheck();
$sqluser="select * from yjcode_user where uid='".$_SESSION[SHOPUSER]."' and shopzt=2";mysql_query("SET NAMES 'GBK'");$resuser=mysql_query($sqluser);
if(!$rowuser=mysql_fetch_array($resuser)){php_toheader("openshop3.php");}

if(sqlzhuru($_POST[jvs])=="shop"){
 zwzr();
 $c1=sqlzhuru1($_POST[C1]);if(empty($c1)){$c1=1;}else{$c1=0;}
 $c2=sqlzhuru1($_POST[C2]);if(empty($c2)){$c2=1;}else{$c2=0;}
 updatetable("yjcode_user","ordertx1=".$c1.",ordertx2=".$c2." where id=".$rowuser[id]);
 php_toheader("shop1.php?t=suc"); 
}

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
layer.msg('正在提交', {icon: 16  ,time: 0,shade :0.25});
tjwait();
f1.action="shop1.php";
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
 
 <? include("rcap4.php");?>
 <script language="javascript">
 document.getElementById("rcap2").className="l1 l2";
 </script>

 <!--白B-->
 <div class="rkuang">
 
 <? systs("恭喜您，操作成功!","shop1.php")?>
 <form name="f1" method="post" onsubmit="return tj()">
 <input type="hidden" value="shop" name="jvs" />
 <ul class="uk">
 <li class="l1">订单通知：</li>
 <li class="l2">
 <label><input name="C1" type="checkbox" value="1"<? if(empty($rowuser[ordertx1])){?> checked="checked"<? }?> /> 短信通知</label>&nbsp;&nbsp;&nbsp;&nbsp;
 <label><input name="C2" type="checkbox" value="1"<? if(empty($rowuser[ordertx2])){?> checked="checked"<? }?> /> 邮件通知</label>
 </li>
 <li class="l3"><?=tjbtnr("提交")?></li>
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