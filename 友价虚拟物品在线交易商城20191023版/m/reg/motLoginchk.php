<?
include("../../config/conn.php");
include("../../config/function.php");
$mot=sqlzhuru($_GET[mob]);
if(empty($mot)){echo "True";exit;}
if(!preg_match("/^1[3456789]\d{9}$/", $mot)){echo "err1";exit;}

$yz=MakePass(6);
htmlget(weburl."tem/getmobyzm.php?yz=".$yz."&mob=".$mot."&smsbh=000");

updatetable("yjcode_control","smskc=smskc-1");
intotable("yjcode_yzm","tit,yzm,admin","'".$mot."','".$yz."',2");
?>