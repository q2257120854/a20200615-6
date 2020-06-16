<?
include("../../config/conn.php");
include("../../config/function.php");
include("../../config/tpclass.php");
if(empty($_SESSION[SHOPUSER])){Audit_alert("登录超时","../reg/","parent.");}
$sqluser="select * from yjcode_user where uid='".$_SESSION[SHOPUSER]."'";mysql_query("SET NAMES 'GBK'");$resuser=mysql_query($sqluser);
if(!$rowuser=mysql_fetch_array($resuser)){Audit_alert("登录超时","../reg/","parent.");}
$userid=$rowuser[id];
$bh=returndeldian($_GET[bh]);
if(!preg_match("/^[-a-zA-Z0-9]*$/",$bh)){exit;}
$admin=intval($_GET[admin]);

$h=returnjgdw($_GET[h],"",103);
$w=returnjgdw($_GET[w],"",103);
$tp="img/tpadd.gif";

if($admin==1){ //店铺LOGO
 $a="../../upload/".$userid."/shop.jpg";
 if(is_file($a)){$tp=$a."?t=".time();}

}elseif($admin==2){ //头像
 $a="../../upload/".$userid."/user.jpg";
 if(is_file($a)){$tp=$a."?t=".time();}

}elseif($admin==7){
 $a="../../upload/".$userid."/".strgb2312($rowuser[sfz],0,15)."-1.jpg";
 if(is_file($a)){$tp=$a."?t=".time();}

}elseif($admin==8){
 $a="../../upload/".$userid."/".strgb2312($rowuser[sfz],0,15)."-2.jpg";
 if(is_file($a)){$tp=$a."?t=".time();}

}elseif($admin==9){
 $a="../../upload/".$userid."/".strgb2312($rowuser[sfz],0,15)."-3.jpg";
 if(is_file($a)){$tp=$a."?t=".time();}

}


if($_GET[action]=="update"){  //上传
 if($admin==1){
  $targetFile = "../../upload/".$userid."/shop.jpg";
  move_uploaded_file($_FILES['inp1']['tmp_name'],$targetFile);
  $cm=new CreatMiniature();
  $bw=300;$bg=300;
  $imgsrc="../../upload/".$userid."/shop.jpg";
  list($width, $height) = getimagesize(weburl."upload/".$userid."/shop.jpg");
  $cm->SetVar($imgsrc,"file");if($width>$bw){$cm->Cut($imgsrc,$bw,$bg);}
 
}elseif($admin==2){
  $targetFile = "../../upload/".$userid."/user.jpg";
  move_uploaded_file($_FILES['inp1']['tmp_name'],$targetFile);
  $cm=new CreatMiniature();
  $bw=200;$bg=200;
  $imgsrc="../../upload/".$userid."/user.jpg";
  list($width, $height) = getimagesize(weburl."upload/".$userid."/user.jpg");
  $cm->SetVar($imgsrc,"file");if($width>$bw){$cm->Cut($imgsrc,$bw,$bg);}


}elseif($admin==3){ //评价B
 while1("*","yjcode_order where orderbh='".$bh."' and userid=".$userid);if(!$row1=mysql_fetch_array($res1)){Audit_alert("登录超时","../reg/","parent.");}
 $targetFolder = "upload/".$userid."/".$bh."/";
 createDir("../../".$targetFolder);
 $total = count($_FILES['inp1']['tmp_name']);
 for($k=0; $k<$total; $k++) {
  if(returncount("yjcode_tp where bh='".$bh."'")<7){
   if(is_uploaded_file($_FILES['inp1']['tmp_name'])){
    $sj=date("Y-m-d H:i:s");
    $mbh=str_replace(" ","",microtime()."tp".$userid);
    $mbh=str_replace(".","",$mbh);
    $targetFile = "../../".$targetFolder.$mbh.".jpg";
	move_uploaded_file($_FILES['inp1']['tmp_name'],$targetFile);
	$cm=new CreatMiniature();
	$bw=800;$bg=0;$sw=350;$sh=350;
	$imgsrc="../../".$targetFolder.$mbh.".jpg";
    list($width, $height) = getimagesize(weburl.$targetFolder.$mbh.".jpg");$bgv=intval($height/($width/$bw));
    $cm->SetVar($imgsrc,"file");if($width>$bw){$cm->BackFill($imgsrc,$bw,$bgv);}
	imageWaterMark($imgsrc,websypos,"../../img/shuiyin.png","","","","",0,0);
	if($sw>$width){$sw=$width;}if($sh>$height){$sh=$height;}
    $cm->Cut("../../".$targetFolder.$mbh."-1.jpg",$sw,$sh);
	$wjv=$targetFolder.$mbh.".jpg";
	$nxh=returnxh("yjcode_tp"," and bh='".$bh."'");
	intotable("yjcode_tp","bh,tp,type1,sj,userid,xh","'".$bh."','".$wjv."','评价','".$sj."',".$userid.",".$nxh."");
   }
  }
 }
 
 
}elseif($admin==6){ //商品B
 $targetFolder = "upload/".$userid."/".$bh."/";
 createDir("../../".$targetFolder);
  if(returncount("yjcode_tp where bh='".$bh."'")<7){
   if(is_uploaded_file($_FILES['inp1']['tmp_name'])){
    $sj=date("Y-m-d H:i:s");
    $mbh=str_replace(" ","",microtime()."tp".$userid);
    $mbh=str_replace(".","",$mbh);
    $targetFile = "../../".$targetFolder.$mbh.".jpg";
	move_uploaded_file($_FILES['inp1']['tmp_name'],$targetFile);
	$cm=new CreatMiniature();
	$bw=800;$bg=0;$sw=500;$sh=500;$zw=200;$zh=200;
	$imgsrc="../../".$targetFolder.$mbh.".jpg";
    list($width, $height) = getimagesize(weburl.$targetFolder.$mbh.".jpg");$bgv=intval($height/($width/$bw));
    $cm->SetVar($imgsrc,"file");if($width>$bw){$cm->BackFill($imgsrc,$bw,$bgv);}
	imageWaterMark($imgsrc,websypos,"../../img/shuiyin.png","","","","",0,0);
	if($sw>$width){$sw=$width;}if($sh>$height){$sh=$height;}
    if(empty($rowcontrol[picys])){$cm->Cut("../../".$targetFolder.$mbh."-1.jpg",$sw,$sh);}else{$cm->BackFill("../../".$targetFolder.$mbh."-1.jpg",$sw,$sh);}
	if($zw>$width){$zw=$width;}if($zh>$height){$zh=$height;}
    if(empty($rowcontrol[picys])){$cm->Cut("../../".$targetFolder.$mbh."-2.jpg",$zw,$zh);}else{$cm->BackFill("../../".$targetFolder.$mbh."-2.jpg",$zw,$zh);}
	$wjv=$targetFolder.$mbh.".jpg";
	$nxh=returnxh("yjcode_tp"," and bh='".$bh."'");
	//OSSB
	if(check_in("a2a",$rowcontrol[aliosskg])){
	 $upty=1;
     include('../../config/alioss/Common.php');
     $bucket = Common::getBucketName();
     $ossClient = Common::getOssClient();
     if(!is_null($ossClient)){;
	 $ossClient->setTimeout(3600);
	 $ossClient->setConnectTimeout(3600);
     $ossClient->createObjectDir($bucket, $targetFolder);
     $ossClient->uploadFile($bucket,$targetFolder.$mbh.".jpg",$targetFile);
     $ossClient->uploadFile($bucket,$targetFolder.$mbh."-1.jpg","../../".$targetFolder.$mbh."-1.jpg");
     $ossClient->uploadFile($bucket,$targetFolder.$mbh."-2.jpg","../../".$targetFolder.$mbh."-2.jpg");
	 delFile($targetFile);
	 delFile("../../".$targetFolder.$mbh."-1.jpg");
	 delFile("../../".$targetFolder.$mbh."-2.jpg");
	 $alioss=preg_split("/,/",$rowcontrol[alioss]);
	 $wjv="https://".$alioss[3].".".$alioss[2]."/".$targetFolder.$mbh.".jpg";
	 }
	}
	//OSSE
	intotable("yjcode_tp","bh,tp,type1,sj,userid,xh,upty","'".$bh."','".$wjv."','商品','".$sj."',".$userid.",".$nxh.",".intval($upty)."");
   }
  }
 
}elseif($admin==7){
  $targetFile = "../../upload/".$userid."/".strgb2312($rowuser[sfz],0,15)."-1.jpg";
  move_uploaded_file($_FILES['inp1']['tmp_name'],$targetFile);
  $cm=new CreatMiniature();
  $bw=510;$bg=0;
  $imgsrc="../../upload/".$userid."/user.jpg";
  list($width, $height) = getimagesize(weburl."upload/".$userid."/".strgb2312($rowuser[sfz],0,15)."-1.jpg");
  $cm->SetVar($imgsrc,"file");if($width>$bw){$cm->BackFill($imgsrc,$bw,$bg);}
 
}elseif($admin==8){
  $targetFile = "../../upload/".$userid."/".strgb2312($rowuser[sfz],0,15)."-2.jpg";
  move_uploaded_file($_FILES['inp1']['tmp_name'],$targetFile);
  $cm=new CreatMiniature();
  $bw=510;$bg=0;
  $imgsrc="../../upload/".$userid."/user.jpg";
  list($width, $height) = getimagesize(weburl."upload/".$userid."/".strgb2312($rowuser[sfz],0,15)."-2.jpg");
  $cm->SetVar($imgsrc,"file");if($width>$bw){$cm->BackFill($imgsrc,$bw,$bg);}
 
}elseif($admin==9){
  $targetFile = "../../upload/".$userid."/".strgb2312($rowuser[sfz],0,15)."-3.jpg";
  move_uploaded_file($_FILES['inp1']['tmp_name'],$targetFile);
  $cm=new CreatMiniature();
  $bw=510;$bg=0;
  $imgsrc="../../upload/".$userid."/user.jpg";
  list($width, $height) = getimagesize(weburl."upload/".$userid."/".strgb2312($rowuser[sfz],0,15)."-3.jpg");
  $cm->SetVar($imgsrc,"file");if($width>$bw){$cm->BackFill($imgsrc,$bw,$bg);}


}
php_toheader("tpupload.php?bh=".$bh."&admin=".$admin."&t=suc&h=".$h."&w=".$w);
 
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>图片上传</title>
<style type="text/css">
body{margin:0;font-size:12px;color:#333;}
*{margin:0 auto;padding:0;}
ul{list-style-type:none;margin:0;padding:0;}
.main{float:left;width:<?=$w?>px;height:<?=$h?>px;cursor:pointer;}
#upload input{position: relative;border:solid transparent;opacity: 0;filter:alpha(opacity=0); cursor: pointer;float:left;width:<?=$w?>px;height:<?=$h?>px;z-index:2;}
#upload .inptp{position:relative;overflow: hidden;display:inline-block;*display:inline;height:<?=$h?>px;cursor:pointer;width:<?=$w?>px;float:left;margin-top:-<?=$h+6?>px;z-index:1;}
#uping{float:left;height:<?=$h?>px;text-align:center;width:<?=$w?>px;border:#00B7EE dotted 1px;font-family:"Microsoft YaHei",微软雅黑,"MicrosoftJhengHei",华文细黑,STHeiti,MingLiu;font-size:13px;color:#ff6600;background-color:#f2f2f2;}
</style>
<script language="javascript">
function filecha(){
document.getElementById("upload").style.display="none";
document.getElementById("uping").style.display="";
tpf.submit();
}
</script>
</head>
<body>
<div class="main">

<!--等待上传开始-->
<form method="post" name="tpf" enctype="multipart/form-data" action="tpupload.php?bh=<?=$bh?>&admin=<?=$admin?>&w=<?=$w?>&h=<?=$h?>&action=update">
<div id="upload">
 <input type="file" onchange="filecha()" name="inp1" size="25" />
 <span class="inptp"><img src="<?=$tp?>" width="100%" /></span>
</div>
<input type="hidden" value="upload" name="yjcode" />
</form>
<!--等待上传结束-->

<!--正在上传-->
<div id="uping" style="display:none;">正在处理……</div>
<!--正在上传-->

</div>
<? if($_GET[t]=="suc" && $admin==3 || $admin==6){?>
<script language="javascript">
parent.xgtread('<?=$bh?>');
</script>
<? }?>
</body>
</html>