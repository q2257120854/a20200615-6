<?
session_start();
header("Content-type: text/html; charset=gb2312"); 
include_once("config.php");
include_once("sql.php");
$conn=@mysql_connect(sqlhost.":".sqldk,sqluid,sqlpwd) or die("ERR001,联系技术人员处理");
mysql_select_db(sqltable,$conn) or die("ERR002,联系技术人员处理");
date_default_timezone_set('Asia/Shanghai');

$sqlcontrol="select * from yjcode_control";mysql_query("SET NAMES 'GBK'");$rescontrol=mysql_query($sqlcontrol,$conn);
if(!$rowcontrol=mysql_fetch_array($rescontrol)){echo "<h1>站点未进行基本配置，导致网站无法运行,联系技术人员处理，错误代码ERR004。</h1>";exit;}
define("weburl",$rowcontrol["weburlv"]); 
define("webname",$rowcontrol["webnamev"]);
define("websypos",$rowcontrol["websyposv"]);
?>