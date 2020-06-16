<?
include("../../config/conn.php");
include("../../config/function.php");

$wxpay=preg_split("/,/",$rowcontrol[wxpay]);
$u="https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$wxpay[0]."&secret=".$wxpay[3]."&code=".$_GET[code]."&grant_type=authorization_code";
$str1=file_get_contents($u);
$a1=preg_split("/access_token\":\"/",$str1);
if(empty($a1[0])){php_toheader("../");}
$a2=preg_split("/\"/",$a1[1]);
$b1=preg_split("/openid\":\"/",$str1);
$b2=preg_split("/\"/",$b1[1]); 
$wxopenid=$b2[0]; //唯一识别号
if(empty($wxopenid)){php_toheader(weburl);}
$u="https://api.weixin.qq.com/sns/userinfo?access_token=".$a2[0]."&openid=".$wxopenid."&lang=zh_CN";
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
}else{
$noses="wxopenid='".$wxopenid."'";
}

if(empty($noses)){php_toheader(weburl."m");}
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
$WAPLJ=1;
include("../../reg/reg_tem.php");
php_toheader(returnjgdw($_SESSION["tzURL"],"","../user/"));

//表示未登录结束

?>