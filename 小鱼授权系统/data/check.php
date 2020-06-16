<?php
include("../system/api.inc.php");
define("VERSION",3072);//最新版本号
@header("content-Type:text/json;charset=utf-8");
$bb='../pack/version.php';
$version = file_get_contents($bb); //版本号标识
$url=daddslashes($_GET['url']);
$authcode=daddslashes($_GET['authcode']);
$content="<html xmlns=\"http://www.w3.org/1999/xhtml\" lang=\"zh-CN\">
    <head>
        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
        <title>千寻网络提示您</title>
        <style type=\"text/css\">
html{background:#eee}body{background:#fff;color:#333;font-family:\"微软雅黑\",\"Microsoft YaHei\",sans-serif;margin:2em auto;padding:1em 2em;max-width:700px;-webkit-box-shadow:10px 10px 10px rgba(0,0,0,.13);box-shadow:10px 10px 10px rgba(0,0,0,.13);opacity:.8}h1{border-bottom:1px solid #dadada;clear:both;color:#666;font:24px \"微软雅黑\",\"Microsoft YaHei\",,sans-serif;margin:30px 0 0 0;padding:0;padding-bottom:7px}#error-page{margin-top:50px}h3{text-align:center}#error-page p{font-size:9px;line-height:1.5;margin:25px 0 20px}#error-page code{font-family:Consolas,Monaco,monospace}ul li{margin-bottom:10px;font-size:9px}a{color:#21759B;text-decoration:none;margin-top:-10px}a:hover{color:#D54E21}.button{background:#f7f7f7;border:1px solid #ccc;color:#555;display:inline-block;text-decoration:none;font-size:9px;line-height:26px;height:28px;margin:0;padding:0 10px 1px;cursor:pointer;-webkit-border-radius:3px;-webkit-appearance:none;border-radius:3px;white-space:nowrap;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;-webkit-box-shadow:inset 0 1px 0 #fff,0 1px 0 rgba(0,0,0,.08);box-shadow:inset 0 1px 0 #fff,0 1px 0 rgba(0,0,0,.08);vertical-align:top}.button.button-large{height:29px;line-height:28px;padding:0 12px}.button:focus,.button:hover{background:#fafafa;border-color:#999;color:#222}.button:focus{-webkit-box-shadow:1px 1px 1px rgba(0,0,0,.2);box-shadow:1px 1px 1px rgba(0,0,0,.2)}.button:active{background:#eee;border-color:#999;color:#333;-webkit-box-shadow:inset 0 2px 5px -3px rgba(0,0,0,.5);box-shadow:inset 0 2px 5px -3px rgba(0,0,0,.5)}table{table-layout:auto;border:1px solid #333;empty-cells:show;border-collapse:collapse}th{padding:4px;border:1px solid #333;overflow:hidden;color:#333;background:#eee}td{padding:4px;border:1px solid #333;overflow:hidden;color:#333}
        </style>
    </head>
    <body id=\"error-page\" style=\"text-align: center\">
        <font color='#FF0000'><h3>千寻网络提示您</h3></font>
        <font color='#FFFF00'><b>发现你使用的是盗版程序或者未授权程序，请停止使用。</font></br>
        <font color='#FF00FF'>为了你的安全请购买正版</br></font>
        <font color='#00FF00'>QQ号：3436901764购买，如不同意，群号：169870254</b></font></body>
	";//未授权显示内容
$allowupdate=1;
$log='../pack/log.php';
$uplog = file_get_contents($log); //版本号标识
$zj_log='../pack/zj_log.php';
$zj_uplog = file_get_contents($zj_log); //版本号标识
//$uplog='目录服务器暂时维护!';


if(!$_GET['ver'] && ($url=='localhost' || $url=='127.0.0.1'))exit();


if($_GET['ver']) {
  
	if($allowupdate==1) {
		if($_GET['ver']>=$version) {
			$code=0;
			$msg='<font color="green">您使用的已是最新版本！</font><br/>当前版本：V'.$version.' (Build '.VERSION.')';
		} else {
			$code=1;
			$msg='<font color="red">发现新版本(～￣▽￣)～！</font> 最新版本：V'.$version.' (Build '.VERSION.')';
		}
	} else {
		$code=0;
		$msg='<font color="blue">更新服务器正在维护，请稍后访问！</font>';
	}
}

if(checkauth($url)) {
	if($_GET['ver']){
		$result=array('code'=>$code,'msg'=>$msg,'log'=>$uplog,'version'=>$version,'zjlog'=>$zj_uplog,'file'=>$download);
    }else{
		$result=array('code'=>'1','authcode'=>$authcode);
    }
} else {
	$result=array('code'=>'-1','msg'=>$content);
}

echo json_encode($result);
?>
