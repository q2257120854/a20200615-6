<?
require("return.php");
function zwzr(){}

function intotable($itable,$zdarr,$resarr){global $conn;$sqlinto="insert into ".$itable."(".$zdarr.")values(".$resarr.")";mysql_query("SET NAMES 'GBK'");mysql_query($sqlinto,$conn);}
function updatetable($utable,$ures){global $conn;$sqlupdate="update ".$utable." set ".$ures;mysql_query("SET NAMES 'GBK'");mysql_query($sqlupdate,$conn);}
function deletetable($dsql){global $conn;$sqldelete="delete from ".$dsql;mysql_query("SET NAMES 'GBK'");mysql_query($sqldelete,$conn);}

function createDir($path){if(!is_dir($path)){mkdir($path,0777);}}
function sesCheck(){
 if(empty($_SESSION["SHOPUSER"]) || empty($_SESSION["SHOPUSERPWD"])){php_toheader("../reg/");}
 $sqluy="select * from yjcode_user where uid='".$_SESSION["SHOPUSER"]."' and pwd='".$_SESSION["SHOPUSERPWD"]."'";mysql_query("SET NAMES 'GBK'");
 $resuy=mysql_query($sqluy);if(!$rowuy=mysql_fetch_array($resuy)){$_SESSION["SHOPUSER"]="";$_SESSION["SHOPUSERPWD"]="";php_toheader(weburl);}
}
function sesCheck_m(){
 if(empty($_SESSION["SHOPUSER"]) || empty($_SESSION["SHOPUSERPWD"])){php_toheader("../reg/");}
 $sqluy="select * from yjcode_user where uid='".$_SESSION["SHOPUSER"]."' and pwd='".$_SESSION["SHOPUSERPWD"]."'";mysql_query("SET NAMES 'GBK'");
 $resuy=mysql_query($sqluy);if(!$rowuy=mysql_fetch_array($resuy)){$_SESSION["SHOPUSER"]="";$_SESSION["SHOPUSERPWD"]="";php_toheader(weburl);}
}
function AdminSes_audit(){
 if($_SESSION["SHOPADMIN"]=="" || $_SESSION["SHOPADMINPWD"]==""){php_toheader("index.php");}
 global $adminqx;
 $sqladmin="select * from yjcode_admin where adminuid='".$_SESSION["SHOPADMIN"]."' and adminpwd='".$_SESSION["SHOPADMINPWD"]."'";mysql_query("SET NAMES 'GBK'");
 $resadmin=mysql_query($sqladmin);
 if(!$rowadmin=mysql_fetch_array($resadmin)){$_SESSION["SHOPADMIN"]="";$_SESSION["SHOPADMINPWD"]="";php_toheader("./");}else{$adminqx=$rowadmin[qx];}
 
 $wzget=$_SERVER['PHP_SELF'];
 if(empty($wzget)){echo "HT001 [www.yj99.cn]";exit;}
 $ht1=preg_split("/\//",$wzget);
 $houtai=$ht1[count($ht1)-2];
 if(strstr($adminqx,",0,")){if(strcmp("yjadmin",$houtai)==0 || strcmp("admin",$houtai)==0 || strcmp("manage",$houtai)==0 || strcmp("admin888",$houtai)==0){php_toheader("ht.php");}}
}

function php_toheader($nurlx){echo "<script>";echo "location.href='".$nurlx."';";echo "</script>";exit;}
function Audit_alert($alertStr,$alertUrl,$par=""){echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=gb2312\"><script>";echo "alert('".$alertStr."');".$par."location.href='".$alertUrl."';";echo "</script>";exit;}define("CHR",weburl);

function tjbtnr($a,$b="",$c=""){
 if($c==""){$ts="正在处理数据，请不要刷新页面，也不要关闭页面 ^_^";}else{$ts=$c;}
 $bk="";
 if($b!=""){$bk="<input type=\"button\" class=\"btn3 tjinput\" onmouseover=\"this.className='btn3 btn4 tjinput';\" onclick=\"gourl('".$b."')\" onmouseout=\"this.className='btn3 tjinput';\" value=\"返回\" />";}
 echo "<div id=\"tjbtn\"><input type=\"submit\" class=\"btn1 tjinput\" onmouseover=\"this.className='btn1 btn2 tjinput';\" onmouseout=\"this.className='btn1 tjinput';\" value=\"".$a."\" />".$bk."</div><div id=\"tjing\" style=\"display:none;color:#F96F39;\"><img style=\"margin:0 0 6px 0;\" src=\"../img/ajax_loader.gif\" width=\"208\" height=\"13\" /><br>".$ts."</div>";}

function pagef($se,$ps,$ptable,$px,$pzd="*"){global $res;global $count;global $page_count;global $page;global $row;$ses=$se;$pagesize=$ps;$sql="select count(*) as id from ".$ptable." ".$ses;mysql_query("SET NAMES 'GBK'");$res=mysql_query($sql);$row=mysql_fetch_array($res);$count=$row["id"];if($count%$pagesize==0){$allpage=$count/$pagesize;}else{$allpage=($count-$count%$pagesize)/$pagesize+1;}if($count % $pagesize){$page_count=(int)($count / $pagesize)+1;}else{$page_count=$count / $pagesize;}
if($page>$page_count){$page=$page_count;}if($page<1){$page=1;}$sql="select ".$pzd." from ".$ptable." ".$ses." ".$px." limit ".($page-1)*$pagesize.",".$pagesize."";mysql_query("SET NAMES 'GBK'");$res=mysql_query($sql);}

function tjbtnr_m($a){echo "<input type=\"submit\" class=\"tjinput\" value=\"".$a."\" />";}

function uploadtpnodata($tpi,$lj,$mc,$tpgs,$bw,$bg,$sw=0,$sh=0,$needsy="yes",$xw=0,$xh=0){
 $i=$tpi;
 if(check_in(";",$_FILES["inp$i"]["tmp_name"])){exit;}
 $cm=new CreatMiniature();
 createDir("../".$lj);
 if(!empty($_FILES["inp$i"]["tmp_name"])){
  if($tpgs=="jpg"){$tp = array("image/pjpeg","image/jpeg","image/jpg");}
  elseif($tpgs=="gif"){$tp = array("image/gif");}
  elseif($tpgs=="allpic"){$tp = array("image/pjpeg","image/jpeg","image/jpg","image/gif","image/x-png","image/png");}
  if(!in_array($_FILES["inp$i"]["type"],$tp)){echo "<script>alert('格式不对');history.go(-1);</script>";exit;}
  $filetype = $_FILES["inp$i"]['type'];
  if($filetype == 'image/jpeg' || $filetype == 'image/jpg' || $filetype == 'image/pjpeg'){$type = '.jpg';}
  if($filetype == 'image/gif'){$type = '.gif';}$tna=$_FILES["inp$i"]["name"];
  move_uploaded_file($_FILES["inp$i"]['tmp_name'], "../".$lj.$mc);
  list($width, $height) = getimagesize(weburl.$lj.$mc);
  if($bg==0){$bgv=intval($height/($width/$bw));}else{$bgv=$bg;}
  $cm->SetVar("../".$lj.$mc,"file");
  if($width>$bw){$cm->Cut("../".$lj.$mc,$bw,$bgv);}
  if($needsy=="yes"){imageWaterMark("../".$lj.$mc,websypos,"../img/shuiyin.png","","","","",0,0);}
  if($sw!=0){$a=preg_split("/\./",$mc);$cm->Cut("../".$lj.$a[0]."-1.".$a[1],$sw,$sh);}
  if($xw!=0){$a=preg_split("/\./",$mc);$cm->Cut("../".$lj.$a[0]."-2.".$a[1],$xw,$xh);}
 }
}
function uploadtp($tbh,$tty,$tuid){
 global $res3;
 while3("*","yjcode_clear where bh='".$tbh."' and type1='".$tty."' order by id asc");
 $i=1;
 while($row3=mysql_fetch_array($res3)){
 $nxh=returnxh("yjcode_tp"," and bh='".$tbh."' and type1='".$tty."'");
 if(panduan("*","yjcode_tp where bh='".$tbh."' and type1='".$tty."' and iffm=1")==1){$fmv=0;}else{$fmv=1;}
 intotable("yjcode_tp","bh,tp,type1,iffm,sj,userid,xh","'".$tbh."','".$row3[tp]."','".$tty."',".$fmv.",'".$row3[sj]."','".$tuid."',".$nxh."");
 deletetable("yjcode_clear where id=".$row3[id]);
 $i++;
 }
}
 
function delDirAndFile($dirName){
if(is_dir($dirName)){
if ( $handle = opendir( "$dirName" ) ) {
while ( false !== ( $item = readdir( $handle ) ) ) {
if ( $item != "." && $item != ".." ) {
if ( is_dir( "$dirName/$item" ) ) {delDirAndFile( "$dirName/$item" );} 
else {if( unlink( "$dirName/$item" ) );}}
}
closedir($handle);
if(rmdir($dirName));}
}
}
function delFile($nowu){if(is_file($nowu)){unlink($nowu);}}

function html_template($yurl,$nurl){
$url =weburl.$yurl;
$ch = curl_init();

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
$output = curl_exec($ch);
curl_close($ch);
$fp= fopen($nurl,"w");
fwrite($fp,$output);
fclose($fp);
}

function html1(){
global $rowcontrol;
$mb=$rowcontrol[nowmb];
if(empty($mb)){updatetable("yjcode_control","nowmb='default'");$mb="default";}
recurse_copy("../tem/moban/".$mb."/css/","../css/");
recurse_copy("../tem/moban/".$mb."/homeimg/","../homeimg/");
recurse_copy("../tem/moban/".$mb."/js/","../js/");
html_template("tem/moban/".$mb."/tem/top.php","../tem/top.html");
html_template("tem/moban/".$mb."/tem/top1.php","../tem/top1.html");
html_template("tem/moban/".$mb."/tem/bottom.php","../tem/bottom.html");
html_template("tem/moban/".$mb."/indextemplate.php","../index.html");
html_template("news/indextemplate.php","../news/index.html");

if(empty($rowcontrol[ifwap])){
$wapmb=$rowcontrol[wapmb];
if(empty($wapmb)){updatetable("yjcode_control","wapmb='default'");$wapmb="default";}
recurse_copy("../m/tem/moban/".$wapmb."/css/","../m/css/");
recurse_copy("../m/tem/moban/".$wapmb."/homeimg/","../m/homeimg/");
recurse_copy("../m/tem/moban/".$wapmb."/js/","../m/js/");
html_template("m/tem/moban/".$wapmb."/indextemplate.php","../m/index.html");
}

$nsj=date("Y-m-d H:i:s",strtotime("-1 day"));
deletetable("yjcode_help where zt=99");
deletetable("yjcode_news where zt=99 and sj<='".$nsj."'");
deletetable("yjcode_newspj where zt=99 and sj<='".$nsj."'");
deletetable("yjcode_ad where zt=99 and sj<='".$nsj."'");
deletetable("yjcode_adlx where zt=99 and sj<='".$nsj."'");
deletetable("yjcode_pro where zt=99 and sj<='".$nsj."'");
deletetable("yjcode_protype where zt=99 and sj<='".$nsj."'");
deletetable("yjcode_gg where zt=99 and sj<='".$nsj."'");
deletetable("yjcode_gd where zt=99 and sj<='".$nsj."'");
deletetable("yjcode_gdhf where zt=99 and sj<='".$nsj."'");
deletetable("yjcode_taocan where zt=99");
deletetable("yjcode_kuaidi where zt=99");
deletetable("yjcode_userdj where zt=99");
deletetable("yjcode_shdz where zt=99 and sj<='".$nsj."'");
deletetable("yjcode_yunfei where zt=99");
deletetable("yjcode_provideo where zt=99");
deletetable("yjcode_djl");
}

function recurse_copy($src,$dst) {$dir = opendir($src);@mkdir($dst);while(false !== ( $file = readdir($dir)) ) {if (( $file != '.' ) && ( $file != '..' )) {if ( is_dir($src . '/' . $file) ) {recurse_copy($src . '/' . $file,$dst . '/' . $file);}else {copy($src . '/' . $file,$dst . '/' . $file);}}}closedir($dir);}

function PointUpdateM($c_uid,$c_money){global $conn;$m=sprintf("%.2f",$c_money);updatetable("yjcode_user","money1=money1+(".$m.") where id=".$c_uid);}

function PointIntoM($c_uid,$c_tit,$c_money,$c_admin=0,$c_jyh=''){
 global $conn;
 $m=sprintf("%.2f",$c_money);
 intotable("yjcode_moneyrecord","bh,userid,tit,moneynum,sj,uip,admin,jyh","'".time()."',".$c_uid.",'".$c_tit."',".$m.",'".date('Y-m-d H:i:s')."','".$_SERVER['REMOTE_ADDR']."',".intval($c_admin).",'".$c_jyh."'");
}

function PointUpdateB($c_uid,$c_money){global $conn;$m=sprintf("%.2f",$c_money);updatetable("yjcode_user","baomoney=baomoney+(".$m.") where id=".$c_uid);}

function PointIntoB($c_uid,$c_tit,$c_money,$c_admin=0,$c_zt=0){global $conn;$m=sprintf("%.2f",$c_money);intotable("yjcode_baomoneyrecord","bh,userid,tit,moneynum,sj,uip,admin,zt","'".time()."',".$c_uid.",'".$c_tit."',".$m.",'".date('Y-m-d H:i:s')."','".$_SERVER['REMOTE_ADDR']."',".$c_admin.",".$c_zt."");}

function PointUpdate($c_uid,$c_jf){global $conn;updatetable("yjcode_user","jf=jf+(".$c_jf.") where id=".$c_uid);}

function PointInto($c_uid,$c_tit,$c_jf){global $conn;intotable("yjcode_jfrecord","userid,tit,jfnum,sj,uip","".$c_uid.",'".$c_tit."',".$c_jf.",'".date('Y-m-d H:i:s')."','".$_SERVER['REMOTE_ADDR']."'");}
function while0($wzd,$wses){global $res;$sql="select ".$wzd." from ".$wses;mysql_query("SET NAMES 'GBK'");$res=mysql_query($sql);}function while1($wzd,$wses){global $res1;$sql1="select ".$wzd." from ".$wses;mysql_query("SET NAMES 'GBK'");$res1=mysql_query($sql1);}function while2($wzd,$wses){global $res2;$sql2="select ".$wzd." from ".$wses;mysql_query("SET NAMES 'GBK'");$res2=mysql_query($sql2);}function while3($wzd,$wses){global $res3;$sql3="select ".$wzd." from ".$wses;mysql_query("SET NAMES 'GBK'");$res3=mysql_query($sql3);}

function delproduct($b,$u){
 $pid=returnproid($b);
 deletetable("yjcode_clear where bh='".$b."'");
 deletetable("yjcode_tp where bh='".$b."'");
 deletetable("yjcode_propj where probh='".$b."'");
 deletetable("yjcode_car where probh='".$b."'");
 deletetable("yjcode_profav where probh='".$b."'");
 deletetable("yjcode_kc where probh='".$b."'");
 deletetable("yjcode_taocan where probh='".$b."'");
 deletetable("yjcode_taocan_kc where probh='".$b."'");
 deletetable("yjcode_prouserdj where probh='".$b."'");
 deletetable("yjcode_provideo where probh='".$b."'");
 deletetable("yjcode_jubao where jbid=".$pid." and admin=1");
 deletetable("yjcode_wenda where probh='".$b."'");
 delDirAndFile("../upload/".$u."/".$b."/");
 deletetable("yjcode_pro where bh='".$b."'");
}

function deluid($u){//删除会员
global $res3;
$userid=returnuserid($u);
if(is_numeric($userid)){
 deletetable("yjcode_news where userid=".$userid);
 deletetable("yjcode_tp where userid=".$userid);
 deletetable("yjcode_loginlog where userid=".$userid);
 deletetable("yjcode_moneyrecord where userid=".$userid);
 deletetable("yjcode_baomoneyrecord where userid=".$userid);
 deletetable("yjcode_jfrecord where userid=".$userid);
 deletetable("yjcode_tixian where userid=".$userid);
 while3("bh,userid","yjcode_pro where userid=".$userid);while($row3=mysql_fetch_array($res3)){delproduct($row3[bh],$row3[userid]);}
 deletetable("yjcode_protype where userid=".$userid);
 deletetable("yjcode_shopmenu where userid=".$userid);
 deletetable("yjcode_shopbannar where userid=".$userid);
 deletetable("yjcode_propj where userid=".$userid);
 deletetable("yjcode_car where userid=".$userid);
 deletetable("yjcode_order where selluserid=".$userid." or userid=".$userid);
 deletetable("yjcode_db where selluserid=".$userid." or userid=".$userid);
 deletetable("yjcode_tk where selluserid=".$userid." or userid=".$userid);
 deletetable("yjcode_shopfav where shopid=".$userid." or userid=".$userid);
 deletetable("yjcode_profav where userid=".$userid);
 deletetable("yjcode_dingdang where userid=".$userid);
 deletetable("yjcode_qiandao where userid=".$userid);
 deletetable("yjcode_task where userid=".$userid);
 deletetable("yjcode_taskhf where userid=".$userid." or useridhf=".$userid);
 deletetable("yjcode_tasklog where userid=".$userid." or useridhf=".$userid);
 deletetable("yjcode_kc where userid=".$userid." or userid1=".$userid);
 deletetable("yjcode_taocan_kc where userid=".$userid." or userid1=".$userid);
 deletetable("yjcode_smsmail where userid=".$userid);
 deletetable("yjcode_gd where userid=".$userid);
 deletetable("yjcode_gdhf where userid=".$userid);
 deletetable("yjcode_sms where userid=".$userid);
 deletetable("yjcode_payreng where userid=".$userid);
 deletetable("yjcode_prouserdj where userid=".$userid);
 deletetable("yjcode_shdz where userid=".$userid);
 deletetable("yjcode_yunfei where userid=".$userid);
 deletetable("yjcode_provideo where userid=".$userid);
 deletetable("yjcode_orderlog where userid=".$userid." or selluserid=".$userid);
 deletetable("yjcode_fbhis where userid=".$userid);
 deletetable("yjcode_wenda where userid=".$userid." or selluserid=".$userid);
 delDirAndFile("../upload/".$userid."/");
 clearstatcache();
 if(!is_dir("../upload/".$userid."/")){deletetable("yjcode_user where uid='".$u."'");}
}
}

function checkdjl($c,$bhid,$tb){
 $uid=returnuserid($_SESSION[SHOPUSER]);
 $sj1=date("Y-m-d H:i:s");
 $uip1=$_SERVER["REMOTE_ADDR"];
 global $res1;
 $y=0;
 while1("sj,uip,admin,bhid","yjcode_djl where admin='".$c."' and uip='".$uip1."' and bhid='".$bhid."' order by sj desc");
 if(!$row1=mysql_fetch_array($res1)){$y=2;}else{
  $sjc=DateDiff($sj1,$row1[sj],"s");
  if($sjc>600){$y=1;}else{$y=0;}
 }	
 if(2==$y){intotable("yjcode_djl","userid,sj,uip,admin,bhid","".$uid.",'".$sj1."','".$uip1."','".$c."','".$bhid."'");}
 elseif(1==$y){updatetable("yjcode_djl","sj='".$sj1."' where admin='".$c."' and uip='".$uip1."' and bhid='".$bhid."'");}
 if(0!=$y){
  if(check_in($c,"c1,c2,c3")){
  updatetable($tb,"djl=djl+1 where id=".$bhid);
  }
 }
}

function sellmoneytj($u){
 $ma=0;
 $sqlb="select sum(money1*num) as totalall from yjcode_order where ddzt='suc' and selluserid=".$u;
 mysql_query("SET NAMES 'GBK'");$resb=mysql_query($sqlb);if($rowb=mysql_fetch_array($resb)){$ma=$rowb["totalall"];}
 $mb=0;
 $sqlb="select sum(money1*num) as totalall from yjcode_order where ddzt='suc' and month(sj) = month(curdate()) and year(sj) = year(curdate()) and selluserid=".$u;
 mysql_query("SET NAMES 'GBK'");$resb=mysql_query($sqlb);if($rowb=mysql_fetch_array($resb)){$mb=$rowb["totalall"];}
 updatetable("yjcode_user","sellmall=".$ma.",sellmyue=".$mb." where id=".$u);
}

function taskok($tid){ //自动验证任务状态
 global $rowcontrol;
 global $conn;
 $sj1=date("Y-m-d H:i:s");
 $sqla="select * from yjcode_task where id=".$tid;mysql_query("SET NAMES 'GBK'");$resa=mysql_query($sqla,$conn);if($rowa=mysql_fetch_array($resa)){
 //单人任务到期B
 if(empty($rowa[taskty]) && $sj1>=$rowa[yxq] && 0==$rowa[zt]){
  updatetable("yjcode_task","zt=10 where id=".$rowa[id]);
  if($rowa[money4]>0){
  PointIntoM($rowa[userid],"任务到期，退回订金(任务编号".$rowa[bh].")",$rowa[money4]);
  PointUpdateM($rowa[userid],$rowa[money4]);
  }
  if(!empty($rowa[jsbao])){
   $sqlb="select * from yjcode_taskhf where bh='".$rowa[bh]."'";mysql_query("SET NAMES 'GBK'");$resb=mysql_query($sqlb,$conn);while($rowb=mysql_fetch_array($resb)){
   PointIntoB($rowb[useridhf],"雇主未在有效期内选标，任务结束，退还保证金",$rowa[jsbao],2);
   PointUpdateB($rowb[useridhf],$rowa[jsbao]); 
   }
  }
 }
 //单人任务到期E
 //单人任务接手未完成B
 if(empty($rowa[taskty]) && 3==$rowa[zt]){
  $sqlb="select * from yjcode_taskhf where bh='".$rowa[bh]."' and ifxz=1 and useridhf=".$rowa[useridhf]."";mysql_query("SET NAMES 'GBK'");$resb=mysql_query($sqlb,$conn);
  if($rowb=mysql_fetch_array($resb)){	 
   if($rowb[rwdq]<=$sj1){
    updatetable("yjcode_task","zt=10 where id=".$rowa[id]);
    if($rowa[money4]>0){
    PointIntoM($rowa[userid],"任务到期，退回订金(任务编号".$rowa[bh].")",$rowa[money4]);
    PointUpdateM($rowa[userid],$rowa[money4]);
    }
    PointIntoM($rowa[userid],"接手方未在时规定时间里提交验收，退回款项(任务编号".$rowa[bh].")",$rowa[money3]);
    PointUpdateM($rowa[userid],$rowa[money3]);
    if(!empty($rowa[jsbao])){
    PointIntoB($rowa[userid],"接手方未在规定时间里提交验收，雇主获赔保证金",$rowa[jsbao],2);
    PointUpdateB($rowa[userid],$rowa[jsbao]); 
    }
   }
  }
 }
 //单人任务接手未完成E
 //单人任务接手方验收B
 if(empty($rowa[taskty]) && 4==$rowa[zt]){
  $sqlb="select * from yjcode_taskhf where bh='".$rowa[bh]."' and ifxz=1 and useridhf=".$rowa[useridhf]."";mysql_query("SET NAMES 'GBK'");$resb=mysql_query($sqlb,$conn);
  if($rowb=mysql_fetch_array($resb)){
   if($rowb[oksj]<=$sj1){
   PointIntoM($rowa[useridhf],"任务完成，获得佣金(任务编号".$rowa[bh].")",$rowb[money1]);
   PointUpdateM($rowa[useridhf],$rowb[money1]);
   if(1==$rowa[yjfs]){
   $m=$rowcontrol[taskyj]*$rowb[money1]*(-1);
   PointIntoM($rowa[useridhf],"任务完成，扣除平台中介费(任务编号".$rowa[bh].")",$m);
   PointUpdateM($rowa[useridhf],$m);
   }elseif(2==$rowa[yjfs]){
   $m=$rowcontrol[taskyj]*$rowb[money1]*(-1)*0.5;
   PointIntoM($rowa[useridhf],"任务完成，扣除平台中介费(任务编号".$rowa[bh].")",$m);
   PointUpdateM($rowa[useridhf],$m);
   }
   updatetable("yjcode_task","zt=5 where id=".$rowa[id]);
   $txt="雇主未在指定时间内进行验收，系统自动处理";
   intotable("yjcode_tasklog","bh,userid,useridhf,admin,txt,sj,fj","'".$rowa[bh]."',".$rowa[userid].",".$rowa[useridhf].",3,'".$txt."','".$sj1."',''");
    if(!empty($rowa[jsbao])){
     PointIntoB($rowa[useridhf],"任务完成通过验收，退还保证金",$rowa[jsbao],2);
     PointUpdateB($rowa[useridhf],$rowa[jsbao]); 
    }
   }
  }
 }
 //单人任务接手方验收E
 
 //多人任务到期B
 if($rowa[taskty]==1 && $sj1>=$rowa[yxq] && 101==$rowa[zt]){
  updatetable("yjcode_task","zt=104 where id=".$rowa[id]);
 }
 if($rowa[taskty]==1 && 104==$rowa[zt]){
  if(panduan("*","yjcode_taskhf where bh='".$rowa[bh]."' and (zt=1 or zt=3 or zt=4)")==0){
  if($rowa[money3]>0){
  PointIntoM($rowa[userid],"任务到期，退回已冻结金额(任务编号".$rowa[bh].")",$rowa[money3]);
  PointUpdateM($rowa[userid],$rowa[money3]);
  updatetable("yjcode_task","money3=0 where id=".$rowa[id]);
  }
  }
 }
 //多人任务到期E
 //多人任务接手未完成B
 if(1==$rowa[taskty] && 101==$rowa[zt]){
  $sqlb="select * from yjcode_taskhf where bh='".$rowa[bh]."' and zt=0";mysql_query("SET NAMES 'GBK'");$resb=mysql_query($sqlb,$conn);
  while($rowb=mysql_fetch_array($resb)){
   if($rowb[rwdq]<=$sj1){
    updatetable("yjcode_taskhf","zt=7 where id=".$rowb[id]);
    if(!empty($rowa[jsbao])){
    PointIntoB($rowa[userid],"接手方未在规定时间里提交验收，雇主获赔保证金",$rowa[jsbao],2);
    PointUpdateB($rowa[userid],$rowa[jsbao]); 
    }
   }
  }
 }
 //多人任务接手未完成E
 //多人任务接手判断B
 if($rowa[taskty]==1 && (101==$rowa[zt] || 104==$rowa[zt])){
  $sqlb="select * from yjcode_taskhf where bh='".$rowa[bh]."' and zt=1 and taskty=1";mysql_query("SET NAMES 'GBK'");$resb=mysql_query($sqlb,$conn);
  while($rowb=mysql_fetch_array($resb)){
   if($rowb[oksj]<=$sj1){
    if(1==$rowb[zt]){
     PointIntoM($rowb[useridhf],"任务完成，获得佣金(任务编号".$rowb[bh].")",$rowb[money1]);
     PointUpdateM($rowb[useridhf],$rowb[money1]);
     $zjm=0;
     if(0==$rowtask[yjfs]){
     $zjm=$rowcontrol[taskyj]*$rowb[money1];
	 }elseif(1==$rowa[yjfs]){
     $m=$rowcontrol[taskyj]*$rowb[money1]*(-1);
     PointIntoM($rowb[useridhf],"任务完成，扣除平台中介费(任务编号".$rowb[bh].")",$m);
     PointUpdateM($rowb[useridhf],$m);
     }elseif(2==$rowa[yjfs]){
     $m=$rowcontrol[taskyj]*$rowb[money1]*(-1)*0.5;
	 $zjm=$m;
     PointIntoM($rowb[useridhf],"任务完成，扣除平台中介费(任务编号".$rowb[bh].")",$m);
     PointUpdateM($rowb[useridhf],$m);
     }
     $djm=$rowb[money1]+abs($zjm);
     updatetable("yjcode_task","money3=money3-".$djm." where id=".$rowa[id]);
     updatetable("yjcode_taskhf","zt=2 where id=".$rowb[id]);
     $txt="雇主未在指定时间内进行验收，系统自动处理";
     intotable("yjcode_tasklog","bh,userid,useridhf,admin,txt,sj,fj","'".$rowb[bh]."',".$rowb[userid].",".$rowb[useridhf].",3,'".$txt."','".$sj1."',''");
     if(!empty($rowa[jsbao])){
      PointIntoB($rowb[useridhf],"雇主未在指定时间内进行验收，退还保证金",$rowa[jsbao],2);
      PointUpdateB($rowb[useridhf],$rowa[jsbao]); 
     }
	}elseif(3==$rowb[zt]){
     updatetable("yjcode_taskhf","zt=7 where id=".$rowb[id]);
	}
   }
  }
 }
 //多人任务接手判断E
 //多人任务参与B
 if($rowa[taskty]==1){
 $anu=returncount("yjcode_taskhf where bh='".$rowa[bh]."' and taskty=1 and (zt=0 or zt=1 or zt=2 or zt=3 or zt=4)");
 updatetable("yjcode_task","taskcy=".$anu." where id=".$rowa[id]);
 $anok=returncount("yjcode_taskhf where bh='".$rowa[bh]."' and taskty=1 and zt=2");
 if($anok>=$rowa[tasknum]){
  updatetable("yjcode_task","zt=102 where id=".$rowa[id]);
 }
 }
 //多人任务参与E
 }
}

function kamikc($b){
 if(!empty($b)){
  if(panduan("bh,fhxs","yjcode_pro where bh='".$b."' and fhxs=4")==1){
  $a=returncount("yjcode_kc where ifok=0 and probh='".$b."'");
  updatetable("yjcode_pro","kcnum=".$a." where bh='".$b."'");
  }
 }
}

function kamikc_tc($b,$d){
 if(!empty($b)){
  if(panduan("id,fhxs","yjcode_taocan where fhxs=4 and id=".$d)==1){
  $a=returncount("yjcode_taocan_kc where ifok=0 and probh='".$b."' and tcid=".$d);
  updatetable("yjcode_taocan","kcnum=".$a." where id=".$d);
  }
 }
}

function autoAD($ab){

 $sj1=date("Y-m-d H:i:s");
 $sqlad="select * from yjcode_ad where adbh='".$ab."' and zt=0 order by id asc";mysql_query("SET NAMES 'GBK'");$resad=mysql_query($sqlad);
 while($rowad=mysql_fetch_array($resad)){
  if($sj1>$rowad[dqsj]){
  deletetable("yjcode_ad where id=".$rowad[id]);
  }
 }

 $sqlad1="select * from yjcode_adlx where adbh='".$ab."' and admin=1 order by id asc";mysql_query("SET NAMES 'GBK'");$resad1=mysql_query($sqlad1);
 if($rowad1=mysql_fetch_array($resad1)){
  if(1==$rowad1[fflx]){
   $maxnum=$rowad1[maxnum];
   $nnum=returncount("yjcode_ad where adbh='".$ab."' and zt=0");
   if($maxnum>$nnum){
   $ni=$maxnum-$nnum;
   $sqlad2="select * from yjcode_ad where adbh='".$ab."' and zt=1 order by sj asc limit ".$ni;mysql_query("SET NAMES 'GBK'");$resad2=mysql_query($sqlad2);
   while($rowad2=mysql_fetch_array($resad2)){
   $sjc=strtotime($rowad2[dqsj])-strtotime($rowad2[sj])+strtotime($sj1);
   $dq=date("Y-m-d H:i:s",$sjc);
   updatetable("yjcode_ad","zt=0,dqsj='".$dq."' where id=".$rowad2[id]);
   }
   }
  }elseif(2==$rowad1[fflx]){
   $sqlad4="select * from yjcode_ad where adbh='".$ab."' and zt=1 order by sj asc";mysql_query("SET NAMES 'GBK'");$resad4=mysql_query($sqlad4);
   while($rowad4=mysql_fetch_array($resad4)){
   $sqlad2="select * from yjcode_ad where adbh='".$ab."' and zt=0 and xh=".$rowad4[xh];mysql_query("SET NAMES 'GBK'");$resad2=mysql_query($sqlad2);
   if(!$rowad2=mysql_fetch_array($resad2)){
   $sjc=strtotime($rowad2[dqsj])-strtotime($rowad2[sj])+strtotime($sj1);
   $dq=date("Y-m-d H:i:s",$sjc);
   updatetable("yjcode_ad","zt=0,dqsj='".$dq."' where id=".$rowad4[id]);
   }
   }
  }
 }

}


/*IP黑名单过滤B*/
if(mysql_num_rows(mysql_query("SHOW TABLES LIKE 'yjcode_guolv'"))==1){
    
$nip=preg_split("/\./",getuip());
$sqlglip="select * from yjcode_guolv where admin=1 and ((ip1='".$nip[0]."' and ip2='*' and ip3='*' and ip4='*') or (ip1='".$nip[0]."' and ip2='".$nip[1]."' and ip3='*' and ip4='*') or (ip1='".$nip[0]."' and ip2='".$nip[1]."' and ip3='".$nip[2]."' and ip4='*') or (ip1='".$nip[0]."' and ip2='".$nip[1]."' and ip3='".$nip[2]."' and ip4='".$nip[3]."')) order by id asc";mysql_query("SET NAMES 'GBK'");$resglip=mysql_query($sqlglip);
if($rowglip=mysql_fetch_array($resglip)){
 echo "ERROR88";exit;
}
	
}
/*IP黑名单过滤E*/

?>