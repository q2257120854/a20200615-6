<?php
include("../config/conn.php");
include("../config/function.php");
AdminSes_audit();
$bh=$_GET[bh];
$sj=date("Y-m-d H:i:s");
while0("*","yjcode_guolv where bh='".$bh."'");if(!$row=mysql_fetch_array($res)){php_toheader("guolvlist.php");}
$adminty=returnguolvty($row[admin]);
//函数开始
if($_GET[control]=="update"){
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0701,")){Audit_alert("权限不够","default.php");}
 zwzr();
 $tit=sqlzhuru($_POST[ttit]);
 if(check_in(".",$tit)){
  $nip=preg_split("/\./",getuip());
  if($tit==getuip() || $tit==$nip[0].".*.*.*" || $tit==$nip[0].".".$nip[1].".*.*" || $tit==$nip[0].".".$nip[1].".".$nip[2].".*"){Audit_alert("不能加自己的IP，否则自己都进不了网站了~","guolv.php?bh=".$bh);}
  $a=preg_split("/\./",$tit);$ses="ip1='".$a[0]."',ip2='".$a[1]."',ip3='".$a[2]."',ip4='".$a[3]."',";
 }
 updatetable("yjcode_guolv",$ses."
			 tit='".$tit."',
			 txt='".sqlzhuru($_POST[ttxt])."',
			 sj='".$sj."',
			 zt=1 where bh='".$bh."'");
 php_toheader("guolv.php?t=suc&bh=".$bh);

}
//函数结果

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
</head>
<body>
<? include("top.php");?>
<script language="javascript">
document.getElementById("menu2").className="a1";
</script>
<? if(!strstr($adminqx,",0,") && !strstr($adminqx,",0702,")){echo "<div class='noneqx'>无权限</div>";exit;}?>

<div class="yjcode">
 <? $leftid=7;include("menu_user.php");?>

<div class="right">
 
 <? if($_GET[t]=="suc"){systs("恭喜您，操作成功！[<a href='guolvlx.php?admin=".$row[admin]."'>继续添加信息</a>]","guolv.php?bh=".$bh);}?>


 <div class="bqu1">
 <a href="javascript:void(0);" class="a1"><?=$adminty?>信息</a>
 <a href="guolvlist.php?admin=<?=$row[admin]?>">返回列表</a>
 </div> 

 <!--B-->
 <div class="rkuang">
 <script language="javascript">
 function tj(){
 if((document.f1.ttit.value).replace(/\s/,"")==""){alert("请输入<?=$adminty?>");document.f1.ttit.focus();return false;}
 layer.msg('正在提交', {icon: 16  ,time: 0,shade :0.25});
 f1.action="guolv.php?bh=<?=$bh?>&control=update";
 }
 </script>
 <form name="f1" method="post" onsubmit="return tj()">
 <ul class="uk">
 <li class="l1">黑名单类型：</li>
 <li class="l21"><?=$adminty?></li>
 <li class="l1"><span class="red">*</span> <?=$adminty?>：</li>
 <li class="l2"><input type="text" size="30" value="<?=$row[tit]?>" class="inp" name="ttit" /><span class="fd">支持通配符(*)，如100.100.*.* 表示将100.100下的所有IP都屏蔽</span></li>
 <li class="l4">备注：</li>
 <li class="l5"><textarea name="ttxt"><?=$row[txt]?></textarea></li>
 <li class="l3"><input type="submit" value="保存修改" class="btn1" /></li>
 </ul>
 </form>
 </div>
 <!--E-->
 
</div>
</div>
<?php include("bottom.php");?>
</body>
</html>