<?
include("../config/conn.php");
include("../config/function.php");
if($_GET[id]=="" || empty($_SESSION[SHOPUSER])){echo "err1";exit;}
$id=intval($_GET[id]);
$userid=returnuserid($_SESSION["SHOPUSER"]);
while0("*","yjcode_smsmail where userid=".$userid." and id=".$id);if(!$row=mysql_fetch_array($res)){echo "err1";exit;}
deletetable("yjcode_smsmail where id=".$id." and userid=".$userid);

if($row[admin]==1){ //发送邮件
 require("../config/mailphp/sendmail.php");
 @yjsendmail($row[tit],$row[fa],$row[txt]);

}elseif($row[admin]==2){ //发送手机短信
 
 while3("*","yjcode_smsmb where mybh='004'");
 if($row3=mysql_fetch_array($res3)){$txt=$row3[txt];}else{$txt=$row[txt];}
 if(empty($rowcontrol[smsmode])){
  include("../config/mobphp/mysendsms.php");
  $str=str_replace("\${tit}",$row[tit],$txt);
  @yjsendsms($row[fa],$str);
 }else{
  $sms_txt="{tit:'".$row[tit]."'}";
  if(1==$rowcontrol[smsmode]){$sms_txt="{tit:'".$row[tit]."'}";}else{$sms_txt="{\"tit\":\"".$row[tit]."\"}";}
  $sms_mot=$row[fa];
  $sms_id=$row3[mbid];
  @include("../config/mobphp/mysendsms.php");
 }
 
 updatetable("yjcode_control","smskc=smskc-1");

}


echo "ok";
?>