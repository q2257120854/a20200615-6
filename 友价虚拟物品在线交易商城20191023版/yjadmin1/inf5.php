<?php
include("../config/conn.php");
include("../config/function.php");
AdminSes_audit();

if(sqlzhuru($_POST[yjcode])=="control"){
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0301,")){Audit_alert("权限不够","default.php");}
 zwzr();
 $alioss=sqlzhuru($_POST[alioss0]).",".sqlzhuru($_POST[alioss1]).",".sqlzhuru($_POST[alioss2]).",".sqlzhuru($_POST[alioss3]);
 updatetable("yjcode_control","alioss='".$alioss."',aliosskg='".$_GET[kg]."'");
 $output="<?php final class Config{const OSS_ACCESS_ID = '".sqlzhuru($_POST[alioss0])."';const OSS_ACCESS_KEY = '".sqlzhuru($_POST[alioss1])."';const OSS_ENDPOINT = '".sqlzhuru($_POST[alioss2])."';const OSS_TEST_BUCKET = '".sqlzhuru($_POST[alioss3])."';}";
 $fp= fopen("../config/alioss/Config.php","w");
 fwrite($fp,$output);
 fclose($fp);

 php_toheader("inf5.php?t=suc");
}

while0("*","yjcode_control");$row=mysql_fetch_array($res);
$alioss=array("","","","");
if(!empty($row[alioss]) && $row[alioss]!=",,,"){$alioss=preg_split("/,/",$row[alioss]);}
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
<script language="javascript">
function tj(){
c=document.getElementsByName("C1");str="a";for(i=0;i<c.length;i++){if(c[i].checked){str=str+c[i].value+"a";}}
layer.msg('正在提交', {icon: 16  ,time: 0,shade :0.25});
f1.action="inf5.php?kg="+str;
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
 
 <? if($_GET[t]=="suc"){systs("恭喜您，操作成功！","inf5.php");}?>
 <? include("rightcap1.php");?>
 <script language="javascript">document.getElementById("rtit6").className="a1";</script>
 
 <!--Begin-->
 <div class="rkuang">
 <form name="f1" method="post" onsubmit="return tj()" enctype="multipart/form-data">
 <input type="hidden" name="yjcode" value="control" />

 <ul class="rcap"><li class="l1"></li><li class="l2">阿里云OSS</li><li class="l3"></li></ul>
 <ul class="uk">
 <li class="l1">ACCESS_ID：</li>
 <li class="l2">
 <? if(!strstr($adminqx,",0,") && !strstr($adminqx,",0301,")){$sv="机密数据,权限不够";}else{$sv=$alioss[0];}?>
 <input  name="alioss0" value="<?=$sv?>" size="20" type="text" class="inp" /> 
 <span class="fd"><a class="red" href="http://www.yj99.cn/faq/view124.html" target="_blank">查看配置教程</a></span>
 </li>
 <li class="l1">ACCESS_KEY：</li>
 <li class="l2">
 <? if(!strstr($adminqx,",0,") && !strstr($adminqx,",0301,")){$sv="机密数据,权限不够";}else{$sv=$alioss[1];}?>
 <input  name="alioss1" value="<?=$sv?>" size="60" type="text" class="inp" /> 
 </li>
 <li class="l1">ENDPOINT：</li>
 <li class="l2">
 <? if(!strstr($adminqx,",0,") && !strstr($adminqx,",0301,")){$sv="机密数据,权限不够";}else{$sv=$alioss[2];}?>
 <input  name="alioss2" value="<?=$sv?>" size="60" type="text" class="inp" /> 
 </li>
 <li class="l1">TEST_BUCKET：</li>
 <li class="l2">
 <? if(!strstr($adminqx,",0,") && !strstr($adminqx,",0301,")){$sv="机密数据,权限不够";}else{$sv=$alioss[3];}?>
 <input  name="alioss3" value="<?=$sv?>" size="20" type="text" class="inp" /> 
 </li>
 <li class="l1">OSS开关：</li>
 <li class="l2">
 <label><input name="C1" type="checkbox" value="1"<? if(check_in("a1a",$row[aliosskg])){?> checked="checked"<? }?> /> 发货形式里的附件</label>
 <label><input name="C1" type="checkbox" value="2"<? if(check_in("a2a",$row[aliosskg])){?> checked="checked"<? }?> /> 商品效果图</label>
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