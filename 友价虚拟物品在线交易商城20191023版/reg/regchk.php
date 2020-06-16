<?
include("../config/conn.php");
include("../config/function.php");
$mob=$_GET[mob];
if(strtolower($_SESSION["authnum_session"])!=strtolower($_GET[tpicyzm])){echo "err1";exit;}
if(empty($mob)){echo "True";exit;}

while1("*","yjcode_smsmb where mybh='000'");
if($row1=mysql_fetch_array($res1)){$txt=$row1[txt];}else{$txt="验证码：${yzm},如果不是本人操作，请忽略此信息。";}
$yz=MakePass(6);
if(empty($rowcontrol[smsmode])){
 include("../config/mobphp/mysendsms.php");
 $str=str_replace("\${yzm}",$yz,$txt);
 yjsendsms($mob,$str);
}else{
 if(1==$rowcontrol[smsmode]){$sms_txt="{yzm:'".$yz."'}";}else{$sms_txt="{\"yzm\":\"".$yz."\"}";}
 $sms_mot=$mob;
 $sms_id=$row1[mbid];
 @include("../config/mobphp/mysendsms.php");
}

updatetable("yjcode_control","smskc=smskc-1");
intotable("yjcode_yzm","tit,yzm,admin","'".$mob."','".$yz."',2");echo "ok";exit;
?>