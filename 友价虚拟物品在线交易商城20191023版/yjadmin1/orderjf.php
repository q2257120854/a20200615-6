<?php
include("../config/conn.php");
include("../config/function.php");
AdminSes_audit();
$orderbh=$_GET[orderbh];
while0("*","yjcode_order where orderbh='".$orderbh."'");if(!$row=mysql_fetch_array($res)){php_toheader("orderlist.php");}
$sj=date("Y-m-d H:i:s");

if($_GET[control]=="update"){
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0401,")){Audit_alert("权限不够","default.php");}
 zwzr();
 $txt=sqlzhuru1($_POST[content]);
 if(empty($txt)){Audit_alert("内容不得为空，返回重试！","orderjf.php?orderbh=".$orderbh);}
 intotable("yjcode_orderlog","orderbh,userid,selluserid,admin,txt,sj","'".$orderbh."',".$row[userid].",".$row[selluserid].",3,'".$txt."','".$sj."'");
 php_toheader("orderjf.php?orderbh=".$orderbh); 

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><?=webname?>管理系统</title>
<link href="css/basic.css" rel="stylesheet" type="text/css" />
<link href="css/order.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script language="javascript" src="js/basic.js"></script>
<script language="javascript" src="js/layer.js"></script>

<script type="text/javascript" charset="gbk" src="../config/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="gbk" src="../config/ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="gbk" src="../config/ueditor/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript" charset="gbk" src="../config/ueditor/unit.js"></script>

</head>
<body>
<? include("top.php");?>
<script language="javascript">
document.getElementById("menu6").className="a1";
</script>
<? if(!strstr($adminqx,",0,") && !strstr($adminqx,",0402,")){echo "<div class='noneqx'>无权限</div>";exit;}?>

<div class="yjcode">
 <? $leftid=1;include("menu_order.php");?>

<div class="right">
 <div class="bqu1">
 <a class="a1" href="javascript:void(0);">沟通记录</a>
 <a href="orderview.php?orderbh=<?=$row[orderbh]?>">返回</a>
 </div>

 <div class="rkuang">
 <!--B-->
 <div class="gdhflist">
  <ul class="u1 u0">
  <li class="l1"><img src="<?=returntppd("../upload/".$row[userid]."/user.jpg","img/nonetx.jpg")?>" width="40" height="40" /></li>
  <li class="l2">[买方] <?=$row[tkly]?><br><?=$row[tksj]?></li>
  </ul>
  <ul class="u1">
  <li class="l1"><img src="<?=returntppd("../upload/".$row[selluserid]."/user.jpg","img/nonetx.jpg")?>" width="40" height="40" /></li>
  <li class="l2">[卖方] <?=$row[tkjg]?><br><?=$row[tkoksj]?></li>
  </ul>
  <? 
  while1("*","yjcode_orderlog where orderbh='".$orderbh."' order by sj asc");while($row1=mysql_fetch_array($res1)){
  $txt=$row1[txt];
  if($row1[admin]==1){$tp=returntppd("../upload/".$row1[userid]."/user.jpg","img/nonetx.jpg");$sf="买方";}
  elseif($row1[admin]==2){$tp=returntppd("../upload/".$row1[useridhf]."/user.jpg","img/nonetx.jpg");$sf="卖方";}
  elseif($row1[admin]==3){$tp="img/nonetx.jpg";$sf="平台";}
  ?>
  <ul class="u1">
  <li class="l1"><img src="<?=$tp?>" width="40" height="40" /></li>
  <li class="l2">[<?=$sf?>] <?=$txt?><br><?=$row1[sj]?></li>
  </ul>
  <? }?>

 </div>
 <!--E-->

 <script language="javascript">
 function tj(){
 layer.msg('正在验证', {icon: 16  ,time: 0,shade :0.25});
 f1.action="orderjf.php?orderbh=<?=$orderbh?>&control=update";
 }
 </script>
 <form name="f1" method="post" onsubmit="return tj()">
 <ul class="uk">
 <li class="l10"><span class="red">*</span> 管理员回复：</li>
 <li class="l11"><script id="editor" name="content" type="text/plain" style="width:858px;height:330px;"></script></li>
 <li class="l3"><input type="submit" value="下一步" class="btn1" /></li>
 </ul>
 </form>
 </div>
 
</div>
</div>
<?php include("bottom.php");?>
<script type="text/javascript">
//实例化编辑器
var ue = UE.getEditor('editor');
</script>
</body>
</html>