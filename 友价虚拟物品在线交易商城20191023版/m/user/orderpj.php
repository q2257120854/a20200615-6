<?
include("../../config/conn.php");
include("../../config/function.php");
sesCheck_m();
$userid=returnuserid($_SESSION["SHOPUSER"]);
$orderbh=$_GET[orderbh];
while0("*","yjcode_order where orderbh='".$orderbh."' and ddzt='suc' and userid=".$userid);if(!$row=mysql_fetch_array($res)){php_toheader("order.php");}
if(panduan("bh","yjcode_pro where bh='".$row[probh]."'")==0){Audit_alert("该商品已被删除，无法进行评价！","order.php");}
$sqlpj="select * from yjcode_propj where orderbh='".$orderbh."' and userid=".$userid;mysql_query("SET NAMES 'GBK'");$respj=mysql_query($sqlpj);
if($rowpj=mysql_fetch_array($respj)){$ifpj=1;}else{$ifpj=0;}

if(sqlzhuru($_POST[jvs])=="pj"){
 zwzr();
 if(1==$ifpj){Audit_alert("您已评价过，无须重复点评！","orderpj.php?orderbh=".$orderbh);}
 $sj=date("Y-m-d H:i:s");
 $uip=$_SERVER["REMOTE_ADDR"];
 if(panduan("*","yjcode_tp where bh='".$orderbh."'")==1){$iftp=1;}else{$iftp=0;}
 intotable("yjcode_propj","probh,selluserid,userid,sj,uip,pf1,pf2,pf3,txt,orderbh,pjlx,iftp","'".$row[probh]."',".$row[selluserid].",".$row[userid].",'".$sj."','".$uip."',".sqlzhuru($_POST[hpjjf1]).",".sqlzhuru($_POST[hpjjf2]).",".sqlzhuru($_POST[hpjjf3]).",'".sqlzhuru($_POST[s1])."','".$row[orderbh]."',".$_POST[Rpj].",".$iftp."");$id=mysql_insert_id();
 if(empty($id)){Audit_alert("您已评价过，不能重复点评！","orderpj.php?orderbh=".$orderbh);}
 $sql1="select avg(pf1) as pf1v,avg(pf2) as pf2v,avg(pf3) as pf3v from yjcode_propj where probh='".$row[probh]."' and selluserid=".$row[selluserid];mysql_query("SET NAMES 'GBK'");$res1=mysql_query($sql1);
 $row1=mysql_fetch_array($res1);
 updatetable("yjcode_pro","pf1=".round($row1[pf1v],2).",pf2=".round($row1[pf2v],2).",pf3=".round($row1[pf3v],2)." where bh='".$row[probh]."'");
 PointInto($userid,"交易成功，点评商品获得积分",$rowcontrol[pjjf]);
 PointUpdate($userid,$rowcontrol[pjjf]); 
 updatetable("yjcode_order","ifpj=1 where orderbh='".$orderbh."'");

 $sqlp="select avg(pf1) pf1v,avg(pf2) pf2v,avg(pf3) pf3v from yjcode_pro where zt=0 and userid=".$row[selluserid];mysql_query("SET NAMES 'GBK'");
 $resp=mysql_query($sqlp);$rowp=mysql_fetch_array($resp);
 updatetable("yjcode_user","pf1=".round($rowp[pf1v],2).",pf2=".round($rowp[pf2v],2).",pf3=".round($rowp[pf3v],2)." where id=".$row[selluserid]);

 php_toheader("orderpj.php?orderbh=".$orderbh);

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
<script language="javascript">
function tj(){
 if((document.f1.s1.value).replace(/\s/,"")==""){layerts("请输入简要的点评内容");return false;}
 layer.open({type: 2,content: '正在提交',shadeClose:false});
 f1.action="orderpj.php?orderbh=<?=$orderbh?>";
}
</script>
</head>
<body>
<? include("topuser.php");?>

<div class="bfbtop1 box">
 <div class="d1" onClick="gourl('order.php')"><img src="img/topleft.png" height="21" /></div>
 <div class="d2">评价</div>
 <div class="d3"></div>
</div>

 <? if(0==$ifpj){?>
 <form name="f1" method="post" onSubmit="return tj()">
 <input type="hidden" value="pj" name="jvs" />
 <div class="listcap box"><div class="d2">填写评价，可获得<?=$rowcontrol[pjjf]?>积分</div></div>
 <div class="orderpj box"><div class="d1"><textarea name="s1"></textarea></div></div>
 <div class="uk box">
  <div class="d1">评价类型</div>
  <div class="d2">
  <select name="Rpj">
  <option value="1">好评</option>
  <option value="2">中评</option>
  <option value="3">差评</option>
  </select>
  </div>
  <div class="d3"><img src="../img/rightjian.png" height="13" /></div>
 </div>
 <div class="uk box">
  <div class="d1">描述相符</div>
  <div class="d2"><select name="hpjjf1"><? for($i=5;$i>=1;$i--){?><option value="<?=$i?>"><?=$i?>分</option><? }?></select></div>
  <div class="d3"><img src="../img/rightjian.png" height="13" /></div>
 </div>
 <div class="uk box">
  <div class="d1">发货速度</div>
  <div class="d2"><select name="hpjjf2"><? for($i=5;$i>=1;$i--){?><option value="<?=$i?>"><?=$i?>分</option><? }?></select></div>
  <div class="d3"><img src="../img/rightjian.png" height="13" /></div>
 </div>
 <div class="uk box">
  <div class="d1">服务态度</div>
  <div class="d2"><select name="hpjjf3"><? for($i=5;$i>=1;$i--){?><option value="<?=$i?>"><?=$i?>分</option><? }?></select></div>
  <div class="d3"><img src="../img/rightjian.png" height="13" /></div>
 </div>
<!--图片B-->
<div class="uk box">
 <div class="d1">评价图片<span class="s1"></span></div>
 <div class="d2"><iframe style="float:left;margin-top:-1px;" src="tpupload.php?admin=3&bh=<?=$orderbh?>" width="103" scrolling="no" height="103" frameborder="0"></iframe></div>
</div>
<div class="xgtp box">
<div class="xgtpm">
 <div id="xgtp1" style="display:none;">正在处理</div>
 <div id="xgtp2"></div>
</div>
</div>
<!--图片E-->
 <div class="fbbtn box">
 <div class="d1"><? tjbtnr_m("发表评论")?></div>
 </div>
 </form>
 
 <? }else{?>
 <div class="orderpj1 box">
  <div class="d1">评价内容</div>
  <div class="d2">
  您于 <?=$rowpj[sj]?> 对本次交易进行了评价：<br>
  <strong class="feng">描述相符度<?=$rowpj[pf1]?>分，发货速度<?=$rowpj[pf2]?>分，卖家服务态度<?=$rowpj[pf3]?>分</strong><br>
  评价：<?=$rowpj[txt]?><br>
  <? while1("*","yjcode_tp where bh='".$orderbh."' order by xh asc");while($row1=mysql_fetch_array($res1)){$tp="../../".str_replace(".","-1.",$row1[tp]);?>
  <a href="../../<?=$row1[tp]?>" target="_blank"><img src="<?=$tp?>" width="50" height="50" /></a>&nbsp;&nbsp;
  <? }?>
  </div>
 </div>
 <? }?>

<? include("orderv.php");?>

<script language="javascript">
function xgtread(x){
 $.get("readtp.php",{bh:x,admin:7},function(result){
  $("#xgtp2").html(result);
 });
}
function deltp(x){
 document.getElementById("xgtp1").style.display="";
 $.get("tpdel.php",{id:x,admin:7},function(result){
  xgtread("<?=$orderbh?>");
  document.getElementById("xgtp1").style.display="none";
 });
}
xgtread("<?=$orderbh?>");
</script>

</body>
</html>