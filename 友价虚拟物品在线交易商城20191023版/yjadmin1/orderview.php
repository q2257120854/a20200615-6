<?php
include("../config/conn.php");
include("../config/function.php");
AdminSes_audit();
$orderbh=$_GET[orderbh];
$sj=date("Y-m-d H:i:s");
while0("*","yjcode_order where orderbh='".$orderbh."'");if(!$row=mysql_fetch_array($res)){php_toheader("orderlist.php");}
$tp=returntp("bh='".$row[probh]."' order by iffm desc","-2");

//函数开始
if($_GET[control]=="update" && sqlzhuru($_POST[jvs])=="order"){
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0401,")){Audit_alert("权限不够","default.php");}
 zwzr();
 if($row[ddzt]!="jf"){Audit_alert("订单状态错误，返回列表重试","orderlist.php");}
 $sj=date("Y-m-d H:i:s");
 //同意B
 if(sqlzhuru($_POST[R1])=="yes"){
  $tkjg="管理员介入，退款纠纷判定买方胜诉";
  $allmoney=$row[money1]*$row[num]+$row[yunfei];
  PointUpdateM($row[userid],$allmoney);
  PointIntoM($row[userid],$tkjg,$allmoney);
  intotable("yjcode_orderlog","orderbh,userid,selluserid,admin,txt,sj","'".$orderbh."',".$row[userid].",".$row[selluserid].",3,'".$tkjg."','".$sj."'");
  updatetable("yjcode_order","ddzt='jfbuy' where id=".$row[id]);
 }
 //同意E
 //不同意B
 if(sqlzhuru($_POST[R1])=="no"){
  $tkjg="管理员介入，退款纠纷判定卖方胜诉";
  $allmoney=$row[money1]*$row[num]+$row[yunfei];
  $sellblm=returnsellbl($row[selluserid],$row[probh])*$allmoney; //卖家可得金额
  $ptyj=$allmoney-$sellblm;
  PointUpdateM($row[selluserid],$sellblm);
  PointIntoM($row[selluserid],"退款纠纷，判定卖方胜诉，已自动扣除平台佣金".$ptyj."元",$sellblm);
  //推荐B
  $v=returntjuserid($row[userid]);
  $tjmoney=returntjmoney($row[probh]);
  if(!empty($v) && !empty($tjmoney)){
  $tjm=$allmoney*$tjmoney;
  PointUpdateM($v,$tjm);
  PointIntoM($v,"您推荐的买家成功交易了".$allmoney."元，您获得相应佣金",$tjm);
  PointUpdateM($row[selluserid],$tjm*(-1));
  PointIntoM($row[selluserid],"买家由其他用户推荐进来(推荐人ID:".$v.")，扣除佣金",$tjm*(-1));
  }
  //推荐E
  intotable("yjcode_orderlog","orderbh,userid,selluserid,admin,txt,sj","'".$orderbh."',".$row[userid].",".$row[selluserid].",3,'".$tkjg."','".$sj."'");
  updatetable("yjcode_order","ddzt='jfsell',oksj='".$sj."' where orderbh='".$orderbh."'");
 }
 //不同意E
 php_toheader("orderview.php?t=suc&orderbh=".$orderbh); 
 
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><?=webname?>管理系统</title>
<link href="css/basic.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script language="javascript" src="js/basic.js"></script>
<script language="javascript" src="js/layer.js"></script>

<script type="text/javascript" charset="gbk" src="../config/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="gbk" src="../config/ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="gbk" src="../config/ueditor/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript" charset="gbk" src="../config/ueditor/unit.js"></script>

<script language="javascript">
function tj(){
r=document.getElementsByName("R1");rr="";for(i=0;i<r.length;i++){if(r[i].checked==true){rr=r[i].value;}}if(rr==""){alert("请选择纠纷处理！");return false;}
if(!confirm("确定要提交该操作吗？")){return false;}
layer.msg('正在验证', {icon: 16  ,time: 0,shade :0.25});
f1.action="orderview.php?orderbh=<?=$orderbh?>&control=update";
}
</script>
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
 <a class="a1" href="orderlist.php">订单信息</a>
 </div>

 <? if($_GET[t]=="suc"){systs("恭喜您，操作成功！","orderview.php?orderbh=".$orderbh);}?>
 <div class="rights">
 <strong>提示：</strong><br>
 <span class="red">只有当买卖双方在退款这一环节无法达成共识时，管理员才可介入订单调整，且只能调整一次，请根据实际情况慎重操作</span>
 </div>

 <div class="rkuang">
 <ul class="rcap"><li class="l1"></li><li class="l2">订单信息</li><li class="l3"></li></ul>
 <ul class="uk">
 <li class="l1">订单状态：</li>
 <li class="l21"><strong><?=returnorderzt($row[ddzt])?></strong></li>
 <li class="l1">订单金额：</li>
 <li class="l21 feng"><strong><?=$row[money1]*$row[num]?>元</strong> (单价<?=$row[money1]?>元 * <?=$row[num]?>件，含运费<?=$row[yunfei]?>元)</li>
 <li class="l1">选购套餐：</li>
 <li class="l2"><input type="text" class="inp redony" readonly="readonly" size="60" value="<?=$row[tcv]?>" /></li>

 <? if($row[ddzt]=="db" || $row[ddzt]=="suc"){?>
 <li class="l1">发货时间：</li>
 <li class="l2"><input type="text" class="inp redony" readonly="readonly" size="20" value="<?=$row[fhsj]?>" /></li>
 <? }?>
 
 <? if($row[ddzt]=="back"){while1("*","yjcode_tk where orderbh='".$orderbh."'");$row1=mysql_fetch_array($res1);?>
 <li class="l1">退款申请时间：</li>
 <li class="l2"><input type="text" class="inp redony" readonly="readonly" size="20" value="<?=$row1[sj]?>" /></li>
 <li class="l10">退款理由：</li>
 <li class="l11"><script id="editor" name="content" type="text/plain" style="width:710px;height:330px;"><?=$row1[tkly]?></script></li>
 <? }?>
 
 <? if($row[ddzt]=="backsuc" || $row[ddzt]=="backerr"){?>
 <li class="l1">退款申请时间：</li>
 <li class="l2"><input type="text" class="inp redony" readonly="readonly" size="20" value="<?=$row[tksj]?>" /></li>
 <li class="l1">退款理由：</li>
 <li class="l2"><input type="text" class="inp redony" readonly="readonly" size="100" value="<?=$row[tkly]?>" /></li>
 <li class="l1">退款处理结果：</li>
 <li class="l2"><input type="text" class="inp redony" readonly="readonly" size="100" value="<?=$row[tkjg]?>" /></li>
 <li class="l1">退款处理时间：</li>
 <li class="l2"><input type="text" class="inp redony" readonly="readonly" size="20" value="<?=$row[tkoksj]?>" /></li>
 <? }?>
 
 <? if($row[ddzt]=="suc"){?>
 <li class="l1">确认收货时间：</li>
 <li class="l2"><input type="text" class="inp redony" readonly="readonly" size="20" value="<?=$row[oksj]?>" /></li>
 <? }?>
 
 <li class="l1">订单编号：</li>
 <li class="l2"><input type="text" class="inp redony" readonly="readonly" size="20" value="<?=$row[orderbh]?>" /></li>
 <li class="l1">商品名称：</li>
 <li class="l2"><input type="text" class="inp redony" readonly="readonly" size="100" value="<?=$row[tit]?>" /></li>
 <li class="l8"></li>
 <li class="l9"><img src="<?=$tp?>" onerror="this.src='../img/none60x60.gif'" width="54" height="54" /></li>
 <li class="l1">交易时间：</li>
 <li class="l2"><input type="text" class="inp redony" readonly="readonly" size="20" value="<?=$row[sj]?>" /></li>
 <li class="l1">交易IP：</li>
 <li class="l2"><input type="text" class="inp redony" readonly="readonly" size="20" value="<?=$row[uip]?>" /></li>
 <li class="l4">购买信息：</li>
 <li class="l5"><textarea name="tbuyform"><?=str_replace("<br>","\n",$row[buyform])?></textarea></li>
 <? if(!empty($row[shdz])){?>
 <li class="l1">收货地址：</li>
 <li class="l2"><input type="text" class="inp redony" readonly="readonly" size="100" value="<?=$row[shdz]?>" /></li>
 <? }?>
 </ul>
 <ul class="rcap"><li class="l1"></li><li class="l2">买卖双方</li><li class="l3"></li></ul>
 <ul class="uk">
 <? while1("*","yjcode_user where id=".$row[userid]);$row1=mysql_fetch_array($res1);?>
 <li class="l1">买家信息：</li>
 <li class="l2"><input type="text" class="inp redony" readonly="readonly" size="100" value="帐号:<?=$row1[uid]?> 昵称:<?=$row1[nc]?> 手机:<?=$row1[mot]?> QQ:<?=$row1[uqq]?>" /></li>
 <? while1("*","yjcode_user where id=".$row[selluserid]);$row1=mysql_fetch_array($res1);?>
 <li class="l1">卖家信息：</li>
 <li class="l2"><input type="text" class="inp redony" readonly="readonly" size="100" value="帐号:<?=$row1[uid]?> 昵称:<?=$row1[nc]?> 手机:<?=$row1[mot]?> QQ:<?=$row1[uqq]?>" /></li>
 </ul>
 
 <form name="f1" method="post" onsubmit="return tj()">
 <input type="hidden" name="jvs" value="order" />
 <ul class="rcap"><li class="l1"></li><li class="l2">管理员操作</li><li class="l3"></li></ul>
 <ul class="uk">
 <li class="l1">沟通记录：</li>
 <li class="l21"><a href="orderjf.php?orderbh=<?=$orderbh?>" class="red" target="_blank">【点击查看】</a></li>
 <? if($row[ddzt]=="jf"){?>
 <li class="l1">退款纠纷处理：</li>
 <li class="l2">
 <label><input name="R1" type="radio" value="yes" /> <strong>买家胜诉</strong></label> 
 <label><input name="R1" type="radio" value="no" /> <strong>卖家胜诉</strong></label> 
 </li>
 <li class="l1">友情提示：</li>
 <li class="l21">只有当买卖双方在退款这一环节无法达成共识时，管理员才可介入订单调整，且<strong class="red">只能调整一次，请根据实际情况慎重操作</strong>。</li>
 <li class="l3"><input type="submit" value="保存修改" class="btn1" /></li>
 <? }?>
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