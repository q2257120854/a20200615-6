<?
$luserid=$rowuser[id];
createDir("../../upload/".$luserid."/");
sellmoneytj($luserid);
$autoses="(selluserid=".$luserid." or userid=".$luserid.")";
include("../../user/auto.php");
include("../tem/moban/".$rowcontrol[wapmb]."/tem/bottom.php");
?>
