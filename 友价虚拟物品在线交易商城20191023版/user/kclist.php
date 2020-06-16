<?
include("../config/conn.php");
include("../config/function.php");
sesCheck();
if(empty($_SESSION[SAFEPWD])){Audit_alert("卡密信息操作需要先进行安全码验证!","safepwd.php");}
$bh=$_GET[bh];
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
function ser(){
location.href="kclist.php?bh=<?=$bh?>&st1="+document.getElementById("st1").value+"&sd1="+document.getElementById("sd1").value;
}
function glover(x){
 document.getElementById("gl"+x).style.display="";
}
function glout(x){
 document.getElementById("gl"+x).style.display="none";
}
function del(x){
document.getElementById("chk"+x).checked=true;
NcheckDEL(5,'yjcode_kc');
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
 
 <? include("protop.php");?>
 <? include("rcap3.php");?>
 <script language="javascript">
 document.getElementById("rcap4").className="l1 l2";
 </script>

 <!--白B-->
 <div class="rkuang">
 
 <ul class="uk uk0">
 <li class="l1">库存统计：</li>
 <li class="l21">
 已使用（<strong class="red"><?=returncount("yjcode_kc where userid=".$luserid." and probh='".$bh."' and ifok=1")?></strong>）&nbsp;&nbsp;&nbsp;&nbsp;
 未使用（<strong class="blue"><?=returncount("yjcode_kc where userid=".$luserid." and probh='".$bh."' and ifok=0")?></strong>）
 </li>
 </ul> 

 <div class="ksedi uk0">
  <div class="d1">
  <a href="javascript:;" onclick="NcheckDEL(5,'yjcode_kc')" class="a1">删除</a>
  <a href="kc.php?bh=<?=$bh?>" class="a2">添加信息</a>
 </div>
 <div class="d2">
  <input type="button" onclick="ser()" value="查询" class="btn" />
  <select id="sd1">
  <option value="">全部</option>
  <option value="0"<? if($_GET[sd1]=="0"){?> selected="selected"<? }?>>未使用</option>
  <option value="1"<? if($_GET[sd1]=="1"){?> selected="selected"<? }?>>已使用</option>
  </select>
  <span class="s1">使用情况：</span>
  <input type="text" id="st1" value="<?=$_GET[st1]?>" class="inp1" />
  <span class="s1">关键词：</span>
 </div>
 </div>

 <ul class="kamikccap">
 <li class="l1"><input name="C2" type="checkbox" onclick="xuan()" /></li>
 <li class="l2">排序</li>
 <li class="l3">卡号</li>
 <li class="l4">密码</li>
 <li class="l5">使用状况</li>
 <li class="l6">使用会员</li>
 <li class="l7">使用时间</li>
 <li class="l8">编辑</li>
 </ul>
  
 <?
 $ses=" where userid=".$luserid." and probh='".$bh."'";
 if($_GET[st1]!=""){$ses=$ses." and ka like '%".$_GET[st1]."%'";}
 if($_GET[sd1]!=""){$ses=$ses." and ifok=".$_GET[sd1];}
 $page=$_GET["page"];if($page==""){$page=1;}else{$page=intval($_GET["page"]);}
 pagef($ses,30,"yjcode_kc","order by id asc");while($row=mysql_fetch_array($res)){
 ?>
 <ul class="kamikclist">
 <li class="l1"><input name="C1" type="checkbox" id="chk<?=$row[id]?>" value="<?=$row[id]?>" /></li>
 <li class="l2"><?=$row[id]?></li>
 <li class="l3"><?=returntitdian($row[ka],35)?></li>
 <li class="l4"><?=returntitdian($row[mi],35)?></li>
 <li class="l5"><? if(1==$row[ifok]){?><span class="red">已使用</span><? }else{?><span class="blue">未使用</span><? }?></li>
 <li class="l6"><?=returnuser($row[userid1])?></li>
 <li class="l7"><?=$row[sj]?></li>
 <li class="l8" onmouseover="glover(<?=$row[id]?>)" onmouseout="glout(<?=$row[id]?>)">
  <span class="s1">管理</span>
  <div class="gl" style="display:none;" id="gl<?=$row[id]?>">
  <a href="kc.php?bh=<?=$bh?>&action=update&id=<?=$row[id]?>">编辑信息</a>
  <a href="javascript:;" onclick="del(<?=$row[id]?>)">删除卡密</a>
  </div>
 </li>
 </ul>
 <? }?>

 <div class="npa">
 <?
 $nowurl="kclist.php";
 $nowwd="bh=".$bh."&st1=".$_GET[st1]."&sd1=".$_GET[sd1];
 require("page.php");
 ?>
 </div>
 
 <div class="clear clear10"></div>
 
 </div>
 <!--白E-->

</div> 
<!--RE-->

</div>

<div class="clear clear15"></div>
<? include("../tem/bottom.html");?>
</body>
</html>