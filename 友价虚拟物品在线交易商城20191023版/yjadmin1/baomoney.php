<?php
include("../config/conn.php");
include("../config/function.php");
AdminSes_audit();
$id=$_GET[id];
while0("*","yjcode_baomoneyrecord where id=".$id);if(!$row=mysql_fetch_array($res)){php_toheader("baomoneylist.php");}

$sqluser="select * from yjcode_user where id=".$row[userid];mysql_query("SET NAMES 'GBK'");$resuser=mysql_query($sqluser);
if(!$rowuser=mysql_fetch_array($resuser)){php_toheader("baomoneylist.php");}

//函数开始
if($_GET[control]=="update"){
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0701,")){Audit_alert("权限不够","default.php");}
 zwzr();
 $zt=intval($_POST[R1]);
 if(0==$zt && 1==$row[zt]){
 $t1=abs($row[moneynum]);
 PointIntoM($row[userid],"解冻保证金",$t1);
 PointUpdateM($row[userid],$t1); 
 }elseif(2==$zt && 1==$row[zt]){
 $t1=abs($row[moneynum]);
 PointIntoB($row[userid],"保证金解冻被拒(原因:".$_POST[tztsm].")",$t1);
 PointUpdateB($row[userid],$t1); 
 }
 updatetable("yjcode_baomoneyrecord","zt=".$zt.",ztsm='".$_POST[tztsm]."' where id=".$id);
 php_toheader("baomoney.php?t=suc&id=".$id);
}
//函数结果
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><?=webname?>管理系统</title>
<link href="css/basic.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script language="javascript" src="js/basic.js"></script>
<script language="javascript" src="js/layer.js"></script>
<script language="javascript">
function tj(){
 if(confirm("确定执行该操作吗？")){}else{return false;}
 layer.msg('正在提交', {icon: 16  ,time: 0,shade :0.25});
 f1.action="baomoney.php?control=update&id=<?=$row[id]?>";
 }
function ztonc(x){
 if(2==x){document.getElementById("ztv").style.display="";}else{document.getElementById("ztv").style.display="none";}
}
</script>
</head>
<body>
<? include("top.php");?>
<script language="javascript">
document.getElementById("menu2").className="a1";
</script>
<? if(!strstr($adminqx,",0,") && !strstr($adminqx,",0702,")){echo "<div class='noneqx'>无权限</div>";exit;}?>

<div class="yjcode">
 <? $leftid=3;include("menu_user.php");?>

<div class="right">
 <? if($_GET[t]=="suc"){systs("恭喜您，操作成功！","baomoney.php?id=".$id);}?>
 <div class="bqu1">
 <a href="javascript:void(0);" class="a1">保证金管理</a>
 <a href="baomoneylist.php">返回列表</a>
 </div> 
 <!--B-->
 <div class="rkuang">
 <form name="f1" method="post" onsubmit="return tj()">
 <ul class="uk">
 <li class="l1">会员帐号：</li>
 <li class="l2"><input type="text" class="inp redony" readonly="readonly" name="tuid" size="20" value="<?=$rowuser[uid]?>" /></li>
 <li class="l1">可用余额：</li>
 <li class="l2"><input class="inp redony" readonly="readonly" value="<?=sprintf("%.2f",$rowuser[money1])?>" size="10" type="text"/></li>
 <li class="l1">可用保证金：</li>
 <li class="l2"><input class="inp redony" readonly="readonly" value="<?=sprintf("%.2f",$rowuser[baomoney])?>" size="10" type="text"/></li>
 <li class="l1">操作保证金：</li>
 <li class="l2"><input class="inp" readonly="readonly" value="<?=sprintf("%.2f",$row[moneynum])?>" size="10" type="text"/></li>
 <li class="l1">操作性质：</li>
 <li class="l2"><input class="inp" readonly="readonly" value="<? if($row[moneynum]>0){echo "缴纳";}else{echo "解冻";}?>" size="10" type="text"/></li>
 <li class="l1">管理员审核：</li>
 <li class="l2">
 <label><input name="R1" type="radio" onclick="ztonc(0)" value="0"<? if(0==$row[zt]){?> checked="checked"<? }?> /> 通过审核</label>
 <label><input name="R1" type="radio" onclick="ztonc(1)" value="1"<? if(1==$row[zt]){?> checked="checked"<? }?> /> 正在审核</label>
 <label><input name="R1" type="radio" onclick="ztonc(2)" value="2"<? if(2==$row[zt]){?> checked="checked"<? }?> /> 审核不通过</label>
 </li>
 </ul>
 <ul class="uk uk0" id="ztv" style="display:none;">
 <li class="l1">被拒原因：</li>
 <li class="l2"><input type="text" class="inp" name="tztsm" size="90" value="<?=$row[ztsm]?>" /></li>
 </ul>
 <? if(1==$row[zt]){?>
 <ul class="uk uk0">
 <li class="l3"><input type="submit" value="保存修改" class="btn1" /></li>
 </ul>
 <? }?>
 </form>
 </div>
 <!--E-->
</div>
</div>
<?php include("bottom.php");?>
<script language="javascript">ztonc(<?=$row[zt]?>);</script>
</body>
</html>