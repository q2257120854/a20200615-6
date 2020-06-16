<?
include("../../config/conn.php");
include("../../config/function.php");
sesCheck_m();
$sqluser="select * from yjcode_user where uid='".$_SESSION[SHOPUSER]."' and shopzt=2";mysql_query("SET NAMES 'GBK'");$resuser=mysql_query($sqluser);
if(!$rowuser=mysql_fetch_array($resuser)){php_toheader("openshop3.php");}

$userid=$rowuser[id];
$bh=sqlzhuru($_GET[bh]);
while0("*","yjcode_pro where bh='".$bh."' and userid=".$userid);if(!$row=mysql_fetch_array($res)){php_toheader("productlist.php");}

//函数开始
if($_GET[control]=="update"){
 zwzr();
 $sj=date("Y-m-d H:i:s");
 $myty=preg_split("/yjcode/",sqlzhuru($_POST[mty]));
 $txt=sqlzhuru1($_POST[content]);
 $tit=sqlzhuru($_POST[ttit]);
 $wkey=strgb2312(sqlzhuru($_POST[twkey]),0,240);
 $wdes=strgb2312(sqlzhuru($_POST[twdes]),0,240);
 $yhsj1=sqlzhuru($_POST[tyhsj1]);if(!empty($yhsj1)){$ses="yhsj1='".$yhsj1."',";}
 $yhsj2=sqlzhuru($_POST[tyhsj2]);if(!empty($yhsj1)){$ses=$ses."yhsj2='".$yhsj2."',";}
 $money1=sqlzhuru($_POST[tmoney1]);
 $money2=sqlzhuru($_POST[tmoney2]);
 $money3=sqlzhuru($_POST[tmoney3]);if(!is_numeric($money3)){$money3=0;}
 $kcnum=sqlzhuru($_POST[tkcnum]);if(!is_numeric($kcnum)){$kcnum=0;}
 if($money1<0 || $money2<0 || $money3<0){Audit_alert("价格不能为负数！","productlist.php");}
 $fhxs=intval(sqlzhuru($_POST[Rfhxs]));
 if($rowcontrol[ifproduct]=="on"){$nzt=0;}else{$nzt=1;}
 
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
			 myty1id=".$myty[0].",
			 myty2id=".$myty[1].",
			 tysx='".$tysx."',
			 zt=".$nzt.",
			 tit='".$tit."',
			 wkey='".$wkey."',
			 wdes='".$wdes."',
			 kcnum=".$kcnum.", 
			 money1=".$money1.", 
			 money2=".$money2.",
			 money3=".$money3.",
			 yhxs=".sqlzhuru($_POST[Ryhxs]).",
			 yhsm='".sqlzhuru($_POST[tyhsm])."',
			 fhxs=".$fhxs.",
			 wpurl='".sqlzhuru($_POST[twpurl])."',
			 wppwd='".sqlzhuru($_POST[twppwd])."',
			 wppwd1='".sqlzhuru($_POST[twppwd1])."',
			 upty=".intval($_POST[Rupty]).",
			 ysweb='".sqlzhuru($_POST[tysweb])."',
			 ifuserdj=".$ifuserjd.",
			 zl=".sqlzhuru($_POST[tzl]).",
			 downurl='".sqlzhuru($_POST[tdownurl])."'
			 where bh='".$bh."' and userid=".$userid);
 //上传B
 if(3==$fhxs){
  $up1=$_FILES["inp1"]["name"];
  if(!empty($up1)){
   $mc=MakePassAll(15)."-".time()."-".$userid.".".returnhz($up1);
   $lj="../../upload/".$userid."/".$bh."/";
   move_uploaded_file($_FILES["inp1"]['tmp_name'],$lj.$mc);
   
   if(intval($_POST[Rupty])==0){
    delFile($lj.$row[upf]);
   }elseif(intval($_POST[Rupty])==1){
    include('../../config/alioss/Common.php');
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
     if(panduan("probh,userid,ka","yjcode_kc where probh='".$bh."' and ka='".$e[0]."' and userid=".$userid)==0){
     $mi="";
	 if(count($e)>=2){for($ei=1;$ei<count($e);$ei++){$mi=$mi." ".$e[$ei];}}
	 intotable("yjcode_kc","probh,userid,ka,mi,ifok","'".$bh."',".$userid.",'".$e[0]."','".$mi."',0");
	 }
  }
 }
 kamikc($bh);
 }
 //卡密E
 
 php_toheader("product1.php?bh=".$bh);

}
//函数结果

$ijia=1;
?>
<html>
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
<title>会员中心 <?=webname?></title>
<? include("../tem/cssjs.html");?>
<link href="css/sell.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js" ></script> 

<script language="javascript">
function tj(){
if((document.f1.ttit.value).replace(/\s/,"")==""){layerts("请输入标题");return false;}
a=document.f1.tkcnum.value;if(a.replace("/\s/","")=="" || isNaN(a)){layerts("请输入有效的库存");return false;}
a=document.f1.tmoney1.value;if(a.replace("/\s/","")=="" || isNaN(a)){layerts("请输入有效的价格");return false;}
a=document.f1.tmoney2.value;if(a.replace("/\s/","")=="" || isNaN(a)){layerts("请输入有效的价格");return false;}
if(document.f1.Rfhxs.value==""){layerts("请选择发货形式！");return false;}
cstr="xcf";
c=document.getElementsByName("Csx");
for(i=0;i<c.length;i++){if(c[i].checked==true){cstr=cstr+c[i].value+"xcf";}}
document.f1.tysx.value=cstr;
layer.open({type: 2,content: '正在提交',shadeClose:false});
f1.action="product.php?bh=<?=$bh?>&control=update";
}

function yhxsonc(){
x=document.f1.Ryhxs.value;
if(1==x){document.getElementById("yhxsul").style.display="none";}	
else if(2==x){document.getElementById("yhxsul").style.display="";}	
}

function fhxsonc(){
x=document.f1.Rfhxs.value;
for(i=1;i<=5;i++){
d=document.getElementById("fhxs"+i);if(d){d.style.display="none";}
}
d=document.getElementById("fhxs"+x);if(d){d.style.display="";}
if(x==4){document.getElementById("kcuk").style.display="none";}else{document.getElementById("kcuk").style.display="";}
}

function djonc(){
x=document.f1.Rifuserdj.value;
if(0==x){document.getElementById("djv").style.display="none";}else{document.getElementById("djv").style.display="";}
}

function yjkscha(){
m2=document.f1.tmoney2.value;
yjk=document.f1.yjks.value;
if(isNaN(m2) || yjk==""){yj=m2;}else{yj=accMul(m2,yjk);}
document.f1.tmoney1.value=yj;
}

</script>
</head>
<body>
<? include("topuser.php");?>

<div class="bfbtop2 box">
 <div class="d1" onClick="gourl('productlist.php')"><img src="img/topleft1.png" height="21" /></div>
 <div class="d2">商品编辑</div>
 <div class="d3"></div>
</div>

<!--开始-->
<form name="f1" method="post" onSubmit="return tj()" enctype="multipart/form-data">
<div class="uk box">
 <div class="d1">商品分组<span class="s1"></span></div>
 <div class="d2"><?=returntype(1,$row[ty1id])." - ".returntype(2,$row[ty2id])." - ".returntype(3,$row[ty3id])." - ".returntype(4,$row[ty4id])." - ".returntype(5,$row[ty5id])?></div>
 <div class="d3" onClick="gourl('productlx.php?action=update&id=<?=$row[id]?>')"><img src="../img/rightjian.png" height="13" /></div>
</div>

<div class="uk box">
 <div class="d1">店内分组<span class="s1"></span></div>
 <div class="d2">
 <select name="mty" style="font-size:13px;">
 <option value="0yjcode0">选择分组</option>
 <? while1("*","yjcode_protype where admin=1 and zt=0 and userid=".$rowuser[id]);while($row1=mysql_fetch_array($res1)){?>
 <option value="<?=$row1[id]?>yjcode0"<? if($row1[id]==$row[myty1id] && $row[myty2id]==0){?> selected="selected"<? }?> style="background-color:#EFEFEF;color:#333;"><?=$row1[name1]?></option>
 <? while2("*","yjcode_protype where admin=2 and name1='".$row1[name1]."' and zt=0 and userid=".$rowuser[id]);while($row2=mysql_fetch_array($res2)){?>
 <option value="<?=$row1[id]?>yjcode<?=$row2[id]?>"<? if($row1[id]==$row[myty1id] && $row2[id]==$row[myty2id]){?> selected="selected"<? }?>> - <?=$row2[name2]?></option>
 <? }?>
 <? }?>
 </select>
 </div>
 <div class="d3"><img src="../img/rightjian.png" height="13" /></div>
</div>

<div class="uk box">
 <div class="d1">标 题<span class="s1"></span></div>
 <div class="d2"><input type="text" class="inp" placeholder="请输入标题" name="ttit" value="<?=$row[tit]?>" /></div>
</div>

<div class="uk box">
 <div class="d1">优惠形式<span class="s1"></span></div>
 <div class="d2">
 <select name="Ryhxs" onChange="yhxsonc()" style="font-size:13px;">
 <option value="1" <? if(1==$row[yhxs]){?> selected="selected"<? }?>>长期优惠</option>
 <option value="2" <? if(2==$row[yhxs]){?> selected="selected"<? }?>>限时优惠</option>
 </select>
 </div>
 <div class="d3"><img src="../img/rightjian.png" height="13" /></div>
</div>

<div class="uk box">
 <div class="d1">当前售价<span class="s1"></span></div>
 <div class="d2"><input type="text" class="inp" placeholder="请输入当前售价" name="tmoney2" value="<?=$row[money2]?>" /></div>
 <div class="d31">元</div>
</div>

<div class="uk box">
 <div class="d1">快捷设置<span class="s1"></span></div>
 <div class="d2">
 <select name="yjks" style="font-size:13px;" onChange="yjkscha()">
 <option value="">快捷设置</option>
 <? for($i=1;$i<10;$i++){?>
 <option value="1.<?=$i?>">X1.<?=$i?>(相当于当前售价为<?=10-$i?>折优惠)</option>
 <? }?>
 </select>
 </div>
 <div class="d3"><img src="../img/rightjian.png" height="13" /></div>
</div>
<div class="uk box">
 <div class="d1">原 价<span class="s1"></span></div>
 <div class="d2"><input type="text" class="inp" placeholder="请输入当前售价" name="tmoney1" value="<?=$row[money1]?>" /></div>
 <div class="d31">元</div>
</div>

<div id="yhxsul" style="display:none;">
<div class="uk box">
 <div class="d1">限时优惠<span class="s1"></span></div>
 <div class="d2"><input type="text" class="inp" placeholder="请输入限时优惠价" name="tmoney3" value="<?=$row[money3]?>" /></div>
 <div class="d31">元</div>
</div>
<div class="uk box">
 <div class="d1">优惠说明<span class="s1"></span></div>
 <div class="d2"><input type="text" class="inp" placeholder="请输入优惠说明" name="tyhsm" value="<?=$row[yhsm]?>" /></div>
</div>
<div class="uk box">
 <div class="d1">优惠开始<span class="s1"></span></div>
 <div class="d2"><input class="inp" name="tyhsj1" placeholder="请设置优惠开始时间" value="<?=returnjgdw(isDate($row[yhsj1]),"","")?>" readonly onClick="SelectDate(this,'yyyy-MM-dd hh:mm:ss')" type="text"/></div>
</div>
<div class="uk box">
 <div class="d1">优惠截止<span class="s1"></span></div>
 <div class="d2"><input class="inp" name="tyhsj2" placeholder="请设置优惠截止时间" value="<?=returnjgdw(isDate($row[yhsj2]),"","")?>" readonly onClick="SelectDate(this,'yyyy-MM-dd hh:mm:ss')" type="text"/></div>
</div>
</div>

<div class="uk box">
 <div class="d1">发货形式<span class="s1"></span></div>
 <div class="d2">
 <select name="Rfhxs" onChange="fhxsonc()" style="font-size:13px;">
 <? if(strstr($rowcontrol[fhxs],"1") || empty($rowcontrol[fhxs])){?>
 <option value="1" <? if(1==$row[fhxs]){?> selected<? }?>>手动发货</option>
 <? }?>
 <? if(strstr($rowcontrol[fhxs],"2") || empty($rowcontrol[fhxs])){?>
 <option value="2" <? if(2==$row[fhxs]){?> selected<? }?>>网盘下载</option>
 <? }?>
 <? if(strstr($rowcontrol[fhxs],"3") || empty($rowcontrol[fhxs])){?>
 <option value="3" <? if(3==$row[fhxs]){?> selected<? }?>>网站直接下载</option>
 <? }?>
 <? if(strstr($rowcontrol[fhxs],"4") || empty($rowcontrol[fhxs])){?>
 <option value="4" <? if(4==$row[fhxs]){?> selected<? }?>>点卡交易</option>
 <? }?>
 <? if(strstr($rowcontrol[fhxs],"5") || empty($rowcontrol[fhxs])){?>
 <option value="5" <? if(5==$row[fhxs]){?> selected<? }?>>实物快递</option>
 <? }?>
 </select>
 </div>
 <div class="d3"><img src="../img/rightjian.png" height="13" /></div>
</div>

<div class="uk box" id="kcuk">
 <div class="d1">库 存 量<span class="s1"></span></div>
 <div class="d2"><input type="text" class="inp" name="tkcnum" value="<?=returnjgdw($row[kcnum],"",0)?>" /></div>
</div>

<div id="fhxs2">
<div class="uk box">
 <div class="d1">网盘地址<span class="s1"></span></div>
 <div class="d2"><input type="text" class="inp" name="twpurl" placeholder="输入网盘地址" value="<?=$row[wpurl]?>" /></div>
</div>
<div class="uk box">
 <div class="d1">网盘密码<span class="s1"></span></div>
 <div class="d2"><input type="text" class="inp" name="twppwd" placeholder="输入网盘密码" value="<?=$row[wppwd]?>" /></div>
</div>
<div class="uk box">
 <div class="d1">解压密码<span class="s1"></span></div>
 <div class="d2"><input type="text" class="inp" name="twppwd1" placeholder="输入解压密码" value="<?=$row[wppwd1]?>" /></div>
</div>
</div>

<div id="fhxs3">

<? if(check_in("a1a",$rowcontrol[aliosskg])){$a=1;}else{$a=0;}?>
<input type="hidden" value="<?=$a?>" name="Rupty" />

<div class="uk box">
 <div class="d1">上传文件<span class="s1"></span></div>
 <div class="d2"><input type="file" name="inp1" id="inp1" class="inp"></div>
</div>
<? 
if(!empty($row[upf])){
if(empty($row[upty])){$u=weburl."upload/".$row[userid]."/".$row[bh]."/".$row[upf];}else{$u=$row[upf];}
?>
<div class="uk box">
 <div class="d1">文件预览<span class="s1"></span></div>
 <div class="d21">【<a href="<?=$u?>" class="blue" target="_blank">点击预览</a>】</div>
</div>
<? }?>
</div>

<div id="fhxs4">
<div class="uk box">
 <div class="d1">下载地址<span class="s1"></span></div>
 <div class="d2"><input type="text" class="inp" name="tdownurl" placeholder="请输入下载地址，可留空" value="<?=$row[downurl]?>" /></div>
</div>
<div class="uk box">
 <div class="d1">库 存<span class="s1"></span></div>
 <div class="d21"><strong class="red"><?=$row[kcnum]?>件</strong></div>
</div>
<div class="uk box">
 <div class="d1">添加卡密<span class="s1"></span></div>
 <div class="d2"><textarea name="s1" placeholder="导入格式为卡号+空格+密码(可跟上附加内容)，一行一组，如AAAAA BBBBB"></textarea></div>
</div>
</div>

<div id="fhxs5">
<div class="uk box">
 <div class="d1">重 量<span class="s1"></span></div>
 <div class="d2"><input type="text" class="inp" name="tzl" value="<?=sprintf("%.2f",$row[zl])?>" /></div>
 <div class="d31">KG</div>
</div>
</div>

<!--效果图B-->
<div class="uk box">
 <div class="d1">效 果 图<span class="s1"></span></div>
 <div class="d2"><iframe style="float:left;" src="tpupload.php?admin=6&bh=<?=$bh?>" width="103" scrolling="no" height="103" frameborder="0"></iframe></div>
</div>
<div class="xgtp box">
<div class="xgtpm">
 <div id="xgtp1" style="display:none;">正在处理</div>
 <div id="xgtp2"></div>
</div>
</div>
<!--效果图E-->

<div class="rts box" style="cursor:pointer;" onClick="xtinfonc()"><div class="d1">【点击<span id="xtzs">展开</span>】选填部分，我们建议您也填写。</div></div>

<div id="xuantian" style="display:none;">

<input type="hidden" value="<?=$row[tysx]?>" name="tysx" />
<? $i=1;while1("*","yjcode_typesx where admin=1 and typeid=".$row[ty1id]." order by xh asc");while($row1=mysql_fetch_array($res1)){?>
<input type="hidden" value="<?=$row1[id]?>" name="tysxty1_<?=$i?>" />
<div class="uk box">
 <div class="d1"><?=$row1[name1]?><span class="s1"></span></div>
 <div class="d2" id="idiv<?=$ijia?>">
 <? $j=1;while2("*","yjcode_typesx where admin=2 and name1='".$row1[name1]."' and typeid=".$row1[typeid]." order by xh asc");while($row2=mysql_fetch_array($res2)){?>
 <label><input name="Csx" type="checkbox" value="<?=$row2[id]?>"<? if(strstr($row[tysx],"xcf".$row2[id]."xcf")){?>checked="checked"<? }?> /> <?=$row2[name2]?></label>
 <? $j++;}?>
 <? 
 if(!empty($row1[ifzi])){
 $v="";
 $a1=preg_split("/xcf".$row1[id].":/",$row[tysx]);
 if(count($a1)>1){$b1=preg_split("/xcf/",$a1[1]);$v=$b1[0];}
 ?>
 <input type="text" name="zi_<?=$i?>_<?=$j?>" placeholder="可以在此手动输入内容" value="<?=$v?>" class="inp" />
 <? }?>
 <input type="hidden" value="<?=$j?>" name="tysxSnum<?=$i?>" />
 </div>
 <div class="d3" onClick="iimgonc(<?=$ijia?>)"><img src="img/jian3.gif" id="iimg<?=$ijia?>" /></div>
</div>
<? $i++;$ijia++;}?>
<input type="hidden" value="<?=$i?>" name="tysxBnum" />

<div class="uk box">
 <div class="d1">会员等级<span class="s1"></span></div>
 <div class="d2">
 <select name="Rifuserdj" onChange="djonc()" style="font-size:13px;">
 <option value="0" <? if(empty($row[ifuserdj])){?> selected="selected"<? }?>>不启用</option>
 <option value="1" <? if(1==$row[ifuserdj]){?> selected="selected"<? }?>>启用</option>
 </select>
 </div>
 <div class="d3"><img src="../img/rightjian.png" height="13" /></div>
</div>

<div id="djv" style="display:none;">
 <div class="djuk box">
  <div class="d1">会员等级<span class="s1"></span></div>
  <div class="d2">折扣(10为无折扣，9表示9折)</div>
 </div>
 <? 
 $j=1;while1("*","yjcode_userdj where zt=0 order by xh asc");while($row1=mysql_fetch_array($res1)){
 while2("*","yjcode_prouserdj where probh='".$bh."' and djname='".$row1[name1]."'");if($row2=mysql_fetch_array($res2)){$zhekou=$row2[zhi];}else{$zhekou=$row1[zhekou];}
 ?>
 <div class="djuk1 box">
  <div class="d1"><input type="text" readonly name="name1_<?=$j?>" value="<?=$row1[name1]?>" /></div>
  <div class="d2"><input type="text" name="zhekou_<?=$j?>" value="<?=$zhekou?>" /></div>
 </div>
 <? $j++;}?>
 <input type="hidden" value="<?=$j?>" name="djnum" />
</div>

<div class="uk box">
 <div class="d1">演示网址<span class="s1"></span></div>
 <div class="d2"><input placeholder="可以输入演示网址" type="text" class="inp" name="tysweb" value="<?=$row[ysweb]?>" /></div>
</div>

<div class="uk box">
 <div class="d1">关 键词<span class="s1"></span></div>
 <div class="d2"><input placeholder="可以输入SEO关键词" type="text" class="inp" name="twkey" value="<?=$row[wkey]?>" /></div>
</div>

<div class="uk box">
 <div class="d1">描 述<span class="s1"></span></div>
 <div class="d2"><textarea placeholder="可以输入SEO描述" name="twdes" value="<?=$row[wkey]?>"></textarea></div>
</div>

<div class="uk box">
 <div class="d1">自定编码<span class="s1"></span></div>
 <div class="d2"><input placeholder="可以输入自定义编码" type="text" class="inp" name="tmybh" value="<?=$row[mybh]?>" /></div>
</div>

</div>

<div class="fbbtn box">
 <div class="d1"><? tjbtnr_m("下一步")?></div>
</div>

</form>
<!--结束-->

<script type="text/javascript">
//实例化编辑器
yhxsonc();
fhxsonc();
djonc();

function xgtread(x){
 $.get("readtp.php",{bh:x,admin:6},function(result){
  $("#xgtp2").html(result);
 });
}
function deltp(x){
 document.getElementById("xgtp1").style.display="";
 $.get("tpdel.php",{id:x,admin:6},function(result){
  xgtread("<?=$bh?>");
  document.getElementById("xgtp1").style.display="none";
 });
}
xgtread("<?=$bh?>");

function xtinfonc(){
if(document.getElementById("xtzs").innerHTML=="展开"){document.getElementById("xuantian").style.display="";document.getElementById("xtzs").innerHTML="收起";}
else{document.getElementById("xuantian").style.display="none";document.getElementById("xtzs").innerHTML="展开";}
}

</script>

</body>
</html>