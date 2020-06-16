<?php
//以下代码为PHP核心代码 如若不明 请勿修改
error_reporting(0);
header('Content-type:text/html;charset=utf-8');

include './inc/config.php';
$page=$_GET['page'];
$page1=$_GET['page']+=1;
$page2=$_GET['page']-1;
$pageurl = $host.'/?page='.$page1;
$pageurl1 = $host.'/?page='.$page2;
$info=file_get_contents('http://www.360kan.com/dianying/listajax?rank=rankhot&cat=all&year=all&area=all&act=all&pageno='.$page1);
$info=json_decode($info,true);
$yuming="http://www.360kan.com";
//print_r($info['data']['list']);exit;
?>