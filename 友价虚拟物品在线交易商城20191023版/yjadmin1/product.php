<?php
include("../config/conn.php");
include("../config/function.php");
AdminSes_audit();
$bh=$_GET[bh];
while0("*","yjcode_pro where bh='".$bh."'");if(!$row=mysql_fetch_array($res)){php_toheader("productlist.php");}

$timestamp=time();
while1("*","yjcode_admin where adminuid='".$_SESSION[SHOPADMIN]."'");$row1=mysql_fetch_array($res1);$adminpwd=$row1[adminpwd];

//函数开始
if($_GET[control]=="update"){
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0101,")){Audit_alert("权限不够","default.php");}
 zwzr();
 $myty=preg_split("/yjcode/",sqlzhuru($_POST[mty]));
 $txt=($_POST[content]);
 $tit=sqlzhuru($_POST[ttit]);
 $wkey=strgb2312(sqlzhuru($_POST[twkey]),0,240);
 $wdes=strgb2312(sqlzhuru($_POST[twdes]),0,240);
 $yhsj1=sqlzhuru($_POST[tyhsj1]);if(!empty($yhsj1)){$ses="yhsj1='".$yhsj1."',";}
 $yhsj2=sqlzhuru($_POST[tyhsj2]);if(!empty($yhsj2)){$ses=$ses."yhsj2='".$yhsj2."',";}
 $money3=sqlzhuru($_POST[tmoney3]);if(!is_numeric($money3)){$money3=0;}
 $kcnum=sqlzhuru($_POST[tkcnum]);if(!is_numeric($kcnum)){$kcnum=0;}
 $fhxs=intval(sqlzhuru($_POST[Rfhxs]));
 
 $tysx=sqlzhuru($_POST[tysx]);
 $tysxB=intval(sqlzhuru($_POST[tysxBnum]));
 for($i=1;$i<$tysxB;$i++){
  $tysxS=intval(sqlzhuru($_POST["tysxSnum".$i]));
  for($j=1;$j<=$tysxS;$j++){
  $zi=sqlzhuru($_POST["zi_".$i."_".$j]);
  if(!empty($zi)){
  $tysx=$tysx."xcf".$_POST["tysxty1_".$i].":".$zi;
  }
  }
 }
 
 $ifuserjd=intval($_POST[Rifuserdj]);
 if(1==$ifuserjd){
 deletetable("yjcode_prouserdj where probh='".$bh."'");
  for($i=1;$i<intval($_POST[djnum]);$i++){
  $zhekou=$_POST["zhekou_".$i];
  $djname=$_POST["name1_".$i];
  if(!empty($zhekou)){intotable("yjcode_prouserdj","probh,userid,djname,admin,zhi","'".$bh."',".$row[userid].",'".$djname."',1,".$zhekou."");}
  }
 }
 
 updatetable("yjcode_pro",$ses."
			 mybh='".sqlzhuru($_POST[tmybh])."',
			 lastsj='".sqlzhuru($_POST[tlastsj])."',
			 myty1id=".$myty[0].",
			 myty2id=".$myty[1].",
			 tysx='".$tysx."',
			 zt=".$_POST[Rzt].",
			 ztsm='".sqlzhuru($_POST[tztsm])."',
			 tit='".$tit."',
			 wkey='".$wkey."',
			 wdes='".$wdes."',
			 txt='".$txt."',
			 djl=".sqlzhuru($_POST[tdjl]).",
			 xsnum=".sqlzhuru($_POST[txsnum]).", 
			 kcnum=".$kcnum.", 
			 money1=".sqlzhuru($_POST[tmoney1]).", 
			 money2=".sqlzhuru($_POST[tmoney2]).",
			 money3=".$money3.",
			 yhxs=".sqlzhuru($_POST[Ryhxs]).",
			 yhsm='".sqlzhuru($_POST[tyhsm])."',
			 ifxj=".sqlzhuru($_POST[Rifxj]).",
			 iftuan=".sqlzhuru($_POST[Riftuan]).",
			 iftj=".sqlzhuru($_POST[tiftj]).",
			 fhxs=".$fhxs.",
			 wpurl='".sqlzhuru($_POST[twpurl])."',
			 wppwd='".sqlzhuru($_POST[twppwd])."',
			 wppwd1='".sqlzhuru($_POST[twppwd1])."',
			 upty=".intval($_POST[Rupty]).",
			 ysweb='".sqlzhuru($_POST[tysweb])."',
			 ifuserdj=".$ifuserjd.",
			 txtmb='".sqlzhuru($_POST[ttxtmb])."',
			 zl=".sqlzhuru($_POST[tzl]).",
			 downurl='".sqlzhuru($_POST[tdownurl])."'
			 where bh='".$bh."'");
 uploadtp($bh,"商品",$row[userid]);
 //上传B
 if(3==$fhxs){
  $up1=$_FILES["inp1"]["name"];
  if(!empty($up1)){
   $userid=$row[userid];
   $mc=MakePassAll(15)."-".time()."-".$userid.".".returnhz($up1);
   $lj="../upload/".$userid."/".$bh."/";
   move_uploaded_file($_FILES["inp1"]['tmp_name'],$lj.$mc);
   
   if(intval($_POST[Rupty])==0){
    delFile($lj.$row[upf]);
   }elseif(intval($_POST[Rupty])==1){
    include('../config/alioss/Common.php');
    $bucket = Common::getBucketName();
    $ossClient = Common::getOssClient();
    if(!is_null($ossClient)){;
	$ossClient->setTimeout(3600);
	$ossClient->setConnectTimeout(3600);
    $ossClient->createObjectDir($bucket, "upload/".$userid."/".$bh."/");
    $ossClient->uploadFile($bucket,"upload/".$userid."/".$bh."/".$mc,$lj.$mc);
	delFile($lj.$mc);
	$alioss=preg_split("/,/",$rowcontrol[alioss]);
	$mc="https://".$alioss[3].".".$alioss[2]."/"."upload/".$userid."/".$bh."/".$mc;
	}
   }
  
  updatetable("yjcode_pro","upf='".$mc."' where bh='".$bh."' and userid=".$userid);
  }
 }
 //上传E
 //卡密B
 if(4==$fhxs){
 $c=str_replace("\r","",($_POST[s1]));
 $d=preg_split("/\n/",$c);
 for($i=0;$i<=count($d);$i++){
  if(!empty($d[$i])){
   $e=preg_split("/\s/",$d[$i]);
     if(panduan("probh,userid,ka","yjcode_kc where probh='".$bh."' and ka='".$e[0]."' and userid=".$row[userid])==0){
     $mi="";
	 if(count($e)>=2){for($ei=1;$ei<count($e);$ei++){$mi=$mi." ".$e[$ei];}}
	 intotable("yjcode_kc","probh,userid,ka,mi,ifok","'".$bh."',".$row[userid].",'".$e[0]."','".$mi."',0");
	 }
  }
 }
 kamikc($bh);
 }
 //卡密E
 
 php_toheader("product.php?t=suc&bh=".$bh);

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
<link href="css/product.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script language="javascript" src="js/basic.js"></script>
<script language="javascript" src="js/layer.js"></script>
<script language="javascript">
function tj(){
if((document.f1.ttit.value).replace(/\s/,"")==""){alert("请输入标题");document.f1.ttit.focus();return false;}
a=document.f1.tkcnum.value;if(a.replace("/\s/","")=="" || isNaN(a)){alert("请输入有效的库存");document.f1.tkcnum.focus();return false;}
a=document.f1.tmoney1.value;if(a.replace("/\s/","")=="" || isNaN(a)){alert("请输入有效的价格");document.f1.tmoney1.focus();return false;}
a=document.f1.tmoney2.value;if(a.replace("/\s/","")=="" || isNaN(a)){alert("请输入有效的价格");document.f1.tmoney2.focus();return false;}
a=document.f1.tdjl.value;if(a.replace("/\s/","")=="" || isNaN(a)){alert("请输入有效的点击率");document.f1.tdjl.focus();return false;}
a=document.f1.txsnum.value;if(a.replace("/\s/","")=="" || isNaN(a)){alert("请输入有效的销量量");document.f1.txsnum.focus();return false;}
r=document.getElementsByName("Rfhxs");rr="";for(i=0;i<r.length;i++){if(r[i].checked==true){rr=r[i].value;}}if(rr==""){alert("请选择发货形式！");return false;}
r=document.getElementsByName("Rzt");rr="";for(i=0;i<r.length;i++){if(r[i].checked==true){rr=r[i].value;}}if(rr==""){alert("请选择审核状态！");return false;}
cstr="xcf";
c=document.getElementsByName("Csx");
for(i=0;i<c.length;i++){if(c[i].checked==true){cstr=cstr+c[i].value+"xcf";}}
document.f1.tysx.value=cstr;
layer.msg('正在提交', {icon: 16  ,time: 0,shade :0.25});
f1.action="product.php?bh=<?=$bh?>&control=update";
}

function yhxsonc(x){
if(1==x){document.getElementById("yhxsul").style.display="none";}	
else if(2==x){document.getElementById("yhxsul").style.display="";}	
}

function fhxsonc(x){
for(i=1;i<=5;i++){
d=document.getElementById("fhxs"+i);if(d){d.style.display="none";}
}
d=document.getElementById("fhxs"+x);if(d){d.style.display="";}
}

function djonc(x){
if(0==x){document.getElementById("djv").style.display="none";}else{document.getElementById("djv").style.display="";}
}

function ztonc(x){
if(2==x){document.getElementById("proztv").style.display="";}else{document.getElementById("proztv").style.display="none";}
}
function ysareaonc(){
 layer.open({
  type: 2,
  shadeClose: true,
  area: ['600px', '505px'],
  title:["销售区域设置","text-align:left"],
  skin: 'layui-layer-rim', //加上边框
  content:['ysarea.php?bh=<?=$bh?>', 'no'] 
 });
}

function tzxh(){
 layer.open({
  type: 2,
  shadeClose: true,
  area: ['610px', '345px'],
  title:["图片排序","text-align:left"],
  skin: 'layui-layer-rim', //加上边框
  content:['tpxh.php?bh=<?=$bh?>', 'no'] 
 });
}

function videoonc(){
 layer.open({
  type: 2,
  shadeClose: false,
  area: ['901px', '550px'],
  title:["视频管理","text-align:left"],
  skin: 'layui-layer-rim', //加上边框
  content:['provideolist.php?bh=<?=$bh?>', 'no'] 
 });
}


</script>
<script type="text/javascript" src="js/adddate.js" ></script> 

<script type="text/javascript" charset="gbk" src="../config/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="gbk" src="../config/ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="gbk" src="../config/ueditor/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript" charset="gbk" src="../config/ueditor/unit.js"></script>

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

 <? if($_GET[t]=="suc"){systs("恭喜您，操作成功！[<a href='productlx.php'>继续添加新商品</a>]","product.php?bh=".$bh);}?>
 <? include("rightcap4.php");?>
 <script language="javascript">document.getElementById("rtit1").className="a1";</script>

 <!--B-->
 <div class="rkuang">
 <form name="f1" method="post" onsubmit="return tj()" enctype="multipart/form-data">
 <ul class="rcap"><li class="l1"></li><li class="l2">必填项目</li><li class="l3"></li></ul>
 <ul class="uk">
 <li class="l1"><span class="red">*</span> 所在分组：</li>
 <li class="l21"><strong><?=returntype(1,$row[ty1id])." - ".returntype(2,$row[ty2id])." - ".returntype(3,$row[ty3id])." - ".returntype(4,$row[ty4id])." - ".returntype(5,$row[ty5id])?></strong> [<a href="productlx.php?action=update&id=<?=$row[id]?>">修改</a>]</li>
 <li class="l1">自定义分组：</li>
 <li class="l2">
 <select name="mty" class="inp">
 <option value="0yjcode0">选择分组</option>
 <? while1("*","yjcode_protype where admin=1 and zt=0 and userid=".$row[userid]);while($row1=mysql_fetch_array($res1)){?>
 <option value="<?=$row1[id]?>yjcode0"<? if($row1[id]==$row[myty1id] && $row[myty2id]==0){?> selected="selected"<? }?> style="background-color:#EFEFEF;color:#333;"><?=$row1[name1]?></option>
 <? while2("*","yjcode_protype where admin=2 and name1='".$row1[name1]."' and zt=0 and userid=".$row[userid]);while($row2=mysql_fetch_array($res2)){?>
 <option value="<?=$row1[id]?>yjcode<?=$row2[id]?>"<? if($row1[id]==$row[myty1id] && $row2[id]==$row[myty2id]){?> selected="selected"<? }?>> - <?=$row2[name2]?></option>
 <? }?>
 <? }?>
 </select>
 </li>
 <li class="l1"><span class="red">*</span> 标题：</li>
 <li class="l2"><input type="text" size="80" value="<?=$row[tit]?>" class="inp" name="ttit" /></li>
 <li class="l1"><span class="red">*</span> 优惠形式：</li>
 <li class="l2">
 <label><input name="Ryhxs" type="radio" value="1" onclick="yhxsonc(1)" <? if(1==$row[yhxs]){?>checked="checked"<? }?> /> 长期优惠</label>
 <label><input name="Ryhxs" type="radio" value="2" onclick="yhxsonc(2)" <? if(2==$row[yhxs]){?>checked="checked"<? }?> /> 限时优惠</label>
 </li>
 <li class="l1"><span class="red">*</span> 优惠价：</li>
 <li class="l2">
 <input class="inp" name="tmoney2" value="<?=$row[money2]?>" size="10" type="text"/>
 <span class="fd red">提示：如果设置了套餐，优惠价建议填写套餐中最低的价格</span>
 </li>
 <li class="l1"><span class="red">*</span> 原价：</li>
 <li class="l2"><input class="inp" name="tmoney1" value="<?=$row[money1]?>" size="10" type="text"/></li>
 </ul>
 
 <ul class="uk uk0" id="yhxsul" style="display:none;">
 <li class="l1"><span class="red">*</span> 限时优惠价：</li>
 <li class="l2"><input class="inp" name="tmoney3" value="<?=$row[money3]?>" size="10" type="text"/></li>
 <li class="l1"><span class="red">*</span> 限时优惠说明：</li>
 <li class="l2"><input type="text" size="80" value="<?=$row[yhsm]?>" class="inp" name="tyhsm" /></li>
 <li class="l1"><span class="red">*</span> 优惠时间：</li>
 <li class="l2">
 <input class="inp" name="tyhsj1" value="<?=returnjgdw(isDate($row[yhsj1]),"","")?>" readonly="readonly" onclick="SelectDate(this,'yyyy-MM-dd hh:mm:ss')" size="20" type="text"/> 
 <span class="fd" style="margin-right:10px;">到</span> 
 <input class="inp" name="tyhsj2" value="<?=returnjgdw(isDate($row[yhsj2]),"","")?>" readonly="readonly" onclick="SelectDate(this,'yyyy-MM-dd hh:mm:ss')" size="20" type="text"/>
 </li>
 </ul>
 
 
 <ul class="uk uk0">
 <li class="l1"><span class="red">*</span> 发货形式：</li>
 <li class="l2">
 <? if(strstr($rowcontrol[fhxs],"1") || empty($rowcontrol[fhxs])){?>
 <label><input name="Rfhxs" type="radio" value="1" onclick="fhxsonc(1)" <? if(1==$row[fhxs]){?>checked="checked"<? }?> /> 手动发货</label>
 <? }?>
 <? if(strstr($rowcontrol[fhxs],"2") || empty($rowcontrol[fhxs])){?>
 <label><input name="Rfhxs" type="radio" value="2" onclick="fhxsonc(2)" <? if(2==$row[fhxs]){?>checked="checked"<? }?> /> 网盘下载</label>
 <? }?>
 <? if(strstr($rowcontrol[fhxs],"3") || empty($rowcontrol[fhxs])){?>
 <label><input name="Rfhxs" type="radio" value="3" onclick="fhxsonc(3)" <? if(3==$row[fhxs]){?>checked="checked"<? }?> /> 网站直接下载</label>
 <? }?>
 <? if(strstr($rowcontrol[fhxs],"4") || empty($rowcontrol[fhxs])){?>
 <label><input name="Rfhxs" type="radio" value="4" onclick="fhxsonc(4)" <? if(4==$row[fhxs]){?>checked="checked"<? }?> /> 点卡交易</label>
 <? }?>
 <? if(strstr($rowcontrol[fhxs],"5") || empty($rowcontrol[fhxs])){?>
 <label><input name="Rfhxs" type="radio" value="5" onclick="fhxsonc(5)" <? if(5==$row[fhxs]){?>checked="checked"<? }?> /> 实物快递</label>
 <? }?>
 </li>
 <li class="l1"><span class="red">*</span> 库存量：</li>
 <li class="l2"><input class="inp" name="tkcnum" value="<?=$row[kcnum]?>" size="10" type="text"/><span class="fd">(如果是点卡交易类，库存值无需填写，将自动读取)</span></li>
 </ul> 
 <ul class="uk uk0" id="fhxs2" style="display:none;">
 <li class="l1">网盘地址：</li>
 <li class="l2"><input class="inp" name="twpurl" value="<?=$row[wpurl]?>" size="80" type="text"/></li>
 <li class="l1">网盘密码：</li>
 <li class="l2"><input class="inp" name="twppwd" value="<?=$row[wppwd]?>" size="20" type="text"/></li>
 <li class="l1">解压密码：</li>
 <li class="l2"><input class="inp" name="twppwd1" value="<?=$row[wppwd1]?>" size="20" type="text"/></li>
 </ul>
 
 <? if(check_in("a1a",$rowcontrol[aliosskg])){$a=1;}else{$a=0;}?>
 <input type="hidden" value="<?=$a?>" name="Rupty" />
 <ul class="uk uk0" id="fhxs3" style="display:none;">
 <li class="l1">上传提示：</li>
 <li class="l21">文件最大支持<?=ini_get('upload_max_filesize')?></li>
 <li class="l1">上传文件：</li>
 <li class="l2"><input type="file" name="inp1" id="inp1" class="inp1" size="25"></li>
 <? 
 if(!empty($row[upf])){
 if(empty($row[upty])){$u=weburl."upload/".$row[userid]."/".$row[bh]."/".$row[upf];}else{$u=$row[upf];}
 ?>
 <li class="l1">文件预览：</li>
 <li class="l21">【<a href="<?=$u?>" class="blue" target="_blank">点击预览</a>】</li>
 <? }?>
 </ul>
 
 <ul class="uk uk0" id="fhxs4" style="display:none;">
 <li class="l1">下载地址：</li>
 <li class="l2"><input class="inp" name="tdownurl" value="<?=$row[downurl]?>" size="80" type="text"/><span class="fd">可留空</span></li>
 <li class="l1">库存：</li>
 <li class="l21"><strong class="red"><?=$row[kcnum]?>件</strong> [<a href="kclist.php?bh=<?=$bh?>" target="_blank" class="blue">管理库存</a>]</li>
 <li class="l1">说明：</li>
 <li class="l21 red">导入格式为卡号+空格+密码(可跟上附加内容)，一行一组，如AAAAA BBBBB</li>
 <li class="l4">添加卡密：</li>
 <li class="l5"><textarea name="s1"></textarea></li>
 </ul>
 <ul class="uk uk0" id="fhxs5" style="display:none;">
 <li class="l1">重量：</li>
 <li class="l2"><input class="inp" name="tzl" value="<?=sprintf("%.2f",$row[zl])?>" size="10" type="text"/><span class="fd">KG</span></li>
 </ul>
 
 <!--效果图/详情B-->
 <ul class="rcap"><li class="l1"></li><li class="l2">效果图/详情</li><li class="l3"></li></ul>
 <ul class="uk">
 <li class="l1">效果图：</li>
 <li class="l2">
 <iframe style="float:left;" src="tpupload.php?admin=1&bh=<?=$bh?>" width="150" scrolling="no" height="33" frameborder="0"></iframe>
 <span class="fd">可最多上传7张效果图 【<a href="javascript:void(0);" onclick="tzxh()" class="blue">调整图片顺序</a>】</span>
 </li>
 </ul>
 <div class="xgtp">
  <div id="xgtp1" style="display:none;">正在处理</div>
  <div id="xgtp2"></div>
 </div>
 <ul class="uk uk0">
 <li class="l10"><span class="red">*</span> 详细描述：</li>
 <li class="l11"><script id="editor" name="content" type="text/plain" style="width:858px;height:330px;"><?=$row[txt]?></script></li>
 </ul>
 <!--效果图/详情E-->
 
 <ul class="rcap" style="margin-bottom:10px;"><li class="l1"></li><li class="l2">选填项目</li><li class="l3"></li></ul>
 <input type="hidden" value="<?=$row[tysx]?>" name="tysx" />
 <? $i=1;while1("*","yjcode_typesx where admin=1 and typeid=".$row[ty1id]." order by xh asc");while($row1=mysql_fetch_array($res1)){?>
 <input type="hidden" value="<?=$row1[id]?>" name="tysxty1_<?=$i?>" />
 <ul class="uk1 uk0">
 <li class="l1"><?=$row1[name1]?>：</li>
 <li class="l2">
 <? $j=1;while2("*","yjcode_typesx where admin=2 and name1='".$row1[name1]."' and typeid=".$row1[typeid]." order by xh asc");while($row2=mysql_fetch_array($res2)){?>
 <label><input name="Csx" type="checkbox" value="<?=$row2[id]?>"<? if(strstr($row[tysx],"xcf".$row2[id]."xcf")){?>checked="checked"<? }?> /> <?=$row2[name2]?></label>
 <? $j++;}?>
 <? 
 if(!empty($row1[ifzi])){
 $v="";
 $a1=preg_split("/xcf".$row1[id].":/",$row[tysx]);
 if(count($a1)>1){$b1=preg_split("/xcf/",$a1[1]);$v=$b1[0];}
 ?>
 <input type="text" name="zi_<?=$i?>_<?=$j?>" size="10" value="<?=$v?>" class="inp" />
 <? }?>
 <input type="hidden" value="<?=$j?>" name="tysxSnum<?=$i?>" />
 </li>
 </ul>
 <? $i++;}?>
 <input type="hidden" value="<?=$i?>" name="tysxBnum" />
 <ul class="uk">
 <li class="l1"><span class="red">*</span> 启用会员等级：</li>
 <li class="l2">
 <label><input name="Rifuserdj" type="radio" value="0" onclick="djonc(0)" <? if(empty($row[ifuserdj])){?>checked="checked"<? }?> /> 不启用</label> 
 <label><input name="Rifuserdj" type="radio" value="1" onclick="djonc(1)" <? if(1==$row[ifuserdj]){?>checked="checked"<? }?> /> 启用</label> 
 </li>
 </ul>
 <div id="djv" style="display:none;">
 <ul class="dju1">
 <li class="l1">会员等级</li>
 <li class="l2">享受折扣(10表示无折扣，9表示9折)</li>
 </ul>
 <? 
 $j=1;while1("*","yjcode_userdj where zt=0 order by xh asc");while($row1=mysql_fetch_array($res1)){
 while2("*","yjcode_prouserdj where probh='".$bh."' and djname='".$row1[name1]."'");if($row2=mysql_fetch_array($res2)){$zhekou=$row2[zhi];}else{$zhekou=$row1[zhekou];}
 ?>
 <ul class="dju2">
 <li class="l1"><input type="text" readonly="readonly" name="name1_<?=$j?>" value="<?=$row1[name1]?>" /></li>
 <li class="l2"><input type="text" name="zhekou_<?=$j?>" value="<?=$zhekou?>" /></li>
 </ul>
 <? $j++;}?>
 <input type="hidden" value="<?=$j?>" name="djnum" />
 </div>
 <ul class="uk uk0">
 <li class="l1">设置套餐：</li>
 <li class="l21">【<strong><a href="taocanlist.php?bh=<?=$row[bh]?>" target="_blank" class="blue">进入套餐编辑</a></strong>】</li>
 <li class="l1">销售区域：</li>
 <li class="l21">【<a href="javascript:void(0);" onclick="ysareaonc()">编辑允许区域列表</a>】</li>
 <li class="l1">展示网址：</li>
 <li class="l2"><input type="text" size="80" value="<?=$row[ysweb]?>" class="inp" name="tysweb" /></li>
 <li class="l1">展示模板：</li>
 <li class="l2">
 <select name="ttxtmb" class="inp">
 <option value="">默认模板</option>
 <? while1("*","yjcode_txtmb where admin=1 order by mbid asc");while($row1=mysql_fetch_array($res1)){?>
 <option value="<?=$row1[mbid]?>"<? if($row1[mbid]==$row[txtmb]){?> selected="selected"<? }?>><?=$row1[tit]?>(<?=$row1[txt]?>)</option>
 <? }?>
 </select>
 </li>
 <li class="l1">商品关键词：</li>
 <li class="l2"><input  name="twkey" value="<?=$row[wkey]?>" size="60" type="text" class="inp" onfocus="inpf(this)" onblur="inpb(this)" /></li>
 <li class="l4">商品描述：</li>
 <li class="l5"><textarea name="twdes"><?=$row[wdes]?></textarea></li>
 <li class="l1">自定义编码：</li>
 <li class="l2"><input type="text" size="10" value="<?=$row[mybh]?>" class="inp" name="tmybh" /></li>
 <li class="l1">上架/下架：</li>
 <li class="l2">
 <label><input name="Rifxj" type="radio" value="0" <? if(0==$row[ifxj]){?>checked="checked"<? }?> /> 上架</label>
 <label><input name="Rifxj" type="radio" value="1" <? if(1==$row[ifxj]){?>checked="checked"<? }?> /> 下架</label>
 </li>
 </ul>

 <ul class="rcap"><li class="l1"></li><li class="l2">管理员操作</li><li class="l3"></li></ul>
 <ul class="uk">
 <li class="l1">更新时间：</li>
 <li class="l2"><input class="inp" name="tlastsj" value="<?=$row[lastsj]?>" size="20" type="text"/><span class="fd">正确的时间格式如：2012-12-12 12:12:12</span></li>
 <li class="l1">点击率：</li>
 <li class="l2"><input class="inp" name="tdjl" value="<?=$row[djl]?>" size="10" type="text"/></li>
 <li class="l1">销售量：</li>
 <li class="l2"><input class="inp" name="txsnum" value="<?=$row[xsnum]?>" size="10" type="text"/></li>
 <li class="l1">推荐序号：</li>
 <li class="l2"><input class="inp" name="tiftj" value="<?=$row[iftj]?>" size="10" type="text"/><span class="fd">默认0表示不推荐，大于0则按从小到大显示排序</span></li>
 <li class="l1">首页团购：</li>
 <li class="l2">
 <label><input name="Riftuan" type="radio" value="0" <? if(empty($row[iftuan])){?>checked="checked"<? }?> /> <strong>否</strong></label>
 <label><input name="Riftuan" type="radio" value="1" <? if(1==$row[iftuan]){?>checked="checked"<? }?> /> <strong>是</strong></label>
 </li>
 <li class="l1">审核状态：</li>
 <li class="l2">
 <label><input name="Rzt" type="radio" value="0" onclick="ztonc(0)" <? if(0==$row[zt]){?>checked="checked"<? }?> /> <strong>正常展示</strong></label> 
 <label><input name="Rzt" type="radio" value="1" onclick="ztonc(1)" <? if(1==$row[zt]){?>checked="checked"<? }?> /> <strong>正在审核</strong></label> 
 <label><input name="Rzt" type="radio" value="2" onclick="ztonc(2)" <? if(2==$row[zt]){?>checked="checked"<? }?> /> <strong>审核不通过</strong></label> 
 </li>
 </ul>
 
 <ul class="uk uk0" id="proztv" style="display:none;">
 <li class="l1">被拒原因：</li>
 <li class="l2"><input type="text" class="inp" name="tztsm" size="90" value="<?=$row[ztsm]?>" /></li>
 </ul>
 
 <ul class="uk uk0">
 <li class="l1">发布会员：</li>
 <li class="l2"><input class="inp redony" readonly="readonly" value="<?=returnuser($row[userid])?>" size="20" type="text"/><span class="fd">[<a href="user_ses.php?uid=<?=returnuser($row[userid])?>" target="_blank">进后台</a>]</span></li>
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
yhxsonc(<?=$row[yhxs]?>);
fhxsonc(<?=$row[fhxs]?>);
djonc(<?=returnjgdw($row[ifuserdj],"",0)?>);
var ue = UE.getEditor('editor');
ztonc(<?=$row[zt]?>);

function xgtread(x){
 $.get("tpread.php",{bh:x},function(result){
  $("#xgtp2").html(result);
 });
}
function deltp(x){
 document.getElementById("xgtp1").style.display="";
 $.get("tpdel.php",{id:x},function(result){
  xgtread("<?=$bh?>");
  document.getElementById("xgtp1").style.display="none";
 });
}
xgtread("<?=$bh?>");

</script>
</body>
</html>