<?
include("../config/conn.php");
include("../config/function.php");
sesCheck();
$userid=returnuserid($_SESSION[SHOPUSER]);

if($_GET[page]!=""){$page=$_GET[page];}else{$page=1;}
$ses=" where zt<>99 and userid=".$userid;

if($_GET[control]=="del"){
 deletetable("yjcode_gd where userid=".$userid." and bh='".$_GET[bh]."'");
 deletetable("yjcode_gdhf where userid=".$userid." and gdbh='".$_GET[bh]."'");
 php_toheader("gdlist.php?t=suc");
 
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>用户管理面板 - <?=webname?></title>
<? include("cssjs.html");?>
<link href="css/hudong.css" rel="stylesheet" type="text/css" />
<script language="javascript">
function del(x){
 if(confirm("确认删除该工单信息吗？")){
  layer.msg('正在处理数据，请稍候', {icon: 16  ,time: 0,shade :0.25});
  location.href="gdlist.php?control=del&bh="+x;
 }else{return false;}
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
 
 <? include("rcap12.php");?>
 <script language="javascript">
 document.getElementById("rcap1").className="l1 l2";
 </script>

 <!--白B-->
 <div class="rkuang">
 
 <? systs("恭喜您，操作成功!","gdlist.php")?>
 <ul class="gdcap">
 <li class="l1">工单编号</li>
 <li class="l2">问题内容</li>
 <li class="l3">提交时间</li>
 <li class="l4">状态</li>
 <li class="l5">操作</li>
 </ul>
 <? pagef($ses,20,"yjcode_gd","order by sj desc");while($row=mysql_fetch_array($res)){?>
 <ul class="gdlist" onmouseover="this.className='gdlist gdlist1';" onmouseout="this.className='gdlist';">
 <li class="l1"><?=$row[bh]?></li>
 <li class="l2"><a href="gdhf.php?bh=<?=$row[bh]?>"><?=strgb2312(strip_tags($row[txt]),0,45)?></a></li>
 <li class="l3"><?=$row[sj]?></li>
 <li class="l4"><?=returngdzt($row[gdzt])?></li>
 <li class="l5">
 <a href="gdhf.php?bh=<?=$row[bh]?>">查看</a> | 
 <a href="javascript:void(0);" onclick="del('<?=$row[bh]?>')">删除</a>
 </li>
 </ul>
 <? }?>
 <?
 $nowurl="gdlist.php";
 $nowwd="";
 include("page.php");
 ?>
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