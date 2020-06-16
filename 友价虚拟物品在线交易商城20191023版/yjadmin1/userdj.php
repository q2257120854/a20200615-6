<?php
include("../config/conn.php");
include("../config/function.php");
AdminSes_audit();
$sj=date("Y-m-d H:i:s");
$bh=$_GET[bh];
while0("*","yjcode_userdj where bh='".$bh."'");if(!$row=mysql_fetch_array($res)){php_toheader("userdjlist.php");}

//函数开始
if($_GET[control]=="update"){
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0301,")){Audit_alert("权限不够","default.php");}
 zwzr();
 $name1=sqlzhuru($_POST[tname1]);
 if(panduan("*","yjcode_userdj where name1='".$name1."' and bh<>'".$bh."'")==1)
 {Audit_alert("会员等级已存在！","userdj.php?bh=".$bh);}
 updatetable("yjcode_userdj","name1='".$name1."',zhekou=".sqlzhuru($_POST[tzhekou]).",money1=".sqlzhuru($_POST[tmoney1]).",jgdw=".sqlzhuru($_POST[d1]).",sj='".$sj."',xh=".sqlzhuru($_POST[txh]).",zt=0 where bh='".$bh."'");
 
 //同步修改其他表的等级名称
 $oldname=$_POST[oldname];
 if(!empty($oldname) && $oldname!=$name1){
  updatetable("yjcode_user","userdj='".$name1."' where userdj='".$oldname."'");
  updatetable("yjcode_prouserdj","djname='".$name1."' where djname='".$oldname."'");
 }
 
 php_toheader("userdj.php?t=suc&bh=".$bh);

}
//函数结果

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><?=webname?>管理后台</title>
<link href="css/basic.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script language="javascript" src="js/basic.js"></script>
<script language="javascript" src="js/layer.js"></script>
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
 
 <? if($_GET[t]=="suc"){systs("恭喜您，操作成功！","userdj.php?bh=".$bh);}?>
 <div class="bqu1">
 <a href="javascript:void(0);" class="a1">会员等级</a>
 <a href="userdjlist.php">返回列表</a>
 </div> 
 
 <!--begin-->
 <div class="rkuang">
 <script language="javascript">
 function tj(){
 if((document.f1.tname1.value).replace(/\s/,"")==""){alert("请输入等级名称！");document.f1.tname1.focus();return false;}
 if((document.f1.tzhekou.value).replace(/\s/,"")=="" || isNaN(document.f1.tzhekou.value)){alert("请输入有效的折扣！");document.f1.tzhekou.focus();return false;}
 if((document.f1.tmoney1.value).replace(/\s/,"")=="" || isNaN(document.f1.tmoney1.value)){alert("请输入有效的月费！");document.f1.tmoney1.focus();return false;}
 if((document.f1.txh.value).replace(/\s/,"")=="" || isNaN(document.f1.txh.value)){alert("请输入有效的排序号！");document.f1.txh.focus();return false;}
 layer.msg('正在提交', {icon: 16  ,time: 0,shade :0.25});
 f1.action="userdj.php?control=update&bh=<?=$bh?>";
 }
 </script>
 <form name="f1" method="post" onsubmit="return tj()">
 <input type="hidden" value="<?=$row[name1]?>" name="oldname" />
 <ul class="uk">
 <li class="l1"><span class="red">*</span> 等级名称：</li>
 <li class="l2"><input type="text" value="<?=$row[name1]?>" class="inp" name="tname1" /></li>
 <li class="l1"><span class="red">*</span> 享受折扣：</li>
 <li class="l2"><input type="text" value="<?=$row[zhekou]?>" class="inp" size="5" name="tzhekou" /> <span class="fd">如10表示无折扣，9表示9折</span></li>
 <li class="l1"><span class="red">*</span> 等级费用：</li>
 <li class="l2">
 <input type="text" value="<?=$row[money1]?>" class="inp" size="5" name="tmoney1" />
 <select name="d1" class="inp" style="margin-left:10px;">
 <option value="0">元/月</option>
 <option value="1"<? if(1==$row[jgdw]){?> selected="selected"<? }?>>元/年</option>
 </select>
 </li>
 <li class="l1"><span class="red">*</span> 排序：</li>
 <li class="l2"><input type="text" class="inp" name="txh" onfocus="inpf(this)" size="5" onblur="inpb(this)" value="<?=$row[xh]?>" /> <span class="fd">序号越小，越靠前</span></li>
 <li class="l3"><input type="submit" value="保存修改" class="btn1" /></li>
 </ul>
 </form>
 </div>
 <!--end-->
 
</div>
</div>
<?php include("bottom.php");?>
</body>
</html>