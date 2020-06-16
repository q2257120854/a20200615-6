<?php
$mod='blank';
include("api.inc.php");
$qq=daddslashes($_GET['qq']);

$row=$DB->get_row("SELECT * FROM auth_site WHERE uid='$qq' and active=1 limit 1");
if($row['url'])
echo '1';
else
echo '0';
$DB->close();
?>