<?php
include("../config/conn.php");
include("../config/function.php");
AdminSes_audit();
$id=$_GET[id];
while0("*","yjcode_payreng where id=".$id);if(!$row=mysql_fetch_array($res)){php_toheader("renglist.php");}
if(1==$row[type1]){$ty="支付宝";}
elseif(2==$row[type1]){$ty="微信";}
$sj=date("Y-m-d H:i:s");
$uip=$_SERVER["REMOTE_ADDR"];
 
if($_GET[control]=="update"){
 $zt=intval(sqlzhuru($_POST[R1]));
 $money1=$_POST[tmoney1];
 $ddbh=$_POST[tddbh];
 if(1==$zt && 2!=$row[ifok]){
  $tit=$ty."人工对账";
  intotable("yjcode_moneyrecord","bh,userid,tit,moneynum,sj,uip,admin,rengbh","'".time()."',".$row[userid].",'".$tit."',".$money1.",'".$sj."','".$uip."',".$row[type1].",'".$ddbh."'");
  updatetable("yjcode_user","money1=money1+".$money1." where id=".$row[userid]);
  updatetable("yjcode_payreng","money1=".$money1.",ddbh='".$ddbh."',ifok=2 where id=".$id);
 }elseif(2==$zt){
 deletetable("yjcode_payreng where id=".$id);
 }
php_toheader("renglist.php");
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
r=document.getElementsByName("R1");rr="";for(i=0;i<r.length;i++){if(r[i].checked==true){rr=r[i].value;}}if(rr==""){alert("请选择对账状态！");return false;}
if(confirm("确定执行该操作吗？")){layer.msg('正在提交', {icon: 16  ,time: 0,shade :0.25});f1.action="reng.php?id=<?=$id?>&control=update";}else{return false;}
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
 <? $leftid=4;include("menu_user.php");?>

<div class="right">
 <div class="rights">
 <strong>提示：</strong><br>
 <span class="green">对账失败，会自动删除该记录。如果核对真实，会新增一条充值记录到会员中心</span>
 </div>
 <div class="bqu1">
 <a href="javascript:void(0);" class="a1">人工对账</a>
 <a href="renglist.php">返回列表</a>
 </div> 
 <!--B-->
 <div class="rkuang">
 <form name="f1" method="post" onsubmit="return tj()">
 <ul class="uk">
 <li class="l1">会员信息：</li>
 <li class="l2">
 <? while1("uid,nc","yjcode_user where id=".$row[userid]);$row1=mysql_fetch_array($res1);?>
 <input type="text" class="inp redony" readonly="readonly" size="60" value="<?=$row1[uid]?> 昵称:<?=$row1[nc]?>" /> 
 <span class="fd"><a href="user_ses.php?uid=<?=$row1[uid]?>" target="_blank">进后台</a></span>
 </li>
 <li class="l1">对账方式：</li>
 <li class="l2"><input type="text" class="inp redony" readonly="readonly" size="40" value="<?=$ty?>" /></li>
 <li class="l1">提交时间：</li>
 <li class="l2"><input type="text" class="inp redony" readonly="readonly" size="40" value="<?=$row[sj]?>" /></li>
 <li class="l1">对账金额：</li>
 <li class="l2"><input type="text" class="inp" name="tmoney1" size="40" value="<?=$row[money1]?>" /></li>
 <li class="l1">充值订单号：</li>
 <li class="l2"><input type="text" class="inp" name="tddbh" size="40" value="<?=$row[ddbh]?>" /></li>
 </ul>
 
 <ul class="rcap"><li class="l1"></li><li class="l2">管理员操作</li><li class="l3"></li></ul>
 <ul class="uk">
 <li class="l1">操作：</li>
 <li class="l2">
 <span class="finp">
 <? if(1==$row[ifok]){?>
 <label class="blue"><input name="R1" type="radio" value="1" /> 对账成功，已经收到钱</label>
 <? }else{?>
 <label class="blue"><input name="R1" type="radio" value="" disabled="disabled" /> 已经对过账，请勿重复对账</label>
 <? }?>
 <label class="red"><input name="R1" type="radio" value="2" /> 对账失败</label>
 </span>
 </li>
 </ul>
 <ul class="uk uk0">
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