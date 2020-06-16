<?php
include("../config/conn.php");
include("../config/function.php");
AdminSes_audit();
$ses=" where id>0";
if($_GET[st1]!=""){$userid=returnuserid($_GET[st1]);$ses=$ses." and userid=".$userid;}
if($_GET[st2]!=""){$ses=$ses." and tit like '%".$_GET[st2]."%'";}
if($_GET[st3]!=""){$ses=$ses." and jyh = '".$_GET[st3]."'";}
if($_GET[sd1]!=""){$a=str_replace("a","",$_GET[sd1]);$ses=$ses." and admin=".$a;}
$page=$_GET["page"];if($page==""){$page=1;}else{$page=intval($_GET["page"]);}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><?=webname?>管理系统</title>
<link href="css/basic.css" rel="stylesheet" type="text/css" />
<link href="css/user.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script language="javascript" src="js/basic.js"></script>
<script language="javascript" src="js/layer.js"></script>
<script language="javascript">
function ser(){
location.href="moneylist.php?st1="+document.getElementById("st1").value+"&st2="+document.getElementById("st2").value+"&st3="+document.getElementById("st3").value+"&sd1="+document.getElementById("sd1").value;	
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
 <? $leftid=2;include("menu_user.php");?>

<div class="right">
 
 <div class="bqu1">
 <a class="a1" href="moneylist.php">会员资金记录</a>
 </div>
 <div class="rights">
 <strong>提示：</strong><br>
 <span class="red">可删除每条记录，删除后，可能导致会员的对帐记录不同步，但不会涉及到金额调整</span>
 </div>
 <!--B-->
 <ul class="psel">
 <li class="l1">会员帐号：</li><li class="l2"><input value="<?=$_GET[st1]?>" type="text" id="st1" size="15" /></li>
 <li class="l1">交易号：</li><li class="l2"><input value="<?=$_GET[st3]?>" type="text" id="st3" size="15" /></li>
 <li class="l1">资金接口：</li>
 <li class="l2">
 <select id="sd1">
 <option value="">==不限==</option>
 <? for($i=0;$i<=5;$i++){?>
 <option value="a<?=$i?>"<? if($_GET[sd1]=='a'.$i){?> selected="selected"<? }?>><?=returnzjjk($i)?></option>
 <? }?>
 </select>
 </li>
 <li class="l1">关键词：</li><li class="l2"><input value="<?=$_GET[st2]?>" type="text" id="st2" size="15" /></li>
 <li class="l3"><a href="javascript:ser()" class="a2">搜索</a></li>
 </ul>
 <ul class="ksedi">
 <li class="l2">
 <a href="javascript:checkDEL(26,'yjcode_moneyrecord')" class="a2">删除</a>
 </li>
 </ul>
 <ul class="mlistcap">
 <li class="l1"><input name="C2" type="checkbox" onclick="xuan()" /></li>
 <li class="l2">说明</li>
 <li class="l3">资金</li>
 <li class="l7">资金接口</li>
 <li class="l8">接口交易号</li>
 <li class="l4">操作IP</li>
 <li class="l5">操作时间</li>
 <li class="l6">会员</li>
 </ul>
 <? pagef($ses,20,"yjcode_moneyrecord","order by sj desc");while($row=mysql_fetch_array($res)){?>
 <ul class="mlist">
 <li class="l1"><input name="C1" type="checkbox" value="<?=$row[id]?>" /></li>
 <li class="l2"><span title="<?=$row[tit]?>"><?=returntitdian($row[tit],60)?></span></li>
 <li class="l3"><? if($row[moneynum]>0){?><span class="blue"><?=$row[moneynum]?></span><? }else{?><span class="red"><?=$row[moneynum]?></span><? }?></li>
 <li class="l7"><?=returnzjjk($row[admin])?></li>
 <li class="l8"><?=$row[jyh]?></li>
 <li class="l4"><a href="http://www.baidu.com/s?wd=<?=$row[uip]?>" target="_blank"><?=$row[uip]?></a></li>
 <li class="l5"><?=$row[sj]?></li>
 <li class="l6"><?=returnuser($row[userid])?></li>
 </ul>
 <? }?>
 <?
 $nowurl="moneylist.php";
 $nowwd="st1=".$_GET[st1]."&st2=".$_GET[st2]."&st3=".$_GET[st3]."&sd1=".$_GET[sd1];
 include("page.php");
 ?>
 <!--E-->
 
</div>
</div>
<?php include("bottom.php");?>
</body>
</html>