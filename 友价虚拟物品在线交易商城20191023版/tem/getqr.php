<?
error_reporting(0); 
include('../config/phpqrcode/phpqrcode.php'); 
$data = $_GET[u]; 
$errorCorrectionLevel = "L"; 
$matrixPointSize = $_GET[size]; 
QRcode::png($data, false, $errorCorrectionLevel, $matrixPointSize); 
exit; 
?>