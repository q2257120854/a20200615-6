<?
include("../config/conn.php");
include("../config/function.php");

$wxlogin=preg_split("/,/",$rowcontrol[wxlogin]);
$u="https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$wxlogin[0]."&secret=".$wxlogin[1]."&code=".$_GET[code]."&grant_type=authorization_code";
$str1=file_get_contents($u);
$a1=preg_split("/access_token\":\"/",$str1);
if(empty($a1[0])){php_toheader("../");}
$a2=preg_split("/\"/",$a1[1]);
$b1=preg_split("/openid\":\"/",$str1);
$b2=preg_split("/\"/",$b1[1]); 
$wxopenid=$b2[0]; //唯一识别号
if(empty($wxopenid)){php_toheader(weburl);}

$u="https://api.weixin.qq.com/sns/userinfo?access_token=".$a2[0]."&openid=".$wxlogin[0];
$str3=file_get_contents($u);
$c1=preg_split("/nickname\":\"/",$str3);
$c2=preg_split("/\"/",$c1[1]);
$d1=preg_split("/headimgurl\":\"/",$str3);
$d2=preg_split("/\"/",$d1[1]);
$tx=str_replace("\\","",$d2[0]); //头像
if(check_in("unionid",$str3)){
$e1=preg_split("/unionid\":\"/",$str3);
$e2=preg_split("/\"/",$e1[1]); 
$unionid=$e2[0];
$noses="unionid='".$unionid."'";
$noses1="wxopenid='".$wxopenid."',unionid='".$unionid."'";
}else{
$noses="wxopenid='".$wxopenid."'";
$noses1="wxopenid='".$wxopenid."'";
}

if(empty($noses)){php_toheader(weburl);}

//表示已登录开始 进行绑定
if(!empty($_SESSION["SHOPUSER"])){
 if(panduan("uid,wxopenid,unionid","yjcode_user where ".$noses." and uid='".$_SESSION["SHOPUSER"]."'")==1)
 {Audit_alert("绑定失败，该微信已经绑定过其他帐号","../".$nlj."user/");}
 updatetable("yjcode_user",$noses1." where uid='".$_SESSION[SHOPUSER]."'");	
 php_toheader(returnjgdw($_SESSION["tzURL"],"","../".$nlj."user/"));
}
//表示已登录结束 进行绑定


//表示未登录开始
while0("uid,wxopenid,unionid,pwd","yjcode_user where ".$noses);if($row=mysql_fetch_array($res)){ //表示该微信已经被绑定
 $_SESSION["SHOPUSER"]=$row[uid];
 $_SESSION["SHOPUSERPWD"]=$row[pwd];
 php_toheader(returnjgdw($_SESSION["tzURL"],"","../user/"));
 exit;
}

//修改该文件，要同步修改下reg/reg.php

$nc=iconv('UTF-8', 'GB2312',$c2[0]);
$bh=time();
$sj=date("Y-m-d H:i:s");
$uip=$_SERVER["REMOTE_ADDR"];
$uid="wx".$bh.rnd_num(300);
$pwd="123456";
$email=$uid."@qq.com";
include("../reg/reg_tem.php");
php_toheader(returnjgdw($_SESSION["tzURL"],"","../user/"));

//表示未登录结束

?>