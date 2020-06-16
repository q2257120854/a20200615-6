<?
 //UC¿ªÊ¼
 if(1==$rowcontrol[ifuc]){
 include '../config.inc.php';
 include '../include/db_mysql.class.php';
 $db = new dbstuff;
 $db->connect($dbhost, $dbuser, $dbpw, $dbname, $pconnect);
 include '../uc_client/client.php';
 if($data = uc_get_user($uid)){echo "True";exit;}
 }
 //UC½áÊø
?>