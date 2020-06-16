<?php
include("../config/conn.php");
include("../config/function.php");
AdminSes_audit();
$ses=" where id>0";
if($_GET[st1]!=""){$ses=$ses." and (nc like '%".$_GET[st1]."%' or uid like '%".$_GET[st1]."%')";}
if($_GET[shopzt]!=""){$ses=$ses." and shopzt=".$_GET[shopzt];}
if($_GET[zt]!=""){$ses=$ses." and zt=".$_GET[zt];}
if($_GET[rz]!=""){$ses=$ses." and sfzrz=0";}
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
location.href="userlist.php?st1="+document.getElementById("st1").value;	
}
function delu(){
var c=document.getElementsByName("C1");
str="";
for(i=0;i<c.length;i++){
 if(c[i].checked){
 if(str==""){
 str=c[i].value;
 }else{
 str=str+","+c[i].value;
 }
 }
}
if(str==""){alert("请至少选择一条数据");return false;}
layer.confirm("删除会员会删除该会员名下所有信息，<span color='#ff0000'>且不可恢复</span>，请慎重！如果涉及交易中的资金，会导致资金不同步，确定删除吗？", {
  btn: ['确定','关闭'] //按钮
}, function(){
  checkDEL(9,'yjcode_user');
}, function(){
  layer.closeAll();
});
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
 
 <div class="bqu1">
 <a class="a1" href="userlist.php">会员列表</a>
 </div>
 <div class="rights">
 <strong>提示：</strong><br>
 <span class="red">删除会员会删除该会员名下所有信息，且不可恢复，请慎重。如果涉及交易中的资金，会导致资金不同步</span>
 </div>

 <!--B-->
 <ul class="psel">
 <li class="l1">关键词：</li><li class="l2"><input value="<?=$_GET[st1]?>" type="text" id="st1" size="15" /></li>
 <li class="l3"><a href="javascript:ser()" class="a2">搜索</a></li>
 </ul>
 <ul class="ksedi">
 <li class="l2">
 <a href="javascript:delu()" class="a2">删除</a>
 </li>
 </ul>
 <ul class="userlistcap">
 <li class="l1"><input name="C2" type="checkbox" onclick="xuan()" /></li>
 <li class="l2">会员帐号</li>
 <li class="l3">会员昵称</li>
 <li class="l4">会员等级</li>
 <li class="l5">开店状态</li>
 <li class="l6">可用余额</li>
 <li class="l7">时间/IP</li>
 <li class="l8">操作</li>
 </ul>
 <?
 pagef($ses,20,"yjcode_user","order by sj desc");while($row=mysql_fetch_array($res)){
 $aurl="user.php?id=".$row[id];
 ?>
 <ul class="userlist">
 <li class="l1"><input name="C1" type="checkbox" value="<?=$row[id]?>" /></li>
 <li class="l2"><? if(0==$row[zt]){?><span class="red">[禁]</span> <? }?><a class="blue" href="<?=$aurl?>"><?=$row[uid]?></a></li>
 <li class="l3"><?=$row[nc]?></li>
 <li class="l4"><?=returnuserdj($row[id])?></li>
 <li class="l5"><?=returnshopztv($row[shopzt])?></li>
 <li class="l6"><a href="usermoney.php?id=<?=$row[id]?>"><?=sprintf("%.2f",$row[money1])?></a></li>
 <li class="l7"><?=$row[sj]?>/<a href="http://www.baidu.com/s?wd=<?=$row[uip]?>" target="_blank">IP</a></li>
 <li class="l8">
 <a href="usermoney.php?id=<?=$row[id]?>">钱</a><span></span>
 <a href="userbao.php?id=<?=$row[id]?>">保</a><span></span>
 <a href="userrz.php?id=<?=$row[id]?>">证</a><span></span>
 <a href="user_ses.php?uid=<?=$row[uid]?>" target="_blank">后台</a>
 </li>
 </ul>
 <? }?>
 <?
 $nowurl="userlist.php";
 $nowwd="st1=".$_GET[st1]."&shopzt=".$_GET[shopzt]."&zt=".$_GET[zt]."&rz=".$_GET[rz];
 include("page.php");
 ?>
 <!--E-->
 
</div>
</div>
<?php include("bottom.php");?>
</body>
</html>