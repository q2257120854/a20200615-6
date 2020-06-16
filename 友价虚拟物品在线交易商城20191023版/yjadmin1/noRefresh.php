<?
set_time_limit(0);
require("../config/conn.php");
require("../config/function.php");
AdminSes_audit();
$admin=$_GET[admin];
$bhid=$_GET[idbh];
$tab=$_GET[tab];
switch($admin){
 case "1":   //删除帮助中心分类
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0303,")){echo "Err9";exit;}
 $nb=preg_split("/,/",$bhid);
 for($i=0;$i<count($nb);$i++){
  $a=preg_split("/xcf/",$nb[$i]); //$a[0]大类ID $a[1]小类ID
  if(intval($a[0])!=0){  //表示删除大类
	if(!is_numeric($a[0])){echo "ERR074";exit;}
	while0("*","yjcode_helptype where id=".$a[0]);$row=mysql_fetch_array($res);
	deletetable("yjcode_helptype where name1='".$row[name1]."'");
  }elseif(intval($a[0])==0){  //表示删除小类
	if(!is_numeric($a[1])){echo "ERR074";exit;}
	deletetable("yjcode_helptype where id=".$a[1]);
  }
 }
 break;	
 case "2":   //删除帮助内容
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0603,")){echo "Err9";exit;}
 $nb=preg_split("/,/",$bhid);
 for($i=0;$i<count($nb);$i++){
   deletetable("yjcode_help where bh='".$nb[$i]."'");
 }
 break;	
 case "3":   //删除商品分组二三级分类
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0303,")){echo "Err9";exit;}
 $nb=preg_split("/,/",$bhid);
 for($i=0;$i<count($nb);$i++){
  $a=preg_split("/xcf/",$nb[$i]); //$a[0]大类ID $a[1]小类ID
  if(intval($a[0])!=0){  //表示删除大类
	if(!is_numeric($a[0])){echo "ERR074";exit;}
	while0("*","yjcode_type where id=".$a[0]);$row=mysql_fetch_array($res);
	deletetable("yjcode_type where type1='".$row[type1]."' and type2='".$row[type2]."'");
  }elseif(intval($a[0])==0){  //表示删除小类
	if(!is_numeric($a[1])){echo "ERR074";exit;}
	while0("*","yjcode_type where id=".$a[1]);$row=mysql_fetch_array($res);
	deletetable("yjcode_type where type1='".$row[type1]."' and type2='".$row[type2]."' and type3='".$row[type3]."'");
  }
 }
 break;	
 case "3a":   //删除商品分组四五级分类
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0303,")){echo "Err9";exit;}
 $nb=preg_split("/,/",$bhid);
 for($i=0;$i<count($nb);$i++){
  $a=preg_split("/xcf/",$nb[$i]); //$a[0]大类ID $a[1]小类ID
  if(intval($a[0])!=0){  //表示删除大类
	if(!is_numeric($a[0])){echo "ERR074";exit;}
	while0("*","yjcode_type where id=".$a[0]);$row=mysql_fetch_array($res);
	deletetable("yjcode_type where type1='".$row[type1]."' and type2='".$row[type2]."' and type3='".$row[type3]."' and type4='".$row[type4]."'");
  }elseif(intval($a[0])==0){  //表示删除小类
	if(!is_numeric($a[1])){echo "ERR074";exit;}
	deletetable("yjcode_type where id=".$a[1]);
  }
 }
 break;	
 case "3b":   //删除二三级区域
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0303,")){echo "Err9";exit;}
 $nb=preg_split("/,/",$bhid);
 for($i=0;$i<count($nb);$i++){
  $a=preg_split("/xcf/",$nb[$i]); //$a[0]大类ID $a[1]小类ID
  if(intval($a[0])!=0){  //表示删除大类
	if(!is_numeric($a[0])){echo "ERR074";exit;}
	while0("*","yjcode_city where id=".intval($a[0]));$row=mysql_fetch_array($res);
	deletetable("yjcode_city where level=3 and parentid='".$row[bh]."'");
	deletetable("yjcode_city where level=2 and id=".intval($a[0]));
  }elseif(intval($a[0])==0){  //表示删除小类
	if(!is_numeric($a[1])){echo "ERR074";exit;}
	deletetable("yjcode_city where id=".intval($a[1]));
  }
 }
 break;	
 case "4":   //删除商品大类
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0303,")){echo "Err9";exit;}
 $nb=preg_split("/,/",$bhid);
 for($i=0;$i<count($nb);$i++){
  deletetable("yjcode_typesx where typeid=".$nb[$i]);
  while0("*","yjcode_type where id=".$nb[$i]);$row=mysql_fetch_array($res);
  deletetable("yjcode_type where type1='".$row[type1]."'");
 }
 break;	
 case "4a":   //删除一级区域
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0303,")){echo "Err9";exit;}
 $nb=preg_split("/,/",$bhid);
 for($i=0;$i<count($nb);$i++){
  while0("*","yjcode_city where level=1 and id=".intval($nb[$i]));$row=mysql_fetch_array($res);
  if(panduan("*","yjcode_city where parentid='".$row[bh]."'")==1){echo "ERR1";exit;}
  deletetable("yjcode_city where level=1 and id=".intval($nb[$i]));
 }
 break;	
 case "5":   //删除资讯分类
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0303,")){echo "Err9";exit;}
 $nb=preg_split("/,/",$bhid);
 for($i=0;$i<count($nb);$i++){
  $a=preg_split("/xcf/",$nb[$i]); //$a[0]大类ID $a[1]小类ID
  if(intval($a[0])!=0){  //表示删除大类
	if(!is_numeric($a[0])){echo "ERR074";exit;}
	if(panduan("type1id,zt","yjcode_news where type1id=".$a[0]." and zt<>99")==1){echo "ERR";exit;}
	while0("*","yjcode_newstype where id=".$a[0]);$row=mysql_fetch_array($res);
	deletetable("yjcode_newstype where name1='".$row[name1]."'");
  }elseif(intval($a[0])==0){  //表示删除小类
	if(!is_numeric($a[1])){echo "ERR074";exit;}
	if(panduan("type2id,zt","yjcode_news where type2id=".$a[1]." and zt<>99")==1){echo "ERR";exit;}
	deletetable("yjcode_newstype where id=".$a[1]);
  }
 }
 break;	
 case "6":   //资讯审核状态
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0201,")){echo "Err9";exit;}
 $nb=preg_split("/,/",$bhid);
 for($i=0;$i<count($nb);$i++){
  while0("bh,zt","yjcode_news where bh='".$nb[$i]."'");while($row=mysql_fetch_array($res)){
  if(1==$row[zt]){$nn=0;}else{$nn=1;}
  updatetable("yjcode_news","zt=".$nn." where bh='".$nb[$i]."'");
  }
 }
 break;	
 case "7":   //删除资讯
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0203,")){echo "Err9";exit;}
 $nb=preg_split("/,/",$bhid);
 for($i=0;$i<count($nb);$i++){
  while0("bh,sj","yjcode_news where bh='".$nb[$i]."'");while($row=mysql_fetch_array($res)){
  delDirAndFile("../upload/news/".dateYMDN($row[sj])."/".$row[bh]."/");
  deletetable("yjcode_news where bh='".$row[bh]."'");
  deletetable("yjcode_tp where type1='资讯' and bh='".$row[bh]."'");
  }
 }
 break;	
 case "8":   //删除广告
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0603,")){echo "Err9";exit;}
 $nb=preg_split("/,/",$bhid);
 for($i=0;$i<count($nb);$i++){
  while0("*","yjcode_ad where bh='".$nb[$i]."' and (type1='图片' or type1='动画')");if($row=mysql_fetch_array($res)){
   delFile("../ad/".$nb[$i].".".$row[jpggif]);
   delFile("../ad/".$nb[$i]."-99.".$row[jpggif]);
  }
  deletetable("yjcode_ad where bh='".$nb[$i]."'");
 }
 break;	
 case "9":   //删除会员
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0703,")){echo "Err9";exit;}
 $nb=preg_split("/,/",$bhid);
 for($i=0;$i<count($nb);$i++){
  while3("id,uid","yjcode_user where id=".$nb[$i]);while($row3=mysql_fetch_array($res3)){
  deluid($row3[uid]);
  }
 }
 break;	
 case "10":   //删除提现，要非等待受理状态的
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0703,")){echo "Err9";exit;}
 $nb=preg_split("/,/",$bhid);
 for($i=0;$i<count($nb);$i++){
  deletetable("yjcode_tixian where zt<>4 and id=".$nb[$i]);
 }
 break;	
 case "11":   //删除管理员
 if(!strstr($adminqx,",0,")){echo "Err9";exit;}
 $nb=preg_split("/,/",$bhid);
 for($i=0;$i<count($nb);$i++){
  $qx=",0,";
  deletetable("yjcode_admin where qx<>'".$qx."' and id=".$nb[$i]);
 }
 break;	
 case "12":   //商品审核状态
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0101,")){echo "Err9";exit;}
 $nb=preg_split("/,/",$bhid);
 for($i=0;$i<count($nb);$i++){
  while0("bh,zt","yjcode_pro where bh='".$nb[$i]."'");while($row=mysql_fetch_array($res)){
  if(1==$row[zt]){$nn=0;}else{$nn=1;}
  updatetable("yjcode_pro","zt=".$nn." where bh='".$nb[$i]."'");
  }
 }
 break;	
 case "13":   //商品上下架状态
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0101,")){echo "Err9";exit;}
 $nb=preg_split("/,/",$bhid);
 for($i=0;$i<count($nb);$i++){
  while0("bh,ifxj","yjcode_pro where bh='".$nb[$i]."'");while($row=mysql_fetch_array($res)){
  if(1==$row[ifxj]){$nn=0;}else{$nn=1;}
  updatetable("yjcode_pro","ifxj=".$nn." where bh='".$nb[$i]."'");
  }
 }
 break;	
 case "14":   //删除商品
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0103,")){echo "Err9";exit;}
 $nb=preg_split("/,/",$bhid);
 for($i=0;$i<count($nb);$i++){
 while1("bh,userid","yjcode_pro where bh='".$nb[$i]."'");
  if($row1=mysql_fetch_array($res1)){delproduct($row1[bh],$row1[userid]);}
 }
 break;	
 case "17":   //删除订单
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0403,")){echo "Err9";exit;}
 $nb=preg_split("/,/",$bhid);
 for($i=0;$i<count($nb);$i++){
 deletetable("yjcode_propj where orderbh='".$nb[$i]."'");
 deletetable("yjcode_tk where orderbh='".$nb[$i]."'");
 deletetable("yjcode_db where orderbh='".$nb[$i]."'");
 deletetable("yjcode_order where orderbh='".$nb[$i]."'");
 deletetable("yjcode_orderlog where orderbh='".$nb[$i]."'");
 }
 break;	
 case "18":   //删除附加选项
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0303,")){echo "Err9";exit;}
 $nb=preg_split("/,/",$bhid);
 for($i=0;$i<count($nb);$i++){
  $a=preg_split("/xcf/",$nb[$i]); //$a[0]大类ID $a[1]小类ID
  if(intval($a[0])!=0){  //表示删除大类
	if(!is_numeric($a[0])){echo "ERR074";exit;}
	while0("*","yjcode_typesx where id=".$a[0]);$row=mysql_fetch_array($res);
	deletetable("yjcode_typesx where name1='".$row[name1]."'");
  }elseif(intval($a[0])==0){  //表示删除小类
	if(!is_numeric($a[1])){echo "ERR074";exit;}
	deletetable("yjcode_typesx where id=".$a[1]);
  }
 }
 break;	
 case "19":   //删除公告
 $nb=preg_split("/,/",$bhid);
 for($i=0;$i<count($nb);$i++){
 deletetable("yjcode_gg where bh='".$nb[$i]."'");
 }
 break;	
 case "20":   //删除任务分组类别
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0303,")){echo "Err9";exit;}
 $nb=preg_split("/,/",$bhid);
 for($i=0;$i<count($nb);$i++){
  $a=preg_split("/xcf/",$nb[$i]); //$a[0]大类ID $a[1]小类ID
  if(intval($a[0])!=0){  //表示删除大类
	if(!is_numeric($a[0])){echo "ERR074";exit;}
	while0("*","yjcode_tasktype where id=".$a[0]);$row=mysql_fetch_array($res);
	deletetable("yjcode_tasktype where name1='".$row[name1]."'");
  }elseif(intval($a[0])==0){  //表示删除小类
	if(!is_numeric($a[1])){echo "ERR074";exit;}
	deletetable("yjcode_tasktype where id=".$a[1]);
  }
 }
 break;	
 case "21":   //删除单人任务
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0603,")){echo "Err9";exit;}
 $nb=preg_split("/,/",$bhid);
 for($i=0;$i<count($nb);$i++){
  while0("*","yjcode_task where bh='".$nb[$i]."' and taskty=0");if($row=mysql_fetch_array($res)){
  if(0==$row[zt] || 1==$row[zt]){
   if($row[money4]>0){
   PointIntoM($row[userid],"删除任务，退回订金",$row[money4]);
   PointUpdateM($row[userid],$row[money4]);
   }
  }
  if(3==$row[zt] || 4==$row[zt] || 8==$row[zt]){
   PointIntoM($row[userid],"删除任务，退回费用",$row[money3]);
   PointUpdateM($row[userid],$row[money3]);
  }
  if(!empty($row[jsbao]) && (0==$row[zt] || 3==$row[zt] || 4==$row[zt] || 8==$row[zt])){
   while1("*","yjcode_taskhf where bh='".$row[bh]."'");if($row1=mysql_fetch_array($res1)){
    PointIntoB($row1[useridhf],"删除任务，退还保证金",$row[jsbao],2);
    PointUpdateB($row1[useridhf],$row[jsbao]); 
   }
  }
  deletetable("yjcode_task where id=".$row[id]);
  deletetable("yjcode_taskhf where bh='".$row[bh]."'");
  deletetable("yjcode_tasklog where bh='".$row[bh]."'");
  }
 }
 break;	
 case "21a":   //删除多人任务
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0603,")){echo "Err9";exit;}
 $nb=preg_split("/,/",$bhid);
 for($i=0;$i<count($nb);$i++){
  while0("*","yjcode_task where bh='".$nb[$i]."' and taskty=1");if($row=mysql_fetch_array($res)){
  if(101==$row[zt] || 104==$row[zt]){
   if($row[money3]>0){
   PointIntoM($row[userid],"管理员删除任务，退回费用",$row[money3]);
   PointUpdateM($row[userid],$row[money3]);
   }
  }
  if(!empty($row[jsbao])){
   while1("*","yjcode_taskhf where bh='".$row[bh]."' and taskty=1 and (zt=0 or zt=1 or zt=3 or zt=4)");while($row1=mysql_fetch_array($res1)){
   PointIntoB($row1[useridhf],"删除任务，退还保证金",$row[jsbao],2);
   PointUpdateB($row1[useridhf],$row[jsbao]); 
   }
  }
  deletetable("yjcode_task where id=".$row[id]);
  deletetable("yjcode_taskhf where bh='".$row[bh]."'");
  deletetable("yjcode_tasklog where bh='".$row[bh]."'");
  }
 }
 break;	
 case "23":   //删除任务回复
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0603,")){echo "Err9";exit;}
 $nb=preg_split("/,/",$bhid);
 for($i=0;$i<count($nb);$i++){
  if(!is_numeric($nb[$i])){echo "ERR074";exit;}
  while1("*","yjcode_taskhf where id=".$nb[$i]);if($row1=mysql_fetch_array($res1)){
  deletetable("yjcode_taskhf where id=".$row1[id]);
  deletetable("yjcode_tasklog where bh=".$row1[bh]." and useridhf=".$row1[useridhf]);
  }
 }
 break;	
 case "25":   //删除卡密
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0103,")){echo "Err9";exit;}
 $nb=preg_split("/,/",$bhid);
 $pbh="";
 if(!empty($nb[0])){while0("id,probh","yjcode_kc where id=".$nb[0]);if($row=mysql_fetch_array($res)){$pbh=$row[probh];}}
 for($i=0;$i<count($nb);$i++){
  if(!is_numeric($nb[$i])){echo "ERR074";exit;}
  deletetable("yjcode_kc where id=".$nb[$i]);
 }
 kamikc($pbh);
 break;	
 case "25t":   //删除套餐卡密
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0103,")){echo "Err9";exit;}
 $nb=preg_split("/,/",$bhid);
 $pbh="";
 if(!empty($nb[0])){while0("id,probh,tcid","yjcode_taocan_kc where id=".$nb[0]);if($row=mysql_fetch_array($res)){$pbh=$row[probh];$tcid=$row[tcid];}}
 for($i=0;$i<count($nb);$i++){
  if(!is_numeric($nb[$i])){echo "ERR074";exit;}
  deletetable("yjcode_taocan_kc where id=".$nb[$i]);
 }
 kamikc_tc($pbh,$tcid);
 break;	
 case "26":   //删除资金记录
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0703,")){echo "Err9";exit;}
 $nb=preg_split("/,/",$bhid);
 for($i=0;$i<count($nb);$i++){
   if(!is_numeric($nb[$i])){echo "ERR074";exit;}
   deletetable("yjcode_moneyrecord where id=".$nb[$i]);
 }
 break;	
 case "26a":   //删除充值订单管理
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0703,")){echo "Err9";exit;}
 $nb=preg_split("/,/",$bhid);
 for($i=0;$i<count($nb);$i++){
   if(!is_numeric($nb[$i])){echo "ERR074";exit;}
   deletetable("yjcode_dingdang where id=".$nb[$i]);
 }
 break;	
 case "27":   //删除商品评价
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0103,")){echo "Err9";exit;}
 $nb=preg_split("/,/",$bhid);
 for($i=0;$i<count($nb);$i++){
   if(!is_numeric($nb[$i])){echo "ERR074";exit;}
   deletetable("yjcode_propj where id=".$nb[$i]);
 }
 break;	
 case "28":   //删除工单
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0603,")){echo "Err9";exit;}
 $nb=preg_split("/,/",$bhid);
 for($i=0;$i<count($nb);$i++){
   deletetable("yjcode_gd where bh='".$nb[$i]."'");
   deletetable("yjcode_gdhf where gdbh='".$nb[$i]."'");
 }
 break;	
 case "30":   //删除商品图片
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0103,")){echo "Err9";exit;}
 $nb=preg_split("/,/",$bhid);
 for($i=0;$i<count($nb);$i++){
   if(!is_numeric($nb[$i])){echo "ERR074";exit;}
   while1("*","yjcode_tp where id=".$nb[$i]);if($row1=mysql_fetch_array($res1)){
   if(!empty($row1[tp])){
   delFile("../".str_replace(".","-1.",$row1[tp]));
   delFile("../".str_replace(".","-2.",$row1[tp]));
   delFile("../".$row1[tp]);
   }
   deletetable("yjcode_tp where id=".$nb[$i]);
   }
 }
 break;	
 case "31":   //删除资讯评价
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0203,")){echo "Err9";exit;}
 $nb=preg_split("/,/",$bhid);
 for($i=0;$i<count($nb);$i++){
   if(!is_numeric($nb[$i])){echo "ERR074";exit;}
   deletetable("yjcode_newspj where id=".$nb[$i]);
 }
 break;	
 case "32":   //删除自助广告体系
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0303,")){echo "Err9";exit;}
 $nb=preg_split("/,/",$bhid);
 for($i=0;$i<count($nb);$i++){
   deletetable("yjcode_adlx where bh='".$nb[$i]."'");
 }
 break;	
 case "33":   //删除套餐
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0103,")){echo "Err9";exit;}
 $nb=preg_split("/,/",$bhid);
 for($i=0;$i<count($nb);$i++){
  $a=preg_split("/xcf/",$nb[$i]); //$a[0]大类ID $a[1]小类ID
  if(intval($a[0])!=0){  //表示删除大类
	if(!is_numeric($a[0])){echo "ERR074";exit;}
	while0("*","yjcode_taocan where id=".$a[0]);$row=mysql_fetch_array($res);
	if(panduan("*","yjcode_taocan where admin=2 and probh='".$row[probh]."' and zt<>99 and tit='".$row[tit]."'")==1){echo "+Err1";exit;}
	deletetable("yjcode_taocan where id=".$row[id]);
	deletetable("yjcode_taocan_kc where tcid=".$row[id]." and probh='".$row[probh]."'");
  }elseif(intval($a[0])==0){  //表示删除小类
	if(!is_numeric($a[1])){echo "ERR074";exit;}
	deletetable("yjcode_taocan where id=".$a[1]);
	deletetable("yjcode_taocan_kc where tcid=".$a[1]);
  }
 }
 break;	
 case "34":   //删除快递公司名称
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0303,")){echo "Err9";exit;}
 $nb=preg_split("/,/",$bhid);
 for($i=0;$i<count($nb);$i++){
  deletetable("yjcode_kuaidi where id=".$nb[$i]);
 }
 break;	
 case "35":   //删除人工对账记录
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0703,")){echo "Err9";exit;}
 $nb=preg_split("/,/",$bhid);
 for($i=0;$i<count($nb);$i++){
  deletetable("yjcode_payreng where id=".$nb[$i]);
 }
 break;	
 case "36":   //删除会员等级
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0303,")){echo "Err9";exit;}
 $nb=preg_split("/,/",$bhid);
 for($i=0;$i<count($nb);$i++){
  while1("*","yjcode_userdj where bh='".$nb[$i]."'");$row1=mysql_fetch_array($res1);
  deletetable("yjcode_userdj where id=".$row1[id]);
  deletetable("yjcode_prouserdj where djname='".$row1[name1]."'");
  updatetable("yjcode_user","userdj='' where userdj='".$row1[name1]."'");
 }
 break;	
 case "37":   //删除登录日志
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0303,")){echo "Err9";exit;}
 $nb=preg_split("/,/",$bhid);
 for($i=0;$i<count($nb);$i++){
  deletetable("yjcode_loginlog where id=".$nb[$i]);
 }
 break;	
 case "38":   //删除充值卡密
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0103,")){echo "Err9";exit;}
 $nb=preg_split("/,/",$bhid);
 for($i=0;$i<count($nb);$i++){
  deletetable("yjcode_paykami where id=".$nb[$i]);
 }
 break;	
 case "39":   //删除保证金记录
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0703,")){echo "Err9";exit;}
 $nb=preg_split("/,/",$bhid);
 for($i=0;$i<count($nb);$i++){
  deletetable("yjcode_baomoneyrecord where id=".$nb[$i]." and zt<>1");
 }
 break;	
 case "40":   //变更商品视频审核状态
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0101,")){echo "Err9";exit;}
 $nb=preg_split("/,/",$bhid);
 for($i=0;$i<count($nb);$i++){
  while0("bh,zt","yjcode_provideo where bh='".$nb[$i]."'");while($row=mysql_fetch_array($res)){
  if(1==$row[zt]){$nn=0;}else{$nn=1;}
  updatetable("yjcode_provideo","zt=".$nn." where bh='".$row[bh]."'");
  }
 }
 break;
 case "41":   //删除商品视频
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0103,")){echo "Err9";exit;}
 $nb=preg_split("/,/",$bhid);
 for($i=0;$i<count($nb);$i++){
  while1("*","yjcode_provideo where bh='".$nb[$i]."'");if($row1=mysql_fetch_array($res1)){
   if($row1[admin]==2){delFile($row1["url"]);}
   delFile("../upload/".$row1[userid]."/".$row1[probh]."/".$row1[bh].".jpg");
   deletetable("yjcode_provideo where id=".$row1[id]);
  }
 }
 break;	
 case "42":   //删除举报类型
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0303,")){echo "Err9";exit;}
 $nb=preg_split("/,/",$bhid);
 for($i=0;$i<count($nb);$i++){
  deletetable("yjcode_jubaotype where id=".intval($nb[$i]));
 }
 break;	
 case "43":   //删除举报内容
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0603,")){echo "Err9";exit;}
 $nb=preg_split("/,/",$bhid);
 for($i=0;$i<count($nb);$i++){
   deletetable("yjcode_jubao where bh='".$nb[$i]."'");
 }
 break;	
 case "44":   //删除黑名单
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0703,")){echo "Err9";exit;}
 $nb=preg_split("/,/",$bhid);
 for($i=0;$i<count($nb);$i++){
   deletetable("yjcode_guolv where id=".intval($nb[$i]));
 }
 break;	

}
echo "True";
?>