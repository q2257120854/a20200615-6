<?php
include("../config/conn.php");
include("../config/function.php");

$sj=date("Y-m-d H:i:s");
$ses=" where zt=2";
if($_GET[zt]=="1"){$ses=$ses." and zt=1";}
elseif($_GET[zt]=="2"){$ses=$ses." and zt=2";}
if($_GET[st1]!=""){$ses=$ses." and tit like '%".$_GET[st1]."%'";}
if($_GET[st2]!=""){$ses=$ses." and mybh='".$_GET[st2]."'";}
if($_GET[st3]!=""){$ses=$ses." and userid='".returnuserid($_GET[st3])."'";}
if($_GET[sd1]!=""){$ses=$ses." and ty1id=".$_GET[sd1];}
if($_GET[page]!=""){$page=$_GET[page];}else{$page=1;}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="renderer" content="webkit" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Item-Number" content="">
<meta name="Pg-Type" content="publicity">
<meta name="keywords" content="<?=webname?>,曝光台,封禁公示,违规公示,处罚公示">
<meta name="description" content="<?=webname?>曝光台、违规、封禁、处罚公示！">
<title>曝光台 - 违规处罚公示 - <?=webname?></title>
<link href="/css/basic.css" rel="stylesheet" type="text/css" />
<link href="css/index.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="/js/basic.js"></script>
<script type="text/javascript" src="/js/jquery.min.js"></script>
<script language="javascript" src="/js/index.js"></script>
<script type="text/javascript" src="/homeimg/jquery.flexslider-min.js"></script>
<script language="javascript" src="/homeimg/index1.js"></script>
<script language="javascript" src="/homeimg/layui.js"></script>
<script language="javascript" src="/homeimg/common.js"></script>
</head>
<body>
<? include("../tem/top.html");?>
	<div class="help_top" style='background:#fff'>
		<div class="main">
		<a href="/" class="logo"></a>
		<h1>处罚公示</h1>
		<cite>
		<a href="/help/" class="first ">帮助中心</a><a href="" class="">消费保障</a><a href="/publicity/" class="curr">处罚公示</a><a href="" class="">订单围观</a>		</cite>
		</div>
	</div>

<div class="pubtop">
	<div class="main">
		<div class="pub-main">
			<div class='pubtop-item'>
      
				<dl class='my'>
					<? if(empty($_SESSION['SHOPUSER'])){?>
											<dt>
							<img src="/user/img/nonetx.gif">
							<cite><a onclick="layer_login()">登录</a> <em>后查看违规统计(·ω·)</em></cite>
						</dt>
							<? }else{?>
							<dt>
                            <img src="../upload/<?=$userid?>/user.jpg"onerror="this.src='/user/img/nonetx.gif'">
							<span><p><?=$usernc?></p>您没有严重违规情况，赞你哦！</span>
                            </dt>	<? }?>
						<dd>
							<cite>
								<em>0</em><p>我的不良计分</p>
							</cite>
							<cite>
								<em>0</em><p>我的不良记录</p>
							</cite>
						</dd>
						<input type="hidden" name="ureturn" value="/publicity/" />

									</dl>
			</div>
			<div class='pubtop-item'>
			</div>
			<div class='pubtop-item'>
				<dl class='link'>
					<dt>
						<a href="#" target="_blank">社区规范 &gt;</a>
						<a href="#" target="_blank">处罚条例  &gt;</a>
					</dt>
					<dd>
						<a href="javascript:layer.alert('您可以在信息详情页面点击【举报】<br>或联系一站网官方客服举报！',{icon:6});" target="_blank"></a>
					</dd>
				</dl>
			</div>
		</div>


	
 <!--商家B-->
 <ul class="tjsj">
 <li class="l1">曝光台 - 违规处罚公示</li>

 </ul>
 <div class="tjsjleft">
 <?
 $i=1;
 pagef($ses,10,"yjcode_pro","and zt=2 order by lastsj desc");while($row=mysql_fetch_array($res)){
 if(0==$row[ifxj]){$xjv="存在违规 ,已被停止展示";}else{$xjv="存在违规，已被停止展示";}
 ?>
 <ul class="u1">
 <li class="l1">
  <a href="" target="_blank" class="a1"><img src="<?=returntppd("../upload/".$row[userid]."/shop.jpg","../img/none180x180.gif")?>" onerror="this.src='img/none180x180.gif'" /></a>
 <li class="a2"><?=mb_substr(returnnc($row[userid]),0,2);?>***<?=mb_substr(returnnc($row[userid]),-2,2);?></li>
 <li class="a3">源码</li>
 <li class="s1"><?=$xjv?></li>
 </li>
 <li class="l2"><strong>对象：</b>（源码）<i><?=returntitdian($row["tit"],70)?></i></strong></li>
 <li class="l3"><strong>原因：<i><?=$row[ztsm]?></i></strong></li>
 <li class="l4"><strong>时间：<font color="#87A34D"><?=$row[sj]?></font></li>
 </ul>
<? $i++;}?>	
 </div>
</div>
<div class="control">
 <div class="npa">
 <?
 $nowurl="index.php";
 $nowwd="zt=".$_GET[zt]."&st1=".$_GET[st1]."&st3=".$_GET[st3]."&sd1=".$_GET[sd1];
 include("page.php");
 ?>
</div>
</div>
<? include("../tem/bottom.html");?>


</body>
</html>