<?
include("../../config/conn.php");
include("../../config/function.php");
$key=$rowcontrol[bankkey];
if(empty($key)){exit;}
$v_oid     =trim($_POST['v_oid']);      
$v_pmode   =trim($_POST['v_pmode']);      
$v_pstatus =trim($_POST['v_pstatus']);      
$v_pstring =trim($_POST['v_pstring']);      
$v_amount  =trim($_POST['v_amount']);     
$v_moneytype  =trim($_POST['v_moneytype']);     
$remark1   =trim($_POST['remark1' ]);     
$remark2   =trim($_POST['remark2' ]);     
$v_md5str  =trim($_POST['v_md5str' ]);     
/**
 * 重新计算md5的值
 */
                           
$md5string=strtoupper(md5($v_oid.$v_pstatus.$v_amount.$v_moneytype.$key)); //拼凑加密串
if ($v_md5str==$md5string)
{
	
 if($v_pstatus=="20"){
  $sj=date("Y-m-d H:i:s");
  $uip=$_SERVER["REMOTE_ADDR"];
  while1("*","yjcode_dingdang where ddbh='".$v_oid."' and ddzt='等待买家付款'");if($row1=mysql_fetch_array($res1)){
   updatetable("yjcode_dingdang","sj='".$sj."',uip='".$uip."',alipayzt='TRADE_SUCCESS',ddzt='交易成功',ifok=1,bz='网银在线支付' where ddbh='".$v_oid."'");
   $money1=$row1["money1"];
   PointIntoM($row1[userid],"网银在线充值".$money1."元",$money1);
   PointUpdateM($row1[userid],$money1);
   if(!empty($row1[sxf])){
   $sxf=$row1[sxf]*(-1);
   PointIntoM($row1[userid],"支付接口手续费",$sxf);
   PointUpdateM($row1[userid],$sxf);
   }
  }
 }

echo "ok";
}else{
echo "error";
}
?>