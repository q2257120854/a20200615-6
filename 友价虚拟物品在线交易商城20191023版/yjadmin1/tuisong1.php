<?php
include("../config/conn.php");//
include("../config/function.php");
AdminSes_audit();
$ses=" where id>0";
if($_GET[page]!=""){$page=$_GET[page];}else{$page=1;}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><?=webname?>管理系统</title>
<link href="css/basic.css" rel="stylesheet" type="text/css" />
<link href="css/order.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script language="javascript" src="js/basic.js"></script>
<script language="javascript" src="js/layer.js"></script>
<script language="javascript">
function ser(){
location.href="tuisong.php?st1="+document.getElementById("st1").value;
}
</script>
</head>
<body>
<? include("top.php");?>
<script language="javascript">
document.getElementById("menu8").className="a1";
</script>
<? if(!strstr($adminqx,",0,") && !strstr($adminqx,",0402,")){echo "<div class='noneqx'>无权限</div>";exit;}?>

<div class="yjcode">
 <? $leftid=1;include("menu_tuisong.php");?>

<div class="right">
 <div class="bqu1">
 <a class="a1" href="tuisong.php?ddzt=<?=$_GET[ddzt]?>"><?=returnjgdw(returnorderzt($_GET[ddzt]),"","熊掌推送记录")?></a>
 </div>
 <ul class="ordercap">
 <li class="l2" style="width: 30px">ID</li>
 <li class="l3" style="width: 300px">推送标题</li>
 <li class="l6" style="width: 400px">推送链接</li>
 <li class="l5">推送状态</li>
 <li class="14">推送时间</li>
 </ul>
 <?
 pagef($ses,10,"xiongzhangurl","order by id desc");while($row=mysql_fetch_array($res)){
     //print_r($row);
 //$tp="../".returntp("bh='".$row[probh]."' order by iffm desc","-2");
 //$au="orderview.php?orderbh=".$row[orderbh];
 ?>
 <ul class="orderlist">

 <li class="l2" style="width: 30px"><?php echo $row['id']; ?></li>
 <li class="l3" style="width: 300px"><? echo $row['titles']; ?></li>
 <li class="l6" style="width: 400px"><? echo $row['urls']; ?></li>
 <li class="l5"><? echo $row['status']; ?></li>
 <li class="14"><? echo $row['datetimes']; ?></li>
 </ul>
 <? }?>
 <?
 $nowurl="tuisong1.php";
 $nowwd="ddzt=".$_GET[ddzt]."&st1=".$_GET[st1]."&st2=".$_GET[st2];
 include("page.php");
 ?>
 <!--E-->
 
</div>
</div>
<?php include("bottom.php");?>
</body>
</html>