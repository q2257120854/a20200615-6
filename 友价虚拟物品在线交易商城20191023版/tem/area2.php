<?php
include("../config/conn.php");
include("../config/function.php");
$area1id=intval($_GET[area1id]);
$area2id=intval($_GET[area2id]);
if($area1id!=""){$ses1=" and parentid='".$area1id."'";}
if($area2id!=""){$ses2=" and parentid='".$area2id."'";}else{$ses2=" and id=0";}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>选择市</title>
<style type="text/css">
body{margin:0;font-size:12px;}
p{margin:2pt 0 0 0;}
*{margin:0 auto;padding:0;}
ul{list-style-type:none;margin:0;padding:0;}
.inp{float:left;border:#CCCCCC solid 1px;height:31px;padding:0 0 0 5px;margin-right:7px;font-family:"Microsoft YaHei",微软雅黑,"MicrosoftJhengHei",华文细黑,STHeiti,MingLiu;}
</style>
<script language="javascript">
function area2cha(){
location.href="area2.php?area1id=<?=$_GET[area1id]?>&area2id="+document.getElementById("area2").value;	
}
function area3cha(){
parent.document.f1.add2.value=document.getElementById("area2").value;
parent.document.f1.add3.value=document.getElementById("area3").value;
}
</script>
</head>
<body>

 <!--begin-->
   <select name="area2" class="inp" id="area2" onchange="area2cha()">
   <option value="0">请选择</option>
   <? while1("*","yjcode_city where level=2".$ses1." order by xh asc");while($row1=mysql_fetch_array($res1)){?>
   <option value="<?=$row1[bh]?>"<? if($row1[bh]==$_GET[area2id]){?> selected="selected"<? }?>><?=$row1[name1]?></option>
   <? }?>
   </select>
   
   <select name="area3" class="inp" id="area3" onchange="area3cha()">
   <option value="0">请选择</option>
   <? while2("*","yjcode_city where level=3".$ses2." order by xh asc");while($row2=mysql_fetch_array($res2)){?>
   <option value="<?=$row2[bh]?>"<? if($row2[bh]==$_GET[area3id]){?> selected="selected"<? }?>><?=$row2[name1]?></option>
   <? }?>
   </select>
 <!--end-->
 
 <script language="javascript">
 area3cha();
 </script>
</body>
</html>