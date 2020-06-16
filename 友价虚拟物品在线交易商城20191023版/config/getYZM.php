<?
session_start();
include("yzSes.php");
$_vc = new ValidateCode();
$_vc->doimg();
$_SESSION["authnum_session"] = $_vc->getCode();
?>