<?
include("../config/conn.php");
include("../config/function.php");
sesCheck();
$bh=$_GET[bh];
$userid=returnuserid($_SESSION["SHOPUSER"]);

if($_GET[control]=="update"){
 $sj=date("Y-m-d H:i:s");	
 updatetable("yjcode_yunfei","tit='".sqlzhuru($_POST[ttit])."',money1=".sqlzhuru($_POST[tmoney1]).",money2=".sqlzhuru($_POST[tmoney2]).",sj='".$sj."',zt=0 where userid=".$userid." and bh='".$bh."'");
 php_toheader("yunfei.php?t=suc&bh=".$bh);

}

while0("*","yjcode_yunfei where userid=".$userid." and bh='".$bh."'");if(!$row=mysql_fetch_array($res)){php_toheader("yunfeilist.php");}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>用户管理面板 - <?=webname?></title>
<? include("cssjs.html");?>
<link href="css/sell.css" rel="stylesheet" type="text/css" />
<script language="javascript">
function tj(){
if((document.f1.ttit.value).replace("/\s/","")==""){alert("请输入模板名称");document.f1.ttit.focus();return false;}
a=document.f1.tmoney1.value;if(a.replace("/\s/","")=="" || isNaN(a)){alert("请输入有效的运费");document.f1.tmoney1.focus();return false;}
a=document.f1.tmoney2.value;if(a.replace("/\s/","")=="" || isNaN(a)){alert("请输入有效的续重费用");document.f1.tmoney2.focus();return false;}
layer.msg('正在提交', {icon: 16  ,time: 0,shade :0.25});
tjwait();
f1.action="yunfei.php?control=update&bh=<?=$bh?>";
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
 
 <? include("sellzf.php");?>
 <? include("rcap16.php");?>
 <script language="javascript">
 document.getElementById("rcap2").className="l1 l2";
 </script>

 <!--白B-->
 <div class="rkuang">
 
 <? systs("恭喜您，操作成功!","yunfei.php?bh=".$bh)?>
 <form name="f1" method="post" onsubmit="return tj()">
 <input type="hidden" value="yunfei" name="jvs" />
 <ul class="uk">
 <li class="l1"><span class="red">*</span>模板名称：</li>
 <li class="l2"><input name="ttit" class="inp" value="<?=$row[tit]?>" size="25" type="text" /></li>
 <li class="l1"><span class="red">*</span>首重运费：</li>
 <li class="l2"><input name="tmoney1" class="inp" value="<?=$row[money1]?>" size="10" type="text" /></li>
 <li class="l1"><span class="red">*</span>续重费用：</li>
 <li class="l2"><input name="tmoney2" class="inp" value="<?=$row[money2]?>" size="10" type="text" /><span class="fd">每1公斤新增费用</span></li>
 <li class="l3"><?=tjbtnr("保存修改","yunfeilist.php")?></li>
 </ul>
 </form>
 
 </div>
 <!--白E-->

</div> 
<!--RE-->

</div>

<div class="clear clear15"></div>
<? include("../tem/bottom.html");?>
</body>
</html>