<?php
include("./system/api.inc.php");
$param=base64_decode($_GET['cs']);
$arr=explode("\t",authcode($param,'DECODE','daigua!!1'));
$version=$arr[0];
$url=$arr[1];
$authcode=$arr[2];

if(!$url || !$authcode){exit();}

if($arr[3]<time())exit("<meta http-equiv='Content-Type' content='text/html; charset=utf-8'/><script language='javascript'>alert('链接已过期，请返回重新下载');history.go(-1);</script>");

if(checkauth($url,$authcode)) {
} else {
	exit("<meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
<script language='javascript'>alert('授权码异常，暂时不能获取更新，请联系QQ：1482222908');history.go(-1);</script>");
}

$row=$DB->get_row("SELECT * FROM auth_site WHERE url='$url' and authcode='$authcode' limit 1");
$sign=$row['sign'];

require_once('./system/pclzip.php');
$file_real=substr($authcode,0,16).'.zip';
$file="./cache/{$file_real}";
$file_path='./pack/azb/';

//写入授权码
$file_str=file_get_contents('./pack/authcode.php');
$file_str=str_replace('f6d56ee49ce5ec8a',$authcode,$file_str);
file_put_contents($file_path.'includes/authcode.php',$file_str);

if(file_exists($file))unlink($file);
$zip = new PclZip($file);
$v_list = $zip->create($file_path ,PCLZIP_OPT_REMOVE_PATH,$file_path);

$file_name='update.zip';
$file_size=filesize("$file");
header("Content-Description: File Transfer");
header("Content-Type:application/force-download");
header("Content-Length: {$file_size}");
header("Content-Disposition:attachment; filename={$file_name}");
readfile("$file");
?>