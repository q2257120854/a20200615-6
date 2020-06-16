<?php
include("../config/conn.php");
include("../config/function.php");
AdminSes_audit();
$bh=time()."ad".rnd_num(100);
$sj=date("Y-m-d H:i:s");
$ad=preg_split("/-/",sqlzhuru($_GET[sm]));

if($_GET[control]=="update"){  //表示修改
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0601,")){Audit_alert("权限不够！","default.php");}
 zwzr();
 if(sqlzhuru($_POST[R1])=="图片"){$tp=inp_tp_upload(1,"../".returnjgdw($rowcontrol[addir],"","gg")."/",$_GET[bh]);$tp3=inp_tp_upload(3,"../".returnjgdw($rowcontrol[addir],"","gg")."/",$_GET[bh]."-99");}elseif(sqlzhuru($_POST[R1])=="动画"){$tp=inp_tp_upload(2,"../".returnjgdw($rowcontrol[addir],"","gg")."/",$_GET[bh]);}
 if($tp!=""){$b=preg_split("/\./",$tp);$tptype=$b[1];}else{$tptype=sqlzhuru($_POST[tptype]);}
 if(sqlzhuru($_POST[R1])=="图片"){$aurl=sqlzhuru($_POST[t1]);}elseif(sqlzhuru($_POST[R1])=="文字"){$aurl=sqlzhuru($_POST[t3]);}
 $dqsj=sqlzhuru($_POST[tdqsj]);if(empty($dqsj)){$dqsj="2049-9-9 9:9:9";}
 updatetable("yjcode_ad","
 type1='".sqlzhuru($_POST[R1])."',
 jpggif='".$tptype."',
 tit='".sqlzhuru($_POST[at1])."',
 txt='".sqlzhuru1($_POST[s1])."',
 sj='".$_POST[tsj]."',
 aurl='".$aurl."',
 aw=".sqlzhuru($_POST[t2]).",
 ah=".sqlzhuru($_POST[t4]).",
 xh=".sqlzhuru($_POST[txh]).",
 zt=".$_POST[Rzt].",
 dqsj='".$dqsj."' where bh='".$_GET[bh]."'");
 php_toheader("ad.php?action=update&t=suc&bh=".$_GET[bh]."&sm=".urlencode(sqlzhuru($_POST[ts2]))."&must=".$_GET[must]);

}

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
<script type="text/javascript" src="js/adddate.js" ></script> 
<script language="javascript">
function lxsel(x){
	document.getElementById("adtp").style.display="none";
	document.getElementById("adcode").style.display="none";
	document.getElementById("adfont").style.display="none";
	document.getElementById("adflash").style.display="none";
	switch(x){
		case "图片":
	document.getElementById("adtp").style.display="";
		break;
		case "代码":
	document.getElementById("adcode").style.display="";
		break;
		case "文字":
	document.getElementById("adfont").style.display="";
		break;
		case "动画":
	document.getElementById("adflash").style.display="";
		break;
		}
	}
</script>
</head>
<body>
<? include("top.php");?>
<script language="javascript">
document.getElementById("menu5").className="a1";
</script>
<? if(!strstr($adminqx,",0,") && !strstr($adminqx,",0602,")){echo "<div class='noneqx'>无权限</div>";exit;}?>

<div class="yjcode">
 <? $leftid=1;include("menu_ad.php");?>

<div class="right">

 <? 
 while0("*","yjcode_ad where bh='".$_GET[bh]."'");$row=mysql_fetch_array($res);
 $tpdis="none";$codedis="none";$flashdis="none";$fontdis="none";
 ?>
 
 <? if($_GET[t]=="suc"){systs("恭喜您，操作成功！[<a href='ad_lx.php?bh=".$row[adbh]."&sm=".urlencode($_GET[sm])."&must=".$_GET[must]."'>继续添加</a>] [<a href='adlist.php?bh=".$row[adbh]."&sm=".urlencode($_GET[sm])."&must=".$_GET[must]."'>返回列表</a>] ","ad.php?bh=".$_GET[bh]."&sm=".urlencode($_GET[sm])."&must=".$_GET[must]);}?>
 
 <div class="bqu1">
 <a class="a1" href="javascript:void(0);">广告管理</a>
 <a href="adlist.php?bh=<?=$row[adbh]?>&sm=<?=urlencode($_GET[sm])?>&must=<?=$_GET[must]?>">返回列表</a>
 </div>

 
 <!--begin-->
 <div class="rkuang">
 <script language="javascript">
 function tj(){
 r=document.getElementsByName("R1");rr="";for(i=0;i<r.length;i++){if(r[i].checked==true){rr=r[i].value;}}if(rr==""){alert("请选择类型！");return false;}
 if(rr=="动画"){
  if((document.f1.t2.value).replace(/\s/,"")=="" || isNaN(document.f1.t2.value)){alert("请输入有效的动画宽度");document.f1.t2.focus();return false;}
  if((document.f1.t4.value).replace(/\s/,"")=="" || isNaN(document.f1.t4.value)){alert("请输入有效的动画高度");document.f1.t4.focus();return false;}
 }
 r=document.getElementsByName("Rzt");rr="";for(i=0;i<r.length;i++){if(r[i].checked==true){rr=r[i].value;}}if(rr==""){alert("请选择审核状态！");return false;}
 layer.msg('正在提交', {icon: 16  ,time: 0,shade :0.25});
 f1.action="ad.php?control=update&must=<?=$_GET[must]?>&bh=<?=$row[bh]?>&sm=<?=urlencode($_GET[sm])?>";
 }
 </script>
 <form name="f1" method="post" onsubmit="return tj()" enctype="multipart/form-data">
 <ul class="uk">
 <li class="l1">广告编号：</li>
 <li class="l2"><input size="20" value="<?=$row[adbh]?>" class="inp redony" name="ts1" readonly="readonly" type="text"/></li>
 <li class="l1">广告说明：</li>
 <li class="l2"><input size="30" value="<?=$_GET[sm]?>" class="inp redony" name="ts2" readonly="readonly" type="text"/></li>
 <li class="l1">广告序号：</li>
 <li class="l2"><input name="txh" value="<?=$row[xh]?>" size="5" onfocus="inpf(this)" onblur="inpb(this)" class="inp" type="text" /></li>
 <li class="l1">类型选择：</li>
 <li class="l2">
 <? if($_GET[must]=="pic" || $_GET[must]==""){?>
 <label><input name="R1"<? if($row[type1]=="图片"){?> checked="checked"<? }?> onclick="lxsel('图片')" type="radio" value="图片" /> 图片</label>
 <? }?>
 <? if($_GET[must]=="code" || $_GET[must]==""){?>
 <label><input name="R1"<? if($row[type1]=="代码"){?> checked="checked"<? }?> type="radio" value="代码" onclick="lxsel('代码')" /> 代码</label> 
 <? }?>
 <? if($_GET[must]=="font" || $_GET[must]==""){?>
 <label><input name="R1"<? if($row[type1]=="文字"){?> checked="checked"<? }?> type="radio" value="文字" onclick="lxsel('文字')" /> 文字</label>
 <? }?>
 <? if($_GET[must]=="flash" || $_GET[must]==""){?>
 <label><input name="R1"<? if($row[type1]=="动画"){?> checked="checked"<? }?> type="radio" value="动画" onclick="lxsel('动画')" /> 动画</label>
 <? }?>
 </li>
 <li class="l1">广告标题：</li>
 <li class="l2"><input name="at1" value="<?=$row[tit]?>" size="40" onfocus="inpf(this)" onblur="inpb(this)" class="inp" type="text" /></li>
 <li class="l1">到期时间：</li>
 <li class="l2"><input class="inp" name="tdqsj" value="<?=$row[dqsj]?>" readonly="readonly" onclick="SelectDate(this,'yyyy-MM-dd hh:mm:ss')" size="20" type="text"/></li>
 </ul>

 <ul class="uk uk0" id="adtp" style="display:none;">
 <li class="l1">链接地址：</li>
 <li class="l2"><input name="t1" value="<?=$row[aurl]?>" size="40" onfocus="inpf(this)" onblur="inpb(this)" class="inp" type="text" /></li>
 <li class="l1"><strong class="red">广告主图：</strong></li>
 <li class="l2"><input type="file" name="inp1" id="inp1" size="15"> 最佳尺寸：<?=$ad[1]?></li>
 <li class="l8"></li>
 <li class="l9"><img src="../<?=returnjgdw($rowcontrol[addir],"","gg")?>/<?=$row[bh]?>.<?=$row[jpggif]?>?t=<?=rnd_num(100)?>" width="200" height="54" /></li>
 <li class="l1">广告副图：</li>
 <li class="l2"><input type="file" name="inp3" id="inp3" size="15"> 如果是拉屏广告，最佳高度是80</li>
 <li class="l8"></li>
 <li class="l9"><img src="../<?=returnjgdw($rowcontrol[addir],"","gg")?>/<?=$row[bh]?>-99.<?=$row[jpggif]?>?t=<?=rnd_num(100)?>" width="200" height="54" /></li>
 </ul>

 <ul class="uk uk0" id="adcode" style="display:none;">
 <li class="l4">代码：</li>
 <li class="l5"><textarea name="s1"><?=$row[txt]?></textarea></li>
 </ul>

 <ul class="uk uk0" id="adfont" style="display:none;">
 <li class="l1">链接地址：</li>
 <li class="l2"><input name="t3" value="<?=$row[aurl]?>" size="40" onfocus="inpf(this)" onblur="inpb(this)" class="inp" type="text" /></li>
 </ul>

 <ul class="uk uk0" id="adflash" style="display:none;">
 <li class="l1">选择动画：</li>
 <li class="l2"><input type="file" name="inp2" id="inp2" size="15"> </li>
 <li class="l1">宽高设置：</li>
 <li class="l2">宽：<input name="t2" value="<?=$row[aw]?>" size="10" onfocus="inpf(this)" onblur="inpb(this)" class="inp" type="text" /> 高：<input name="t4" value="<?=$row[ah]?>" onfocus="inpf(this)" onblur="inpb(this)" size="10" class="inp" type="text" /> </li>
 </ul>

 <ul class="uk uk0">
 <li class="l1">展示状态：</li>
 <li class="l2">
 <label><input name="Rzt" type="radio" value="0" <? if(0==$row[zt]){?>checked="checked"<? }?> /> <strong>正常展示</strong></label> 
 <label><input name="Rzt" type="radio" value="1" <? if(1==$row[zt]){?>checked="checked"<? }?> /> <strong>队列中</strong></label> 
 </li>
 <li class="l1">更新时间：</li>
 <li class="l2"><input class="inp" name="tsj" value="<?=$row[sj]?>" readonly="readonly" onclick="SelectDate(this,'yyyy-MM-dd hh:mm:ss')" size="20" type="text"/></li>
 <li class="l1">发布会员：</li>
 <li class="l2"><input class="inp redony" value="<?=returnuser($row[userid])?>" size="20" type="text"/><span class="fd">[<a href="user_ses.php?uid=<?=returnuser($row[userid])?>" target="_blank">进后台</a>]</span></li>
 <li class="l3"><input type="submit" value="发布广告" class="btn1" /></li>
 </ul>
 <input type="hidden" value="<?=$row[jpggif]?>" name="tptype" />
 </form>
 <script language="javascript">
 lxsel('<?=$row[type1]?>');
 </script>
 </div>
 <!--end-->
 
</div>
</div>
<?php include("bottom.php");?>
</body>
</html>