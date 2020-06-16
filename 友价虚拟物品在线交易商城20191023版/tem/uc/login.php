<?
//修改这个，要同步修改手机版的
/////////////////////有uc开始//////////////////////
if(1==$rowcontrol[ifuc]){
 $sj=date("Y-m-d H:i:s");
 $uip=$_SERVER["REMOTE_ADDR"];
 if($WAPLJ==1){$wapljv="../";$wapljv1="../../reg/";}
 include $wapljv."../config.inc.php";
 include $wapljv."../include/db_mysql.class.php";
 $db = new dbstuff;
 $db->connect($dbhost, $dbuser, $dbpw, $dbname, $pconnect);
 unset($dbhost, $dbuser, $dbpw, $dbname, $pconnect);
 include $wapljv."../uc_client/client.php";
 list($uid, $username, $password, $email) = uc_user_login(sqlzhuru($_POST[t1]), sqlzhuru($_POST[t2]));  //登录
  if($uid>0) {   //uc登录成功
   echo uc_user_synlogin($uid);  //同步登录
   if(panduan("uid","yjcode_user where uid='".sqlzhuru($_POST[t1])."'")==0){
    $uid=sqlzhuru($_POST[t1]);
    $pwd=sqlzhuru($_POST[t2]);
    $nc=sqlzhuru($_POST[t1]);
    include($wapljv1."reg_tem.php");
   }else{
    $uid=sqlzhuru($_POST[t1]);
	$sql="select id,uid,pwd,zt from yjcode_user where uid='".$uid."'";mysql_query("SET NAMES 'GBK'");$res=mysql_query($sql,$conn);$row=mysql_fetch_array($res);
    if(0==$row[zt]){Audit_alert("您的帐号已被禁用，请联系网站客服处理","./");}
    $sj=date("Y-m-d H:i:s");
    $uip=$_SERVER["REMOTE_ADDR"];
    intotable("yjcode_loginlog","admin,userid,sj,uip","1,".$row[id].",'".$sj."','".$uip."'");
    $_SESSION["SHOPUSER"]=$uid;
	$_SESSION["SHOPUSERPWD"]=$row[pwd];
   }
  }else{   //uc登录失败
   $uid=sqlzhuru($_POST[t1]);$pwd=sqlzhuru($_POST[t2]);
   include($wapljv1."login_tem.php");
   if($data = uc_get_user($uid)) {
   uc_user_edit($uid ,$pwd,$pwd,"",1);
   }else{
   $ma=returnemail($uid);
   $uid = uc_user_register($uid,$pwd,$ma);
   }
   list($uid, $username, $password, $email) = uc_user_login($uid,$pwd);  //uc登录
   echo uc_user_synlogin($uid);  //同步登录
  }
php_toheader(returnjgdw($_SESSION["tzURL"],"","../user/"));
}
////////////////////有UC结束////////////////////////

?>