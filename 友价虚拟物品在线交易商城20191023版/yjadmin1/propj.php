<?php
include("../config/conn.php");
include("../config/function.php");
AdminSes_audit();
$id=$_GET[id];

//函数开始
if($_GET[control]=="update"){
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0101,")){Audit_alert("权限不够","default.php");}
 zwzr();
 updatetable("yjcode_propj","
			 txt='".sqlzhuru($_POST[ttxt])."',
			 hf='".sqlzhuru($_POST[thf])."',
			 pf1=".sqlzhuru($_POST[tpf1]).",
			 pf2=".sqlzhuru($_POST[tpf2]).",
			 pf3=".sqlzhuru($_POST[tpf3])."
			 where id=".$id);
 php_toheader("propj.php?t=suc&id=".$id);

}
//函数结果

while0("*","yjcode_propj where id=".$id);if(!$row=mysql_fetch_array($res)){php_toheader("propjlist.php");}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><?=webname?>管理系统</title>
<link href="css/basic.css" rel="stylesheet" type="text/css" />
<link href="css/product.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script language="javascript" src="js/basic.js"></script>
<script language="javascript" src="js/layer.js"></script>
</head>
<body>
<? include("top.php");?>
<script language="javascript">
document.getElementById("menu3").className="a1";
</script>
<? if(!strstr($adminqx,",0,") && !strstr($adminqx,",0102,")){echo "<div class='noneqx'>无权限</div>";exit;}?>

<div class="yjcode">
 <? $leftid=1;include("menu_product.php");?>

<div class="right">

 <? if($_GET[t]=="suc"){systs("恭喜您，操作成功！","propj.php?id=".$id);}?>
 <div class="bqu1">
 <a href="javascript:void(0);" class="a1">用户评价</a>
 <a href="propjlist.php">返回列表</a>
 </div> 
 <!--B-->
 <div class="rkuang">
 <script language="javascript">
 function tj(){
 layer.msg('正在提交', {icon: 16  ,time: 0,shade :0.25});
 f1.action="propj.php?id=<?=$id?>&control=update";
 }
 </script>
 <? while1("*","yjcode_pro where bh='".$row[probh]."'");$row1=mysql_fetch_array($res1);?>
 <form name="f1" method="post" onsubmit="return tj()">
 <ul class="uk">
 <li class="l1">商品信息：</li>
 <li class="l2"><input type="text" size="80" value="<?=$row1[tit]?>" class="inp redony" readonly="readonly" /><span class="fd">[<a href="../product/view<?=$row1[id]?>.html" target="_blank">查看商品</a>]</span></li>
 <li class="l1">订单编号：</li>
 <li class="l2"><input type="text" size="20" value="<?=$row[orderbh]?>" class="inp redony" readonly="readonly" /></li>
 <li class="l1">商品卖家：</li>
 <li class="l2"><input type="text" size="20" value="<? $uid=returnuser($row[selluserid]);echo $uid;?>" class="inp redony" readonly="readonly" /></li>
 <li class="l1">评价会员：</li>
 <li class="l2"><input type="text" size="20" value="<? $uid=returnuser($row[userid]);echo $uid;?>" class="inp redony" readonly="readonly" /></li>
 <li class="l1">评价时间：</li>
 <li class="l2"><input type="text" size="20" value="<?=$row[sj]?>" class="inp redony" readonly="readonly" /></li>
 <li class="l1">IP地址：</li>
 <li class="l2"><input type="text" size="20" value="<?=$row[uip]?>" class="inp redony" readonly="readonly" /></li>
 <li class="l1">描述评分：</li>
 <li class="l2">
 <select name="tpf1" class="inp">
 <? for($i=1;$i<=5;$i++){?>
 <option value="<?=$i?>"<? if($i==$row[pf1]){?> selected="selected"<? }?>><?=$i?>分</option>
 <? }?>
 </select>
 </li>
 <li class="l1">发货评分：</li>
 <li class="l2">
 <select name="tpf2" class="inp">>
 <? for($i=1;$i<=5;$i++){?>
 <option value="<?=$i?>"<? if($i==$row[pf2]){?> selected="selected"<? }?>><?=$i?>分</option>
 <? }?>
 </select>
 </li>
 <li class="l1">售后评分：</li>
 <li class="l2">
 <select name="tpf3" class="inp">>
 <? for($i=1;$i<=5;$i++){?>
 <option value="<?=$i?>"<? if($i==$row[pf3]){?> selected="selected"<? }?>><?=$i?>分</option>
 <? }?>
 </select>
 </li>
 <li class="l4">评价内容：</li>
 <li class="l5"><textarea name="ttxt"><?=$row[txt]?></textarea></li>
 <li class="l4">商家回复：</li>
 <li class="l5"><textarea name="thf"><?=$row[hf]?></textarea></li>
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