<?php
require("return1.php");
function panduan($pzd,$ptable){
 global $conn;
 $sqlpd="select ".$pzd." from ".$ptable;mysql_query("SET NAMES 'GBK'");$respd=mysql_query($sqlpd,$conn);
 if($rowpd=mysql_fetch_array($respd)){return 1;}else{return 0;}
}
function returnxh($tabxh,$sesxh=""){
$sqlxh="select * from ".$tabxh." where id<>0 ".$sesxh." order by xh desc";mysql_query("SET NAMES 'GBK'");$resxh=mysql_query($sqlxh);
if($rowxh=mysql_fetch_array($resxh)){$nxh=$rowxh[xh]+1;}else{$nxh=1;}
return $nxh;
}

function returncount($ctable){
 global $conn;
 $sqlcount="select count(*) as id from ".$ctable;
 mysql_query("SET NAMES 'GBK'");$rescount=mysql_query($sqlcount,$conn);$rowcount=mysql_fetch_array($rescount);return intval($rowcount[id]);
}

function returnsum($zd,$t){
$sqlb="select sum(".$zd.") as allzd from ".$t;mysql_query("SET NAMES 'GBK'");$resb=mysql_query($sqlb);$rowb=mysql_fetch_array($resb);
if(empty($rowb[allzd])){return "0";}else{return $rowb[allzd];}
}

function returnhelptype($tv,$tid){
$sqltype="select * from yjcode_helptype where id=".$tid."";mysql_query("SET NAMES 'GBK'");$restype=mysql_query($sqltype);
$rowtype=mysql_fetch_array($restype);
if($tv==1){return $rowtype[name1];}else{return $rowtype[name2];}
}

function returnnewstype($tyid,$wv){
 global $res3;
 if($tyid==1){while3("id,name1","yjcode_newstype where id=".$wv);if($row3=mysql_fetch_array($res3)){return $row3[name1];}else{return "";}}
 if($tyid==2){while3("id,name2","yjcode_newstype where id=".$wv);if($row3=mysql_fetch_array($res3)){return $row3[name2];}else{return "";}}
}

function returntasktype($tv,$tid){
if(empty($tid)){return "";}
$sqltype="select * from yjcode_tasktype where id=".$tid."";mysql_query("SET NAMES 'GBK'");$restype=mysql_query($sqltype);
$rowtype=mysql_fetch_array($restype);
if($tv==1){return $rowtype[name1];}else{return $rowtype[name2];}
}

function returntype($jbid,$aid){
if(empty($aid)){$aid=0;}
$sqlp="select * from yjcode_type where id=".$aid;mysql_query("SET NAMES 'GBK'");$resp=mysql_query($sqlp);
 if($rowp=mysql_fetch_array($resp)){
  if($jbid==1){return $rowp[type1];}	
  elseif($jbid==2){return $rowp[type2];}	
  elseif($jbid==3){return $rowp[type3];}	
  elseif($jbid==4){return $rowp[type4];}	
  elseif($jbid==5){return $rowp[type5];}	
 }else{return "";}
}

function returntypem($jbid,$aid){
if(empty($aid)){$aid=0;}
$sqlp="select * from yjcode_protype where id=".$aid;mysql_query("SET NAMES 'GBK'");$resp=mysql_query($sqlp);
 if($rowp=mysql_fetch_array($resp)){
  if($jbid==1){return $rowp[name1];}	
  elseif($jbid==2){return $rowp[name2];}	
 }else{return "";}
}

function returnuserid($u){
if(empty($u)){return 0;}else{
$sqlother="select id,uid from yjcode_user where uid='".$u."'";mysql_query("SET NAMES 'GBK'");$resother=mysql_query($sqlother);
if($rowother=mysql_fetch_array($resother)){return $rowother[id];}else{return 0;}
}
}

function returnadmin($u){
$sqlother="select id,adminuid from yjcode_admin where id=".$u;mysql_query("SET NAMES 'GBK'");$resother=mysql_query($sqlother);
if($rowother=mysql_fetch_array($resother)){return $rowother[adminuid];}else{return "";}
}

function returnsellbl($u,$pbh){
global $rowcontrol;
$sbl=0;
$sqlother="select id,sellbl from yjcode_user where id=".$u;mysql_query("SET NAMES 'GBK'");$resother=mysql_query($sqlother);$rowother=mysql_fetch_array($resother);
 if(!empty($rowother[sellbl])){$sbl=$rowother[sellbl];}else{
  $sqlt1="select bh,ty1id from yjcode_pro where bh='".$pbh."'";mysql_query("SET NAMES 'GBK'");$rest1=mysql_query($sqlt1);
  if($rowt1=mysql_fetch_array($rest1)){
   $sqlt2="select id,sellbl from yjcode_type where id=".$rowt1[ty1id];mysql_query("SET NAMES 'GBK'");$rest2=mysql_query($sqlt2);
   if($rowt2=mysql_fetch_array($rest2)){
    if(!empty($rowt2[sellbl])){$sbl=$rowt2[sellbl];}
   }
  }
 }
if(!empty($sbl)){return $sbl;}else{return $rowcontrol[sellbl];}
}

function returnuser($uid){
if(empty($uid)){return "";}
$sqlother="select id,uid from yjcode_user where id=".$uid;mysql_query("SET NAMES 'GBK'");$resother=mysql_query($sqlother);
$rowother=mysql_fetch_array($resother);
return $rowother[uid];
}

function returnemail($uid){
global $conn;
if(empty($uid)){return "";}
$sqlother="select uid,email from yjcode_user where uid='".$uid."'";mysql_query("SET NAMES 'GBK'");$resother=mysql_query($sqlother,$conn);
if($rowother=mysql_fetch_array($resother)){return $rowother[email];}else{return "";}
}

function returnqq($u){
$sqlother="select id,uqq from yjcode_user where id=".$u;mysql_query("SET NAMES 'GBK'");$resother=mysql_query($sqlother);
$rowother=mysql_fetch_array($resother);
return $rowother[uqq];
}

function returnweixin($u){
$sqlother="select id,weixin from yjcode_user where id=".$u;mysql_query("SET NAMES 'GBK'");$resother=mysql_query($sqlother);
$rowother=mysql_fetch_array($resother);
return $rowother[weixin];
}

function returntjuserid($u){
$sqlother="select id,tjuserid from yjcode_user where id=".$u;mysql_query("SET NAMES 'GBK'");$resother=mysql_query($sqlother);
$rowother=mysql_fetch_array($resother);
if(empty($rowother[tjuserid])){$v=0;}else{$v=$rowother[tjuserid];}
return $v;
}

function returnnc($u){
$sqlother="select id,nc from yjcode_user where id=".$u;mysql_query("SET NAMES 'GBK'");$resother=mysql_query($sqlother);
$rowother=mysql_fetch_array($resother);
return $rowother[nc];
}

function returnproid($b){
$sqlother="select id,bh from yjcode_pro where bh='".$b."'";mysql_query("SET NAMES 'GBK'");$resother=mysql_query($sqlother);
$rowother=mysql_fetch_array($resother);
return $rowother[id];
}

function returnxy($u,$t){ //1卖家 2买家
if(1==$t){$sqlxy="select count(*) as id from yjcode_order where selluserid=".$u." and ddzt='suc'";}
elseif(2==$t){$sqlxy="select count(*) as id from yjcode_order where userid=".$u." and ddzt='suc'";}
mysql_query("SET NAMES 'GBK'");$resxy=mysql_query($sqlxy);
$rowxy=mysql_fetch_array($resxy);
return $rowxy[id];
}

function adwhile($adbh,$adnum=0,$w=0,$h=0){
global $rowcontrol;
autoAD($adbh);
$li="";
if($adnum!=0){$li=" limit ".$adnum;}
$sqlad="select * from yjcode_ad where zt=0 and adbh='".$adbh."' order by xh asc".$li;
mysql_query("SET NAMES 'GBK'");
$resad=mysql_query($sqlad);
while($rowad=mysql_fetch_array($resad)){
switch($rowad[type1]){
case "代码":
echo "<div class=\"ad1\">$rowad[txt]</div>";
break;
case "图片":
$s="";
if($w!=0){$s=" width=\"".$w."px;\"";}
if($h!=0){$s=$s." height=\"".$h."px;\"";}
echo "<div class=\"ad1\"><a href=\"".$rowad[aurl]."\" target=_blank><img alt=\"".$rowad[tit]."\"".$s." border=0 src=".weburl.returnjgdw($rowcontrol[addir],"","gg")."/".$rowad[bh].".".$rowad[jpggif]."></a></div>";
break;
case "文字":
echo "<div class=\"ad1\">·<a href=\"".$rowad[aurl]."\" target=_blank>".$rowad[utit]."</a></div>";
break;
case "动画":
echo "<div class=\"ad1\"><embed src=\"".weburl."/".returnjgdw($rowcontrol[addir],"","gg")."/".$rowad[bh].".swf\" quality=\"high\" width=\"".$rowad[aw]."\" height=\"".$rowad[ah]."\" wmode=transparent type=\"application/x-shockwave-flash\"></embed></div>";
break;
}
}
}

function adread($adbh,$w,$h){
global $rowcontrol;
autoAD($adbh);
$sqlad="select * from yjcode_ad where zt=0 and adbh='".$adbh."'";
mysql_query("SET NAMES 'GBK'");
$resad=mysql_query($sqlad);
if($rowad=mysql_fetch_array($resad)){
switch($rowad[type1]){
case "代码":
echo "$rowad[txt]";
break;
case "图片":
if($h==0 || $w==0){
echo "<a href=\"".$rowad[aurl]."\" target=_blank><img border=0 src=".weburl.returnjgdw($rowcontrol[addir],"","gg")."/".$rowad[bh].".".$rowad[jpggif]."></a>";
}else{
echo "<a href=$rowad[aurl] target=_blank><img border=0 src=".weburl.returnjgdw($rowcontrol[addir],"","gg")."/$rowad[bh].$rowad[jpggif] width=$w height=$h></a>";
}
break;
case "文字":
echo "<a href=\"".$rowad[aurl]."\" target=_blank>".$rowad[tit]."</a>";
break;
case "动画":
echo "<div class=\"ad\"><embed src=\"".weburl.returnjgdw($rowcontrol[addir],"","gg")."/".$rowad[bh].".swf\" quality=\"high\" width=\"".$rowad[aw]."\" height=\"".$rowad[ah]."\" wmode=transparent type=\"application/x-shockwave-flash\"></embed></div>";
break;
}
}
}

function adreadID($adid,$w,$h){
global $rowcontrol;
$sqlad="select * from yjcode_ad where zt=0 and id=".$adid;
mysql_query("SET NAMES 'GBK'");
$resad=mysql_query($sqlad);
if($rowad=mysql_fetch_array($resad)){
switch($rowad[type1]){
case "代码":
echo "$rowad[txt]";
break;
case "图片":
if($h==0 || $w==0){
echo "<a href=\"".$rowad[aurl]."\" target=_blank><img border=0 src=".weburl.returnjgdw($rowcontrol[addir],"","gg")."/".$rowad[bh].".".$rowad[jpggif]."></a>";
}else{
echo "<a href=$rowad[aurl] target=_blank><img border=0 src=".weburl.returnjgdw($rowcontrol[addir],"","gg")."/$rowad[bh].$rowad[jpggif] width=$w height=$h></a>";
}
break;
case "文字":
echo "·<a href=\"".$rowad[aurl]."\" target=_blank>".$rowad[utit]."</a>";
break;
case "动画":
echo "<div class=\"ad\"><embed src=\"".weburl.returnjgdw($rowcontrol[addir],"","gg")."/".$rowad[bh].".swf\" quality=\"high\" width=\"".$rowad[aw]."\" height=\"".$rowad[ah]."\" wmode=transparent type=\"application/x-shockwave-flash\"></embed></div>";
break;
}
}
}

function returntp($tsql,$a=""){
 $sqltp="select * from yjcode_tp where ".$tsql;mysql_query("SET NAMES 'GBK'");$restp=mysql_query($sqltp);
 if($rowtp=mysql_fetch_array($restp)){
  if(empty($rowtp[upty])){
   $t=preg_split("/\./",$rowtp[tp]);return weburl.$t[0].$a.".".$t[1];
  }else{
   return returnnotp($rowtp[tp],$a);
  }
 }else{
  return "";
 }
}

function returnuserdj($u){
 $fdj="";
 $sqld="select * from yjcode_userdj where zt=0 order by xh asc";mysql_query("SET NAMES 'GBK'");$resd=mysql_query($sqld);
 if($rowd=mysql_fetch_array($resd)){$fdj=$rowd[name1];}else{$fdj="";}

 $sqlu="select * from yjcode_user where id=".$u;mysql_query("SET NAMES 'GBK'");$resu=mysql_query($sqlu);$rowu=mysql_fetch_array($resu);
 if(empty($rowu[userdj])){
 $ldj=$fdj;
 }else{
 $ldj=$rowu[userdj];
 }
 
 if(!empty($rowu[userdjdq])){
  $sj1=date("Y-m-d H:i:s");
  if($rowu[userdjdq]<$sj1){$ldj=$fdj;$dq=date('Y-m-d H:i:s',strtotime ("-10 second",strtotime($sj1)));updatetable("yjcode_user","userdj='".$fdj."',userdjdq=NULL where id=".$u);}
 }
 
 return $ldj;
 
}


function returnarea($abh){
if(0==$abh){return "";}else{
$sqlarea="select bh,name1 from yjcode_city where bh='".$abh."'";mysql_query("SET NAMES 'GBK'");$resarea=mysql_query($sqlarea);
$rowarea=mysql_fetch_array($resarea);
return $rowarea[name1];
}
}

function returnyunfei($u,$s,$sl,$p){//u商家 s买家收货ID sl数量 p商品编号
 $resu=0;
 if(empty($s)){$resu=0;}
 $sqlyf="select * from yjcode_shdz where id=".$s;mysql_query("SET NAMES 'GBK'");$resyf=mysql_query($sqlyf);
 if($rowyf=mysql_fetch_array($resyf)){$a1=$rowyf[add1];$a2=$rowyf[add2];$a3=$rowyf[add3];}

 $s="|".$a1.",".$a2.",".$a3."|";
 $sqlyf="select * from yjcode_yunfei where cityid like '%".$s."%' and userid=".$u." order by money1 asc";mysql_query("SET NAMES 'GBK'");$resyf=mysql_query($sqlyf);
 if($rowyf=mysql_fetch_array($resyf)){$m1=$rowyf[money1];$m2=$rowyf[money2];}

 $s="|".$a1.",".$a2.",0|";
 $sqlyf="select * from yjcode_yunfei where cityid like '%".$s."%' and userid=".$u." order by money1 asc";mysql_query("SET NAMES 'GBK'");$resyf=mysql_query($sqlyf);
 if($rowyf=mysql_fetch_array($resyf)){$m1=$rowyf[money1];$m2=$rowyf[money2];}

 $s="|".$a1.",0,0|";
 $sqlyf="select * from yjcode_yunfei where cityid like '%".$s."%' and userid=".$u." order by money1 asc";mysql_query("SET NAMES 'GBK'");$resyf=mysql_query($sqlyf);
 if($rowyf=mysql_fetch_array($resyf)){$m1=$rowyf[money1];$m2=$rowyf[money2];}

 $s="|0,0,0|";
 $sqlyf="select * from yjcode_yunfei where cityid like '%".$s."%' and userid=".$u." order by money1 asc";mysql_query("SET NAMES 'GBK'");$resyf=mysql_query($sqlyf);
 if($rowyf=mysql_fetch_array($resyf)){$m1=$rowyf[money1];$m2=$rowyf[money2];}
 
 $sqlp="select * from yjcode_pro where bh='".$p."'";mysql_query("SET NAMES 'GBK'");$resp=mysql_query($sqlp);$rowp=mysql_fetch_array($resp);
 if(5==$rowp[fhxs]){
  $zz=$rowp[zl]*$sl;//总量
  if($zz<=1){$resu=$m1;}else{
  $resu=ceil($zz-1)*$m2+$m1;
  }
 }else{$resu=0;}
 
 if(is_numeric($resu)){return $resu;}else{return 0;}
 
}

function returntjmoney($pbh){
 global $rowcontrol;
 $tjmv=0;
 $sqlt1="select bh,ty1id from yjcode_pro where bh='".$pbh."'";mysql_query("SET NAMES 'GBK'");$rest1=mysql_query($sqlt1);
 if($rowt1=mysql_fetch_array($rest1)){
  $sqlt2="select id,tjmoney from yjcode_type where id=".$rowt1[ty1id];mysql_query("SET NAMES 'GBK'");$rest2=mysql_query($sqlt2);
  if($rowt2=mysql_fetch_array($rest2)){
   if(!empty($rowt2[tjmoney])){$tjmv=$rowt2[tjmoney];}
  }
 }
 if(!empty($tjmv)){return $tjmv;}else{return $rowcontrol[tjmoney];}
}

function returnvideo($a,$w,$h){
 $sqlt1="select * from yjcode_provideo where id=".intval($a);mysql_query("SET NAMES 'GBK'");$rest1=mysql_query($sqlt1);
 if($rowt1=mysql_fetch_array($rest1)){
	 
 if($rowt1[admin]==1){$u=$rowt1[url];}else{$u=str_replace("../upload/","upload/",weburl.$rowt1[url]);}
 
 if($rowt1[gs]=="flv"){
 $str="
 <script type=\"text/javascript\">var swf_width=".$w.";var swf_height=".$h.";var texts='';var files='".$u."';
  document.write('<object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\"   codebase=\"http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0\" width=\"'+ swf_width +'\" height=\"'+ swf_height +'\">');
  document.write('<param name=\"movie\" value=\"".weburl."config/flv.swf\"><param name=\"quality\" value=\"high\">');
  document.write('<param name=\"menu\" value=\"false\"><param name=\"allowFullScreen\" value=\"true\" />');
  document.write('<param name=\"FlashVars\" value=\"vcastr_file='+files+'&IsAutoPlay=1\">');
  document.write('<embed src=\"".weburl."config/flv.swf\" allowFullScreen=\"true\" FlashVars=\"vcastr_file='+files+'&vcastr_title='+texts+'\" menu=\"false\" quality=\"high\" width=\"'+ swf_width +'\" height=\"'+ swf_height +'\" type=\"application/x-shockwave-flash\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" />'); 
  document.write('</object>');
  </script>
 ";
 
 }elseif($rowt1[gs]=="swf"){
 $str="<embed type=\"application/x-shockwave-flash\" class=\"edui-faked-video\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" src=\"".$u."\" width=\"".$w."\" height=\"".$h."\" style=\"float: none\" wmode=\"transparent\" play=\"true\" loop=\"false\" menu=\"false\" allowscriptaccess=\"never\" allowfullscreen=\"true\"/>";

 }
 
 }
return $str;
}

?>