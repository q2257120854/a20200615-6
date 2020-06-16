<?
$sj1=date("Y-m-d H:i:s");

//退款判断
while1("*","yjcode_tk where ".$autoses);while($row1=mysql_fetch_array($res1)){
$sjc=DateDiff($sj1,$row1[tkoksj],"s");
$myorderbh=$row1[orderbh];
 if($sjc>=0){  //表示已经达到生效时间，自动同意退款
 $allmoney=$row1[money1];
 PointUpdateM($row1[userid],$allmoney);
 $tkjg="卖家未在指定时间内处理退款申请，系统默认同意退款";
 PointIntoM($row1[userid],$tkjg,$allmoney);
 updatetable("yjcode_order","ddzt='backsuc',tksj='".$row1[sj]."',tkly='".$row1[tkly]."',tkjg='".$tkjg."',tkoksj='".$sj1."' where orderbh='".$myorderbh."'");
 deletetable("yjcode_tk where orderbh='".$myorderbh."'");
 deletetable("yjcode_db where orderbh='".$myorderbh."'");
 }
}

//自动确认收货
while1("*","yjcode_db where ".$autoses);while($row1=mysql_fetch_array($res1)){
$sjc=DateDiff($sj1,$row1[dboksj],"s");
$myorderbh=$row1[orderbh];
 if($sjc>=0){  //表示已经达到生效时间，自动确认收货
 $allmoney=$row1[money1]; //总金额 
 $sellblm=returnsellbl($row1[selluserid],$row1[probh])*$allmoney; //卖家可得金额
 $ptyj=$allmoney-$sellblm;
 PointUpdateM($row1[selluserid],$sellblm);
 PointIntoM($row1[selluserid],"买家未在有效时间内确认收货，系统自动确认收货，已自动扣除平台佣金".$ptyj."元",$sellblm);
 //推荐B
 $v=returntjuserid($row1[userid]);
 $tjmoney=returntjmoney($row1[probh]);
 if(!empty($v) && !empty($tjmoney)){
 $tjm=$allmoney*$tjmoney;
 $nc1=returnnc($row1[userid]);
 PointUpdateM($v,$tjm);
 PointIntoM($v,"您推荐的买家(".$nc1.")成功交易了".$allmoney."元，您获得相应佣金",$tjm);
 PointUpdateM($row1[selluserid],$tjm*(-1));
 PointIntoM($row1[selluserid],"买家(".$nc1.")由其他用户推荐进来(推荐人ID:".$v.")，扣除佣金",$tjm*(-1));
 }
 //推荐E
 updatetable("yjcode_order","ddzt='suc',oksj='".$sj1."' where orderbh='".$myorderbh."'");
 deletetable("yjcode_db where orderbh='".$myorderbh."'");
 deletetable("yjcode_tk where orderbh='".$myorderbh."'");
 }
}
 

?>