<?
if(empty($uid) || empty($pwd)){Audit_alert("帐号或密码输入有误，返回重试","./");}
 $sql="select * from yjcode_user where (uid='".$uid."' or (mot='".$uid."' and ifmot=1)) and pwd='".sha1($pwd)."'";mysql_query("SET NAMES 'GBK'");$res=mysql_query($sql,$conn);
 ;if(!$row=mysql_fetch_array($res)){Audit_alert("帐号密码验证错误，请返回重试","./");}
 if(0==$row[zt]){Audit_alert("您的帐号已被禁用，请联系网站客服处理","./");}
 $sj=date("Y-m-d H:i:s");
 intotable("yjcode_loginlog","admin,userid,sj,uip","1,".$row[id].",'".$sj."','".getuip()."'");
 $_SESSION["SHOPUSER"]=$row[uid];
 $_SESSION["SHOPUSERPWD"]=$row[pwd];
?>