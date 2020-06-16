<?
include("../../config/conn.php");
include("../../config/function.php");
sesCheck_m();
$userid=returnuserid($_SESSION["SHOPUSER"]);
$orderbh=$_GET[orderbh];
while0("*","yjcode_order where orderbh='".$orderbh."' and (ddzt='db' or ddzt='backerr') and userid=".$userid);if(!$row=mysql_fetch_array($res)){php_toheader("order.php");}


if(sqlzhuru($_POST[jvs])=="sh"){
 zwzr();
 $zfmm=sha1(sqlzhuru($_POST[t1]));
 if($row[ddzt]!="db" && $row[ddzt]!="backerr"){Audit_alert("未知错误！","orderview.php?orderbh=".$orderbh);}
 $allmoney=$row[money1]*$row[num]+$row[yunfei];
 $sellblm=returnsellbl($row[selluserid],$row[probh])*$allmoney; //卖家可得金额
 $ptyj=$allmoney-$sellblm;
 PointUpdateM($row[selluserid],$sellblm);
 PointIntoM($row[selluserid],"成功卖出商品，买方已确认收货，已自动扣除平台佣金".$ptyj."元",$sellblm);
 //推荐B
 $v=returntjuserid($userid);
 $tjmoney=returntjmoney($row[probh]);
 if(!empty($v) && !empty($tjmoney)){
 $tjm=$allmoney*$rowcontrol[tjmoney];
 $nc1=returnnc($userid);
 PointUpdateM($v,$tjm);
 PointIntoM($v,"您推荐的买家(".$nc1.")成功交易了".$allmoney."元，您获得相应佣金",$tjm);
 PointUpdateM($row[selluserid],$tjm*(-1));
 PointIntoM($row[selluserid],"买家由其他用户推荐进来(推荐人ID:".$v.")，扣除佣金",$tjm*(-1));
 }
 //推荐E
 $sj=date("Y-m-d H:i:s");
 updatetable("yjcode_order","ddzt='suc',oksj='".$sj."' where userid=".$userid." and id=".$row[id]);
 deletetable("yjcode_db where userid=".$userid." and orderbh='".$orderbh."'");
 php_toheader("orderview.php?orderbh=".$orderbh); 

}
?>
<html>
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
<title>会员中心 <?=webname?></title>
<? include("../tem/cssjs.html");?>
<link href="css/buy.css" rel="stylesheet" type="text/css" />
</head>
<body>
<? include("topuser.php");?>

<div class="bfbtop1 box">
 <div class="d1" onClick="gourl('order.php')"><img src="img/topleft.png" height="21" /></div>
 <div class="d2">收货</div>
 <div class="d3"></div>
</div>

 <? include("orderv.php");?>
 <? if($row[ddzt]=="db" || $row[ddzt]=="backerr"){?>
 <script language="javascript">
 function tj(){
 if(!confirm("确定收货吗？")){return false;}
 layer.open({type: 2,content: '正在提交',shadeClose:false});
 f1.action="shouhuo.php?orderbh=<?=$orderbh?>";
 }
 </script>
 <form name="f1" method="post" onSubmit="return tj()">
 <div class="fbbtn box">
  <div class="d1"><? tjbtnr_m("确认收货")?></div>
 </div>
 <input type="hidden" value="sh" name="jvs" />
 <input type="hidden" value="<?=$orderbh?>" name="orderbh" />
 </form>
 <div class="tishi box">
 <div class="d1">
 <strong>* 站长提示：</strong><br>
 * 请先试用好您购买的这个商品，再确认收货<br>
 * 如果商品有问题，与售后方无法达成共识，您可以<a href="ordertk.php?orderbh=<?=$orderbh?>">申请退款</a>
 </div>
 </div>
 <? }?>
</body>
</html>