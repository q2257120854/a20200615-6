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
<link href="css/sell.css" rel="stylesheet" type="text/css" />
<script language="javascript">
function ser(){
location.href="prowdlist.php?&st1="+document.getElementById("st1").value+"&ifhf="+document.getElementById("sd1").value;
}
function hfonc(x){
layer.open({
  type: 2,
  shadeClose: true,
  area: ['622px', '215px'],
  title:["问答回复","text-align:left"],
  skin: 'layui-layer-rim', //加上边框
  content:['prowdhf.php?id='+x, 'no'] 
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
 
 <ul class="wz">
 <li class="l1 l2"><a href="prowdlist.php">商品问答</a></li>
 </ul>

 <!--白B-->
 <div class="rkuang">
 
 <div class="ksedi">
 <div class="d1">
 <a href="prowdlist.php?ifhf=no" class="a1">查看所有未回复问答(共<?=returncount("yjcode_wenda where selluserid=".$luserid." and hftxt=''")?>个)</a>
 </div>
 <div class="d2">
  <input type="button" onclick="ser()" value="查询" class="btn" />
  <select id="sd1">
  <option value="">全部</option>
  <option value="no"<? if($_GET[ifhf]=="no"){?> selected="selected"<? }?>>未回复</option>
  <option value="yes"<? if($_GET[ifhf]=="yes"){?> selected="selected"<? }?>>已回复</option>
  </select>
  <span class="s1">回复情况：</span>
  <input type="text" id="st1" value="<?=$_GET[st1]?>" class="inp1" />
  <span class="s1">评价内容：</span>
 </div>
 </div>

 <?
 $ses=" where selluserid=".$luserid;
 if($_GET[ifhf]=="no"){$ses=$ses." and hftxt=''";}
 if($_GET[ifhf]=="yes"){$ses=$ses." and hftxt<>''";}
 if($_GET[st1]!=""){$ses=$ses." and txt like '%".$_GET[st1]."%'";}
 $page=$_GET["page"];if($page==""){$page=1;}else{$page=intval($_GET["page"]);}
 pagef($ses,10,"yjcode_wenda","order by sj desc");while($row=mysql_fetch_array($res)){
 while1("*","yjcode_pro where bh='".$row[probh]."'");$row1=mysql_fetch_array($res1);
 ?>
 <ul class="prowdlist">
 <li class="l1">商品信息：</li>
 <li class="l2"><strong><a href="../product/view<?=$row1[id]?>.html" target="_blank"><?=$row1[tit]?></a></strong></li>
 <li class="l1">提问会员：</li>
 <li class="l3"><?=returnnc($row[userid])?></li>
 <li class="l1">提问时间：</li>
 <li class="l3"><?=$row[sj]?></li>
 </ul>
 <ul class="prowdlist1">
 <li class="l1">咨询问题：</li>
 <li class="l2">
 <?=$row[txt]?><br>
 </li>
 </ul>
 <ul class="prowdlist1">
 <li class="l1">回复内容：</li>
 <li class="l2" style="cursor:pointer;" onclick="hfonc(<?=$row[id]?>)"><? if(empty($row[hftxt])){?><span class="red">【暂未回复，点击进行回复】</span><? }else{?><span class="green">回复时间：<?=$row[hfsj]?><br>回复内容：<?=$row[hftxt]?></span><? }?></li>
 </ul>
 <? }?>

 <div class="npa">
 <?
 $nowurl="prowdlist.php";
 $nowwd="ifhf=".$_GET[ifhf];
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