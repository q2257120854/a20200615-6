<?php
include("../config/conn.php");
include("../config/function.php");
AdminSes_audit();
$id=$_GET[id];
while0("*","yjcode_user where id=".$id);if(!$row=mysql_fetch_array($res)){php_toheader("userlist.php");}

//函数开始
if($_GET[control]=="update"){
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0701,")){Audit_alert("权限不够","default.php");}
 zwzr();
 $d1=intval($_POST[d1]);
 $t=sqlzhuru($_POST[t2]);
 $t1=sprintf("%.2f",$_POST[t1]);
 if($d1==1){$money1=abs($t1);$tit=returnjgdw($t,"","帐户金额充值");PointIntoM($id,$tit,$money1,5);PointUpdateM($id,$money1);}
 elseif($d1==2){$money1=abs($t1)*(-1);$tit=returnjgdw($t,"","帐户金额扣除");PointIntoM($id,$tit,$money1,5);PointUpdateM($id,$money1); }
 elseif($d1==3){
 if($row[money1]<$t1){Audit_alert("余额不够，冻结失败","usermoney.php?id=".$id);}
 $money1=abs($t1)*(-1);$tit=returnjgdw($t,"","帐户金额冻结");PointIntoM($id,$tit,$money1,5);PointUpdateM($id,$money1);
 updatetable("yjcode_user","djmoney=djmoney+".abs($t1)." where id=".$id);
 }elseif($d1==4){
 if($row[djmoney]<$t1){Audit_alert("冻结金额不够，解冻失败","usermoney.php?id=".$id);}
 $money1=abs($t1);$tit=returnjgdw($t,"","帐户金额解冻");PointIntoM($id,$tit,$money1,5);PointUpdateM($id,$money1);
 updatetable("yjcode_user","djmoney=djmoney-".abs($t1)." where id=".$id);
 }
 php_toheader("usermoney.php?t=suc&id=".$id);

}elseif($_GET[control]=="ql"){
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0701,")){Audit_alert("权限不够","default.php");}
 PointIntoM($id,"同步金额数字",0,5);
 updatetable("yjcode_user","money1=0 where id=".$id);
 php_toheader("usermoney.php?t=suc&id=".$id);

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
 if((document.f1.t1.value).replace(/\s/,"")==""){alert("请输入有效的金钱数量!");document.f1.t1.select();return false;}
 if(isNaN(document.f1.t1.value)){alert("请输入有效的金钱数量!");document.f1.t1.select();return false;}
 layer.msg('正在提交', {icon: 16  ,time: 0,shade :0.25});
 f1.action="usermoney.php?control=update&id=<?=$row[id]?>";
 }
function ql(){
if(confirm("只要金额形式出现异常时，才适用本操作，确认吗？")){location.href="usermoney.php?id=<?=$id?>&control=ql";}else{return false;}
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
 <? $leftid=1;include("menu_user.php");?>

<div class="right">
 <? if($_GET[t]=="suc"){systs("恭喜您，操作成功！","usermoney.php?id=".$id);}?>
 <? include("rightcap3.php");?>
 <script language="javascript">document.getElementById("rtit3").className="a1";</script>
 <!--B-->
 <div class="rkuang">
 <form name="f1" method="post" onsubmit="return tj()">
 <ul class="uk">
 <li class="l1">会员帐号：</li>
 <li class="l2"><input type="text" class="inp redony" readonly="readonly" name="tuid" size="20" value="<?=$row[uid]?>" /></li>
 <li class="l1">可用余额：</li>
 <li class="l2"><input class="inp redony" readonly="readonly" value="<?=sprintf("%.2f",$row[money1])?>" size="10" type="text"/><span class="fd">【<a href="javascript:ql()">金额清零</a>】</span></li>
 <li class="l1">冻结金额：</li>
 <li class="l2"><input class="inp redony" readonly="readonly" value="<?=sprintf("%.2f",$row[djmoney])?>" size="10" type="text"/></li>
 <li class="l1">金钱管理：</li>
 <li class="l2">
 <select name="d1" class="inp">
 <option value="1">帐户金额充值</option>
 <option value="2">帐户金额扣除</option>
 <option value="3">帐户金额冻结</option>
 <option value="4">帐户金额解冻</option>
 </select>
 </li>
 <li class="l1">金钱数量：</li>
 <li class="l2"><input name="t1" class="inp" size="10" type="text" /></li>
 <li class="l1">说明：</li>
 <li class="l2"><input name="t2" class="inp" size="50" type="text" /></li>
 <li class="l3"><input type="submit" value="保存修改" class="btn1" /></li>
 </ul>
 </form>
 </div>
 <!--E-->
 
</div>
</div>
<?php include("bottom.php");?>
</body>
</html>