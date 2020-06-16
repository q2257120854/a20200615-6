<?php
include("../config/conn.php");
include("../config/function.php");
AdminSes_audit();
$bh=$_GET[bh];

if($_GET[control]=="xh"){
 zwzr();
 $xhall=intval($_POST["xhall"]);
 for($i=1;$i<$xhall;$i++){
  $xh=intval($_POST["xht".$i]);
  $xhid=intval($_POST["xhid".$i]);
  updatetable("yjcode_tp","xh=".$xh." where id=".$xhid);
 }
 php_toheader("tpxh.php?t=suc&bh=".$bh);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><?=webname?>管理系统</title>
<link rel="stylesheet" href="layui/css/layui.css">
<link href="css/basic.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script language="javascript" src="js/basic.js"></script>
<script language="javascript" src="js/layer.js"></script>
<style type="text/css">
.tplist{float:left;width:610px;}
.tplist .d1{float:left;width:90px;margin:10px 0 0 10px;}
.tplist .d1 img{width:90px;height:90px;}
.tplist .d1 a{float:left;width:100%;}
.tplist .d1 input{float:left;width:88px;text-align:center;margin:5px 0 0 0;}
.tplist .xhbtn{float:left;width:100%;}
.tplist .xhbtn input{float:left;width:200px;height:30px;margin:10px 0 10px 205px;cursor:pointer;border:0;color:#fff;background-color:#ff6600;}
</style>
<script language="javascript">
function tj(){
layer.msg('正在保存', {icon: 16  ,time: 0,shade :0.25});
f1.action="tpxh.php?control=xh&bh=<?=$bh?>";
}
<? if($_GET[t]=="suc"){?>
parent.xgtread("<?=$bh?>");
parent.layer.closeAll();
<? }?>
</script>
</head>
<body>
<div class="tplist">
 <form name="f1" method="post" onsubmit="return tj()">
 <?
 $i=1;
 while1("*","yjcode_tp where bh='".$bh."' order by xh asc");while($row1=mysql_fetch_array($res1)){
 if(empty($row1[upty])){
  $tp1="../".$row1[tp];
  $tp2="../".str_replace(".","-1.",$row1[tp]); 
 }else{
  $tp1=$row1[tp];
  $tp2=returnnotp($row1[tp],"-1");
 }
 ?>
 <div class="d1">
 <a href="<?=$tp1?>" class="a1" target="_blank"><img class="img" border="0" src="<?=$tp2?>" /></a>
 <input type="text" value="<?=$row1[xh]?>" name="xht<?=$i?>" />
 <input type="hidden" value="<?=$row1[id]?>" name="xhid<?=$i?>" />
 </div>
 <? $i++;}?>
 <input type="hidden" value="<?=$i?>" name="xhall" />
 <div class="xhbtn">
 <input type="submit" value="保存序号" />
 </div>
 </form>
</div>
</body>
</html>