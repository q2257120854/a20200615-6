<?
set_time_limit(0);
require("../config/conn.php");
require("../config/function.php");
sesCheck();
$admin=$_GET[admin];
$bhid=$_GET[idbh];
$tab=$_GET[tab];
$sqluser="select * from yjcode_user where uid='".$_SESSION[SHOPUSER]."'";mysql_query("SET NAMES 'GBK'");$resuser=mysql_query($sqluser);
$rowuser=mysql_fetch_array($resuser);
$userid=$rowuser[id];
$sj=date("Y-m-d H:i:s");
switch($admin){
 case "1":   //上下架
 $nb=preg_split("/,/",$bhid);
 for($i=0;$i<count($nb);$i++){
  while0("bh,ifxj",$tab." where bh='".$nb[$i]."' and userid=".$userid);while($row=mysql_fetch_array($res)){
  if(0==$row[ifxj]){$nn=1;}else{$nn=0;}
  updatetable($tab,"ifxj=".$nn." where bh='".$row[bh]."'");
  }
 }
 break;	
 case "2":   //删除商品
 $nb=preg_split("/,/",$bhid);
 for($i=0;$i<count($nb);$i++){
 while1("bh,userid","yjcode_pro where bh='".$nb[$i]."' and userid=".$userid);
  if($row1=mysql_fetch_array($res1)){delproduct($row1[bh],$row1[userid]);}
 }
 break;	
 case "3":   //删除单人任务
 $nb=preg_split("/,/",$bhid);
 for($i=0;$i<count($nb);$i++){
 while0("*","yjcode_task where userid=".$userid." and bh='".$nb[$i]."' and taskty=0 and (zt=0 or zt=1 or zt=2 or zt=5 or zt=6 or zt=7 or zt=9 or zt=10)");
 if($row=mysql_fetch_array($res)){
  if(0==$row[zt] || 1==$row[zt]){
   if($row[money4]>0){
   PointIntoM($row[userid],"删除任务，退回订金",$row[money4]);
   PointUpdateM($row[userid],$row[money4]);
   }
  }
  if(!empty($row[jsbao]) && (0==$row[zt] || 3==$row[zt] || 4==$row[zt] || 8==$row[zt])){
   while1("*","yjcode_taskhf where bh='".$row[bh]."'");if($row1=mysql_fetch_array($res1)){
    PointIntoB($row1[useridhf],"删除任务，退还保证金",$row[jsbao],2);
    PointUpdateB($row1[useridhf],$row[jsbao]); 
   }
  }
  deletetable("yjcode_task where id=".$row[id]);
  deletetable("yjcode_taskhf where bh='".$nb[$i]."'");
  deletetable("yjcode_tasklog where bh='".$nb[$i]."'");
 }
 }
 break;	
 case "3a":   //删除单人接手，没有选中的可以删除
 $nb=preg_split("/,/",$bhid);
 for($i=0;$i<count($nb);$i++){
 while0("*","yjcode_taskhf where useridhf=".$userid." and bh='".$nb[$i]."' and taskty=0 and ifxz=0");if($row=mysql_fetch_array($res)){
  while1("bh,jsbao","yjcode_task where bh='".$row[bh]."'");$row1=mysql_fetch_array($res1);
  if(!empty($row1[jsbao])){
  PointIntoB($row[useridhf],"删除接手，退还保证金",$row1[jsbao],2);
  PointUpdateB($row[useridhf],$row1[jsbao]); 
  }
  deletetable("yjcode_taskhf where id=".$row[id]);
 }
 }
 break;	
 case "5":   //删除卡密
 $nb=preg_split("/,/",$bhid);
 $pbh="";
 if(!empty($nb[0])){while0("id,probh,userid","yjcode_kc where userid=".$userid." and id=".$nb[0]);if($row=mysql_fetch_array($res)){$pbh=$row[probh];}}
 for($i=0;$i<count($nb);$i++){
  if(!is_numeric($nb[$i])){echo "ERR074";exit;}
  deletetable("yjcode_kc where userid=".$userid." and id=".$nb[$i]);
 }
 kamikc($pbh);
 break;	
 case "5t":   //删除套餐卡密
 $nb=preg_split("/,/",$bhid);
 $pbh="";
 if(!empty($nb[0])){while0("id,userid,probh,tcid","yjcode_taocan_kc where userid=".$userid." and id=".$nb[0]);
 if($row=mysql_fetch_array($res)){$pbh=$row[probh];$tcid=$row[tcid];}}
 for($i=0;$i<count($nb);$i++){
  if(!is_numeric($nb[$i])){echo "ERR074";exit;}
  deletetable("yjcode_taocan_kc where userid=".$userid." and id=".$nb[$i]);
 }
 kamikc_tc($pbh,$tcid);
 break;	
 case "6":   //删除卡密
 $nb=preg_split("/,/",$bhid);
 $pbh="";
 if(!empty($nb[0])){while0("id,probh,userid","yjcode_kc where userid=".$userid." and id=".$nb[0]);if($row=mysql_fetch_array($res)){$pbh=$row[probh];}}
 for($i=0;$i<count($nb);$i++){
  if(!is_numeric($nb[$i])){echo "ERR074";exit;}
  deletetable("yjcode_kc where userid=".$userid." and id=".$nb[$i]);
 }
 kamikc($pbh);
 break;	
 case "7":   //更新商品
 $nb=preg_split("/,/",$bhid);
 $syjf=$rowuser[jf];
 for($i=0;$i<count($nb);$i++){ 
 while1("*","yjcode_pro where userid=".$userid." and bh='".$nb[$i]."'");while($row1=mysql_fetch_array($res1)){
  if($syjf>=$rowcontrol[sxjf]){
   $syjf=$syjf-$rowcontrol[sxjf];
   updatetable("yjcode_pro","lastsj='".$sj."' where id=".$row1[id]);
   $jf=$rowcontrol[sxjf]*(-1);
   PointInto($rowuser[id],"刷新商品[".$row1[tit]."]，消耗积分",$jf);PointUpdate($rowuser[id],$jf);
  }
 }
 }
 break;	
 case "9":   //删除套餐
 $nb=preg_split("/,/",$bhid);
 for($i=0;$i<count($nb);$i++){
  $a=preg_split("/xcf/",$nb[$i]); //$a[0]大类ID $a[1]小类ID
  if(intval($a[0])!=0){  //表示删除大类
	if(!is_numeric($a[0])){echo "ERR074";exit;}
	while0("*","yjcode_taocan where userid=".$userid." and id=".$a[0]);$row=mysql_fetch_array($res);
	if(panduan("*","yjcode_taocan where userid=".$userid." and admin=2 and probh='".$row[probh]."' and zt<>99 and tit='".$row[tit]."'")==1){echo "ERR1";exit;}
	deletetable("yjcode_taocan where userid=".$userid." and id=".$row[id]);
	deletetable("yjcode_taocan_kc where userid=".$userid." and tcid=".$row[id]." and probh='".$row[probh]."'");
  }elseif(intval($a[0])==0){  //表示删除小类
	if(!is_numeric($a[1])){echo "ERR074";exit;}
	deletetable("yjcode_taocan where userid=".$userid." and id=".$a[1]);
	deletetable("yjcode_taocan_kc where userid=".$userid." and tcid=".$a[1]);
  }
 }
 break;	
 case "10":   //删除收货地址
 $nb=preg_split("/,/",$bhid);
 for($i=0;$i<count($nb);$i++){
 if(!is_numeric($nb[$i])){echo "ERR074";exit;}
 deletetable("yjcode_shdz where userid=".$userid." and id=".$nb[$i]);
 }
 break;	
 case "11":   //删除运费模板
 $nb=preg_split("/,/",$bhid);
 for($i=0;$i<count($nb);$i++){
 if(!is_numeric($nb[$i])){echo "ERR074";exit;}
 deletetable("yjcode_yunfei where id=".$nb[$i]." and userid=".$userid);
 }
 break;	
 case "12":   //删除资讯
 $nb=preg_split("/,/",$bhid);
 for($i=0;$i<count($nb);$i++){
  while0("id,bh,zt,userid,sj","yjcode_news where bh='".$nb[$i]."' and zt<>0 and userid=".$userid);while($row=mysql_fetch_array($res)){
  delDirAndFile("../upload/news/".dateYMDN($row[sj])."/".$row[bh]."/");
  deletetable("yjcode_news where id=".$row[id]);
  deletetable("yjcode_tp where type1='资讯' and bh='".$row[bh]."'");
  }
 }
 break;	
 case "13":   //删除评价图片
 $nb=preg_split("/,/",$bhid);
 for($i=0;$i<count($nb);$i++){
   if(!is_numeric($nb[$i])){echo "ERR074";exit;}
   while1("*","yjcode_tp where userid=".$userid." and id=".$nb[$i]);if($row1=mysql_fetch_array($res1)){
   if(!empty($row1[tp])){
   delFile("../".str_replace(".","-1.",$row1[tp]));
   delFile("../".$row1[tp]);
   }
   deletetable("yjcode_tp where id=".$nb[$i]);
   }
 }
 break;	
 case "14":   //删除商品视频
 $nb=preg_split("/,/",$bhid);
 for($i=0;$i<count($nb);$i++){
  while1("*","yjcode_provideo where bh='".$nb[$i]."' and userid=".$userid);if($row1=mysql_fetch_array($res1)){
   if($row1[admin]==2){delFile($row1["url"]);}
   delFile("../upload/".$row1[userid]."/".$row1[probh]."/".$row1[bh].".jpg");
   deletetable("yjcode_provideo where id=".$row1[id]);
  }
 }
 break;	
 case "15":   //删除自定义12级分组
 $nb=preg_split("/,/",$bhid);
 for($i=0;$i<count($nb);$i++){
  $a=preg_split("/xcf/",$nb[$i]); //$a[0]大类ID $a[1]小类ID
  if(intval($a[0])!=0){  //表示删除大类
	if(!is_numeric($a[0])){echo "ERR074";exit;}
	while0("*","yjcode_protype where id=".$a[0]." and userid=".$userid);if($row=mysql_fetch_array($res)){
	deletetable("yjcode_protype where name1='".$row[name1]."'");
	}
  }elseif(intval($a[0])==0){  //表示删除小类
	if(!is_numeric($a[1])){echo "ERR074";exit;}
	deletetable("yjcode_protype where id=".$a[1]." and userid=".$userid);
  }
 }
 break;	
 case "16":   //删除自定义店铺导航12级分组
 $nb=preg_split("/,/",$bhid);
 for($i=0;$i<count($nb);$i++){
  $a=preg_split("/xcf/",$nb[$i]); //$a[0]大类ID $a[1]小类ID
  if(intval($a[0])!=0){  //表示删除大类
	if(!is_numeric($a[0])){echo "ERR074";exit;}
	while0("*","yjcode_shopmenu where id=".$a[0]." and userid=".$userid);if($row=mysql_fetch_array($res)){
	deletetable("yjcode_shopmenu where tit1='".$row[tit1]."'");
	}
  }elseif(intval($a[0])==0){  //表示删除小类
	if(!is_numeric($a[1])){echo "ERR074";exit;}
	deletetable("yjcode_shopmenu where id=".$a[1]." and userid=".$userid);
  }
 }
 break;	
 case "17":   //删除店铺轮播图片
 $nb=preg_split("/,/",$bhid);
 for($i=0;$i<count($nb);$i++){
  while1("*","yjcode_shopbannar where bh='".$nb[$i]."' and userid=".$userid);if($row1=mysql_fetch_array($res1)){
   delFile("../upload/".$row1[userid]."/bannar_".$row1[bh].".jpg");
   deletetable("yjcode_shopbannar where id=".$row1[id]);
  }
 }
 break;	

}
echo "True";
?>