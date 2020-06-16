<?php
include("../config/conn.php");
include("../config/function.php");
AdminSes_audit();

while0("*","yjcode_typesx where admin=1 and id=".$_GET[ty1id]);$row=mysql_fetch_array($res);$typeid=$row[typeid];
$sj=date("Y-m-d H:i:s");
//函数开始
if($_GET[control]=="add"){
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0301,")){Audit_alert("权限不够","default.php");}
 zwzr();
 $ty1id=intval($_GET[ty1id]);
 if(panduan("*","yjcode_typesx where admin=2 and name1='".sqlzhuru($_POST[t0])."' and name2='".sqlzhuru($_POST[t1])."' and typeid=".$typeid)==1){Audit_alert("该选项已存在！","typesx1.php?ty1id=".$ty1id);}
 intotable("yjcode_typesx","typeid,name1,name2,sj,xh,admin","".$typeid.",'".sqlzhuru($_POST[t0])."','".sqlzhuru($_POST[t1])."','".$sj."',".sqlzhuru($_POST[t2]).",2");
 $id=mysql_insert_id();
 move_uploaded_file($_FILES["inp1"]['tmp_name'], "../tem/moban/".$rowcontrol[nowmb]."/homeimg/typesx2_".$id.".png");
 php_toheader("typesx1.php?t=suc&ty1id=".$_GET[ty1id]);
 
}elseif($_GET[control]=="update"){
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0301,")){Audit_alert("权限不够","default.php");}
 zwzr();
 $id=intval($_GET[id]);
 if(panduan("*","yjcode_typesx where admin=2 and name1='".sqlzhuru($_POST[t0])."' and name2='".sqlzhuru($_POST[t1])."' and typeid=".$typeid." and id<>".$id)==1){Audit_alert("该选项已存在！","typesx1.php?action=update&id=".$id."&ty1id=".$_GET[ty1id]);}
 updatetable("yjcode_typesx","name2='".sqlzhuru($_POST[t1])."',sj='".$sj."',xh=".sqlzhuru($_POST[t2])." where typeid=".$typeid." and id=".$id);
 move_uploaded_file($_FILES["inp1"]['tmp_name'], "../tem/moban/".$rowcontrol[nowmb]."/homeimg/typesx2_".$id.".png");
 php_toheader("typesx1.php?t=suc&action=update&id=".$id."&ty1id=".$_GET[ty1id]);

}elseif($_GET[control]=="del"){
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0301,")){Audit_alert("权限不够","default.php");}
 zwzr();
 $id=intval($_GET[id]);
 delFile($_GET[tp]);
 php_toheader("typesx1.php?action=update&id=".$id."&ty1id=".$_GET[ty1id]);

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
 
 <? if($_GET[t]=="suc"){systs("恭喜您，操作成功！","typesx1.php?action=".$_GET[action]."&ty1id=".$_GET[ty1id]."&id=".$_GET[id]);}?>
 <div class="bqu1">
 <a href="javascript:void(0);" class="a1"><?=returntype(1,$typeid)?>附加选项 - 编辑二级选项</a>
 <a href="typesxlist.php?typeid=<?=$typeid?>">返回列表</a>
 </div> 
 <!--begin-->
 <div class="rkuang">
 <? if($_GET[action]!="update"){?>
 <script language="javascript">
 function tj(){
 if((document.f1.t1.value).replace(/\s/,"")==""){alert("请输入选项名称！");document.f1.t1.focus();return false;}
 if((document.f1.t2.value).replace(/\s/,"")=="" || isNaN(document.f1.t2.value)){alert("请输入有效的排序号！");document.f1.t2.focus();return false;}
 layer.msg('正在提交', {icon: 16  ,time: 0,shade :0.25});
 f1.action="typesx1.php?control=add&ty1id=<?=$_GET[ty1id]?>";
 }
 </script>
 <form name="f1" method="post" onsubmit="return tj()" enctype="multipart/form-data">
 <ul class="uk">
 <li class="l1">大选项：</li>
 <li class="l2"><input type="text" class="inp redony" value="<?=$row[name1]?>" name="t0" readonly="readonly" /></li>
 <li class="l1">小选项：</li>
 <li class="l2"><input type="text" class="inp" name="t1" /></li>
 <li class="l1">排序：</li>
 <li class="l2"><input type="text" class="inp" name="t2" value="<?=returnxh("yjcode_typesx"," and admin=2 and name1='".$row[name1]."' and typeid=".$typeid)?>" /> <span class="fd">序号越小，越靠前</span></li>
 <li class="l1">图标：</li>
 <li class="l2"><input type="file" class="inp1" name="inp1" id="inp1" size="15" accept=".jpg,.gif,.jpeg,.png"><span class="fd">根据实际情况上传(每套模板都是独立的)</span></li>
 <li class="l3"><input type="submit" value="保存修改" class="btn1" /></li>
 </ul>
 </form>
 
 <? 
 }elseif($_GET[action]=="update"){
 $ty1id=intval($_GET[ty1id]);
 $id=intval($_GET[id]);
 while1("*","yjcode_typesx where id=".$id);if(!$row1=mysql_fetch_array($res1)){php_toheader("typesxlist.php?typeid=".$typeid);}
 ?>
 <script language="javascript">
 function tj(){
 if((document.f1.t1.value).replace(/\s/,"")==""){alert("请输入选项名称！");document.f1.t1.focus();return false;}
 if((document.f1.t2.value).replace(/\s/,"")=="" || isNaN(document.f1.t2.value)){alert("请输入有效的排序号！");document.f1.t2.focus();return false;}
 layer.msg('正在提交', {icon: 16  ,time: 0,shade :0.25});
 f1.action="typesx1.php?control=update&id=<?=$row1[id]?>&ty1id=<?=$ty1id?>";
 }
 function deltp(x){
  if(confirm("确定要删除该图标吗？")){location.href="typesx1.php?id=<?=$id?>&ty1id=<?=$ty1id?>&control=del&tp="+x;}else{return false;}
 }
 </script>
 <form name="f1" method="post" onsubmit="return tj()" enctype="multipart/form-data">
 <input type="hidden" value="<?=$row[name1]?>" name="oldty1" />
 <ul class="uk">
 <li class="l1">大选项：</li>
 <li class="l2"><input type="text" class="inp redony" value="<?=$row[name1]?>" name="t0" readonly="readonly" /></li>
 <li class="l1">小选项：</li>
 <li class="l2"><input type="text" value="<?=$row1[name2]?>" class="inp" name="t1" /></li>
 <li class="l1">排序：</li>
 <li class="l2"><input type="text" class="inp" name="t2" value="<?=$row1[xh]?>" /> <span class="fd">序号越小，越靠前</span></li>
 <li class="l1">图标：</li>
 <li class="l2"><input type="file" class="inp1" name="inp1" id="inp1" size="15" accept=".jpg,.gif,.jpeg,.png"><span class="fd">根据实际情况上传(每套模板都是独立的)</span></li>
 <? $ntp="../tem/moban/".$rowcontrol[nowmb]."/homeimg/typesx2_".$row1[id].".png";if(is_file($ntp)){?>
 <li class="l8"></li>
 <li class="l9"><img src="<?=$ntp?>" style="max-height:55px;" /> [<a href="javascript:void(0);" onclick="deltp('<?=$ntp?>')">删除</a>]</li>
 <? }?>
 <li class="l3"><input type="submit" value="保存修改" class="btn1" /></li>
 </ul>
 </form>
 
 <? }?>
 </div>
 <!--end-->
 
</div>
</div>
<?php include("bottom.php");?>
</body>
</html>