<?
 //UC开始
 if(1==$rowcontrol[ifuc]){
 if($WAPLJ==1){$wapljv="../";}
 include $wapljv."../config.inc.php";
 include $wapljv."../include/db_mysql.class.php";
 $db = new dbstuff;
 $db->connect($dbhost, $dbuser, $dbpw, $dbname, $pconnect);
 unset($dbhost, $dbuser, $dbpw, $dbname, $pconnect);
 include $wapljv."../uc_client/client.php";
 if($data = uc_get_user(sqlzhuru($_POST[t1]))){Audit_alert("该用户名已经被注册，重新选择","reg.php");}
 }
 //UC结束
?>