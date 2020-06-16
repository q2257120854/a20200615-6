<?
include("../config/conn.php");
include("../config/function.php");
AdminSes_audit();
if(sqlzhuru($_POST[yjcode])=="edidir"){
 zwzr();
 if(!strstr($adminqx,",0,")){echo "err3";exit;}
 $t1=trim(sqlzhuru($_POST[t1v]));
 if(!preg_match("/^[_a-zA-Z0-9_]*$/",$t1)){echo "err1";exit;}
 if($rowcontrol[admindir]==$t1){echo "err2";exit;}
 rename("../".$rowcontrol[admindir]."/","../".$t1."/");
 updatetable("yjcode_control","admindir='".$t1."'");
 echo "ok";exit;

}

?>