<?php
include("../config/conn.php");
include("../config/function.php");
AdminSes_audit();
$bh=$_GET[bh];
while0("*","yjcode_adlx where bh='".$bh."'");if(!$row=mysql_fetch_array($res)){php_toheader("adlxlist.php");}

//函数开始
if($_GET[control]=="update"){
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0301,")){Audit_alert("权限不够","default.php");}
 zwzr();
 $sj=date("Y-m-d H:i:s");
 updatetable("yjcode_adlx",$ses."
			 tit='".sqlzhuru($_POST[ttit])."',
			 adbh='".sqlzhuru($_POST[tadbh])."',
			 maxnum=".sqlzhuru($_POST[tmaxnum]).",
			 adh=".sqlzhuru($_POST[tadh]).",
			 adw=".sqlzhuru($_POST[tadw]).",
			 adty='".$_GET[adty]."',
			 fflx=".$_POST[Rfflx].",
			 sj='".sqlzhuru($_POST[tsj])."',
			 zt=0
			 where admin=1 and bh='".$bh."'");
 deletetable("yjcode_adlx where admin=2 and bh='".$bh."'");
 $fflx=intval($_POST[Rfflx]);
 if($fflx==1){//固定费用
  $al=intval($_POST[fflxnum1]);
  for($i=1;$i<=$al;$i++){
  $tianshu=$_POST["tianshu_1_".$i];
  $money1=$_POST["money1_1_".$i];
  if(!empty($tianshu) && !empty($money1)){
  intotable("yjcode_adlx","bh,admin,xh,money1,tianshu,sj","'".$bh."',2,0,".$money1.",".$tianshu.",'".$sj."'");
  }
  }
 }elseif($fflx==2){//根据位置不同定价
  $al=intval($_POST[fflxnum2]);
  for($i=1;$i<=$al;$i++){
  $tianshu=$_POST["tianshu_2_".$i];
  $money1=$_POST["money1_2_".$i];
  $xh=$_POST["xh_2_".$i];
  if(!empty($tianshu) && !empty($money1)){
  intotable("yjcode_adlx","bh,admin,xh,money1,tianshu,sj","'".$bh."',2,".$xh.",".$money1.",".$tianshu.",'".$sj."'");
  }
  }
 }
 php_toheader("adlx.php?t=suc&bh=".$bh);

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
<script language="javascript">
function tj(){
if((document.f1.ttit.value).replace(/\s/,"")==""){alert("请输入标题");document.f1.ttit.focus();return false;}
if((document.f1.tadbh.value).replace(/\s/,"")==""){alert("请输入广告编号");document.f1.tadbh.focus();return false;}
a=document.f1.tmaxnum.value;if(a.replace("/\s/","")=="" || isNaN(a)){alert("请输入有效的数量");document.f1.tmaxnum.focus();return false;}
c=document.getElementsByName("C1");str="xcf";for(i=0;i<c.length;i++){if(c[i].checked){str=str+c[i].value+"xcf";}}
if(str=="xcf"){alert("请至少选择一个广告允许类型");return false;}
layer.msg('正在提交', {icon: 16  ,time: 0,shade :0.25});
f1.action="adlx.php?bh=<?=$bh?>&control=update&adty="+str;
}
function fflxadd1(){
a=parseInt(document.f1.fflxnum1.value);
document.f1.fflxnum1.value=a+5;
str=document.getElementById("fflx1").innerHTML;
for(i=1;i<=5;i++){
b=a+i;
str=str+"<ul class=\"fflxu2\"><li class=\"l1\"><input type=\"text\" name=\"tianshu_1_"+b+"\" /></li><li class=\"l2\"><input type=\"text\" name=\"money1_1_"+b+"\" /></li></ul>";
}
document.getElementById("fflx1").innerHTML=str;
}
function fflxadd2(){
a=parseInt(document.f1.fflxnum2.value);
document.f1.fflxnum2.value=a+5;
str=document.getElementById("fflx2").innerHTML;
for(i=1;i<=5;i++){
b=a+i;
str=str+"<ul class=\"fflxu2\"><li class=\"l1\"><input type=\"text\" name=\"xh_2_"+b+"\" /></li><li class=\"l1\"><input type=\"text\" name=\"tianshu_2_"+b+"\" /></li><li class=\"l2\"><input type=\"text\" name=\"money1_2_"+b+"\" /></li></ul>";
}
document.getElementById("fflx2").innerHTML=str;
}
function fflxonc(x){
document.getElementById("fflx1main").style.display="none";
document.getElementById("fflx2main").style.display="none";
document.getElementById("fflx"+x+"main").style.display="";
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
 <div class="rights">
 <strong>提示：</strong><br>
 <span class="red">请认真填写并核对每项信息，因为这关系到您前台展示的页面美观。</span>
 </div>
 
 <? if($_GET[t]=="suc"){systs("恭喜您，操作成功！","adlx.php?bh=".$bh);}?>
 <div class="bqu1">
 <a href="javascript:void(0);" class="a1">自助广告系统</a>
 <a href="adlxlist.php">返回列表</a>
 </div> 
 <!--B-->
 <div class="rkuang">
 <form name="f1" method="post" onsubmit="return tj()">
 <ul class="uk">
 <li class="l1"><span class="red">*</span> 广告标题：</li>
 <li class="l2"><input type="text" size="80" value="<?=$row[tit]?>" class="inp" name="ttit" /></li>
 <li class="l1"><span class="red">*</span> 广告编号：</li>
 <li class="l2"><input type="text" size="20" value="<?=$row[adbh]?>" class="inp" name="tadbh" /></li>
 <li class="l1"><span class="red">*</span> 最大数量：</li>
 <li class="l2"><input type="text" size="10" value="<?=$row[maxnum]?>" class="inp" name="tmaxnum" /><span class="fd">0表示不限个数</span></li>
 <li class="l1"><span class="red">*</span> 要求宽度：</li>
 <li class="l2"><input type="text" size="10" value="<?=$row[adw]?>" class="inp" name="tadw" /><span class="fd">0表示不限宽度</span></li>
 <li class="l1"><span class="red">*</span> 要求高度：</li>
 <li class="l2"><input type="text" size="10" value="<?=$row[adh]?>" class="inp" name="tadh" /><span class="fd">0表示不限高度</span></li>
 <li class="l1"><span class="red">*</span> 允许类型：</li>
 <li class="l2">
 <label><input name="C1" type="checkbox" value="1"<? if(strstr($row[adty],"xcf1xcf")){?> checked="checked"<? }?>/> 图片</label>
 <label><input name="C1" type="checkbox" value="2"<? if(strstr($row[adty],"xcf2xcf")){?> checked="checked"<? }?>/> 代码</label>
 <label><input name="C1" type="checkbox" value="3"<? if(strstr($row[adty],"xcf3xcf")){?> checked="checked"<? }?>/> 文字</label> 
 <label><input name="C1" type="checkbox" value="4"<? if(strstr($row[adty],"xcf4xcf")){?> checked="checked"<? }?>/> 动画</label> 
 </li>
 <li class="l1"><span class="red">*</span> 付费类型：</li>
 <li class="l2">
 <label><input name="Rfflx" type="radio" value="1" onclick="fflxonc(1)" <? if(1==$row[fflx]){?>checked="checked"<? }?> /> 相同费用</label>
 <label><input name="Rfflx" type="radio" value="2" onclick="fflxonc(2)" <? if(2==$row[fflx]){?>checked="checked"<? }?> /> 根据位置不同定价</label> 
 </li>
 </ul>
 
 <div id="fflx1main" style="display:none;">
 <ul class="fflxu1">
 <li class="l1">购买天数</li>
 <li class="l2">所需费用</li>
 </ul>
 <? $j=1;while1("*","yjcode_adlx where bh='".$bh."' and admin=2 order by id asc");while($row1=mysql_fetch_array($res1)){?>
 <ul class="fflxu2">
 <li class="l1"><input type="text" name="tianshu_1_<?=$j?>" value="<?=$row1[tianshu]?>" /></li>
 <li class="l2"><input type="text" name="money1_1_<?=$j?>" value="<?=$row1[money1]?>" /></li>
 </ul>
 <? $j++;}?>
 <? for($i=1;$i<=2;$i++){?>
 <ul class="fflxu2">
 <li class="l1"><input type="text" name="tianshu_1_<?=$j?>" /></li>
 <li class="l2"><input type="text" name="money1_1_<?=$j?>" /></li>
 </ul>
 <? $j++;}?>
 <div id="fflx1"></div>
 <ul class="uk"><li class="l1"></li><li class="l21"><a href="javascript:void(0);" onclick="fflxadd1()">【新增五行】</a></li></ul>
 <input type="hidden" value="<?=$j?>" name="fflxnum1" />
 </div>
 
 <div id="fflx2main" style="display:none;">
 <ul class="fflxu1">
 <li class="l3">所在位置</li>
 <li class="l1">购买天数</li>
 <li class="l2">所需费用</li>
 </ul>
 <? $j=1;while1("*","yjcode_adlx where bh='".$bh."' and admin=2 order by id asc");while($row1=mysql_fetch_array($res1)){?>
 <ul class="fflxu2">
 <li class="l3"><input type="text" name="xh_2_<?=$j?>" value="<?=$row1[xh]?>" /></li>
 <li class="l1"><input type="text" name="tianshu_2_<?=$j?>" value="<?=$row1[tianshu]?>" /></li>
 <li class="l2"><input type="text" name="money1_2_<?=$j?>" value="<?=$row1[money1]?>" /></li>
 </ul>
 <? $j++;}?>
 <? for($i=1;$i<=2;$i++){?>
 <ul class="fflxu2">
 <li class="l3"><input type="text" name="xh_2_<?=$j?>" /></li>
 <li class="l1"><input type="text" name="tianshu_2_<?=$j?>" /></li>
 <li class="l2"><input type="text" name="money1_2_<?=$j?>" /></li>
 </ul>
 <? $j++;}?>
 <div id="fflx2"></div>
 <ul class="uk uk0"><li class="l1"></li><li class="l21"><a href="javascript:void(0);" onclick="fflxadd2()">【新增五行】</a></li></ul>
 <input type="hidden" value="<?=$j?>" name="fflxnum2" />
 </div>
 
 <ul class="uk uk0">
 <li class="l1">更新时间：</li>
 <li class="l2"><input class="inp" name="tsj" value="<?=$row[sj]?>" size="20" type="text"/><span class="fd">正确的时间格式如：2012-12-12 12:12:12</span></li>
 <li class="l3"><input type="submit" value="保存修改" class="btn1" /></li>
 </ul>
 </form>
 </div>
 <!--E-->
 
</div>
</div>
<script language="javascript">fflxonc(<?=$row[fflx]?>);</script>
<?php include("bottom.php");?>
</body>
</html>