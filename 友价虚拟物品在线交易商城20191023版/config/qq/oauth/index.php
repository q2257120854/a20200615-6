<?php
error_reporting(0);
session_start();
if(!empty($_GET[tz])){$_SESSION[TZPCWAP]=$_GET[tz];}
require_once("../API/qqConnectAPI.php");
$qc = new QC();
$qc->qq_login();
