<?php
include("../config/conn.php");
include("../config/function.php");
AdminSes_audit();
$id=$_GET[id];
while0("*","yjcode_tixian where id=".$id);if(!$row=mysql_fetch_array($res)){php_toheader("txlist.php");}

if($_GET[control]=="update"){
 $zt=intval(sqlzhuru($_POST[R1]));
 if(4==$row[zt] && ($zt==1 || $zt==3)){
  if(3==$zt){
  PointUpdateM($row[userid],$row[money1]);
  PointIntoM($row[userid],"提现申请被拒,原因:".sqlzhuru($_POST[tsm]),$row[money1]);
  }
  updatetable("yjcode_tixian","zt=".$zt.",sm='".sqlzhuru($_POST[tsm])."' where id=".$id);
 }
php_toheader("tx.php?t=suc&id=".$id);
}
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
r=document.getElementsByName("R1");rr="";for(i=0;i<r.length;i++){if(r[i].checked==true){rr=r[i].value;}}if(rr==""){alert("请选择提现状态！");return false;}
if(confirm("确定执行该操作吗？")){layer.msg('正在提交', {icon: 16  ,time: 0,shade :0.25});f1.action="tx.php?id=<?=$id?>&control=update";}else{return false;}
}
function ztonc(x){
if(3==x){document.getElementById("ztsmv").style.display="";}else{document.getElementById("ztsmv").style.display="none";}
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
 <? $leftid=5;include("menu_user.php");?>

<div class="right">
 <div class="rights">
 <strong>提示：</strong><br>
 <span class="green">一经设置，不可修改，请慎重该操作(建议先进行下方的管理员操作，再进行转帐)</span>
 </div>
 <? if($_GET[t]=="suc"){systs("恭喜您，操作成功！","tx.php?id=".$id);}?>
 <div class="bqu1">
 <a href="javascript:void(0);" class="a1">会员提现</a>
 <a href="txlist.php">返回列表</a>
 </div> 
 <!--B-->
 <div class="rkuang">
 <form name="f1" method="post" onsubmit="return tj()">
 <ul class="uk">
 <li class="l1">会员信息：</li>
 <li class="l2">
 <? while1("uid,nc","yjcode_user where id=".$row[userid]);$row1=mysql_fetch_array($res1);?>
 <input type="text" class="inp redony" readonly="readonly" size="40" value="<?=$row1[uid]?> 昵称:<?=$row1[nc]?>" /> 
 <span class="fd"><a href="user_ses.php?uid=<?=$row1[uid]?>" target="_blank">进后台</a></span>
 </li>
 <li class="l1">提现金额：</li>
 <li class="l2"><input type="text" class="inp redony" readonly="readonly" size="40" value="<?=$row[money1]?>元" /></li>
 <li class="l1">手续费率：</li>
 <li class="l2"><input type="text" class="inp redony" readonly="readonly" size="40" value="<?=$rowcontrol[txfl]?>" /></li>
 <li class="l1">应付金额：</li>
 <li class="l2"><input type="text" class="inp redony" readonly="readonly" size="40" value="<?=sprintf("%.2f",$row[money1]-$rowcontrol[txfl]*$row[money1])?>" /></li>
 <li class="l1">收款人：</li>
 <li class="l2"><input type="text" class="inp redony" readonly="readonly" size="40" value="<?=$row[txname]?>" /></li>
 <li class="l1">收款银行：</li>
 <li class="l2"><input type="text" class="inp redony" readonly="readonly" size="40" value="<?=$row[txyh]?>" /></li>
 <li class="l1">卡/帐号：</li>
 <li class="l2"><input type="text" class="inp redony" readonly="readonly" size="40" value="<?=$row[txzh]?>" /></li>
 <li class="l1">当前状态：</li>
 <li class="l21"><strong><?=returntxzt($row[zt],$row[sm])?></strong></li>
 </ul>
 
 <? if(4==$row[zt]){?>
 <ul class="rcap"><li class="l1"></li><li class="l2">管理员操作</li><li class="l3"></li></ul>
 <ul class="uk">
 <li class="l1">操作：</li>
 <li class="l2">
 <label><input name="R1" type="radio" onclick="ztonc(1)" value="1"<? if(1==$row[zt]){?> checked="checked"<? }?> /> 已转帐，提现成功</label>
 <label><input name="R1" type="radio" onclick="ztonc(3)" value="3"<? if(3==$row[zt]){?> checked="checked"<? }?> /> 提现失败</label>
 </li>
 </ul>
 <ul class="uk uk0" id="ztsmv"<? if(3!=$row[zt]){?> style="display:none;"<? }?>>
 <li class="l1">失败原因：</li>
 <li class="l2"><input type="text" class="inp" name="tsm" size="90" value="<?=$row[sm]?>" /></li>
 </ul>
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
</body>
</html>