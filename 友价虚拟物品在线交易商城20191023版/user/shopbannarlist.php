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
function add1(){
layer.open({
  type: 2,
  area: ['622px', '400px'],
  title:["店铺轮播图片","text-align:left"],
  skin: 'layui-layer-rim', //加上边框
  content:['shopbannarlx.php', 'no'] 
});
}
function upd(x){
layer.open({
  type: 2,
  area: ['622px', '400px'],
  title:["店铺轮播图片","text-align:left"],
  skin: 'layui-layer-rim', //加上边框
  content:['shopbannar.php?bh='+x, 'no'] 
});
}
function glover(x){
 document.getElementById("gl"+x).style.display="";
}
function glout(x){
 document.getElementById("gl"+x).style.display="none";
}
function del(x){
document.getElementById("chk"+x).checked=true;
NcheckDEL(17,'yjcode_shopbannar');
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
 
 <? include("rcap4.php");?>
 <script language="javascript">
 document.getElementById("rcap5").className="l1 l2";
 </script>

 <!--白B-->
 <div class="rkuang">
 
 <div class="ksedi">
  <div class="d1">
  <a href="javascript:;" onclick="NcheckDEL(17,'yjcode_shopbannar')" class="a1">删除</a>
  <a href="javascript:;" onclick="add1()" class="a2">添加图片</a>
  </div>
 </div>

 <ul class="shopbannarcap">
 <li class="l1"><input name="C2" type="checkbox" onclick="xuan()" /></li>
 <li class="l2">图片信息</li>
 <li class="l3">排序</li>
 <li class="l4">编辑时间</li>
 <li class="l5">操作</li>
 </ul>
 <? 
 while1("*","yjcode_shopbannar where userid=".$luserid." and zt=0 order by xh asc");while($row1=mysql_fetch_array($res1)){
 if(1==$row1[targ]){$ifn="当前窗口打开";}else{$ifn="新窗口打开";}
 $at="../upload/".$row1[userid]."/shopbannar_".$row1[bh].".jpg";
 ?>
 <ul class="shopbannarlist">
 <li class="l1"><input name="C1" type="checkbox" id="chk<?=$row1[id]?>" value="<?=$row1[bh]?>" /></li>
 <li class="l2">
 <a href="<?=$at?>" target="_blank"><img src="<?=$at?>" align="left" width="70" height="70" /></a>
 <a href="<?=$row1[aurl]?>" target="_blank">
 <strong><?=$row1[tit]?></strong><br><?=$row1[aurl]?><br><span class="green"><?=$ifn?></span>
 </a>
 </li>
 <li class="l3"><?=$row1[xh]?></li>
 <li class="l4"><?=$row1[sj]?></li>
 <li class="l5" onmouseover="glover(<?=$row1[id]?>)" onmouseout="glout(<?=$row1[id]?>)">
  <span class="s1">管理</span>
  <div class="gl" style="display:none;" id="gl<?=$row1[id]?>">
  <a href="javascript:void(0);" onclick="upd('<?=$row1[bh]?>')">修改信息</a>
  <a href="javascript:void(0);" onclick="del(<?=$row1[id]?>)">删除图片</a>
  </div>
 </li>
 </ul>
 <? }?>

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