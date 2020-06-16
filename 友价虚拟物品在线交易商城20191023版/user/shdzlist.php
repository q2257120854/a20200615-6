<?
include("../config/conn.php");
include("../config/function.php");
sesCheck();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>用户管理面板 - <?=webname?></title>
<? include("cssjs.html");?>
<link href="css/inf.css" rel="stylesheet" type="text/css" />
<script language="javascript">
function addshdz(){
layer.open({
  type: 2,
  area: ['700px', '420px'],
  title:["编辑收货地址","text-align:left"],
  skin: 'layui-layer-rim', //加上边框
  content:['shdzlx.php', 'no'] 
});
}

function ediadd(b){
layer.open({
  type: 2,
  area: ['700px', '420px'],
  title:["编辑收货地址","text-align:left"],
  skin: 'layui-layer-rim', //加上边框
  content:['shdz.php?bh='+b, 'no'] 
});
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
 
 <? include("rcap1.php");?>
 <script language="javascript">
 document.getElementById("rcap8").className="l1 l2";
 </script>

 <!--白B-->
 <div class="rkuang">
 
 <div class="ksedi">
  <div class="d1">
  <a href="javascript:NcheckDEL(10,'yjcode_shdz')" class="a2">删除</a>
  <a href="javascript:void(0);" onclick="addshdz()" class="a1">新增地址</a>
  </div>
 </div>

 <ul class="shdzlistcap">
 <li class="l0"><input name="C2" type="checkbox" onclick="xuan()" /></li>
 <li class="l1">详细地址</li>
 <li class="l2">收货人</li>
 <li class="l3">联系电话</li>
 <li class="l4">编辑时间</li>
 </ul>
 <?
 $ses=" where zt=0 and userid=".$luserid;
 $page=$_GET["page"];if($page==""){$page=1;}else{$page=intval($_GET["page"]);}
 pagef($ses,30,"yjcode_shdz","order by sj desc");while($row=mysql_fetch_array($res)){
 $addr=returnarea($row[add1])." ".returnarea($row[add2])." ".returnarea($row[add3])." ".$row[addr];
 ?>
 <ul class="shdzlist">
 <li class="l0"><input name="C1" type="checkbox" value="<?=$row[id]?>" /></li>
 <li class="l1"><? if(1==$row[ifmr]){?><span class="red">[默认地址]</span> <? }?><a href="javascript:void(0);" onclick="ediadd('<?=$row[bh]?>')"><?=$addr?></a></li>
 <li class="l2"><?=$row[lxr]?></li>
 <li class="l3"><?=$row[mot]?></li>
 <li class="l4"><?=$row[sj]?></li>
 </ul>
 <? }?>
 <div class="npa">
 <?
 $nowurl="shdzlist.php";
 $nowwd="";
 require("page.php");
 ?>
 </div>
 <div class="clear clear15"></div>
 
 </div>
 <!--白E-->

</div> 
<!--RE-->

</div>

<div class="clear clear15"></div>
<? include("../tem/bottom.html");?>
</body>
</html>