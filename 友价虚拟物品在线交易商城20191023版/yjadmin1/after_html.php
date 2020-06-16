<?
require("../config/conn.php");
require("../config/function.php");
AdminSes_audit();
$sj=date("Y-m-d H:i:s");

$admin=$_GET[admin];
if(empty($admin)){$admin="0";}

switch($admin)
{
 case "0": //常规缓存清理
 html1();
 break;
 case "1": //订单/店铺状态/订单评价触发变更
 $autoses="id>0";
 include("../user/auto.php");
 
 while1("id,uid,pwd,shopzt,dqsj","yjcode_user where dqsj<'".$sj."' and shopzt=2 and dqsj<>'' and dqsj is not null");while($row1=mysql_fetch_array($res1)){
 updatetable("yjcode_user","shopzt=4 where id=".$row1[id]);
 }
 
 $jysj=date("Y-m-d H:i:s",strtotime("-".$rowcontrol[dbsj]." day"));
 while1("id,probh,sj,userid,selluserid,orderbh,ifpj","yjcode_order where ddzt='suc' and sj<='".$jysj."' and (ifpj is null or ifpj=0) order by id asc");
 while($row1=mysql_fetch_array($res1)){
  while2("orderbh","yjcode_propj where orderbh='".$row1[orderbh]."'");if($row2=mysql_fetch_array($res2)){
   updatetable("yjcode_order","ifpj=1 where id=".$row1[id]);
  }else{
   $uip=$_SERVER["REMOTE_ADDR"];
   $pj="交易完成超过".$rowcontrol[dbsj]."天未评价，默认好评";
   $oksj=date('Y-m-d H:i:s',strtotime ("+".$rowcontrol[dbsj]." day",strtotime($row1[sj])));
   intotable("yjcode_propj","probh,selluserid,userid,sj,uip,pf1,pf2,pf3,txt,orderbh","'".$row1[probh]."',".$row1[selluserid].",".$row1[userid].",'".$oksj."','".$uip."',5,5,5,'".$pj."','".$row1[orderbh]."'");$id=mysql_insert_id();
   $sqla="select avg(pf1) as pf1v,avg(pf2) as pf2v,avg(pf3) as pf3v from yjcode_propj where probh='".$row1[probh]."'";
   mysql_query("SET NAMES 'GBK'");$resa=mysql_query($sqla);$rowa=mysql_fetch_array($resa);
   updatetable("yjcode_pro","pf1=".round($rowa[pf1v],2).",pf2=".round($rowa[pf2v],2).",pf3=".round($rowa[pf3v],2)." where bh='".$row1[probh]."'");
   $sqlp="select avg(pf1) pf1v,avg(pf2) pf2v,avg(pf3) pf3v from yjcode_pro where zt=0 and userid=".$row1[selluserid];mysql_query("SET NAMES 'GBK'");
   $resp=mysql_query($sqlp);$rowp=mysql_fetch_array($resp);
   updatetable("yjcode_user","pf1=".round($rowp[pf1v],2).",pf2=".round($rowp[pf2v],2).",pf3=".round($rowp[pf3v],2)." where id=".$row1[selluserid]);
   updatetable("yjcode_order","ifpj=1 where id=".$row1[id]);
  }
 }
 
 break;
}
 echo "ok";
?>