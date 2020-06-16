<?
include("../../config/conn.php");
include("../../config/function.php");
sesCheck_m();
$sqluser="select * from yjcode_user where uid='".$_SESSION[SHOPUSER]."' and shopzt=2";mysql_query("SET NAMES 'GBK'");$resuser=mysql_query($sqluser);
if(!$rowuser=mysql_fetch_array($resuser)){php_toheader("openshop3.php");}
$userid=$rowuser[id];
$sj=date("Y-m-d H:i:s");
$uip=$_SERVER["REMOTE_ADDR"];

//函数开始
if($_GET[control]=="add"){
 zwzr();
 $bh=time()."-".$userid;
 createDir("../../upload/".$userid."/".$bh."/");
 $ty1id=intval($_POST[type1id]);
 $ty2id=intval($_POST[type2id]);
 $ty3id=intval($_POST[type3id]);
 $ty4id=intval($_POST[type4id]);
 $ty5id=intval($_POST[type5id]);
 intotable("yjcode_pro","bh,userid,sj,lastsj,uip,ty1id,ty2id,ty3id,ty4id,ty5id,zt,djl,xsnum,yhxs,ifxj,pf1,pf2,pf3,iftj,fhxs","'".$bh."',".$userid.",'".$sj."','".$sj."','".$uip."',".$ty1id.",".$ty2id.",".$ty3id.",".$ty4id.",".$ty5id.",99,0,0,1,0,5,5,5,0,1");
 deletetable("yjcode_fbhis where userid=".$userid." and ty1id=".$ty1id." and ty2id=".$ty2id." and ty3id=".$ty3id." and ty4id=".$ty4id." and ty5id=".$ty5id);
 intotable("yjcode_fbhis","userid,ty1id,ty2id,ty3id,ty4id,ty5id,sj,uip","".$userid.",".$ty1id.",".$ty2id.",".$ty3id.",".$ty4id.",".$ty5id.",'".$sj."','".$uip."'");
 $a=returncount("yjcode_fbhis where userid=".$userid);if($a>5){$b=$a-5;deletetable("yjcode_fbhis where userid=".$userid." order by sj asc limit ".$b);}
 php_toheader("product.php?bh=".$bh); 
 

}elseif($_GET[control]=="update"){
 zwzr();
 $ty1id=intval($_POST[type1id]);
 $ty2id=intval($_POST[type2id]);
 $ty3id=intval($_POST[type3id]);
 $ty4id=intval($_POST[type4id]);
 $ty5id=intval($_POST[type5id]);
 updatetable("yjcode_pro","ty1id=".$ty1id.",ty2id=".$ty2id.",ty3id=".$ty3id.",ty4id=".$ty4id.",ty5id=".$ty5id." where userid=".$userid." and id=".$_GET[id]);
 deletetable("yjcode_fbhis where userid=".$userid." and ty1id=".$ty1id." and ty2id=".$ty2id." and ty3id=".$ty3id." and ty4id=".$ty4id." and ty5id=".$ty5id);
 intotable("yjcode_fbhis","userid,ty1id,ty2id,ty3id,ty4id,ty5id,sj,uip","".$userid.",".$ty1id.",".$ty2id.",".$ty3id.",".$ty4id.",".$ty5id.",'".$sj."','".$uip."'");
 $a=returncount("yjcode_fbhis where userid=".$userid);if($a>5){$b=$a-5;deletetable("yjcode_fbhis where userid=".$userid." order by sj asc limit ".$b);}
 php_toheader("product.php?bh=".$_GET[bh]); 

}
//函数结束

?>
<html>
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
<title>会员中心 <?=webname?></title>
<? include("../tem/cssjs.html");?>
<link href="css/sell.css" rel="stylesheet" type="text/css" />
<script language="javascript">
//商品分类点击筛选
function typeonc(){
obj=options=$("#d1 option:selected");;
ptype2.location="protype2.php?type1id="+options.val();
ptype3.location="protype3.php";
ptype4.location="protype4.php";
ptype5.location="protype5.php";
document.f1.type1id.value=options.val();
document.f1.type2id.value=0;
document.f1.type3id.value=0;
document.f1.type4id.value=0;
document.f1.type5id.value=0;
}

function tjadd(){
 if(document.f1.type1id.value=="0"){alert("请选择商品类别");return false;}	
 layer.open({type: 2,content: '正在提交',shadeClose:false});
 f1.action="productlx.php?control=add";
}
function tjupdate(x){
 if(document.f1.type1id.value=="0"){alert("请选择商品类别");return false;}	
 layer.open({type: 2,content: '正在提交',shadeClose:false});
 f1.action="productlx.php?control=update&id=<?=$_GET[id]?>"+"&bh="+x;
}
</script>
</head>
<body>
<? include("topuser.php");?>

<div class="bfbtop2 box">
 <div class="d1" onClick="gourl('productlist.php')"><img src="img/topleft1.png" height="21" /></div>
 <div class="d2">设置分类</div>
 <div class="d3"></div>
</div>

 <!--begin-->
<? if($_GET[action]==""){?>
<form name="f1" method="post" onSubmit="return tjadd()">
<input type="hidden" name="type1id" value="0" />
<input type="hidden" name="type2id" value="0" />
<input type="hidden" name="type3id" value="0" />
<input type="hidden" name="type4id" value="0" />
<input type="hidden" name="type5id" value="0" />

<div class="uk box">
 <div class="d1">一级分类<span class="s1"></span></div>
 <div class="d2">
 <select name="d1" id="d1" style="font-size:13px;" onChange="typeonc()">
 <option value="">点击选择一级分类</option>
 <? while1("*","yjcode_type where admin=1 order by xh asc");while($row1=mysql_fetch_array($res1)){?>
 <option value="<?=$row1[id]?>"><?=$row1[type1]?></option>
 <? }?>
 </select>
 </div>
 <div class="d3"><img src="../img/rightjian.png" height="13" /></div>
</div>

<div class="uk box">
 <div class="d1">二级分类<span class="s1"></span></div>
 <div class="d2">
 <iframe name="ptype2" id="ptype2" height="30" style="margin-left:-4px;" width="100%" border="0" frameborder="0"></iframe>
 </div>
 <div class="d3"><img src="../img/rightjian.png" height="13" /></div>
</div>

<div class="uk box">
 <div class="d1">三级分类<span class="s1"></span></div>
 <div class="d2">
 <iframe name="ptype3" id="ptype3" height="30" width="100%" border="0" frameborder="0"></iframe>
 </div>
 <div class="d3"><img src="../img/rightjian.png" height="13" /></div>
</div>

<div class="uk box">
 <div class="d1">四级分类<span class="s1"></span></div>
 <div class="d2">
 <iframe name="ptype4" id="ptype4" height="30" width="100%" border="0" frameborder="0"></iframe>
 </div>
 <div class="d3"><img src="../img/rightjian.png" height="13" /></div>
</div>

<div class="uk box">
 <div class="d1">五级分类<span class="s1"></span></div>
 <div class="d2">
 <iframe name="ptype5" id="ptype5" height="30" width="100%" border="0" frameborder="0"></iframe>
 </div>
 <div class="d3"><img src="../img/rightjian.png" height="13" /></div>
</div>
 
<div class="fbbtn box">
 <div class="d1"><? tjbtnr_m("下一步")?></div>
</div>

</form>
 
 <? 
 }elseif($_GET[action]=="update"){
 while0("*","yjcode_pro where id=".$_GET[id]."");if(!$row=mysql_fetch_array($res)){php_toheader("productlist.php");}
 ?>
<form name="f1" method="post" onSubmit="return tjupdate('<?=$row[bh]?>')">
<input type="hidden" name="type1id" value="<?=$row[ty1id]?>" />
<input type="hidden" name="type2id" value="<?=$row[ty2id]?>" />
<input type="hidden" name="type3id" value="<?=$row[ty3id]?>" />
<input type="hidden" name="type4id" value="<?=$row[ty4id]?>" />
<input type="hidden" name="type5id" value="<?=$row[ty5id]?>" />

<div class="uk box">
 <div class="d1">一级分类<span class="s1"></span></div>
 <div class="d2">
 <select name="d1" id="d1" style="font-size:13px;" onChange="typeonc()">
 <option value="">点击选择一级分类</option>
 <? while1("*","yjcode_type where admin=1 order by xh asc");while($row1=mysql_fetch_array($res1)){?>
 <option value="<?=$row1[id]?>"<? if($row1[id]==$row[ty1id]){?> selected<? }?>><?=$row1[type1]?></option>
 <? }?>
 </select>
 </div>
 <div class="d3"><img src="../img/rightjian.png" height="13" /></div>
</div>

<div class="uk box">
 <div class="d1">二级分类<span class="s1"></span></div>
 <div class="d2">
 <iframe src="protype2.php?type1id=<?=$row[ty1id]?>&nid=<?=$row[ty2id]?>" name="ptype2" id="ptype2" height="30" style="margin-left:-4px;" width="100%" border="0" frameborder="0"></iframe>
 </div>
 <div class="d3"><img src="../img/rightjian.png" height="13" /></div>
</div>

<div class="uk box">
 <div class="d1">三级分类<span class="s1"></span></div>
 <div class="d2">
 <iframe src="protype3.php?type1id=<?=$row[ty1id]?>&type2id=<?=$row[ty2id]?>&nid=<?=$row[ty3id]?>" name="ptype3" id="ptype3" height="30" width="100%" border="0" frameborder="0"></iframe>
 </div>
 <div class="d3"><img src="../img/rightjian.png" height="13" /></div>
</div>

<div class="uk box">
 <div class="d1">四级分类<span class="s1"></span></div>
 <div class="d2">
 <iframe src="protype4.php?type1id=<?=$row[ty1id]?>&type2id=<?=$row[ty2id]?>&type3id=<?=$row[ty3id]?>&nid=<?=$row[ty4id]?>" name="ptype4" id="ptype4" height="30" width="100%" border="0" frameborder="0"></iframe>
 </div>
 <div class="d3"><img src="../img/rightjian.png" height="13" /></div>
</div>

<div class="uk box">
 <div class="d1">五级分类<span class="s1"></span></div>
 <div class="d2">
 <iframe src="protype5.php?type1id=<?=$row[ty1id]?>&type2id=<?=$row[ty2id]?>&type3id=<?=$row[ty3id]?>&type4id=<?=$row[ty4id]?>&nid=<?=$row[ty5id]?>" name="ptype5" id="ptype5" height="30" width="100%" border="0" frameborder="0"></iframe>
 </div>
 <div class="d3"><img src="../img/rightjian.png" height="13" /></div>
</div>
 
<div class="fbbtn box">
 <div class="d1"><? tjbtnr_m("下一步")?></div>
</div>

</form>

<? }?>
<!--end-->
</body>
</html>