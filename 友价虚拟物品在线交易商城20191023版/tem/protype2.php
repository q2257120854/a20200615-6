<?php
include("../config/conn.php");
include("../config/function.php");
$type1id=intval($_GET[type1id]);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>选择商品分类</title>
<link href="../css/pty.css" rel="stylesheet" type="text/css" />
<script language="javascript">
function prosx2(b,c){
parent.ptype3.location="../tem/protype3.php?type1id=<?=$type1id?>&type2id="+b;
parent.document.f1.type2id.value=b;
parent.document.getElementById("type2name").innerHTML=c+" >> ";
parent.document.f1.type3id.value=0;
parent.document.getElementById("type3name").innerHTML="";
parent.document.f1.type4id.value=0;
parent.document.getElementById("type4name").innerHTML="";
parent.document.f1.type5id.value=0;
parent.document.getElementById("type5name").innerHTML="";
}
</script>
</head>
<body>

 <? 
 if($type1id!="" && $type1id!="0"){
 $type1name=returntype(1,$_GET[type1id]);
 ?>
 <!--begin-->
  <div class="ptype2">
  <a href="javascript:void(0);" class="a1"><?=$type1name?> <img border="0" src="../img/jiandown.gif" width="7" height="4" /></a>
   <? while2("*","yjcode_type where admin=2 and type1='".$type1name."' order by xh asc");while($row2=mysql_fetch_array($res2)){?>
   <a href="javascript:prosx2(<?=$row2[id]?>,'<?=$row2[type2]?>');" class="a2"><?=$row2[type2]?></a>
   <? }?>
  </div>
 <!--end-->
 <? }?>

</body>
</html>