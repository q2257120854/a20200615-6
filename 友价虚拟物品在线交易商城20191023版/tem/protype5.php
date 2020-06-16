<?php
include("../config/conn.php");
include("../config/function.php");
$type1id=intval($_GET[type1id]);
$type2id=intval($_GET[type2id]);
$type3id=intval($_GET[type3id]);
$type4id=intval($_GET[type4id]);
if(!is_numeric($type1id)){$type1id=0;}
if(!is_numeric($type2id)){$type2id=0;}
if(!is_numeric($type3id)){$type3id=0;}
if(!is_numeric($type4id)){$type4id=0;}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>选择商品分类</title>
<link href="../css/pty.css" rel="stylesheet" type="text/css" />
<script language="javascript">
function type5cx(a,b){
parent.document.f1.type5id.value=a;
parent.document.getElementById("type5name").innerHTML=b;
}
</script>
</head>
<body>
 <? 
 if($type4id!=0){
 $type1name=returntype(1,$type1id);
 $type2name=returntype(2,$type2id);
 $type3name=returntype(3,$type3id);
 $type4name=returntype(4,$type4id);
 ?>
 <!--begin-->
  <div class="ptype2">
  <a href="javascript:void(0);" class="a1"><?=$type4name?> <img border="0" src="../img/jiandown.gif" width="7" height="4" /></a>
   <?
   while0("*","yjcode_type where type1='".$type1name."' and type2='".$type2name."' and type3='".$type3name."' and type4='".$type4name."' and admin=5 order by xh asc");while($row=mysql_fetch_array($res)){
   ?>
   <a href="javascript:type5cx(<?=$row[id]?>,'<?=$row[type5]?>');" class="a2"><?=$row[type5]?></a>
   <?
   }
   ?>
  </div>
 <!--end-->
 <? }?>
</body>
</html>