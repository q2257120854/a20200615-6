<?
include("../config/conn.php");
include("../config/function.php");
$bh=$_GET[bh];
if(empty($bh)){exit;}
if(empty($_SESSION["SHOPUSER"])){echo "err1";exit;}
while1("bh,userid","yjcode_pro where bh='".$bh."' and zt=0 and ifxj=0");if(!$row1=mysql_fetch_array($res1)){exit;}
$userid=returnuserid($_SESSION["SHOPUSER"]);
if($userid==$row1[userid]){echo "err2";exit;}
if(panduan("probh,userid","yjcode_profav where probh='".$bh."' and userid=".$userid)==1){echo "ok";exit;}
$sj=date("Y-m-d H:i:s");
intotable("yjcode_profav","probh,userid,selluserid,sj","'".$bh."',".$userid.",".$row1[userid].",'".$sj."'");
echo "ok";exit;
?>
