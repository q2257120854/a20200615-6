<?php
include("../../config/conn.php");
include("../../config/function.php");
$area1id=$_GET[area1id];if(empty($area1id)){$area1id=0;}
$area2id=$_GET[area2id];if(empty($area2id)){$area2id=0;}
$area3id=$_GET[area3id];if(empty($area3id)){$area3id=0;}
if($area1id!=""){$ses1=" and parentid='".$_GET[area1id]."'";}else{$ses1=" and id=0";}
if($area2id!=""){$ses2=" and parentid='".$_GET[area2id]."'";}else{$ses2=" and id=0";}
?>
<html>
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="viewport" content="initial-scale=1, width=device-width, maximum-scale=1, user-scalable=no" />
<title>选择市</title>
<link href="../css/global.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.shdzt1{font-size:14px;margin:10px 0 0 0;}
.shdzt1 .d1{margin:1px 0 0 10px;width:30px;}
.shdzt1 .d2{-webkit-box-flex:1;-moz-box-flex:1;box-flex:1;margin:0 0 0 0;overflow:hidden;}
.shdzt1 .d2 select{background-color:#fff;border:0;width:110%;float:left;font-size:14px;}
.shdzt1 .d3{margin:0 10px 0 0;width:30px;text-align:right;}

.shdz{font-size:14px;margin:15px 0 0 0;}
.shdz .d1{margin:1px 0 0 10px;width:30px;}
.shdz .d2{-webkit-box-flex:1;-moz-box-flex:1;box-flex:1;margin:0 0 0 0;overflow:hidden;}
.shdz .d2 select{background-color:#fff;border:0;width:110%;float:left;font-size:14px;}
.shdz .d3{margin:0 10px 0 0;width:30px;text-align:right;}

.shdzok{font-size:14px;margin:15px 0 0 0;text-align:center;color:#fff;}
.shdzok .d1{-webkit-box-flex:1;-moz-box-flex:1;box-flex:1;margin:0 1px 0 0;padding:10px 0 0 0;height:30px;background-color:#ff6600;}
.shdzok .d2{-webkit-box-flex:1;-moz-box-flex:1;box-flex:1;margin:0 0 0 1px;padding:10px 0 0 0;height:30px;background-color:#CCC;}
</style>
<script language="javascript">
function area1cha(){
a=(document.getElementById("area1").value).split("yjcode");
location.href="area2.php?area1id="+a[0];	
}
function area2cha(){
a=(document.getElementById("area2").value).split("yjcode");
location.href="area2.php?area1id=<?=$area1id?>&area2id="+a[0];	
}
function area3cha(){
a=(document.getElementById("area3").value).split("yjcode");
location.href="area2.php?area1id=<?=$area1id?>&area2id=<?=$area2id?>&area3id="+a[0];	
}
function qyok(){
parent.document.getElementById("add1").value=<?=$area1id?>;
parent.document.getElementById("add2").value=<?=$area2id?>;
parent.document.getElementById("add3").value=<?=$area3id?>;
a=(document.getElementById("area1").value).split("yjcode");
b=(document.getElementById("area2").value).split("yjcode");
c=(document.getElementById("area3").value).split("yjcode");
qy=a[1]+b[1]+c[1];
parent.document.getElementById("qyname").innerHTML=qy;
qyclo();
}
function qyclo(){
parent.layer.closeAll();
}
</script>
</head>
<body>
<div class="shdzt1 box">
 <div class="d1">省：</div>
 <div class="d2">
  <select name="area1" id="area1" onChange="area1cha()">
  <option value="0">请选择</option>
  <? while3("*","yjcode_city where level=1 order by xh asc");while($row3=mysql_fetch_array($res3)){?>
  <option value="<?=$row3[bh]?>yjcode<?=$row3[name1]?>"<? if($row3[bh]==$area1id){?> selected="selected"<? }?>><?=$row3[name1]?></option>
  <? }?>
  </select>
 </div>
 <div class="d3"><img src="../img/rightjian.png" height="14" /></div>
</div>

<div class="shdz box">
 <div class="d1">市：</div>
 <div class="d2">
  <select name="area2" id="area2" onChange="area2cha()">
  <option value="0">请选择市</option>
  <? while1("*","yjcode_city where level=2".$ses1." order by xh asc");while($row1=mysql_fetch_array($res1)){?>
  <option value="<?=$row1[bh]?>yjcode<?=$row1[name1]?>"<? if($row1[bh]==$area2id){?> selected="selected"<? }?>><?=$row1[name1]?></option>
  <? }?>
  </select>
 </div>
 <div class="d3"><img src="../img/rightjian.png" height="14" /></div>
</div>

<div class="shdz box">
 <div class="d1">区：</div>
 <div class="d2">
  <select name="area3" id="area3" onChange="area3cha()">
  <option value="0">请选择区</option>
  <? while2("*","yjcode_city where level=3".$ses2." order by xh asc");while($row2=mysql_fetch_array($res2)){?>
  <option value="<?=$row2[bh]?>yjcode<?=$row2[name1]?>"<? if($row2[bh]==$area3id){?> selected="selected"<? }?>><?=$row2[name1]?></option>
  <? }?>
  </select>
 </div>
 <div class="d3"><img src="../img/rightjian.png" height="14" /></div>
</div>

<div class="shdzok box">
 <div class="d1" onClick="qyok()">确定</div>
 <div class="d2" onClick="qyclo()">取消</div>
</div>

</body>
</html>