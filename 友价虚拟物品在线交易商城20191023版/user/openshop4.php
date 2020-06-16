<?
include("../config/conn.php");
include("../config/function.php");
sesCheck();
$sqluser="select * from yjcode_user where uid='".$_SESSION[SHOPUSER]."'";mysql_query("SET NAMES 'GBK'");$resuser=mysql_query($sqluser);
$rowuser=mysql_fetch_array($resuser);
if(2!=$rowuser[shopzt] && 4!=$rowuser[shopzt]){php_toheader("openshop3.php");}

//入库操作开始
if($_POST[jvs]=="openshop"){
 zwzr();
 $t1=sha1(sqlzhuru($_POST[t1]));
 if(panduan("uid,pwd","yjcode_user where uid='".$_SESSION[SHOPUSER]."' and pwd='".$t1."'")==0){Audit_alert("登录密码验证失败，返回重试！","openshop4.php");}
 $d=preg_split("/xcf/",$_POST[d1]);
 while1("*","yjcode_openyue where id=".$d[2]);if(!$row1=mysql_fetch_array($res1)){Audit_alert("操作失败，返回重试！","openshop4.php");}
 $m=$row1[money1];
 if($m>$rowuser[money1]){Audit_alert("您的余额不够，请先充值！","openshop4.php");}
 $sj=date("Y-m-d H:i:s");
 $dqsj=$rowuser[dqsj];if(empty($dqsj)){$dqsj=$sj;}
 if(strtotime($dqsj)<strtotime($sj)){$dqsj=$sj;}
 $dqsj=date('Y-m-d H:i:s',strtotime ("+".$row1[yue]." month",strtotime($dqsj)));
 if($dqsj<$sj){Audit_alert("续费失败，续费到期年限最大为2038年！","openshop4.php");}
 PointUpdateM($rowuser[id],$m*(-1));
 PointIntoM($rowuser[id],"店铺续费",$m*(-1));
 updatetable("yjcode_user","shopzt=2,dqsj='".$dqsj."' where uid='".$_SESSION[SHOPUSER]."'");
 php_toheader("openshop4.php?t=suc");
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
<link href="css/sell.css" rel="stylesheet" type="text/css" />
<script language="javascript">
function tj(){
if((document.f1.t1.value).replace(/\s/,"")==""){alert("请输入登录密码");document.f1.t1.focus();return false;}	
if(confirm("确定提交吗？")){
 layer.msg('正在提交', {icon: 16  ,time: 0,shade :0.25});
 tjwait();
 f1.action="openshop4.php";
}else{return false;}
}
function fycha(){
d=(document.f1.d1.value).split("xcf");
a=addNum(0,d[1]);
document.getElementById("needmoney").innerHTML=a+"元";
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
 <li class="l1 l2"><a href="openshop4.php">店铺续费</a></li>
 </ul>

 <!--白B-->
 <div class="rkuang">
 
 <? systs("恭喜您，续费成功!","openshop4.php")?>
 <form name="f1" method="post" onsubmit="return tj()">
 <input type="hidden" value="openshop" name="jvs" />
 <ul class="uk">
 <li class="l1">当前到期：</li>
 <li class="l21"><strong><?=$rowuser[dqsj]?></strong></li>
 <li class="l1">续费费用：</li>
 <li class="l21 red"><strong id="needmoney"></strong></li>
 <li class="l1">续费期限：</li>
 <li class="l2 red">
 <select name="d1" class="inp" onchange="fycha()">
 <? while1("*","yjcode_openyue order by yue asc");while($row1=mysql_fetch_array($res1)){if($row1[yue] % 12==0){$nd=$row1[yue]/12;$nd=$nd."年";}else{$nd=$row1[yue]."个月";}?>
 <option value="<?=$row1[yue]?>xcf<?=$row1[money1]?>xcf<?=$row1[id]?>"><?=$nd?> (费用：<?=$row1[money1]?>元)</option>
 <? }?>
 </select>
 </li>
 <li class="l1">您的可用余额：</li>
 <li class="l21 green"><strong><?=$rowuser[money1]?> 元</strong> [<a href="pay.php">点击充值</a>]</li>
 <li class="l1">登录密码：</li>
 <li class="l2"><input type="password" class="inp" name="t1" /></li>
 <li class="l3"><?=tjbtnr("下一步")?></li>
 </ul>
 </form>
 
 </div>
 <!--白E-->

</div> 
<!--RE-->

</div>

<script language="javascript">fycha();</script>
<div class="clear clear15"></div>
<? include("../tem/bottom.html");?>
</body>
</html>