<?
include("../../config/conn.php");
include("../../config/function.php");
$mob=sqlzhuru($_GET[mob]);
if(empty($mob)){echo "err1";exit;}
if(!preg_match("/^1[3456789]\d{9}$/", $mob)){echo "err1";exit;}
if(panduan("mot,ifmot","yjcode_user where mot='".$mob."' and ifmot=1")==1){echo "True";exit;}
$yz=MakePass(6);

htmlget(weburl."tem/getmobyzm.php?yz=".$yz."&mob=".$mob."&smsbh=000");

deletetable("yjcode_yzm where tit='".$mob."' and admin=1");
intotable("yjcode_yzm","tit,yzm,admin","'".$mob."','".$yz."',1");

?>