<?
include("../config/conn.php");
include("../config/function.php");
$sj=date("Y-m-d H:i:s");
$m1= date("Y-m-d",strtotime($sj));
$dayv="";
$numv="";
for($i=10;$i>=0;$i--){
$m2 = date("Y-m-d",strtotime("$m1 -".$i." day"));
$a=preg_split("/-/",$m2);
$a1=$a[1]."-".$a[2];
$s1v=$m2." 00:00:00";
$s2v=$m2." 23:59:59";
$a2=returncount("yjcode_user where sj>='".$s1v."' and sj<='".$s2v."'");
if($i==10){$dayv=$a1;$numv=$a2;}else{$dayv=$dayv.",".$a1;$numv=$numv.",".$a2;}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>会员注册数据走势图</title>
</head>
<body>
<div class="trend-Wrap">
<div class="chart-img" id="newChart" style="width:100%;height:139px;"></div>
</div>
<div style="display:none;">
<input type="hidden" id="yslMonthStr" value="<?=$dayv?>"/>
<input type="hidden" id="yslPriceStr" value="<?=$numv?>"/>
</div>
</body>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="sea.js" data-main="index_cure.js"></script>
</html>