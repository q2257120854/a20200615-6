<?
include("../config/conn.php");
include("../config/function.php");
$u=htmlspecialchars('http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
if($u!=""){
 $a=preg_split("/gotourl.php\?u=/",$u);
 php_toheader($a[1]);
}else{echo "днЮобнЪОЭјжЗ";}
?>