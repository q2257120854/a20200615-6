<?php
include("../config/conn.php");
include("../config/function.php");
AdminSes_audit();
$id=$_GET[id];

//函数开始
if($_GET[control]=="update"){
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0201,")){Audit_alert("权限不够","default.php");}
 zwzr();
 updatetable("yjcode_newspj","
			 sj='".$_POST[tsj]."',
			 uip='".$_POST[tuip]."',
			 txt='".$_POST[ttxt]."',
			 hf='".$_POST[thf]."',
			 zt=".$_POST[Rzt]."
			 where id=".$id);
 php_toheader("newspj.php?t=suc&id=".$id);

}
//函数结果

while0("*","yjcode_newspj where id=".$id);if(!$row=mysql_fetch_array($res)){php_toheader("newspjlist.php");}
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
document.getElementById("menu4").className="a1";
</script>
<? if(!strstr($adminqx,",0,") && !strstr($adminqx,",0202,")){echo "<div class='noneqx'>无权限</div>";exit;}?>

<div class="yjcode">
 <? $leftid=1;include("menu_news.php");?>

<div class="right">
 
 <div class="bqu1">
 <a href="javascript:void(0);" class="a1">资讯评价</a>
 <a href="newspjlist.php">返回列表</a>
 </div>
 
 <? if($_GET[t]=="suc"){systs("恭喜您，操作成功！","newspj.php?id=".$id);}?>
 <!--B-->
 <div class="rkuang">
 <script language="javascript">
 function tj(){
 layer.msg('正在提交', {icon: 16  ,time: 0,shade :0.25});
 f1.action="newspj.php?id=<?=$id?>&control=update";
 }
 </script>
 <? while1("*","yjcode_news where bh='".$row[newsbh]."'");$row1=mysql_fetch_array($res1);?>
 <form name="f1" method="post" onsubmit="return tj()">
 <ul class="uk">
 <li class="l1">资讯信息：</li>
 <li class="l2"><input type="text" size="80" value="<?=$row1[tit]?>" class="inp redony" readonly="readonly" /><span class="fd">[<a href="../news/txtlist_i<?=$row1[id]?>v.html" target="_blank">查看资讯</a>]</span></li>
 <li class="l1">评价会员：</li>
 <li class="l2"><input type="text" size="20" value="<? $uid=returnuser($row[userid]);echo $uid;?>" class="inp redony" readonly="readonly" /></li>
 <li class="l1">评价时间：</li>
 <li class="l2"><input type="text" size="20" value="<?=$row[sj]?>" class="inp" name="tsj" /></li>
 <li class="l1">IP地址：</li>
 <li class="l2"><input type="text" size="20" value="<?=$row[uip]?>" class="inp" name="tuip" /></li>
 <li class="l4">评价内容：</li>
 <li class="l5"><textarea name="ttxt"><?=$row[txt]?></textarea></li>
 <li class="l4">回复内容：</li>
 <li class="l5"><textarea name="thf"><?=$row[hf]?></textarea></li>
 <li class="l1">审核状态：</li>
 <li class="l2">
 <label><input name="Rzt" type="radio" value="0" <? if(0==$row[zt]){?>checked="checked"<? }?> /> <strong>正常展示</strong></label>
 <label><input name="Rzt" type="radio" value="1" <? if(1==$row[zt]){?>checked="checked"<? }?> /> <strong>正在审核</strong></label>
 <label><input name="Rzt" type="radio" value="2" <? if(2==$row[zt]){?>checked="checked"<? }?> /> <strong>审核不通过</strong></label>
 </li>
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