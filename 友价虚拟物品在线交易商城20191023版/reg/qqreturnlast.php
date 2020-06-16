<?
include("../config/conn.php");
include("../config/function.php");
require_once("../config/qq/API/qqConnectAPI.php");
$qc = new QC();
$acs = $qc->qq_callback();
$openid = $qc->get_openid();
if($_SESSION[TZPCWAP]=="wap"){$nlj="m/";}

//表示已登录开始 进行绑定
if(!empty($_SESSION["SHOPUSER"])){
 if(panduan("uid,openid,ifqq","yjcode_user where openid='".$openid."' and ifqq=1")==1){Audit_alert("绑定失败，该QQ已经绑定过其他帐号","../".$nlj."user/");}
 updatetable("yjcode_user","openid='',ifqq=0 where openid='".$openid."'");
 updatetable("yjcode_user","openid='".$openid."',ifqq=1 where uid='".$_SESSION[SHOPUSER]."'");	
 php_toheader(returnjgdw($_SESSION["tzURL"],"","../".$nlj."user/"));
}
//表示已登录结束 进行绑定

//表示未登录开始
while0("uid,openid,pwd","yjcode_user where openid='".$openid."'");if($row=mysql_fetch_array($res)){ //表示该QQ已经被绑定
 $_SESSION["SHOPUSER"]=$row[uid];
 $_SESSION["SHOPUSERPWD"]=$row[pwd];
 php_toheader(returnjgdw($_SESSION["tzURL"],"","../".$nlj."user/"));
 exit;
}

//修改该文件，要同步修改下reg/reg.php、reg/qqreturnlast.php 

$qc = new QC($acs,$openid);
$arr = $qc->get_user_info();

$bh=time();
$sj=date("Y-m-d H:i:s");
$uip=$_SERVER["REMOTE_ADDR"];
$uid="qq".$bh.rnd_num(300);
$pwd="123456";
$nc=iconv('UTF-8', 'GB2312',$arr["nickname"]);
$email=$uid."@qq.com";
include("reg_tem.php");
php_toheader(returnjgdw($_SESSION["tzURL"],"","../".$nlj."user/"));

//表示未登录结束
?>