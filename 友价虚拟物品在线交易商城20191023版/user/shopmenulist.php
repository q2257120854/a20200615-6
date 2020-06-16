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
  area: ['622px', '270px'],
  title:["店铺导航","text-align:left"],
  skin: 'layui-layer-rim', //加上边框
  content:['shopmenu1lx.php', 'no'] 
});
}
function add2(x){
layer.open({
  type: 2,
  area: ['622px', '315px'],
  title:["店铺导航","text-align:left"],
  skin: 'layui-layer-rim', //加上边框
  content:['shopmenu2lx.php?id1='+x, 'no'] 
});
}
function upd1(x){
layer.open({
  type: 2,
  area: ['622px', '270px'],
  title:["店铺导航","text-align:left"],
  skin: 'layui-layer-rim', //加上边框
  content:['shopmenu1.php?bh='+x, 'no'] 
});
}
function upd2(x){
layer.open({
  type: 2,
  area: ['622px', '315px'],
  title:["商品分组","text-align:left"],
  skin: 'layui-layer-rim', //加上边框
  content:['shopmenu2.php?bh='+x, 'no'] 
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
NcheckDEL(16,'yjcode_shopmenu');
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
 document.getElementById("rcap4").className="l1 l2";
 </script>

 <!--白B-->
 <div class="rkuang">
 
 <div class="ksedi">
  <div class="d1">
  <a href="javascript:;" onclick="NcheckDEL(16,'yjcode_shopmenu')" class="a1">删除</a>
  <a href="javascript:;" onclick="add1()" class="a2">添加导航</a>
  </div>
 </div>

 <ul class="shopmenucap">
 <li class="l1"><input name="C2" type="checkbox" onclick="xuan()" /></li>
 <li class="l2">导航名称</li>
 <li class="l3">排序</li>
 <li class="l4">编辑时间</li>
 <li class="l5">操作</li>
 </ul>
 <? while1("*","yjcode_shopmenu where userid=".$luserid." and admin=1 and zt=0 order by xh asc");while($row1=mysql_fetch_array($res1)){?>
 <ul class="shopmenulist">
 <li class="l1"><input name="C1" type="checkbox" id="chk<?=$row1[id]?>" value="<?=$row1[id]?>xcf0" /></li>
 <li class="l2"><a href="<?=$row1[aurl]?>" target="_blank"><?=$row1[tit1]?></a></li>
 <li class="l3"><?=$row1[xh]?></li>
 <li class="l4"><?=$row1[sj]?></li>
 <li class="l5" onmouseover="glover(<?=$row1[id]?>)" onmouseout="glout(<?=$row1[id]?>)">
  <span class="s1">管理</span>
  <div class="gl" style="display:none;" id="gl<?=$row1[id]?>">
  <a href="javascript:void(0);" onclick="upd1('<?=$row1[bh]?>')">修改信息</a>
  <a href="javascript:void(0);" onclick="add2(<?=$row1[id]?>)">添加子导航</a>
  <a href="javascript:void(0);" onclick="del(<?=$row1[id]?>)">删除导航</a>
  </div>
 </li>
 </ul>
 <? while2("*","yjcode_shopmenu where userid=".$luserid." and admin=2 and zt=0 and tit1='".$row1[tit1]."' order by xh asc");while($row2=mysql_fetch_array($res2)){?>
 <ul class="shopmenulist2">
 <li class="l1"><input name="C1" type="checkbox" id="chk<?=$row2[id]?>" value="0xcf<?=$row2[id]?>" /></li>
 <li class="l2"><a href="<?=$row2[aurl]?>" target="_blank"><?=$row2[tit2]?></a></li>
 <li class="l3"><?=$row2[xh]?></li>
 <li class="l4"><?=$row2[sj]?></li>
 <li class="l5" onmouseover="glover(<?=$row2[id]?>)" onmouseout="glout(<?=$row2[id]?>)">
  <span class="s1">管理</span>
  <div class="gl" style="display:none;" id="gl<?=$row2[id]?>">
  <a href="javascript:void(0);" onclick="upd2('<?=$row2[bh]?>')">修改信息</a>
  <a href="javascript:void(0);" onclick="del(<?=$row2[id]?>)">删除类别</a>
  </div>
 </li>
 </ul>
 <? }?>
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