<?
include("../config/conn.php");
include("../config/function.php");
sesCheck();
$userid=returnuserid($_SESSION[SHOPUSER]);
$sj=date("Y-m-d H:i:s");

while1("*","yjcode_qiandao where userid=".$userid." order by sj desc limit 1");
if($row1=mysql_fetch_array($res1)){
$a_ux = strtotime($sj);
$a_date = date('Y-m-d',$a_ux);
$b_date = date('Y-m-d',strtotime($row1[sj]));
if($a_date==$b_date){$ifq=1;}else{$ifq=0;}
}else{$ifq=0;}

//入库操作开始
if($_POST[jvs]=="qd"){
 zwzr();
 if(1==$ifq){Audit_alert("今日已签到，无须重复签到","qiandao.php");}
 $uip=$_SERVER["REMOTE_ADDR"];
 $qdjf=$rowcontrol[qdjf];
 $lxd=0;
 while1("*","yjcode_qiandaojf order by daynum desc limit 1");if($row1=mysql_fetch_array($res1)){
  for($i=2;$i<=$row1[daynum];$i++){
   $iv=$i-1;
   $sjv=date("Y-m-d",strtotime("-".$iv." day"));
   $sj1=$sjv." 00:00:00";
   $sj2=$sjv." 23:59:59";
   while2("*","yjcode_qiandao where userid=".$userid." and sj>='".$sj1."' and sj<='".$sj2."'");if(!$row2=mysql_fetch_array($res2)){break;}else{$lxd++;}
  }
  if($lxd>0){
  $dnum=$lxd+1;
  while3("*","yjcode_qiandaojf where daynum<=".$dnum." order by daynum desc limit 1");if($row3=mysql_fetch_array($res3)){$qdjf=$row3[jf];$lx="(连续签到".$dnum."天)";}
  }
 }
 intotable("yjcode_qiandao","userid,sj,uip,tit,jf","".$userid.",'".$sj."','".$uip."','".sqlzhuru($_POST[t1]).$lx."',".$qdjf."");
 PointInto($userid,"每日签到",$qdjf);
 PointUpdate($userid,$qdjf); 
 php_toheader("qiandao.php");
}
//入库操作结束

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>用户管理面板 - <?=webname?></title>
<? include("cssjs.html");?>
<link href="css/inf.css" rel="stylesheet" type="text/css" />
<script language="javascript">
function tj(){
if((document.f1.t1.value).replace(/\s/,"")==""){alert("请填写今日心情");document.f1.t1.focus();return false;}
layer.msg('正在提交', {icon: 16  ,time: 0,shade :0.25});
tjwait();
f1.action="qiandao.php?control=add";
}
</script>
</head>
<body>
<? include("../tem/top.html");?>
<? include("top.php");?>
<div class="yjcode">

<? include("left.php");?>

<!--RB-->
<div class="userright">
 
 <? include("rcap8.php");?>
 <script language="javascript">
 document.getElementById("rcap1").className="l1 l2";
 </script>

 <!--白B-->
 <div class="rkuang">
 
 <? while1("*","yjcode_qiandaojf order by daynum desc limit 1");if($row1=mysql_fetch_array($res1)){?>
 <div class="rts">连续签到可获得更高的积分奖励(最高可获得<strong class="feng"><?=$row1[jf]?></strong>分)，明天记得也来签到哦^_^</div>
 <? }?>
 
 <? if(0==$ifq){$weekarray=array("日","一","二","三","四","五","六");?>
 <form name="f1" method="post" onsubmit="return tj()">
 <input type="hidden" value="qd" name="jvs" />
 <ul class="uk">
 <li class="l1">今日心情：</li>
 <li class="l2"><input name="t1"  style="width:305px;" value="按时签到是个好习惯^_^ 签到拿分走人" class="inp" type="text" /></li>
 <li class="l3">
 <div id="tjbtn"><input type="submit" value="周<?=$weekarray[date("w")]?>" class="qd" /></div>
 <div id="tjing" style="display:none;color:#F96F39;"><img style="margin:0 0 6px 0;" src="../img/ajax_loader.gif" width="208" height="13" /><br>正在签到，请稍候^_^</div>
 </li>
 </ul>
 </form>
 <? }else{?>
 <ul class="uk">
 <li class="l1">签到提示：</li>
 <li class="l21"><strong class="feng">尊敬的用户，您今日已经签到成功，明天也记得来签到哦^_^</strong></li>
 </ul>
 <? }?>

 <ul class="qiandaocap">
 <li class="l1">签到时间</li>
 <li class="l2">奖励积分</li>
 <li class="l3">签到IP</li>
 <li class="l4">心情</li>
 </ul>
   
 <?
 $ses=" where userid=".$userid;
 $page=$_GET["page"];if($page==""){$page=1;}else{$page=intval($_GET["page"]);}
 pagef($ses,30,"yjcode_qiandao","order by sj desc");while($row=mysql_fetch_array($res)){
 ?>
 <ul class="qiandao">
 <li class="l1"><?=$row[sj]?></li>
 <li class="l2"><?=$row[jf]?></li>
 <li class="l3"><a href="http://www.baidu.com/s?wd=<?=$row[uip]?>" target="_blank"><?=$row[uip]?></a></li>
 <li class="l4"><?=$row[tit]?></li>
 </ul>
 <? }?>

 <div class="npa">
 <?
 $nowurl="qiandao.php";
 $nowwd="";
 require("page.php");
 ?>
 </div>
 
 <div class="clear clear15"></div>
 
 </div>
 <!--白E-->

</div> 
<!--RE-->

</div>

<div class="clear clear15"></div>
<? include("../tem/bottom.html");?>
</body>
</html>