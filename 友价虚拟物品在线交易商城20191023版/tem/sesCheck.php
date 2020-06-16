<?
error_reporting(0);
header("Content-Type:text/html;charset=GB2312");
session_start();
include("../config/conn.php");
include("../config/function.php");
if($_SESSION["SHOPUSER"]==""){echo 0;exit;}else{
while2("*","yjcode_user where uid='".$_SESSION["SHOPUSER"]."'");$row2=mysql_fetch_array($res2);
echo returnjgdw($row2[nc],"",$row2[uid]);
 while1("*","yjcode_qiandao where userid=".returnuserid($_SESSION[SHOPUSER])." order by sj desc limit 1");
 if($row1=mysql_fetch_array($res1)){
 $sj=date("Y-m-d H:i:s");
 $a_ux = strtotime($sj);
 $a_date = date('Y-m-d',$a_ux);
 $b_date = date('Y-m-d',strtotime($row1[sj]));
 if($a_date==$b_date){$ifq="yes";}else{$ifq="no";}
 }else{$ifq="no";}
 echo " ".$ifq;
 echo " ".sprintf("%.2f",$row2[money1])." ".returntppd("../upload/".$row2[id]."/user.jpg","/user/img/nonetx.gif")." ".$row2[id];
}
?>