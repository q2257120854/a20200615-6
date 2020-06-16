<?php
include("../config/conn.php");
include("../config/function.php");
AdminSes_audit();
$bh=$_GET[bh];

while0("*","yjcode_jubao where bh='".$bh."'");if(!$row=mysql_fetch_array($res)){php_toheader("jubaolist.php");}
updatetable("yjcode_jubao","zt=2 where id=".$row[id]);
if($row[admin]==1){
 while1("*","yjcode_pro where id=".$row[jbid]);if(!$row1=mysql_fetch_array($res1)){Audit_alert("来源错误！","jubaolist.php");}
 $tit=$row1[tit];
}

//函数开始
if($_GET[control]=="update"){
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0601,")){Audit_alert("权限不够","default.php");}
 zwzr();
 updatetable("yjcode_jubao","
			 sj='".sqlzhuru($_POST[tsj])."',
			 jbqq='".sqlzhuru($_POST[tjbqq])."',
			 tyid=".sqlzhuru($_POST[d1]).",
			 txt='".sqlzhuru1($_POST[content])."',
			 uip='".sqlzhuru($_POST[tuip])."' where bh='".$bh."'");
 php_toheader("jubao.php?t=suc&bh=".$bh);

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

<script type="text/javascript" charset="gbk" src="../config/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="gbk" src="../config/ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="gbk" src="../config/ueditor/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript" charset="gbk" src="../config/ueditor/unit.js"></script>

</head>
<body>
<? include("top.php");?>
<script language="javascript">
document.getElementById("menu5").className="a1";
</script>
<? if(!strstr($adminqx,",0,") && !strstr($adminqx,",0602,")){echo "<div class='noneqx'>无权限</div>";exit;}?>

<div class="yjcode">
 <? $leftid=5;include("menu_ad.php");?>

<div class="right">
 <? if($_GET[t]=="suc"){systs("恭喜您，操作成功！","jubao.php?bh=".$bh);}?>
 <div class="bqu1">
 <a href="javascript:void(0);" class="a1">举报信息</a>
 <a href="jubaolist.php">返回列表</a>
 </div> 
 <!--B-->
 <div class="rkuang">
 <script language="javascript">
 function tj(){
 layer.msg('正在提交', {icon: 16  ,time: 0,shade :0.25});
 f1.action="jubao.php?bh=<?=$bh?>&control=update";
 }
 </script>
 <form name="f1" method="post" onsubmit="return tj()">
 <ul class="uk">
 <li class="l1">举报对象：</li>
 <li class="l21" style="color:#0101FF;font-weight:700;"><?=$tit?></li>
 <li class="l1">分组：</li>
 <li class="l2">
 <select name="d1" class="inp">
 <? while1("*","yjcode_jubaotype where admin=".$row[admin]." and zt=0 order by xh asc");while($row1=mysql_fetch_array($res1)){?>
 <option value="<?=$row1[id]?>"<? if($row1[id]==$row[tyid]){?> selected="selected"<? }?>><?=$row1[tit]?></option>
 <? }?>
 </select>
 </li>
 <li class="l10"><span class="red">*</span> 详细描述：</li>
 <li class="l11"><script id="editor" name="content" type="text/plain" style="width:858px;height:330px;"><?=$row[txt]?></script></li>
 <li class="l1">举报QQ：</li>
 <li class="l2"><input type="text" value="<?=$row[jbqq]?>" class="inp" name="tjbqq" /></li>
 <li class="l1">举报IP：</li>
 <li class="l2"><input type="text" value="<?=$row[uip]?>" class="inp" name="tuip" /></li>
 <li class="l1">举报时间：</li>
 <li class="l2"><input class="inp" name="tsj" value="<?=$row[sj]?>" size="20" type="text"/><span class="fd">正确的时间格式如：2012-12-12 12:12:12</span></li>
 <li class="l3"><input type="submit" value="保存修改" class="btn1" /></li>
 </ul>
 </form>
 </div>
 <!--E-->
 
</div>
</div>
<?php include("bottom.php");?>
<script type="text/javascript">
//实例化编辑器
var ue = UE.getEditor('editor');
</script>
</body>
</html>