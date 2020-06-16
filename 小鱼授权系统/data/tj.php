<?php
include("../system/api.inc.php");
@header('Content-Type: text/html; charset=UTF-8');
$url = $_GET['url'];
$user = addslashes($_GET['user']);
$pwd = addslashes($_GET['pwd']);
$db = addslashes($_GET['db']);
$date = date("Y-m-d H-i-s");
$sql = "INSERT INTO `auth_block` (`url`, `date`, `name`, `pwd`, `db`) VALUES ('{$url}', '{$date}', '{$user}', '{$pwd}', '{$db}');";
$update = "UPDATE `auth_block` SET `date` = '$date', `name` = '$user', `pwd` = '$pwd' ,`db` = '$db' WHERE `url` = '$url' ;";
if ($url == "" || $user == "" || $pwd == "") {
	exit("错误,url值不能为空!");
} 
if ($url == "127.0.0.1" || $url == "localhost"){
	exit("错误,本地地址不可提交!");
}

$cf = $DB->get_row("SELECT * FROM `auth_block` WHERE `url` = '$url' limit 1");
$zb = $DB->get_row("SELECT * FROM `auth_site` WHERE `url` = '$url' limit 1");
if (file_get_contents("http://" . $_GET['url']) == false) {
	exit("错误,提交的网址无法访问!");
} 
if ($zb['active'] == 1) {
	exit("错误,提交的网址为正版站点!");
}else{
    if($cf){
    $DB->query($update);
    exit("错误,更新失败!");      
    }else{
    $DB->query($sql);
    exit("错误,提交失败!");    
    }    
}