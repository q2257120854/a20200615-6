<?
include("../config/conn.php");
include("../config/function.php");
$id=intval($_GET[id]);
$w=returnjgdw($_GET[w],"",790);
$h=returnjgdw($_GET[h],"",470);
$bh=$_GET[bh];
if(empty($id)){
while1("*","yjcode_provideo where zt=0 and probh='".$bh."' order by sj desc");if($row1=mysql_fetch_array($res1)){$id=$row1[id];}
}
while1("*","yjcode_provideo where id=".$id);if(!$row1=mysql_fetch_array($res1)){exit;}
if($row1[gs]!="mp4"){echo returnvideo($id,$w,$h);exit;}
?>
<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<title>ckplayer</title>
		<script type="text/javascript" src="ckplayer/ckplayer.js" charset="UTF-8"></script>
		<style type="text/css">
			body {
				margin: 0;
				padding: 0px;
				font-family: "Microsoft YaHei", YaHei, "微软雅黑", SimHei, "黑体";
				font-size: 14px
			}
		</style>

	</head>

	<body>
    
    <div class="video" style="width:<?=$w?>px;height:<?=$h?>px;"></div>
<script type="text/javascript">
	var videoObject = {
		container: '.video',
		variable: 'player',
		poster:'pic/wdm.jpg',
		video:'<?=$row1[url]?>'
	};
	var player=new ckplayer(videoObject);
</script>
</body>
</html>
