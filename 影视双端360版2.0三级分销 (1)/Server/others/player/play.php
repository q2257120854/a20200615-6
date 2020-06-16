<?php
$jxapi = "http://api.winds.fun/?v=";
if ( $_GET['play'] != "" ) {
	$url = $jxapi.$_GET['play']; 
	header("location: $url");
}
?>