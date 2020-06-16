<?php
header("Content-Type: text/html;charset=utf-8");//输出不乱码，你懂的 
$mod='blank';
include("api.inc.php");
$get_token=isset($_SESSION['get_token'])?$_SESSION['get_token']:exit;
$uin=daddslashes($_GET['qq']);

if(!$get_token || !$uin){exit();}

$tokenid=base64_encode(md5($uin.md5($uin.'*$$*').'23132'.md5(date("Y-m-d-H"))));

if($tokenid!=$get_token)exit("<meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
<script language='javascript'>alert('验证信息已过期，请返回重新扫码验证。');history.go(-1);</script>");

$row=$DB->get_row("SELECT * FROM auth_site WHERE uid='$uin' limit 1");
$authcode=$row['authcode'];
$sign=$row['sign'];
if(!$authcode || !$sign){exit();}

require_once('pclzip.php');
$file_real=substr($authcode,0,16).'.zip';
$file=CACHE_DIR."/{$file_real}";

if($_GET['my']=='installer') {
echo "<script>alert('正在创建下载进程，即将开始下载');window.location.href='./download/release6000/release_installer.zip';</script>";
}elseif($_GET['my']=='updater') {
$file_path=ROOT.PACKAGE_DIR.'/update6000/';

$file_str=file_get_contents(ROOT.PACKAGE_DIR.'/authcode.php');
$file_str=str_replace('1000000001',$authcode,$file_str);
file_put_contents($file_path.'includes/authcode.php',$file_str);

$file_name='update.zip';
}

if(file_exists($file))unlink($file);
$zip = new PclZip($file);
$v_list = $zip->create($file_path ,PCLZIP_OPT_REMOVE_PATH,$file_path);

$file_size=filesize("$file");

?>