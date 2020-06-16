<?php
include("../../config/conn.php");
include("../../config/function.php");
$type1id=$_GET[type1id];
$type2id=$_GET[type2id];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>二级分类</title>
<style type="text/css">
body{margin:0;}
ul{margin:0;list-style-type:none;}
p{margin:2pt 0 0 0;}
*{margin:0 auto;padding:0;}
input,select{outline: medium none;}
</style>
</head>
<body>
<? 
if(!empty($type1id) && !empty($type2id)){
$type1name=returntype(1,$_GET[type1id]);
$type2name=returntype(2,$_GET[type2id]);
?>
<select name="d1" id="d1" style="font-size:13px;border:0;width:120%;background-color:transparent;" onChange="prosx2()">
<option value="0">选择三级分类(可留空)</option>
<? while2("*","yjcode_type where admin=3 and type1='".$type1name."' and type2='".$type2name."' order by xh asc");while($row2=mysql_fetch_array($res2)){?>
<option value="<?=$row2[id]?>" <? if(intval($_GET[nid])==$row2[id]){?>selected="selected"<? }?>><?=$row2[type3]?></option>
<? }?>
</select>
<? }?>
<script language="javascript">
function prosx2(){
d=options=document.getElementById("d1").value;
parent.ptype4.location="protype4.php?type1id=<?=$type1id?>&type2id=<?=$type2id?>&type3id="+d;
parent.ptype5.location="protype5.php";
parent.document.f1.type3id.value=d;
parent.document.f1.type4id.value=0;
parent.document.f1.type5id.value=0;
}
</script>
</body>
</html>