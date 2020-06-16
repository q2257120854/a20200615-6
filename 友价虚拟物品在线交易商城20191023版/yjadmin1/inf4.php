<?php
include("../config/conn.php");
include("../config/function.php");
AdminSes_audit();
while0("*","yjcode_control");$row=mysql_fetch_array($res);

if(sqlzhuru($_POST[jvs])=="control"){
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0301,")){Audit_alert("权限不够","default.php");}
 zwzr();
 $sellbl=sqlzhuru($_POST[tsellbl]);
 $txyh=sqlzhuru(str_replace(",","xcf",$_POST[ttxyh]));
 updatetable("yjcode_control",$ses."
			  dbsj=".sqlzhuru($_POST[tdbsj]).",
			  ycsj=".sqlzhuru($_POST[tycsj]).",
			  tksj=".sqlzhuru($_POST[ttksj]).",
			  regmoney=".sqlzhuru($_POST[tregmoney]).",
			  regjf=".sqlzhuru($_POST[tregjf]).",
			  pjjf=".sqlzhuru($_POST[tpjjf]).",
			  qdjf=".sqlzhuru($_POST[tqdjf]).",
			  jfmoney=".sqlzhuru($_POST[tjfmoney]).",
			  tjmoney=".sqlzhuru($_POST[ttjmoney]).",
			  sellbl=".$sellbl.",
			  txdi=".sqlzhuru($_POST[ttxdi]).",
			  taskyj=".sqlzhuru($_POST[ttaskyj]).",
			  taskoksj=".sqlzhuru($_POST[ttaskoksj]).",
			  taskerrsj=".sqlzhuru($_POST[ttaskerrsj]).",
			  txfl=".sqlzhuru($_POST[ttxfl]).",
			  inittj='".sqlzhuru($_POST[tinittj])."',
			  txyh='".$txyh."',
			  sxjf=".sqlzhuru($_POST[tsxjf]).",
			  paysxf=".sqlzhuru($_POST[tpaysxf])."
			  ");
 if(intval($_POST[R1])==2){updatetable("yjcode_user","sellbl=".$sellbl."");}
 deletetable("yjcode_qiandaojf");
 for($i=1;$i<=5;$i++){
 $d=$_POST["day_".$i];
 $jf=$_POST["jf_".$i];
 intotable("yjcode_qiandaojf","daynum,jf","".$d.",".$jf."");
 }
 
 $addir=sqlzhuru($_POST[taddir]);
 if(preg_match("/[A-Za-z]/",$addir) && preg_match("/\d/",$addir) && preg_match("/^[_a-zA-Z0-9]*$/",$addir)){}else{Audit_alert("广告目录必须同时包含字母和数字(并且只允许字母和数字组合)","inf4.php");}
 if(@rename("../".$row[addir],"../".$addir)){updatetable("yjcode_control","addir='".$addir."'");}

 php_toheader("inf4.php?t=suc");
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><?=webname?>管理系统</title>
<link href="css/basic.css" rel="stylesheet" type="text/css" />
<link href="css/quanju.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script language="javascript" src="js/basic.js"></script>
<script language="javascript" src="js/layer.js"></script>
<script language="javascript">
function tj(){
layer.msg('正在提交', {icon: 16  ,time: 0,shade :0.25});
f1.action="inf4.php";
}
</script>
</head>
<body>
<? include("top.php");?>
<script language="javascript">
document.getElementById("menu1").className="a1";
</script>
<? if(!strstr($adminqx,",0,") && !strstr($adminqx,",0302,")){echo "<div class='noneqx'>无权限</div>";exit;}?>

<div class="yjcode">
 <? $leftid=1;include("menu_quan.php");?>

<div class="right">
 
 <? if($_GET[t]=="suc"){systs("恭喜您，操作成功！","inf4.php");}?>
 <? include("rightcap1.php");?>
 <script language="javascript">document.getElementById("rtit5").className="a1";</script>
 
 <!--Begin-->
 <div class="rkuang">
 <form name="f1" method="post" onsubmit="return tj()">
 <input type="hidden" name="jvs" value="control" />
 <ul class="uk">
 <li class="l1">担保时间：</li>
 <li class="l2">
 <input name="tdbsj" value="<?=$row[dbsj]?>" size="10" type="text" class="inp" /> 
 <span class="fd">比如设为3，表示发货后，3天内买家未确认收货，系统将自动确认收货</span>
 </li>
 <li class="l1">延迟收货时间：</li>
 <li class="l2">
 <input name="tycsj" value="<?=$row[ycsj]?>" size="10" type="text" class="inp" /> 
 <span class="fd">比如设为7，表示能延迟7天确认收货</span>
 </li>
 <li class="l1">退款时间：</li>
 <li class="l2">
 <input name="ttksj" value="<?=$row[tksj]?>" size="10" type="text" class="inp" /> 
 <span class="fd">比如设为5，表示买家申请退款后，卖家在5天内未处理，将自动退款成功</span>
 </li>
 <li class="l1">注册赠送金钱：</li>
 <li class="l2">
 <input name="tregmoney" value="<?=$row[regmoney]?>" size="10" type="text" class="inp" />
 <span class="fd">默认为0，数值表示会员注册时赠送的金额，不要太高哦</span>
 </li>
 <li class="l1">注册赠送积分：</li>
 <li class="l2">
 <input name="tregjf" value="<?=$row[regjf]?>" size="10" type="text" class="inp" />
 <span class="fd">默认为0，数值表示会员注册时赠送的积分，不要太高哦</span>
 </li>
 <li class="l1">积分兑换比例：</li>
 <li class="l2">
 <input name="tjfmoney" value="<?=$row[jfmoney]?>" size="10" type="text" class="inp" />
 <span class="fd">100表示100积分兑换1人民币，10表示10积分兑换1人民币，依次类推</span>
 </li>
 <li class="l1">评价积分：</li>
 <li class="l2">
 <input name="tpjjf" value="<?=$row[pjjf]?>" size="10" type="text" class="inp" />
 <span class="fd">交易成功后，买家发表点评获得的积分数</span>
 </li>
 <li class="l1">刷新积分：</li>
 <li class="l2">
 <input name="tsxjf" value="<?=$row[sxjf]?>" size="10" type="text" class="inp" />
 <span class="fd">商家刷新商品需要消耗的积分</span>
 </li>
 <li class="l1">签到积分：</li>
 <li class="l2">
 <input name="tqdjf" value="<?=$row[qdjf]?>" size="10" type="text" class="inp" />
 <span class="fd">分 (每日签到，用户可获得的积分)</span>
 </li>
 </ul>
 
 <ul class="openyf">
 <li class="l1">连续签到天数</li>
 <li class="l2">奖励积分</li>
 </ul>
 <? 
 while1("*","yjcode_qiandaojf order by daynum asc");for($j=1;$j<=5;$j++){
 if($row1=mysql_fetch_array($res1)){$d=$row1[daynum];$jf=$row1[jf];}else{$d="";$jf="";}
 ?>
 <ul class="yue">
 <li class="l1"><input type="text" name="day_<?=$j?>" value="<?=$d?>" /></li>
 <li class="l2"><input type="text" name="jf_<?=$j?>" value="<?=$jf?>" /></li>
 </ul>
 <? }?>
 
 <ul class="uk">
 <li class="l1">任务中介佣金：</li>
 <li class="l2">
 <input name="ttaskyj" value="<?=$row[taskyj]?>" size="10" type="text" class="inp" />
 <span class="fd">任务交易完成后，平台可获得的佣金比例 <span class="red">0.01表示百分之一，0.02表示百分之二</span>，依次类推</span>
 </li>
 <li class="l1">任务卖家验收：</li>
 <li class="l2">
 <input name="ttaskoksj" value="<?=$row[taskoksj]?>" size="10" type="text" class="inp" />
 <span class="fd">天，接手方发起验收后，卖家需要在这个时间内处理，否则自动验收</span>
 </li>
 <li class="l1">任务买家验收：</li>
 <li class="l2">
 <input name="ttaskerrsj" value="<?=$row[taskerrsj]?>" size="10" type="text" class="inp" />
 <span class="fd">天，任务验收不通过，买家需要在这个天数内处理，否则自动处理</span>
 </li>
 <li class="l1">推荐佣金比例：</li>
 <li class="l2">
 <input name="ttjmoney" value="<?=$row[tjmoney]?>" size="10" type="text" class="inp" />
 <span class="fd">推荐的用户可获得的交易佣金比例：0.01表示1%，0.02表示2%。<span class="red">(如果商品分组有设置，以商品分组设置为准)</span></span>
 </li>
 <li class="l1">卖家收入比例：</li>
 <li class="l2">
 <input name="tsellbl" value="<?=$row[sellbl]?>" size="10" type="text" class="inp" />
 <span class="fd">卖家可获得的金额比例:1表示全归卖家，0.9表示90%归卖家。<span class="red">(如果商品分组有设置，以商品分组设置为准)</span></span>
 </li>
 <li class="l1">收入比例应用：</li>
 <li class="l2">
 <label><input name="R1" type="radio" value="1" checked="checked" /> 仅新注册用户</label>
 <label><input name="R1" type="radio" value="2" /> 全站用户重置</label>
 </li>
 <li class="l1">最低提现值：</li>
 <li class="l2">
 <input name="ttxdi" value="<?=returnjgdw($row[txdi],"",0)?>" size="10" type="text" class="inp" />
 <span class="fd">必须为整数，不能带小数点</span>
 </li>
 <li class="l1">提现手续费：</li>
 <li class="l2">
 <input name="ttxfl" value="<?=returnjgdw($row[txfl],"",0)?>" size="10" type="text" class="inp" />
 <span class="fd">如0.01，表示百分之一，即100元收取1元手续费</span>
 </li>
 <li class="l1">支付手续费：</li>
 <li class="l2">
 <input name="tpaysxf" value="<?=returnjgdw($row[paysxf],"",0)?>" size="10" type="text" class="inp" />
 <span class="fd">如0.01，表示百分之一，即100元收取1元手续费（只要通过支付接口付款时，才会调用）</span>
 </li>
 <li class="l1">提现银行：</li>
 <li class="l2">
 <input name="ttxyh" value="<?=returnjgdw(str_replace("xcf",",",$row[txyh]),"","支付宝,微信")?>" size="80" type="text" class="inp" /><span class="fd">用逗号隔开</span>
 </li>
 <li class="l1">统计数据初始：</li>
 <li class="l2">
 <input name="tinittj" value="<?=$row[inittj]?>" size="30" type="text" class="inp" />
 <span class="fd">用逗号隔开，格式为：会员数,商品数,交易笔数,交易金额数，如 100,50,200,10000</span>
 </li>
 <li class="l1">广告目录：</li>
 <li class="l2">
 <input name="taddir" value="<?=$row[addir]?>" size="10" type="text" class="inp" />
 <span class="fd red">广告目录必须同时包含字母和数字</span>
 </li>
 <li class="l3"><input type="submit" value="保存修改" class="btn1" /></li>
 </ul>
 </form>
 </div>
 <!--End-->
 
</div>
</div>

<? include("bottom.php");?>
</body>
</html>