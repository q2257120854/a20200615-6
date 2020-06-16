<?php
include("../config/conn.php");
include("../config/function.php");
AdminSes_audit();
$sj=date("Y-m-d H:i:s");
$today1=dateYMD($sj)." 00:00:00";
$today2=dateYMD($sj)." 23:59:59";
if($_GET[control]=="ret"){deletetable("yjcode_update");php_toheader("default.php");}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><?=webname?>管理系统</title>
<link rel="stylesheet" href="layui/css/layui.css">
<link href="css/basic.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script language="javascript" src="js/basic.js"></script>
<script language="javascript" src="js/layer.js"></script>
<script language="javascript" src="js/gx.js"></script>
<script language="javascript">
function retgx(){
if(confirm("建议在升级失败的情况下才提交重新升级，确定吗？")){location.href="default.php?control=ret";}else{return false;}	
}
</script>
</head>
<body>
<? include("top.php");?>
<script language="javascript">
document.getElementById("menu1").className="a1";
</script>

<div class="yjcode">
 <? $leftid=1;include("menu_quan.php");?>

<div class="right">

<div class="bqu1">
<a class="a1" href="default.php">全局管理</a>
</div>
  
<!--B-->
<div class="rkuang">

<!--基础数据B-->
<div class="ishuju">
 <ul class="u1 u11">
 <li class="l1"><img src="img/icon1.png" /></li>
 <li class="l2"><strong><?=sprintf("%.1f",returnsum("moneynum","yjcode_moneyrecord where sj>='".$today1."' and sj<='".$today2."'"));?></strong> 元<br>今日收入总额</li>
 </ul>
 <ul class="u1 u12">
 <li class="l1"><img src="img/icon2.png" /></li>
 <li class="l2"><strong><?=returncount("yjcode_user where shopzt=2 and sj>='".$today1."' and sj<='".$today2."'")?></strong> 家<br>今日新增商家</li>
 </ul>
 <ul class="u1 u13">
 <li class="l1"><img src="img/icon3.png" /></li>
 <li class="l2"><strong><?=returncount("yjcode_pro where zt=0 and lastsj>='".$today1."' and lastsj<='".$today2."'")?></strong> 个<br>今日更新商品</li>
 </ul>
 <ul class="u1 u14">
 <li class="l1"><img src="img/icon4.png" /></li>
 <li class="l2"><strong><?=returncount("yjcode_news where zt=0 and lastsj>='".$today1."' and lastsj<='".$today2."'")?></strong> 篇<br>今日更新资讯</li>
 </ul>
 <ul class="u1 u15">
 <li class="l1"><img src="img/icon5.png" /></li>
 <li class="l2"><strong><?=returncount("yjcode_order where sj>='".$today1."' and sj<='".$today2."'")?></strong> 个<br>今日订单总数</li>
 </ul>
 <ul class="u1 u16">
 <li class="l1"><img src="img/icon6.png" /></li>
 <li class="l2"><strong><?=$rowcontrol[smskc]?></strong> 条<br>短信剩余库存</li>
 </ul>
</div>
<!--基础数据E-->

<!--会员走势B-->
<div class="iuser">
 <div class="d1">会员注册数据走势图</div>
 <iframe marginwidth="1" marginheight="1" width="100%" height="141px" border="0" frameborder="0" src="iuser.php"></iframe>
</div>
<!--会员走势E-->

<!--开始判断高危-->
<? $errnum=0;?>
<div class="gaowei" id="gaowei" style="display:none;">
 <span class="gaocap">您的网站发现<strong id="errnum"></strong>个高危漏洞，请尽快修复，避免严重损失</span>
 <?
 if(empty($rowcontrol[ifshell])){
 $testv="yes";
 $dirarr=array("img/",
			   returnjgdw($rowcontrol[addir],"","gg")."/",
			   "ckeditor/attached/",
			   "config/ueditor/php/upload/",
			   "config/ueditor/php/upload1/",
			   "config/ueditor/php/upload2/",
			   "config/ueditor/php/upload3/",
			   "config/ueditor_mini/php/upload/",
			   "config/ueditor_mini/php/upload1/",
			   "config/ueditor_mini/php/upload2/",
			   "config/ueditor_mini/php/upload3/",
			   "upload/"
			   );
 for($i=0;$i<count($dirarr);$i++){
 createDir("../".$dirarr[$i]);
 $fp= fopen("../".$dirarr[$i]."shell.php","w");fwrite($fp,$testv);fclose($fp);if(@htmlget(weburl.$dirarr[$i]."shell.php")=="yes"){
  $errnum++;
 ?>
 <ul class="u1" onmouseover="this.className='u1 u2';" onmouseout="this.className='u1';">
 <li class="l1"><a href="http://www.yj99.cn/faq/view20.html" target="_blank">修复方法</a></li>
 <li class="l2">文件夹：<strong><?=$dirarr[$i]?></strong> 存在可执行脚本权限漏洞，有被注入并运行木马的风险</li>
 </ul>
 <? }}}else{?>
 <ul class="u1" onmouseover="this.className='u1 u2';" onmouseout="this.className='u1';">
 <li class="l1"><a href="inf1.php">启动检测</a></li>
 <li class="l2">您的后台关闭了 [脚本执行权限检测开关]，如果确保该类漏洞已经修复，可忽略本条提示</li>
 </ul>
 <? $errnum++;}?>
 
 <?
 while1("*","yjcode_admin where adminuid='".$_SESSION["SHOPADMIN"]."'");$row1=mysql_fetch_array($res1);
 if(strcmp("admin",$row1[adminuid])==0){$errnum++;
 ?>
 <ul class="u1" onmouseover="this.className='u1 u2';" onmouseout="this.className='u1';">
 <li class="l1"><a href="adminlist.php">立即修复</a></li>
 <li class="l2">请不要采用admin之类的容易被猜到的字符做为管理员账号</li>
 </ul>
 <? }?>
 
 <?
 if(strcmp(sha1("admin"),$row1[adminpwd])==0 || strcmp(sha1("123456"),$row1[adminpwd])==0 || strcmp(sha1("admin888"),$row1[adminpwd])==0){$errnum++;
 ?>
 <ul class="u1" onmouseover="this.className='u1 u2';" onmouseout="this.className='u1';">
 <li class="l1"><a href="pwd.php">立即修复</a></li>
 <li class="l2">请不要采用admin、123456、admin888之类的容易被猜到的字符做为密码</li>
 </ul>
 <? }?>

 <?
 if(@htmlget(weburl."config/conn.php?id=1%20and%201=1")=="4004"){$errnum++;
 ?>
 <ul class="u1" onmouseover="this.className='u1 u2';" onmouseout="this.className='u1';">
 <li class="l1"><a href="http://www.yj99.cn/faq/view129.html" target="_blank">点击修复</a></li>
 <li class="l2">您的主机/服务器未安装网站安全防护软件，建议安装，避免遭受攻击</li>
 </ul>
 <? }?>
 
</div>
<script language="javascript">
if(<?=$errnum?>==0){document.getElementById("gaowei").style.display="none";}else{document.getElementById("gaowei").style.display="";document.getElementById("errnum").innerHTML=<?=$errnum?>;}
</script>
<!--结束判断高危--> 

<!--更新B-->
<form name="f1" method="post" onsubmit="return callServer()">
<div class="gx" id="gx1" style="display:none;">
<span class="gxts">检测到有新补丁发布，建议升级</span>
<ul class="uk">
<li class="l1">后台密码：</li>
<li class="l2"><input type="password" class="inp" name="t1" size="20" onfocus="inpf(this)" onblur="inpb(this)" /></li>
<li class="l1"></li>
<li class="l21">
升级后，会同步到官网最新版本，<strong class="red">如您有过二次开发，请先做好备份</strong>，
【<a href="http://www.yj99.cn/faq/view35.html" class="blue" target="_blank">关于在线升级的详细说明</a>】
</li>
<li class="l3"><input type="submit" value="开始升级" class="btn1" /></li>
</ul>
</div>

<div class="gx" id="gx2" style="display:none;">
<span class="gxts">您的版本已是最新版 <span style="font-size:12px;color:#94B5DC;font-weight:100;cursor:pointer;" onClick="retgx()">[重新升级]</span></span>
</div>

<div class="gx" id="gx3" style="display:;">
<span class="gxts">正在获取最新版本信息……</span>
</div>
</form>
<script language="javascript">gxchk();</script>
<!--更新E-->

<!--待办事宜B-->
<div class="idai">
 <div class="d1">待办事项和数据统计</div>
 
 <? $anum=returncount("yjcode_user where shopzt=1");?>
 <ul class="u2">
 <li class="l1">开店审核</li>
 <li class="l2"><a class="<? if($anum>0){?>red<? }?>" href="userlist.php?shopzt=1">(<?=$anum?>)</a> 家</li>
 </ul>
 
 <? $anum=returncount("yjcode_baomoneyrecord where zt=1");?>
 <ul class="u2">
 <li class="l1">解冻保证金</li>
 <li class="l2"><a class="<? if($anum>0){?>red<? }?>" href="baomoneylist.php?zt=1">(<?=$anum?>)</a> 笔</li>
 </ul>
 
 <? $anum=returncount("yjcode_tixian where zt=4");?>
 <ul class="u2">
 <li class="l1">需要处理提现</li>
 <li class="l2"><a class="<? if($anum>0){?>red<? }?>" href="txlist.php?zt=4">(<?=$anum?>)</a> 笔</li>
 </ul>

 <? $anum=returncount("yjcode_user where sfzrz=0");?>
 <ul class="u2">
 <li class="l1">实名认证审核</li>
 <li class="l2"><a class="<? if($anum>0){?>red<? }?>" href="userlist.php?rz=xy">(<?=$anum?>)</a> 位</li>
 </ul>

 <? $anum=returncount("yjcode_payreng where ifok=1");?>
 <ul class="u2">
 <li class="l1">人工对账审核</li>
 <li class="l2"><a class="<? if($anum>0){?>red<? }?>" href="renglist.php?zt=1">(<?=$anum?>)</a> 笔</li>
 </ul>

 <? $anum=returncount("yjcode_user");?>
 <ul class="u2">
 <li class="l1">总用户数</li>
 <li class="l2"><a href="userlist.php">(<?=$anum?>)</a> 位</li>
 </ul>

 <? $anum=returncount("yjcode_pro where zt=1");?>
 <ul class="u2">
 <li class="l1">需要审核商品</li>
 <li class="l2"><a class="<? if($anum>0){?>red<? }?>" href="productlist.php?zt=1">(<?=$anum?>)</a> 个</li>
 </ul>

 <? $anum=returncount("yjcode_pro where zt<>99");?>
 <ul class="u2">
 <li class="l1">所有商品</li>
 <li class="l2"><a href="productlist.php">(<?=$anum?>)</a> 个</li>
 </ul>

 <? $anum=returncount("yjcode_order where ddzt='wait'");?>
 <ul class="u2">
 <li class="l1">等待发货订单</li>
 <li class="l2"><a class="<? if($anum>0){?>red<? }?>" href="orderlist.php?ddzt=wait">(<?=$anum?>)</a> 单</li>
 </ul>

 <? $anum=returncount("yjcode_order where ddzt='jf'");?>
 <ul class="u2">
 <li class="l1">交易纠纷</li>
 <li class="l2"><a class="<? if($anum>0){?>red<? }?>" href="orderlist.php?ddzt=jf">(<?=$anum?>)</a> 笔</li>
 </ul>

 <? $anum=returncount("yjcode_jubao where zt=1");?>
 <ul class="u2">
 <li class="l1">需要处理举报</li>
 <li class="l2"><a class="<? if($anum>0){?>red<? }?>" href="jubaolist.php?zt=1">(<?=$anum?>)</a> 件</li>
 </ul>

 <? $anum=returncount("yjcode_news where zt=1");?>
 <ul class="u2">
 <li class="l1">需要审核稿件</li>
 <li class="l2"><a class="<? if($anum>0){?>red<? }?>" href="newslist.php?zt=1">(<?=$anum?>)</a> 篇</li>
 </ul>

 <? $anum=returncount("yjcode_task where zt=1");?>
 <ul class="u2">
 <li class="l1">需要审核任务</li>
 <li class="l2"><a class="<? if($anum>0){?>red<? }?>" href="tasklist.php?zt=1">(<?=$anum?>)</a> 个</li>
 </ul>

 <? $anum=returncount("yjcode_task where zt=8");?>
 <ul class="u2">
 <li class="l1">有纠纷的任务</li>
 <li class="l2"><a class="<? if($anum>0){?>red<? }?>" href="tasklist.php?zt=8">(<?=$anum?>)</a> 个</li>
 </ul>

 <? $anum=returncount("yjcode_gd where gdzt=1 and zt<>99");?>
 <ul class="u2">
 <li class="l1">等待受理工单</li>
 <li class="l2"><a class="<? if($anum>0){?>red<? }?>" href="gdlist.php?gdzt=1">(<?=$anum?>)</a> 个</li>
 </ul>

 <? $anum=returncount("yjcode_newspj where zt=1");?>
 <ul class="u2">
 <li class="l1">审核资讯评价</li>
 <li class="l2"><a class="<? if($anum>0){?>red<? }?>" href="newspjlist.php?zt=1">(<?=$anum?>)</a> 个</li>
 </ul>
</div>
<!--待办事宜E-->

<!--系统参数B-->
<div class="isys">
 <div class="d1">系统信息</div>
 <ul class="u2">
 <li class="l1">PHP版本</li>
 <li class="l2"><? if(!strstr($adminqx,",0,") && !strstr($adminqx,",0302,")){echo "查看权限不够";}else{echo phpversion();}?></li>
 </ul>
 <ul class="u2">
 <li class="l1">MYSQL版本</li>
 <li class="l2"><?=mysql_get_server_info()?></li>
 </ul>
 <ul class="u2">
 <li class="l1">服务器系统</li>
 <li class="l2"><? if(!strstr($adminqx,",0,") && !strstr($adminqx,",0302,")){echo "查看权限不够";}else{echo php_uname('s').php_uname('r');}?></li>
 </ul>
 <ul class="u2">
 <li class="l1">PHP运行环境</li>
 <li class="l2"><? if(!strstr($adminqx,",0,") && !strstr($adminqx,",0302,")){echo "查看权限不够";}else{echo $_SERVER['SERVER_SOFTWARE'];}?></li>
 </ul>
 <ul class="u2">
 <li class="l1">服务器IP</li>
 <li class="l2"><?=GetHostByName($_SERVER['SERVER_NAME'])?></li>
 </ul>
 <ul class="u2">
 <li class="l1">PHP最大上传</li>
 <li class="l2"><?=ini_get('upload_max_filesize')?></li>
 </ul>
 <ul class="u2">
 <li class="l1">是否支持CURL</li>
 <li class="l2"><? $a=function_exists('curl_init');if($a==1){echo "支持";}else{echo "<span class=red>不支持</span>";}?></li>
 </ul>
 <ul class="u2">
 <li class="l1">当前系统时间</li>
 <li class="l2"><?=getsj()?></li>
 </ul>
</div>
<!--系统参数E-->

</div>
<!--E-->

</div>
</div>
<? include("bottom.php");?>
</body>
</html>